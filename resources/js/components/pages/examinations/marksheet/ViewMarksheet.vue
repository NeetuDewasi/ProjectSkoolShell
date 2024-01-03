<template>
    <div>
        <div class="container">
            <div class="modal-content">
                <div class="modal-body" id="card_detail" style="border:4px solid black;">
                    <div class="modal-inner-content">
                        <div class="col-md-12">
                            <div class="header">
                                <span class="col-sm-2 left-span float-left">
                                    <img src="/assets/img/logo.png" style="width:150px;height:100px;">
                                </span>
                                <span class="col-sm-2 right-span float-right">
                                    <img src="/assets/img/user_icon.png" style="width:150px;height:100px;">
                                </span>
                            </div>
                            <div class="col-sm-8 heading-layout text-center">
                                <span class="sttext1">EZY SCHOOL EXAM</span><br>
                                <span><u>SCHOOL</u></span><br>
                                <span class=""><u>Secondary Examinations </u></span><br>
                                <span>2021-2022</span>
                            </div>
                        </div><br>
                        <div class="divider"></div>
                        <div class="col-md-12">

                            <div class="row d-flex">
                                <div class="col-md-4">
                                    <label> MR/MS :</label>
                                </div>
                                <div class="col-md-6">

                                    <strong v-if="student && student != null">
                                        {{student.student_first_name}}
                                        {{student.student_middle_name}}
                                        {{student.student_last_name}}
                                    </strong>
                                </div>
                            </div>

                            <div class="row d-flex">
                                <div class="col-md-4">
                                    <label> FATHER/HUSBAND NAME :</label>
                                </div>
                                <div class="col-md-6">
                                    <strong>SHANKAR CHOUDHARY </strong>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label> MOTHER NAME :</label>
                                </div>
                                <div class="col-md-6">
                                    <strong>NEELAM CHOUDHARY </strong>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label> DATE OF BIRTH :</label>
                                </div>
                                <div class="col-md-6">
                                    <strong>16/08/2014 </strong>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label> CLASS :</label>
                                </div>
                                <div class="col-md-6">
                                    <span v-if="student && student != null">
                                        <strong v-if=" student.school_class && student.school_class.class_name != null">
                                            {{ student.school_class.class_name }}
                                        </strong>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label> SCHOOL NAME :</label>
                                </div>
                                <div class="col-md-6">
                                    <strong>LIS </strong>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label> EXAM CENTER :</label>
                                </div>
                                <div class="col-md-6">
                                    <strong>LUCKY BAL NIKETAN </strong>
                                </div>
                            </div>

                        </div>

                        <table class="table-bordered table-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="">Subject</th>
                                    <th class="">Max. Marks</th>
                                    <th class="">Min. Marks</th>
                                    <th class="">Marks Obtained</th>
                                    <th class="">Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="mark,index in marks_details" :key="index">
                                    <td>
                                        <span v-if="mark.exam_subjects != null">
                                            <span
                                                v-if="mark.exam_subjects.subjects && mark.exam_subjects.subjects.name">
                                                {{mark.exam_subjects.subjects.name}}
                                            </span>
                                        </span>
                                    </td>
                                    <td>
                                        <span v-if="mark.exam_subjects != null">
                                            <span
                                                v-if="mark.exam_subjects.exam_maxmarks && mark.exam_subjects.exam_maxmarks">
                                                {{mark.exam_subjects.exam_maxmarks}}
                                            </span>
                                        </span>
                                    </td>
                                    <td>
                                        <span v-if="mark.exam_subjects != null">
                                            <span
                                                v-if="mark.exam_subjects.exam_minmarks && mark.exam_subjects.exam_minmarks">
                                                {{mark.exam_subjects.exam_minmarks}}
                                            </span>
                                        </span>
                                    </td>
                                    <td>
                                        <span v-if="mark.exam_subjects != null">
                                            <span v-if="mark.marks && mark.marks !=null">
                                                {{mark.marks}}
                                            </span>
                                        </span>
                                    </td>
                                    <td>{{marksGrade(mark.marks,mark.exam_subjects.exam_maxmarks)}}</td>
                                </tr>
                                <tr>
                                    <th>Grand total</th>
                                    <td>{{maxTotal}}</td>
                                    <td></td>
                                    <td>{{totalMarks}}</td>
                                    <td>{{marksGrade(totalMarks,maxTotal)}}</td>
                                </tr>
                                <tr class="text-center"><strong>  Percentage : </strong>
                                    {{per}}%
                                </tr>
                            </tbody>
                        </table>
                         <!-- <div class="row">
                            <div class="col-3 pl-5rem">
                                <strong class="fw-bold">Total</strong>
                            </div>
                            <div class="col-3 pl-5rem">
                                <span>{{totalMarks}}</span>
                            </div>
                            <div class="col-3 pl-5rem">
                                <strong class="fw-bold">Grade</strong>
                            </div>
                            <div class="col-3 pl-5rem">
                                <span>{{marksGrade(totalMarks,maxTotal)}}</span>
                            </div>
                        </div> -->

                        <div class="col-12 signature">
                            <div class="row d-flex">

                                <div class="col-4 float-left">
                                    <div class="box-body box-profile">
                                        <span v-if="marksheet_list != null">
                                            <span
                                                v-if=" marksheet_list.marksheet_left_sign && marksheet_list.marksheet_left_sign != null">
                                                <img :src="marksheet_list.marksheet_left_sign"
                                                    style="height: 50px;" /><br />
                                            </span>
                                        </span>
                                        <label>Principal Signature</label>
                                    </div>
                                </div>

                                <div class="col-4 float-center">
                                    <div class="box-body box-profile">
                                        <span v-if="marksheet_list && marksheet_list != null">
                                            <span
                                                v-if="marksheet_list.marksheet_middle_sign && marksheet_list.marksheet_middle_sign != null">
                                                <img :src="marksheet_list.marksheet_middle_sign" style="height: 50px;"
                                                    class="center-cropped" />
                                            </span>
                                        </span>
                                        <label>Class Teacher Signature</label>
                                    </div>
                                </div>

                                <div class="col-4 float-right">
                                    <div class="box-body box-profile">
                                        <span v-if="marksheet_list && marksheet_list != null">
                                            <span
                                                v-if="marksheet_list.marksheet_right_sign && marksheet_list.marksheet_right_sign != null">
                                                <img :src="marksheet_list.marksheet_right_sign" style="height: 50px;"
                                                    class="center-cropped" />
                                            </span>
                                        </span>
                                        <label>Exam Head Signature</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            marksheet_list: {},
            student: {},
            marks_details: [],
            totalMarks : 0,
            maxTotal : 0,
            per: 0,
        };
    },
    mounted() {
        if (this.$route.params.marksheet_id && this.$route.params.student_admission_id && this.$route.params.examGroupId && this.$route.params.new_examId) {
            this.student_admission_id = this.$route.params.student_admission_id;
            this.marksheet_id = this.$route.params.marksheet_id;
            this.examGroupId = this.$route.params.examGroupId;
            this.new_examId = this.$route.params.new_examId;
            this.getGeneratedMarksheet();
            this.getMarks();
        } else {
            this.$router.go(-1);
        }
    },
    methods: {
        async getGeneratedMarksheet() {
            const res = await this.callApi(
                "get",
                `/api/school/examinations/design_marksheet/${this.student_admission_id}/${this.marksheet_id}`,
                null,
            );
            this.log('Marksheet data', res);
            this.log('student', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.marksheet_list = data.marksheetList;
                    this.student = data.student;
                }
            }
        },
        async getMarks() {
            var data = new FormData();
            data.append('exam_group_id', this.examGroupId);
            data.append('exam_id', this.new_examId);
            data.append('admission_id', this.student_admission_id);
            const res = await this.callApi(
                "post",
                `/api/school/examinations/design_marksheet/getMarks`,
                data,
            );
            this.log('Marks data', res);

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.marks_details = data.marks_details;
                    this.totalMarks = data.total;
                    data.marks_details.forEach(element => {
                        this.maxTotal += parseInt(element.exam_subjects.exam_maxmarks)

                    });
                    this.per = this.totalMarks/this.maxTotal * 100;
                    this.log(this.maxTotal)
                }
            }
        },
        marksGrade(oMarks, maxMarks) {
           let data = 0;
             data  = oMarks /maxMarks * 100;
            let grade = '';
            if (data >= 90 && data<=100) {
                grade = 'A+';
            }else if (data <= 90 && data >= 79) {
                grade = 'A';
            } else if (data <= 80 && data >= 69) {
                grade = 'B';
            }else if (data <= 70 && data >= 59) {
                grade = 'C';
            }else if (data <= 60 && data >= 49) {
                grade = 'D';
            } else if(data <= 49 && data >= 33) {
                grade = 'E';
            }else if(data <= 33 && data >= 0){
                grade = 'Fail';
            }
            return grade;
        }
    }
};
</script>

<style scoped>
th,
td {
    width: 4%;
    text-align: center;
}

table,
th,
td {
    border: 1px solid rgb(54, 51, 51);
}

div {
    font-size: 14px medium;
}


.sttext1 {
    font-size: 15px;
    font-weight: 15px;
}

.box-profile {
    height: 50px !important;
}

.signature {
    margin-bottom: 7%;
    padding-bottom: 30px;
    margin-top: 5%;
    height: auto;
}
.pl-5rem{
    padding-top: 1rem !important;
    padding-left: 5rem!important;
}
</style>
