<template>
    <div>
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Exam Students</h4>
                <!-- <button type="button" class="close" data-dismiss="modal" autocomplete="off"
                        @click="()=>{ studentModelClose =false}">×</button> -->
                    <button type="button" class="btn btn-info" @click="goBack()">Back</button>
            </div>
            <div class="modal-body">
                <div>
                    <input type="hidden" name="exam_id" value="6" class="exam_group_class_batch_exam_id">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Class</label><small class="req"> *</small>
                                <Select2 ref="class_list" placeholder="--SELECT A CLASS--" :items="class_list"
                                    @change="selectClass" />
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="esection">Section</label><small class="req"> *</small>
                                <Select2 ref="section_list" :items="section_list" @change="selectSection" />
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <button type="button" class="btn btn-primary pull-right btn-sm checkbox-toggle"
                                @click="getData(selectedSection, classId)">
                                <i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>
                </div>
                <div class="table table-responsive" v-show="!noData">
                    <Table ref="table" :tableData="tableData" :tableHead="tableHead" checkbox="enabled"
                        @click="getAdmission()" />
                </div>
                <NoData v-show="noData" />
                <div class="row">
                    <button type="submit" class="btn btn-primary pull-right" id="load" @click.prevent="submitData()"
                        data-loading-text="<i class='fa fa-spinner fa-spin '></i> Saving...">{{ frmBtn }}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
var toast;
export default {
    data() {
        return {
            tableHead: {
                items: {
                    item1: { label: 'Admission No.' },
                    item2: { label: 'Student Name' },
                    item3: { label: 'Father Name' },
                    item4: { label: 'Category' },
                    item5: { label: 'Gender' },
                },
                actions: false,
            },
            studentModelClose: false,
            tableData: [],
            isLoaded: false,
            noData: false,
            tableStudentData: [],
            class_list: [],
            section_list: [],
            studentList: [],
            selectedSection: -1,
            classId: -1,
            editedIndex: -1,
            selecteIds: [],
            student_category: {},
        };
    },
    computed: {
        frmBtn: function () {
            return this.editedIndex !== -1 ? 'Update' : 'Save';
        },
    },

    created() {
        if (this.$route.params.examGroup_id && this.$route.params.newExam_id) {
            this.examGroup_id = this.$route.params.examGroup_id;
            this.newExam_id = this.$route.params.newExam_id;
        }
        this.getClassList();
    },
    methods: {
        goBack() {
            this.$router.go(-1);
        },
        async getClassList() {
            const res = await this.callApi("get", `/api/school/general/get_class_list`, null);
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
            const res = await this.callApi("get", `/api/school/general/class/${this.classId}/sections`, null);
            this.log("SECTIONS", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.sections = data.school_class_sections;
                    this.$refs.section_list.updateList(data.school_class_sections);

                }
            }
        },
        async selectSection(val) {
            this.selectedSection = val;
        },

        async getData(sectionId, classId) {
            var data = new FormData();
            data.append('class_id', classId);
            data.append('section_id', sectionId);
            this.isLoaded = false;
            const res = await this.callApi(
                "post",
                `/api/school/examinations/assign_students/get`,
                data
            );
            this.log('STUDENT DATA', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.studentList = data.students;
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
                        item1: element.admission_number ? element.admission_number : '',
                        item2: `${element.first_name} ${element.middle_name != null ? element.middle_name : ''} ${element.last_name != null ? element.last_name : ''}`,
                        item3: `${element.student_guardian != null ? (element.student_guardian.father.first_name != null ? element.student_guardian.father.first_name : '') + ' ' + (element.student_guardian.father.middle_name != null ? element.student_guardian.father.middle_name : '') + ' ' + (element.student_guardian.father.last_name != null ? element.student_guardian.father.last_name : '') : ''}`,
                        item4: element.student_category.category_name ? element.student_category.category_name : '',
                        item5: element.gender ? element.gender : '',
                    },
                    action: {
                        edit: false,
                        delete: false,
                    },
                });
            });
        },
        getSelectedIds() {
            this.selecteIds = this.$refs.table.getSelectedIds();
        },
        async submitData() {
            this.getSelectedIds();
            // var isVaild = await this.validExamForm();
            // if (!isVaild) {
            //     return;
            // }
            toast = Toast.fire({
                icon: "warning",
                title: "Please Wait!! Creating new Exam",
                timer: 0,
            });
            var data = new FormData();
            this.log('EDITITEM', this.selecteIds);
            data.append('exam_groupId', this.examGroup_id ? this.examGroup_id : '');
            data.append('exam_id', this.newExam_id ? this.newExam_id : '');
            data.append('class_id', this.classId ? this.classId : '');
            data.append('section_id', this.selectedSection ? this.selectedSection : '');
            this.selecteIds.forEach(element => {
                data.append('admission_ids[]', element);
            });
            let url = "";
            if (this.editedIndex != -1) {
                url = `/api/school/examinations/assign_students/update/${this.editedIndex}`;
            } else {
                url = `/api/school/examinations/assign_students/save`;
            }
            const res = await this.callApi("post", url, data);
            this.log('REQUEST', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {

                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    })
                    this.resetForm();
                    this.$router.go(-1);
                } else {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                }
            } else {
                toast = Toast.fire({
                    icon: data.status,
                    title: data.message,
                    timer: 2500,
                });
            }

        },
        resetForm() {
            this.log('Reset Form');
            this.editedIndex = -1
            this.classId = ''
            this.selectedSection = ''
            this.selecteIds = ''
        },
    },
};
</script>

<style scoped>
.btn-primary {
    float: right;
    margin-left: 50px;
}
</style>
