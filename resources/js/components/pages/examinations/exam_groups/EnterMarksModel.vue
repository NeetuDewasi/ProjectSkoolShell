<template>
    <div>
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Exam Students</h4>
                <button type="button" class="btn btn-info" @click="goBack()">Back</button>
                <!-- <button type="button" class="close" data-dismiss="modal" autocomplete="off"
        @click="()=>{ studentModelClose =false}">×</button>-->
            </div>
            <div class="modal-body">
                <div>
                    <input type="hidden" name="exam_id" value="6" class="exam_group_class_batch_exam_id" />
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Class</label>
                                <small class="req">*</small>
                                <Select2 ref="class_list" placeholder="--SELECT A CLASS--" :items="class_list"
                                    @change="selectClass" />
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="esection">Section</label>
                                <small class="req">*</small>
                                <Select2 ref="section_list" :items="section_list" @change="selectSection" />
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-sm-4 form-group">
                            <label for="exam">Session</label>
                            <Select2 :item="sessionList" ref="sessionList" @change="selectSession"
                                placeholder="--SELECT A SESSION--" />
                            <span class="text text-danger" id="session_id_error"></span>
                        </div>
                    </div>

                    <div class="col-sm-12 btn-search float-end">
                        <button type="button" class="btn btn-primary btn-sm checkbox-toggle"
                            @click="getData(sectionId, classId)">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>
                </div>
                <div class="table table-responsive">
                    <table>
                        <thead>
                            <th>Admission No.</th>
                            <th>Roll Number</th>
                            <th>Student Name</th>
                            <th>Father Name</th>
                            <th>Category</th>
                            <th>Gender</th>
                            <th>Attendance</th>
                            <th>Marks</th>
                            <th>Note</th>
                        </thead>
                        <tbody>
                            <tr v-for="student in studentList" :key="student.student_admission_id">
                                <td>

                                    {{ student.student_admission_number }}
                                </td>
                                <td>{{ student.student_roll_number }}</td>
                                <td>{{ student.student_first_name }} {{ student.student_last_name }}</td>
                                <td>
                                    <span
                                        v-if="student.student_guardian != null && student.student_guardian.father != null">{{ student.student_guardian.father.first_name
                                        }} {{ student.student_guardian.father.last_name }}
                                    </span>
                                </td>
                                <td><span
                                        v-if="student.student_category != null && student.student_category.category_name != null">
                                        {{ student.student_category.category_name }}
                                    </span>
                                </td>
                                <td>{{ student.student_gender }}</td>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input checkAll" id="select_check"
                                            ref="attendance" />
                                        <label class="form-check-label">
                                            Absent
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <input style="width:100px;" type="text" placeholder="Enter Marks" ref="marks" />
                                </td>
                                <td>
                                    <input style="width:100px;" type="text" ref="note" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <button type="submit" class="btn btn-primary pull-right" id="load" @click.prevent="submitData()"
                    data-loading-text="<i class='fa fa-spinner fa-spin '></i> Saving...">{{ frmBtn }}</button>
            </div>
        </div>
    </div>
</template>

