<template>
    <div>

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header ">
                    <h4 class="modal-title folat-left"> Exam Subjects</h4>
                     <button type="button" class="btn btn-info" @click="goBack()">Back</button>
                </div>

                    <div class="row pb10">
                        <div class="col-lg-2 col-md-3 col-sm-12 col-xs-6 mx-5">
                        <label><b> Exam Name</b></label><br>
                        <span v-if="examDetails !=null">{{examDetails.newExam_name}}</span>
                        </div>

                        <div class="col-lg-2 col-md-3 col-sm-12 col-xs-6">
                            <label><b> Group</b></label><br>
                           <span v-if="examDetails && examDetails.exam_groups!=null">{{examDetails.exam_groups}}</span>
                        </div>
                    </div>
                    <!--./row--> <div class="table table-responsive" v-show="!noData">
                        <Table ref="table" :tableData="tableData" :tableHead="tableHead" />
                    </div>
                    <NoData v-show="noData" />
                    <div class="divider2"></div>
                    <!-- <div class="table-responsive row">
                        <table class="table table-bordered" id="subjects_table">
                             <thead>
                                <tr>
                                    <th class="col-sm-3">Subject</th>
                                    <th class="">Date From</th>
                                    <th class="">Start Time</th>
                                    <th class="">Duration</th>
                                    <th class="">Room No</th>
                                    <th class="">Marks (Max..)</th>
                                    <th class="">Marks (Min..)</th>
                                    <th class="text-right">Enter Marks</th>
                                </tr>
                            </thead> -->
                            <!-- <tbody>
                                <tr>
                                    <td>
                                        <input class="form-control" type="text">
                                    </td>
                                    <td>21-03-2023</td>
                                    <td>10:30:00</td>
                                    <td>2</td>
                                    <td>109</td>
                                    <td>100.00</td>
                                    <td>33.00</td>
                                    <td class="col-sm-1 text-right">
                                        <button type="button" class="btn btn-default btn-xs" data-toggle="modal"
                                            data-target="#subjectModal" data-subject_name="Hindi" data-subject_id="14"
                                            data-teachersubject_id="1" data-original-title="" title=""
                                            autocomplete="off"><i class="fa fa-newspaper-o"
                                                aria-hidden="true"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>English</td>
                                    <td>22-03-2023</td>
                                    <td>10:30:00</td>
                                    <td>2</td>
                                    <td>108</td>
                                    <td>100.00</td>
                                    <td>33.00</td>
                                    <td class="col-sm-1 text-right">
                                        <button type="button" class="btn btn-default btn-xs" data-toggle="modal"
                                            data-target="#subjectModal" data-subject_name="English" data-subject_id="15"
                                            data-teachersubject_id="2"><i class="fa fa-newspaper-o"
                                                aria-hidden="true"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Maths</td>
                                    <td>23-03-2023</td>
                                    <td>10:30:00</td>
                                    <td>2</td>
                                    <td>109</td>
                                    <td>100.00</td>
                                    <td>33.00</td>
                                    <td class="col-sm-1 text-right">
                                        <button type="button" class="btn btn-default btn-xs" data-toggle="modal"
                                            data-target="#subjectModal" data-subject_name="Maths" data-subject_id="16"
                                            data-teachersubject_id="3"><i class="fa fa-newspaper-o"
                                                aria-hidden="true"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>-->
            </div>
        </div>
</template>

<script>
export default {
    data() {
        return {
            tableHead: {
                items: {
                    item1: { label: 'Sr.No.' },
                    item2: { label: 'Subjects' },
                    item3: { label: 'Date From' },
                    item4: { label: 'Start Time' },
                    item5: { label: 'Duration' },
                    item6: { label: 'Room No.' },
                    item7: { label: 'Marks(max.)' },
                    item8: { label: 'Marks(min.)' },
                },
                actions: false,
            },
            tableData: [],
            isLoaded: false,
            noData: false,
            subjectDetails:[],
            examGroup_id:-1,
            newExam_id:-1,
            subjectList:[],
            examDetails:{},
        };
    },
  created(){
     if (this.$route.params.examGroup_id && this.$route.params.newExam_id) {
            this.examGroup_id = this.$route.params.examGroup_id;
            this.log('Group>>',this.$route.params.examGroup_id);
            this.newExam_id = this.$route.params.newExam_id;
            this.log(this.$route.params.newExam_id);
        }
  },
  mounted(){
    this.$parent.loadOtherScript();
    this.getData();
    this.getExamSubjectData();
  },
  methods:{
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
            async getExamSubjectData() {
                this.isLoaded = false;
                var data = new FormData();
                data.append('examgroup_id', this.examGroup_id);
                data.append('exam_id', this.newExam_id);
                const res = await this.callApi(
                    "post",
                    `/api/school/examinations/assign_marks`,
                    data
                );
                this.log('Exam Subject DATA', res);
                if (res.status == 200) {
                    var data = res.data;
                    if (data.status == "success") {
                        this.subjectDetails = data.exam_subjects;
                        this.initTable();
                    }
                }
                this.$refs.table.loadTable();
                this.isLoaded = true;
            },
        initTable() {
            this.tableData = [];
            this.subjectDetails.forEach((element) => {
                this.tableData.push({
                    // id: element.exam_subject_id,
                    item: element,
                    data: {
                        item1: element.exam_subject_id ? element.exam_subject_id : '',
                        item2: element.subjects.name ? element.subjects.name : '',
                        item3: element.exam_date ? element.exam_date : '',
                        item4: element.exam_time ? element.exam_time : '',
                        item5: element.exam_duration ? element.exam_duration : '',
                        item6: element.exam_room_no ? element.exam_room_no : '',
                        item7: element.exam_maxmarks ? element.exam_maxmarks : '',
                        item8: element.exam_minmarks ? element.exam_minmarks : '',
                        item9: {
                            type: "action",
                            options: {
                                style: "border:none",
                                // class: "btn btn-info",
                                icon: '<i class="fa fa-newspaper" title="Enter Marks"></i>',
                                method: this.enterMarks
                            },
                        },
                    },
                    action: {
                        edit: false,
                        delete: false,
                    },
                });
            });

        },
        enterMarks(item) {
             this.$router.push({
                path: `/school/examinations/enter_marks_model/${this.examGroup_id}/${this.newExam_id}/${item.exam_subject_id}`
            });
             this.log(item.subject_id);
        },
         goBack() {
            this.$router.go(-1);
        },

  },
};
</script>

