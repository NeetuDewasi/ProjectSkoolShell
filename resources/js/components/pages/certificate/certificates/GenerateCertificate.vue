<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb pageTitle="Generate Certificate" :breadcrumbList="breadcrumbList" />
            <div class="row gutters-20">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Select Criteria</h3>
                                </div>
                            </div>

                            <form class="new-added-form">
                                <div class="row">
                                    <div class="col-4 form-group">
                                        <label>Select Class</label>
                                        <Select2 ref="class_list_select2" placeholder="--SELECT A CLASS--"
                                            :items="class_list" @change="selectClass" />
                                    </div>
                                    <div class="col-4 form-group">
                                        <label>Select Section</label>
                                        <Select2 ref="section_list_select2" :items="section_list"
                                            @change="selectSection" />
                                    </div>
                                    <div class="col-4 form-group">
                                        <label>Select Certificate</label>
                                        <Select2 ref="certificate_list" :items="certificate_list"
                                            @change="selectCertificate" />
                                    </div>
                                    <!-- <div class="col-6 form-group">
                    <label>Student Name</label>
                     <div
                          v-for="(student, index) in studentList"
                          :key="student.student_admission_id"
                        >
                          <div>
                            <span>
                              <input
                                :id="`studentChecked${index}`"
                                type="checkbox"
                                name="selectStudent[]"
                                @change.prevent="selectStudent(student.student_admission_id, index)"
                              />
                            </span>
                            <span @click="selectStudent(student.student_admission_id, index)">
                              {{
                              getStudentFullName(student)
                              }}
                            </span>
                          </div>
                        </div>
                  </div> -->

                                </div>
                                <!-- <div
                                        class="d-flex justify-content-end mt-5"
                                    >
                                        <button
                                            type="submit"
                                            class="btn-fill-lg text-light shadow-dodger-blue bg-dodger-blue"
                                            @click.prevent="submitData()"
                                        >
                                            {{ formBtn }}
                                        </button>
                                    </div> -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="item-title">
                        <h3>Student Certificate List</h3>
                    </div>
                    <div class="table-responsive" v-show="!noData">
                        <Table ref="table" :tableData="tableData" :tableHead="tableHead" />
                    </div>
                    <NoData v-show="noData" />
                </div>
            </div>
            <Footer />
        </div>
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
            tableHead: {
                items: {
                    item1: { label: "Sr.No." },
                    item2: { label: "Admission Number" },
                    item3: { label: "Class" },
                    item4: { label: "Student Name" },
                    item5: { label: "Father Name" },
                    items6: { label: "Gender" },
                    item7: { label: "Mobile Number" },
                    // item7: { label: "" },
                },
                actions: true,
            },
            class_list: [],
            section_list: [],
            classId: -1,
            sectionId: -1,
            studentList: [],
            certificate_List: [],
            certificate_list: [],
            editedIndex: -1,
            tableData: [],
            isLoaded: false,
            noData: false,
            // editItem:{
            //     studentIds:[],
            // },
        };
    },
    computed: {
        formBtn: function () {
            return this.editedIndex != -1 ? "Update" : "Save";
        }
    },
    mounted() {
        this.$parent.loadOtherScript();
        this.getClassList();
        this.getCertificateList();
    },
    methods: {
        async getClassList() {
            const res = await this.callApi(
                "get",
                `/api/school/general/get_class_list`,
                null,
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
                null,
            );
            this.log('section data', res)
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.sections = data.school_class_sections;
                    this.$refs.section_list_select2.updateList(data.school_class_sections);
                }
            }

        },
        selectSection(val) {
            this.sectionId = val;
        },

        async getCertificateList() {
            const res = await this.callApi(
                "get",
                `/api/school/certificate/student_certificate/certificate_list`,
                null,
            );
            this.log('List of Certificates', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.certificate_list = data.certificateList;
                    this.$refs.certificate_list.updateList(data.certificateList);
                }
            }
        },
        selectCertificate(val) {
            this.certificate_id = val;
            this.getData(this.sectionId, this.classId);
        },

        async getData(classId, sectionId) {
            this.isLoaded = false;
            const res = await this.callApi(
                "get",
                `/api/school/students/student_admissions/id_card/${sectionId}/${classId}`,
                null
            );
            this.log('DAATAA', res);
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
                        item1: element.admission_id,
                        item2: element.admission_number ? element.admission_number : '',
                        item3: `${element.school_class.class_name != null ? element.school_class.class_name : ''} ${element.school_section.section_name != null ? element.school_section.section_name : ''}`,
                        item4: `${element.first_name != null ? element.first_name : '' } ${element.middle_name != null ? element.middle_name : ''} ${element.last_name != null ? element.last_name : ''}`,
                        item5: `${element.student_guardian != null ? (element.student_guardian.father.first_name != null ? element.student_guardian.father.first_name : '') + '  ' + (element.student_guardian.father.middle_name != null ? element.student_guardian.father.middle_name : '') + ' ' + (element.student_guardian.father.last_name != null ? element.student_guardian.father.last_name : '') : ''}`,
                        item6: element.gender ? element.gender : '',
                        item7: element.mobile != null ? element.mobile : '',
                        item8: {
                            type: 'action',
                            options: {
                                label:' Generate ',
                                class:'btn-primary',
                                style: 'border:1px solid;color:light background:primary',
                                method: this.viewCertificate,
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
        viewCertificate(item, index) {
            this.$router.push(`/school/certificate/view_certificate/${item.student_admission_id}/${this.certificate_id}`);
        },
    },
};
</script>

