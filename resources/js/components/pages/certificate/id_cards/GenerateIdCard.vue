<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb
                pageTitle="Generate Id Card"
                :breadcrumbList="breadcrumbList"
            />
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Generate Student Id Card</h3>
                                </div>
                            </div>
                            <form class="new-added-form">
                                <div class="row">
                                    <div class="col-3 form-group">
                                        <label>Select Class</label>
                                        <Select2
                                            ref="class_list_select2"
                                            placeholder="--SELECT A CLASS--"
                                            :items="class_list"
                                            @change="selectClass"
                                        />
                                    </div>
                                    <div class="col-3 form-group">
                                        <label>Select Section</label>
                                        <Select2
                                            ref="section_list_select2"
                                            :items="section_list"
                                            @change="selectSection"
                                        />
                                    </div>
                                    <div class="col-6 form-group">
                                        <label>Select Id Card</label>
                                        <Select2
                                            ref="idCard_list"
                                            :items="idCard_list"
                                            @change="selectCard"
                                        />
                                    </div>
                                    <!-- <div class="col-6 form-group">
                                        <label>Student Name</label>
                                        <div
                                            v-for="(
                                                student, index
                                            ) in studentList"
                                            :key="student.student_admission_id"
                                        >
                                            <div>
                                                <span>
                                                    <input
                                                        :id="`studentChecked${index}`"
                                                        type="checkbox"
                                                        name="selectStudent[]"
                                                        @change.prevent="
                                                            selectStudent(
                                                                student.student_admission_id,
                                                                index
                                                            )
                                                        "
                                                    />
                                                </span>
                                                <span
                                                    @click="
                                                        selectStudent(
                                                            student.student_admission_id,
                                                            index
                                                        )
                                                    "
                                                >
                                                    {{
                                                        getStudentFullName(
                                                            student
                                                        )
                                                    }}
                                                </span>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="item-title">
                        <h3>Student List</h3>
                    </div>
                    <div class="table table-responsive" v-show="!noData">
								<Table
									ref="table"
									:tableData="tableData"
									:tableHead="tableHead"
								/>
							</div>
							<NoData v-show="noData" />
                </div>
            </div>
        </div>
        <Footer />
    </div>
</template>

<script>
var toast;
export default {
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "admin.dashboard" },
                    name: "Home",
                },
                {
                    name: "Generate Certificate",
                },
            ],
            class_list: [],
            section_list: [],
            classId: -1,
            sectionId: -1,
            studentList: [],
            idCard_list: [],
            editedIndex: -1,
            editItem: {
                studentIds: [],
            },
            tableData: [],
            isLoaded: false,
            noData: false,
             tableHead: {
                items: {
                   item1: { label: "Sr.No." },
                    item2: { label: "Admission Number" },
                    item3: { label: "Class" },
                    item4: { label: "Student Name" },
                    item5: { label: "Father Name" },
                    items6:{ label: "Gender"},
                    item7: { label: "Mobile Number" },
                },
                actions: true,
            },
        };
    },
    computed: {
        formBtn: function () {
            return this.editedIndex != -1 ? "Update" : "Save";
        },
    },
    mounted() {
        this.$parent.loadOtherScript();
        this.getClassList();
        this.getIdCardList();
    },
    methods: {
        async getClassList() {
            const res = await this.callApi(
                "get",
                `/api/school/general/get_class_list`,
                null
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.class_list = data.class_list;
                    this.$refs.class_list_select2.updateList(data.class_list);
                }
            }
        },

        async selectClass(val) {
            this.classId = val;
            const res = await this.callApi(
                "get",
                `/api/school/general/class/${this.classId}/sections`,
                null
            );
            this.log("section data", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.sections = data.school_class_sections;
                    this.$refs.section_list_select2.updateList(
                        data.school_class_sections
                    );
                }
            }

        },
        selectSection(val) {
            this.sectionId = val;
        },

        async getIdCardList() {
            const res = await this.callApi(
                "get",
                `/api/school/certificate/id_card/get_idCard_list`,
                null
            );
            this.log("List of Id Cards", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.idCard_list = data.idCardList;
                    this.$refs.idCard_list.updateList(data.idCardList);
                }
            }
        },
        selectCard(val) {
            this.idCard_id = val;
            this.getData(this.sectionId, this.classId);
        },

        async getData(sectionId, classId) {
            this.isLoaded = false;
            const res = await this.callApi(
                "get",
                `/api/school/students/student_admissions/id_card/${this.sectionId}/${this.classId}`,
                null
            );
            this.log('DAATAA',res);
            if (res.status == 200) {
            var data = res.data;
            if (data.status == "success") {
                    this.studentList = data.student_admissions;
                    this.initTable();
                }
            }
            this.$refs.table.loadTable();
            this.isLoaded = true;
        },
        initTable() {
            this.tableData = [];
            this.studentList.forEach((element) => {
                this.tableData.push({
                    item: element,
                    data: {
                        item1: element.student_admission_id,
                        item2: element.student_admission_number ? element.student_admission_number:'',
                        item3: `${element.school_class.class_name != null ? element.school_class.class_name : ''} ${element.school_section.section_name != null ? element.school_section.section_name : ''}`,
                        item4: `${element.first_name} ${element.student_middle_name != null ? element.middle_name : ''} ${element.last_name != null ? element.student_last_name : ''}`,
                        item5: `${element.student_guardian != null ? (element.student_guardian.father.first_name != null ? element.student_guardian.father.first_name : '') + '  ' + (element.student_guardian.father.middle_name != null ? element.student_guardian.father.middle_name : '') + '  ' + (element.student_guardian.father.last_name != null ? element.student_guardian.father.last_name : '') : ''}`,
                        item6: element.student_gender ? element.student_gender:'',
                        item7: element.student_guardian != null ? (element.student_guardian.father.mobile != null ? element.student_guardian.father.mobile : '') : '',
                        item8: {
                            type: 'action',
                            options: {
                                label:' Generate ',
                                class:'btn-primary',
                                style: 'border:1px solid;color:light background:primary',
                                method: this.displayIdCard
                            }
                        },
                    },
                    action: {
                        edit: false,
                        delete: true,
                    },
                });
            });
        },
        displayIdCard(item, index){
            this.$router.push(`/school/certificate/id_cards/viewGenerated_id_cards/${item.student_admission_id}/${this.idCard_id}`);
        },
    },
};
</script>
