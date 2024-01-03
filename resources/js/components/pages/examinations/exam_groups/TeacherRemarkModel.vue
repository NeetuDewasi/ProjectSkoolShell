<template>
    <div>

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal">×</button> -->
                <h4 class="modal-title mb-5">Teacher Remark</h4>
            </div>

            <div class="modal-body">
                <div class="row pb10">

                    <div class="col-lg-2 col-md-3 col-sm-12">
                        <label><b>Exam</b></label><br>
                    <span v-if="examDetails !=null">{{examDetails.newExam_name}}</span>
                    </div>

                    <div class="col-lg-10 col-md-9 col-sm-12">
                        <label><b> Group</b></label><br>
                    <span v-if="examDetails && examDetails.exam_groups!=null">{{examDetails.exam_groups}}</span>
                    </div>
                </div>
                <div class="divider2"></div>
                <div class="row pb10">
                    <table class="table table-striped mb10">
                        <thead class="table-head">
                            <tr>
                                <th>Admission No.</th>
                                <th>Roll Number</th>
                                <th>Student Name</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr v-for="student in student_list" :key="student.student_admission_id">
                                <td>

                                    {{student.students.student_admission_number}}
                                </td>
                                <td>{{student.students.student_roll_number}}</td>
                                <td>{{student.students.student_first_name}} {{student.student_last_name}}</td>
                                <td>
                                    <input type="text" class="form-control" style="border:none; width:300px;" ref="teacher_remarks">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="clearfix"></div>
                    <div class="row footer-row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-sm float-end mt-5"
                                data-loading-text="<i class='fa fa-spinner fa-spin '></i> Please Wait.."
                                autocomplete="off" @click="submitData()">{{frmBtn}}</button>
                        </div>
                    </div>
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
            examGroup_id: -1,
            newExam_id:-1,
            examGroup: {},
            exam_names: [],
            examDetails: {},
            student_list: [],
            editedIndex:-1,
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
        this.log('GROUP ID', this.examGroup_id);
        this.log('EXAM ID', this.newExam_id);
        this.getStudents();
         this.getData();
    },

    methods: {
         async getData() {
            this.isLoaded = false;
            var data = new FormData();
            data.append('examgroup_id', this.examGroup_id);
            data.append('exam_id', this.newExam_id);
            const res = await this.callApi(
                "post",
                `/api/school/examinations/addNew_exam/exams`,
                data
            );
            this.log('Exam DATA', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.examDetails = data.exam_names;
                }
            }
        },
        async getStudents() {
            this.isLoaded = false;
            var data = new FormData();
            data.append('examgroup_id', this.examGroup_id);
            data.append('exam_id', this.newExam_id);
            const res = await this.callApi(
                "post",
                `/api/school/examinations/teacher_remarks`,
                data
            );
            this.log('Exam Students', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.student_list = data.exam_students;
                }
            }
        },
         async submitData() {
            toast = Toast.fire({
                icon: "warning",
                title: "Please Wait!! Creating new Exam",
                timer: 0,
            });
            var data = new FormData();
            data.append('exam_groupId', this.examGroup_id ? this.examGroup_id : '');
            data.append('exam_id', this.newExam_id ? this.newExam_id : '');
            this.student_list.forEach((student,index) => {
            data.append('admission_id[]', student.student_admission_id);
            data.append('remarks[]', this.$refs.teacher_remarks ? this.$refs.teacher_remarks[index].value : '');
            this.log('Admission Id',student.student_admission_id);
            });
            let url = "";
            if (this.editedIndex != -1) {
                url = `/api/school/examinations/teacher_remarks/update/${this.editedIndex}`;
            } else {
                url = `/api/school/examinations/teacher_remarks/save`;
            }
            // console.log("DATA>>>", data);
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
    },
};
</script>

<style scoped>
.modal-xl {
    width: 97%;
}
.model-body{
    color: #646464;
}
.row {
    margin-left: 10px;
    color: rgb(48, 46, 46);

}
.table-head {
    border: 1px rgb(161, 158, 158);
    ;
}
.modal-content {
    height: 60vh;
}
.modal-header .modal-title {
    margin-top: 10px;
}
.form-control {
    border-bottom: 1px solid #f4f4f4 !important;
    border: 0;
}
.footer-row
{
    margin-right: -5px;
    margin-left: -5px;
}
</style>
