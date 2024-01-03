<template>
    <div>
        <div class="modal-content add_exam_name">
            <div class="modal-header">
                <h4 class="modal-title">Add Subjects</h4>
                <button type="button" class="btn btn-info" @click="goBack()">Back</button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div class="row pb10">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-3">
                            <label><b>Exam</b></label><br>
                            <span v-if="examDetails != null">{{ examDetails.newExam_name }}</span>
                        </div>
                        <div class="col-lg-5 col-md-3 col-sm-12 col-xs-5">
                            <label><b> Group</b></label><br>
                            <span v-if="examDetails && examDetails.exam_groups != null">{{ examDetails.exam_groups }}</span>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-4">
                            <button type="button" name="add" class="btn btn-primary btn-sm add pull-right"
                                style="float:right" @click="showSubjects" autocomplete="off">
                                <span class="fa fa-plus"></span> Add Subjects
                            </button>
                        </div>
                    </div>
                </div>

                <!-- <input type="hidden" name="exam_group_class_batch_exam_id" value="6"> -->
                <div class="col-12">
                    <div class="row subject-row" v-for="item, index in addSubjectArray" :key="index">
                        <div class="col-12 form-group ">
                            <span class="text text-danger remove fa fa-times py-2 pointer" style="float:right"
                                @click="closeSubjects(item, index)"></span>
                        </div>
                        <div class="col-3 form-group">
                            <label>Subject</label>
                            <Select2 ref="subject_list" class="placeholder" :items="subject_list" v-model="item.subject" />
                        </div>
                        <div class="col-3">
                            <label>Date From</label>
                            <DatePicker class="form-group placeholder" format="DD-MMM-YYYY" value-type="format" type="date"
                                placeholder="Select a date" v-model="item.displayDate" :default-value="new Date()" />
                        </div>
                        <div class="col-3 form-group">
                            <label>Time</label>
                            <br />
                            <input class="placeholder" placeholder="Enter Exam Time" type="time" v-model="item.exam_time" />
                        </div>
                        <div class="col-3 form-group">
                            <label>Duration</label>
                            <input type="text" class="placeholder set-width" placeholder="Enter Exam Duration"
                                v-model="item.exam_duration" />
                        </div>
                        <div class="col-3 form-group">
                            <label>Room No</label>
                            <input class="placeholder set-width" type="text" placeholder="Enter Room No."
                                v-model="item.room_no" />
                        </div>
                        <div class="col-3 form-group">
                            <label>Marks(max.)</label>
                            <input class="placeholder set-width" placeholder="Enter Max Marks" type="number"
                                v-model="item.exam_maxmarks" />
                        </div>
                        <div class="col-3 form-group">
                            <label>Marks(min.)</label>
                            <input class="placeholder set-width" placeholder="Enter Min marks" type="number"
                                v-model="item.exam_minmarks" />
                        </div>
                    </div>
                    <div class="divider2"></div>
                </div>
            </div>

            <div class="row">
                <button type="submit" class="btn btn-primary save" id="load" @click.prevent="submitData()"
                    data-loading-text="<i class='fa fa-spinner fa-spin '></i> Saving...">{{ frmBtn }}</button>
            </div>
        </div>
    </div>
</template>

<script>
// import AddExamSubjects from '../examSchedule/AddExamSubjects';
var toast;
export default {
    //  components:{
    // AddExamSubjects
    //  },
    data() {
        return {
            tableData: [],
            isLoaded: false,
            noData: false,
            editedIndex: -1,
            examDetails: {},
            studentModelClose: false,
            showSubjectModel: false,
            subject_list: [],

            addSubjectArray: [{
                subject: '',
                exam_time: '',
                displayDate: '',
                exam_duration: '',
                exam_maxmarks: '',
                exam_minmarks: '',
                room_no: '',
            }],
            tdDate: false,
            displayDate: "",
        };
    },
    computed: {
        frmBtn: function () {
            return this.editedIndex !== -1 ? 'Update' : 'Save';
        },
    },
    watch: {
        displayDate: function (val) {
            this.displayDate = val;
            this.exam_date = moment(new Date(val)).format("YYYY-MM-DD");
        },
    },
    created() {
        if (this.$route.params.examGroup_id && this.$route.params.newExam_id) {
            this.examGroup_id = this.$route.params.examGroup_id;
            this.newExam_id = this.$route.params.newExam_id;
        }
        this.getSubjects();
        this.getData();
    },

    methods:
    {
        goBack() {
            this.$router.go(-1);
        },
        disabledAfterToday(date) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            return date > today;
        },
        showSubjects() {
            this.addSubjectArray.push({
                subject: '',
                exam_time: '',
                displayDate: '',
                exam_duration: '',
                exam_maxmarks: '',
                exam_minmarks: '',
                room_no: '',
            });
            var i = this.addSubjectArray.length - 1;
            setTimeout(() => {
                this.$refs.subject_list[i].updateList(this.subject_list);
            }, 500);
        },
        closeSubjects(item, index) {
            this.addSubjectArray.splice(index, 1);
        },
        async getSubjects() {
            const res = await this.callApi(
                "get",
                `/api/school/academics/school_subjects`,
                null
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.subject_list = data.school_subjects;
                    this.$refs.subject_list[0].updateList(data.school_subjects);
                }
            }
        },
        selectSubject(subjectId) {
            this.subjectId = subjectId;
        },

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
        async submitData() {
            toast = Toast.fire({
                icon: "warning",
                title: "Please Wait!! Creating new Exam",
                timer: 0,
            });
            var data = new FormData();
            data.append('examgroup_id', this.examGroup_id ? this.examGroup_id : '');
            data.append('exam_id', this.newExam_id ? this.newExam_id : '');
            this.addSubjectArray.forEach((item, index) => {
                data.append('date_from[]', item.displayDate ? moment(new Date(item.displayDate)).format("YYYY-MM-DD") : '');
                data.append('start_time[]', item.exam_time ? item.exam_time : '');
                data.append('duration[]', item.exam_duration ? item.exam_duration : '');
                data.append('room_no[]', item.room_no ? item.room_no : '');
                data.append('max_marks[]', item.exam_maxmarks ? item.exam_maxmarks : '');
                data.append('min_marks[]', item.exam_minmarks ? item.exam_minmarks : '');
                data.append('subjects[]', this.$refs.subject_list[index].$refs.commonSelect2.value);
            })
            let url = "";
            if (this.editedIndex != -1) {
                url = `/api/school/examinations/addexam_subjects/update/${this.editedIndex}`;
            } else {
                url = `/api/school/examinations/addexam_subjects/save`;
            }
            const res = await this.callApi("post", url, data);
            this.log('REQUEST', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.resetForm();

                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    })
                    this.$router.go(-1);
                }
                else {
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
            this.editItem = {}
            this.session_id = -1
            this.editedIndex = -1
        },
    },
};
</script>

<style scoped>
.td_subject {
    border: none;
    border-color: antiquewhite;
}

input {
    padding: 5px;
    border: none;
}

.btn.save {
    margin-left: 35px;
    align-items: center;
    margin-bottom: 20px;
}

.form-group {
    border: 1px !important;
}

.row.pb10 {
    margin-bottom: 5%;
}

.model-body {
    height: 80%;
}

.bottom-space {
    margin-bottom: 20px;
}

.col-3.form-group {
    margin-top: 5px;
}

.subject-row {
    border: 1px solid rgb(187, 179, 179);
    margin-bottom: 20px;
}

input .placeholder {
    color: rgb(192, 190, 190);
}

.set-width {
    width: 150px;
}
</style>