<script>
var toast;
export default {
    data() {
        return {
            // tableHead: {
            //     items: {
            //         item1: { label: 'Admission No.' },
            //         item2: { label: 'Student Name' },
            //         item3: { label: 'Father Name' },
            //         item4: { label: 'Category' },
            //         item5: { label: 'Gender' },
            //         // item6: { label: 'Marks' },
            //         // item7: { label: 'Note' },
            //     },
            //     actions: true,
            // },
            studentModelClose: false,
            tableData: [],
            isLoaded: false,
            noData: false,
            tableStudentData: [],
            class_list: [],
            section_list: [],
            selectedSection: -1,
            classId: -1,
            editedIndex: -1,
            selecteIds: [],
            student_category: {},
            subjectDetails: {},
            studentList: [],
            sessionList: [],
            sectionId: -1
        };
    },
    computed: {
        frmBtn: function () {
            return this.editedIndex !== -1 ? 'Update' : 'Save';
        },
    },

    created() {
        if (this.$route.params.examGroup_id && this.$route.params.newExam_id && this.$route.params.subject_id) {
            this.examGroup_id = this.$route.params.examGroup_id;
            this.newExam_id = this.$route.params.newExam_id;
            this.subject_id = this.$route.params.subject_id;
            this.log(this.$route.params.subject_id);
        }
        this.getClassList();
        this.getExamSubjectData();
        this.getSession();
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
        selectSection(section_id) {
            this.sectionId = section_id;
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
        selectSession(val) {
            this.session_id = val;
        },
        async getExamSubjectData() {
            this.isLoaded = false;
            var data = new FormData();
            data.append('examgroup_id', this.examGroup_id);
            data.append('exam_id', this.newExam_id);
            const res = await this.callApi(
                "post",
                `/api/school/examinations/addexam_subjects`,
                data
            );
            this.log('Exam Subject DATA', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.examSubjects = data.exam_subjects;
                }
            }
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
                    this.studentList = data.student_admissions;
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
            data.append('subject_id', this.subject_id ? this.subject_id : '');
            data.append('class_id', this.classId ? this.classId : '');
            data.append('section_id', this.sectionId ? this.sectionId : '');
            data.append('session_id', this.session_id ? this.session_id : '');
            console.log('Student List', this.studentList);
            this.studentList.forEach((student, index) => {
                data.append('admission_id[]', student.student_admission_id);
                data.append('absent[]', this.$refs.attendance ? this.$refs.attendance[index].checked : '');
                data.append('marks[]', this.$refs.marks ? this.$refs.marks[index].value : '');
                data.append('note[]', this.$refs.note ? this.$refs.note[index].value : '');
            });
            let url = "";
            if (this.editedIndex != -1) {
                url = `/api/school/examinations/assign_marks/update/${this.editedIndex}`;
            } else {
                url = `/api/school/examinations/assign_marks/save`;
            }
            console.log("DATA>>>", data);
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

<style>
.row.d-flex.file-upload {
    border-radius: 30px;
    border-color: rgb(43, 41, 41);
}

.dropify-wrapper {
    display: block;
    position: relative;
    cursor: pointer;
    width: 100%;
    max-width: 100%;
    height: 28px;
    padding: 0px 5px;
    /* font-size: 14px; */
    line-height: 26px;
    color: #777;
    background-color: #FFF;
    background-image: none;
    text-align: center;
    border: 1px solid #ccc;
    -webkit-transition: border-color .15s linear;
    transition: border-color .15s linear;
}

.dropify-wrapper,
.dropify-wrapper .dropify-clear {
    font-family: Roboto, "Helvetica Neue", Helvetica, Arial;
}

.btn-search {
    margin-left: 80%;
}

.dropify-wrapper {
    text-align: left !important;
    border-bottom: 1px solid #f4f4f4 !important;
    border-top: 0 !important;
    border-left: 0 !important;
    border-right: 0 !important;
}


.dropify-wrapper .dropify-loader {
    position: absolute;
    top: 15px;
    right: 15px;
    display: none;
    z-index: 9;
}

.dropify-wrapper .dropify-errors-container {
    position: absolute;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    z-index: 3;
    background: rgba(243, 65, 65, .8);
    text-align: left;
    visibility: hidden;
    opacity: 0;
    -webkit-transition: visibility 0s linear .15s, opacity .15s linear;
    transition: visibility 0s linear .15s, opacity .15s linear;
}

.dropify-wrapper .dropify-errors-container ul {
    padding: 10px 20px;
    margin: 0;
    position: absolute;
    left: 0;
    top: 50%;
    -webkit-transform: translateY(-50%);
    transform: translateY(-50%);
}

ul {
    display: block;
    list-style-type: disc;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    padding-inline-start: 40px;
}

.dropify-wrapper input {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    height: 100%;
    width: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 5;
}

input[type=file] {
    display: block;
    border: none;
    outline: 0;
    opacity: 0;
    margin-top: 5px;
}

.dropify-wrapper .dropify-preview {
    display: none;
    position: absolute;
    z-index: 1;
    background-color: #FFF;
    padding: 4px;
    width: 100%;
    height: 100%;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    overflow: hidden;
    text-align: center;
}

.dropify-wrapper .dropify-preview .dropify-infos {
    position: absolute;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    z-index: 3;
    background: rgba(0, 0, 0, .7);
    opacity: 0;
    -webkit-transition: opacity .15s linear;
    transition: opacity .15s linear;
}

.dropify-wrapper .dropify-preview .dropify-infos .dropify-infos-inner {
    position: absolute;
    top: 50%;
    -webkit-transform: translate(0, -50%);
    transform: translate(0, -50%);
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    width: 100%;
    padding: 0 20px;
    -webkit-transition: all .2s ease;
    transition: all .2s ease;
}

.dropify-wrapper .dropify-preview .dropify-infos .dropify-infos-inner p {
    padding: 0;
    margin: 0;
    position: relative;
    width: 100%;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    color: #FFF;
    text-align: center;
    line-height: 25px;
    font-weight: 700;
}

p {
    display: block;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
}

.dropify-wrapper .dropify-preview .dropify-infos .dropify-infos-inner p.dropify-infos-message {
    margin-top: -24px;
    padding-top: 13px;
    font-size: 11px;
    position: relative;
    opacity: .5;
}
</style>
