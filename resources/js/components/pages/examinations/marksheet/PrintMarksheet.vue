<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb
                pageTitle="Marks Grade"
                :breadcrumbList="breadcrumbList"
            />
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card height-auto">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Select Criteria</h3>
                                </div>
                            </div>
                            <form class="mg-b-20">
                                <div class="row gutters-8">
                                    <div
                                        class="col-xl-3 col-lg-6 col-sm-3 col-12 form-group"
                                    >
                                        <label for="exam_group"
                                            >Exam Group *</label
                                        >
                                        <Select2
                                            :items="examGroupList"
                                            ref="examGroupList"
                                            placeholder="--SELECT A GROUP--"
                                            @change="getExamNames"
                                        />
                                    </div>
                                    <div
                                        class="col-xl-3 col-lg-6 col-sm-5 col-12 form-group"
                                    >
                                        <label for="exam_name">Exam *</label>
                                        <Select2
                                            :item="examNames_list"
                                            ref="examNames_list"
                                            @change="selectExamName"
                                            placeholder="--SELECT EXAM--"
                                        />
                                    </div>
                                    <div
                                        class="col-xl-2 col-lg-6 col-sm-5 col-12 form-group"
                                    >
                                        <label for="session">Session *</label>
                                        <Select2
                                            :item="sessionList"
                                            ref="sessionList"
                                            placeholder="--SELECT SESSION--"
                                        />
                                    </div>
                                    <div
                                        class="col-xl-2 col-lg-6 col-sm-5 col-12 form-group"
                                    >
                                        <label for="class">Class *</label>
                                        <Select2
                                            :item="class_list"
                                            ref="class_list"
                                            placeholder="--Select Class--"
                                            @change="selectClass"
                                        />
                                    </div>
                                    <div
                                        class="col-xl-2 col-lg-6 col-sm-5 col-12 form-group"
                                    >
                                        <label for="section">Section *</label>
                                        <Select2
                                            :item="section_list"
                                            ref="section_list"
                                            @change="selectSection"
                                            placeholder="Select Section"
                                        />
                                    </div>
                                    <div
                                        class="col-xl-2 col-lg-6 col-sm-5 col-12 form-group"
                                    >
                                        <label for="section">Template *</label>
                                        <Select2
                                            :item="template_names"
                                            ref="template_names"
                                            placeholder="Select Template"
                                            @change="selectTemplate"

                                        />
                                    </div>
                                </div>
                                <!-- <div class="d-flex justify-content-end">
                                    <button
                                        type="submit"
                                        class="btn btn-gradient-yellow btn-lg btn-hover-bluedark text-white"
                                    >
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div> -->
                            </form>
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Exam Result</h3>
                                </div>
                            </div>
                            <div
                                class="table table-responsive"
                                v-show="!noData"
                            >
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
                    name: "Marks Grade",
                },
            ],
            tableHead: {
                items: {
                    item1: { label: 'Admission No.' },
                    item2: { label: 'Student Name' },
                    item3: { label: 'Father Name' },
                    item4: { label: 'Category' },
                    item5: { label: 'Gender' },
                },
                actions: true,
            },
            tableData: [],
            isLoaded: false,
            noData: false,
            examGroupList: [],
            examNames_list: [],
            section_list: [],
            class_list: [],
            sessionList: [],
            template_names:[],
            studentList:[],
        };
    },
    mounted() {
        this.$parent.loadOtherScript();
        this.getClassList();
        this.getExamGroup();
        this.getSession();
        this.getTemplate();
    },
    methods: {
        async getClassList() {
            const res = await this.callApi(
                "get",
                `/api/school/general/get_class_list`,
                null
            );
            this.log("CLASS", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.class_list = data.class_list;
                    this.$refs.class_list.updateList(data.class_list);
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
            this.log("SECTIONS", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.sections = data.school_class_sections;
                    this.$refs.section_list.updateList(
                        data.school_class_sections
                    );
                    if (this.editedIndex !== -1) {
                        this.$refs.section_list.setSelected(this.sectionId);
                    }
                }
            }
        },
        selectSection(val) {
            this.sectionId = val;
        },
        async getExamGroup() {
            const res = await this.callApi(
                "get",
                `/api/school/examinations/exam_group/getExamGroup`,
                null
            );
            this.log("EXAM GROUPS", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.examGroupList = data.examGroup_list;
                    this.$refs.examGroupList.updateList(data.examGroup_list);
                }
            }
        },

        async getExamNames(val) {
            this.examGroupId = val;
            this.log('Exam Group',this.examGroupId);
            const res = await this.callApi(
                "get",
                `/api/school/examinations/demo_exam_schedule/${val}`,
                null,
            );
            this.log('EXAM NAMES', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.examNames_list = data.exam_names;
                    this.$refs.examNames_list.updateList(data.exam_names);
                }
            }
        },
        selectExamName(new_examId) {
            this.new_examId = new_examId;
            this.log('Exam Id',this.new_examId);
        },
        async getSession() {
            const res = await this.callApi(
                "get",
                `/api/school/general/session`,
                null
            );
            this.log("SESSION", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.log(data.school_sessions);
                    this.sessionList = data.school_sessions;
                    this.$refs.sessionList.updateList(data.school_sessions);
                }
            }
        },
         async getTemplate() {
            const res = await this.callApi(
                "get",
                `/api/school/examinations/design_marksheet/templates`,
                null
            );
            this.log("TEMPLATES", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.template_names = data.marksheet_list;
                    this.$refs.template_names.updateList(data.marksheet_list);
                }
            }
        },
        selectTemplate(marksheet_id)
        {
            this.marksheet_id = marksheet_id;
            this.getData(this.sectionId, this.classId);
        },
        async getData() {
            this.isLoaded = false;
            const res = await this.callApi(
                "get",
               `/api/school/students/student_admissions/id_card/${this.classId}/${this.sectionId}`,
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
                    id: element.student_admission_id,
                    item: element,
                    data: {
                        item1: element.student_admission_number ? element.student_admission_number : '',
                        item2: `${element.first_name} ${element.middle_name != null ? element.middle_name : ''} ${element.last_name != null ? element.last_name : ''}`,
                        item3:`${element.student_guardian != null ? (element.student_guardian.father.first_name != null ? element.student_guardian.father.first_name : '') + ' ' + (element.student_guardian.father.middle_name != null ? element.student_guardian.father.middle_name : '') + ' ' + (element.student_guardian.father.last_name != null ? element.student_guardian.father.last_name : '') : ''}`,
                        item4: element.student_category.category_name ? element.student_category.category_name : '',
                        item5:  element.student_gender ? element.student_gender : '',
                        item6: {
                            type: 'action',
                            options: {
                                label:' Generate ',
                                class:'btn-primary',
                                style: 'border:1px solid;color:light background:primary',
                                method: this.generateMarksheet
                            }
                        },
                    },
                    action: {
                        edit: false,
                        delete: false,
                    },
                });
            });
        },
        generateMarksheet(item,index){
            this.$router.push(`/school/examinations/view_marksheet/${item.student_admission_id}/${this.marksheet_id}/${this.examGroupId}/${this.new_examId}`);
        }
    },
};
</script>
