<template>
    <div>
        <div class="container">
            <div class="modal-content">
                <div class="modal-body" id="card_detail">
                    <div class="modal-inner-content">
                        <div class="header">
                            <span class="left-span">Date, Time</span>
                            <span class="right-span float-right">Ezone school</span>
                        </div>
                        <div class="heading-layout col-12 text-center">
                            <span class="sttext1">EZY SCHOOL EXAM</span><br>
                            <span><u>SCHOOL</u></span><br>
                            <span><u>Secondary Examinations 2021-2022</u></span>
                        </div>

                        <!-- <div class="student-detail col-12">


                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row d-flex ">
                                            <div class="col-md-3">
                                                <label>ROLL NUMBER</label>
                                            </div>
                                            <div class="col-5"><b>10002</b>
                                            </div>
                                        </div>
                                        <div class="row d-flex ">
                                            <div class="col-md-3">
                                                <label>NAME </label>
                                            </div>
                                            <div class="col-5"><b>Yash Chopra</b>
                                            </div>
                                        </div>
                                        <div class="row d-flex">
                                            <div class="col-md-3"> CLASS
                                            </div>
                                            <div class="col-md-5"><b>5 </b>
                                            </div>
                                        </div>
                                        <div class="row d-flex">
                                            <div class="col-md-3 "> DOB
                                            </div>
                                            <div class="col-md-5 "><b>15/07/2004</b>
                                            </div>
                                        </div>

                                        <div class="row d-flex float-right right-row">
                                            <div class="col-3"> FATHERS NAME
                                            </div>
                                            <div class="col-md-5 "><b>MAYANK DEVRA</b>
                                            </div>
                                        </div>
                                        <div class="row d-flex float-right">
                                            <div class="col-3"> MOTHERS NAME
                                            </div>
                                            <div class="col-md-5"><b>MAYANK DEVRA</b>
                                            </div>
                                        </div>
                                        <div class="row d-flex float-right">
                                            <div class="col-5"><b>SCHOOL NAME</b>
                                            </div>
                                            <div class="ml-5"><b> JOHNSAN SCHOOL</b>
                                            </div>
                                        </div>
                                        <div class="row d-flex float-right">
                                            <div class="col-5"><b>CENTER </b>
                                            </div>
                                            <div class="ml-5"><b>LUCKY SCHOOL</b>
                                            </div>
                                        </div>
                                </div>

                            <div class="col-3 right-logo float-right">
                                <div class="box-body box-profile">
                                    <div class="box box-primary">
                                        <img src="/assets/img/logo.png" style="width:200px; height:150px;">
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div> -->

                        <div class="mark-container">
                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tbody>
                                    <!-- <tr>
                        <td valign="top">
                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tbody><tr>
                                    <td valign="top" align="center" width="100">
                                                                            </td>
                                    <td valign="top">
                                        <table cellpadding="0" cellspacing="0" width="100%">
                                                                                            <tbody><tr>
                                                    <td valign="top" style="font-size: 26px; font-weight: bold; text-align: center; text-transform: uppercase; padding-top: 10px;">EZY SCHOOL EXAM 21-22</td>
                                                </tr>

                                            <tr><td valign="top" height="5"></td></tr>
                                                                                            <tr>
                                                    <td valign="top" style="font-size: 20px;text-align: center; text-transform: uppercase; text-decoration: underline;">
                                                        EZY SCHOOL</td>
                                                </tr>

                                        </tbody></table>
                                    </td>
                                    <td width="100" valign="top" align="center">
                                                                            </td>

                                </tr>
                            </tbody></table>
                        </td>
                    </tr> -->

                                    <!-- <tr>
                        <td valign="top" style="text-align: center; text-transform: capitalize; text-decoration: underline; font-weight: bold; padding-top: 5px;">May-June 2022 Examinations </td>
                    </tr> -->

                                    <tr>
                                        <td valign="top" height="10"></td>
                                    </tr>
                                    <tr>
                                        <td valign="top">
                                            <table cellpadding="0" cellspacing="0" width="100%"
                                                style="text-transform: uppercase;">
                                                <tbody>
                                                    <tr>
                                                        <td valign="top">
                                                            <table cellpadding="0" cellspacing="0" width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td valign="top" width="25%"
                                                                            style="padding-bottom: 10px;"> Roll Number
                                                                        </td>
                                                                        <td valign="top" width="30%"
                                                                            style="font-weight: bold;padding-bottom: 10px;">
                                                                            <span v-if="students && students != null">{{students.student_roll_number}}</span>
                                                                        </td>
                                                                        <td valign="top" width="20%"
                                                                            style="padding-bottom: 10px;"> Admission No
                                                                        </td>
                                                                        <td valign="top" width="25%"
                                                                            style="font-weight: bold;padding-bottom: 10px;">
                                                                            <span v-if="students && students != null">{{students.student_admission_number}}</span>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td valign="top" style="padding-bottom: 10px;">
                                                                            Student's Name</td>
                                                                        <td valign="top"
                                                                            style="text-transform: uppercase; font-weight: bold;padding-bottom: 10px;">
                                                                            <span v-if="students && students != null">
                                                                            {{students.student_first_name}}
                                                                            {{ students.student_middle_name }}
                                                                            {{ students.student_last_name }}
                                                                            </span>
                                                                        </td>
                                                                        <td valign="top" style="padding-bottom: 10px;">
                                                                            Class
                                                                        </td>
                                                                        <td valign="top"
                                                                            style="text-transform: uppercase; font-weight: bold;padding-bottom: 10px;">
                                                                            <span  v-if="students.school_class && students.school_class.class_name != null">
                                                                              {{ students.school_class.class_name }}
                                                                            </span>
                                                                             <span  v-if="students.school_section && students.school_section.section_name != null">
                                                                              {{ students.school_section.section_name }}
                                                                            </span>
                                                                            </td>
                                                                   </tr>

                                                                    <tr>
                                                                        <td valign="top" style="padding-bottom: 10px;">
                                                                            D.O.B</td>
                                                                        <td valign="top"
                                                                            style="text-transform: uppercase; font-weight: bold;padding-bottom: 10px;">
                                                                            8/10/2002</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td valign="top" style="padding-bottom: 10px;">
                                                                            Fathers Name</td>
                                                                        <td valign="top"
                                                                            style="text-transform: uppercase; font-weight: bold;padding-bottom: 10px;">
                                                                            Olivier Thomas</td>

                                                                        <td valign="top" style="padding-bottom: 10px;">
                                                                            Mothers Name</td>
                                                                        <td valign="top"
                                                                            style="text-transform: uppercase; font-weight: bold;padding-bottom: 10px;">
                                                                            Caroline Thomas</td>

                                                                    </tr>

                                                                    <tr>
                                                                        <td valign="top" style="padding-bottom: 10px;">
                                                                            School Name</td>
                                                                        <td valign="top" colspan="3"
                                                                            style="text-transform: uppercase; font-weight: bold;padding-bottom: 10px;">
                                                                            EZY SCHOOL </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td valign="top" style="padding-bottom: 10px;">
                                                                            Exam Center</td>
                                                                        <td valign="top" colspan="3"
                                                                            style="text-transform: uppercase; font-weight: bold;padding-bottom: 10px;">
                                                                            EZY SCHOOL Housing Board </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                        <td valign="top" width="25%" align="right">
                                                            <img src="https://ezonebarmer.ezyschool.in/uploads/student_images/no_image.png"
                                                                width="100" height="100">
                                                        </td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" height="10"></td>
                                    </tr>
                                    <tr>
                                        <td valign="top">
                                            <table cellpadding="0" cellspacing="0" width="100%" class="denifittable table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <th valign="top"
                                                            style="text-align: center; text-transform: uppercase;">
                                                            Theory Exam Date &amp; Time</th>
                                                        <th valign="top"
                                                            style="text-align: center; text-transform: uppercase;">Paper
                                                            Code</th>
                                                        <th valign="top"
                                                            style="text-align: center; text-transform: uppercase;">
                                                            Subject</th>
                                                        <th valign="top"
                                                            style="text-align: center; text-transform: uppercase;">Opted
                                                            By Student</th>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top" style="text-align: center;">03-Jun-2022 2 P.M.
                                                            - 5 P.M.</td>
                                                        <td style="text-align: center;text-transform: uppercase;">7713
                                                        </td>
                                                        <td style="text-align: center;text-transform: uppercase;">
                                                            Mathematics</td>
                                                        <td style="text-align: center;text-transform: uppercase;">TH
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top" style="text-align: center;">03-Jun-2022 2 P.M.
                                                            - 5 P.M.</td>
                                                        <td style="text-align: center;text-transform: uppercase;">7714
                                                        </td>
                                                        <td style="text-align: center;text-transform: uppercase;">
                                                            Sceince</td>
                                                        <td style="text-align: center;text-transform: uppercase;">TH
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top" style="text-align: center;">03-Jun-2022 2 P.M.
                                                            - 5 P.M.</td>
                                                        <td style="text-align: center;text-transform: uppercase;">7715
                                                        </td>
                                                        <td style="text-align: center;text-transform: uppercase;">
                                                            English</td>
                                                        <td style="text-align: center;text-transform: uppercase;">TH
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top" style="text-align: center;">03-Jun-2022 2 P.M.
                                                            - 5 P.M.</td>
                                                        <td style="text-align: center;text-transform: uppercase;">7716
                                                        </td>
                                                        <td style="text-align: center;text-transform: uppercase;">Social
                                                            Science</td>
                                                        <td style="text-align: center;text-transform: uppercase;">TH
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" height="5"></td>
                                    </tr>

                                    <tr>
                                        <td valign="top" height="20px"></td>
                                    </tr>
                                </tbody>
                            </table>
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
            admit_card_list:{},
            students:{},
        };
    },
    mounted() {
        if (this.$route.params.admitCard_id && this.$route.params.student_admission_id) {
            this.student_admission_id = this.$route.params.student_admission_id;
            this.admitCard_id = this.$route.params.admitCard_id;
                this.getGeneratedAdmitCards();
        } else {
            this.$router.go(-1);
        }
    },
    methods:{
         async getGeneratedAdmitCards(){
            const res = await this.callApi(
                "get",
                 `/api/school/examinations/print_admit_card/${this.student_admission_id}/${this.admitCard_id}`,
                 null,
                 );
                this.log('Admit Cards',res) ;
                this.log('Students',res) ;
                if (res.status == 200) {
                     var data = res.data;
                if(data.status == "success"){
                    this.admit_card_list = data.admitCardList;
                    this.students = data.student;
                }
            }


        }
    },

};
</script>

<style scoped>
.sttext1 {
    font-size: 24px;
    line-height: 30px;
}

.right-logo {
    margin-bottom: 5%;
    margin-right: 0%;
    margin-left: 0%;
}
</style>
