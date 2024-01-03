<template>
    <div>
        <div>
            <div class="content-wrapper" style="min-height: 606px;">
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header ptbnull">
                                    <h3 class="box-title titlefix"> Exam List</h3>
                                    <div class="impbtntitle">
                                        <div class="btn btn-primary" @click="newExamForm()">New Exam</div>
                                        <a tabindex="-1" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#examconnectModal" data-examgroup_id="3" data-original-title=""
                                            @click="()=>{ examModel = true}"> Link Exams</a>
                                            <button type="button" class="btn btn-info text-light" @click="goBack()">Back</button>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <input type="hidden" name="current_session" id="current_session" value="18">

                                    <div class="row pb10">
                                        <div class="col-lg-2 col-md-3 col-sm-12 col-xs-6">
                                            <label><b> Group</b></label><br>
                                           <span v-if="examGroup != null">{{ examGroup.examGroup_name }}</span>
                                        </div>

                                        <div class="col-lg-2 col-md-3 col-sm-12 col-xs-6">
                                            <label><b>Exam Type</b></label><br>
                                            <span
                                                v-if="examGroup.examGroup_type && examGroup.examGroup_type.name!= null">{{examGroup.examGroup_type.name}}</span>
                                        </div>
                                        <!--./col-lg-4-->
                                        <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                                                <label><b>Description </b></label><br>
                                                <span
                                                    v-if="examGroup && examGroup.examGroup_description!= null">{{examGroup.examGroup_description}}</span>
                                        </div>
                                        <!--./col-lg-4-->

                                    </div>
                                    <!--./row-->
                                    <div class="divider2"></div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="hidden" id="examgroup_id">
                                        </div>
                                    </div>

                                    <div class="table table-responsive" v-show="!noData">
                                        <Table ref="table" :tableData="tableData" :tableHead="tableHead" />
                                    </div>
                                    <NoData v-show="noData" />
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div>
            <div id="examconnectModal" class="modal fade in" :class="examModel ? 'show':''" role="dialog"
                aria-hidden="false">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="heading-layout">
                                <h4 class="modal-title mr-5" style="float:left;" id="myModalLabel"> Link Exam</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                    @click="()=>{ examModelClose =false}">×</button>
                            </div>
                        </div>
                        <div class="modal-body examconnectModalBody">
                            <div>
                                <table class="table table-strippedn table-hover mb10">
                                    <thead>
                                        <tr class="active">
                                            <th width="20">
                                                <input type="checkbox" class="select-all checkbox" id="ckbCheckAll">
                                            </th>
                                            <th>Exam</th>
                                            <th>Weightage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="" v-for="(exam, index) in namesList" :key="exam.newExam_id">
                                            <td>
                                                <input :id="`examChecked${index}`" type="checkbox"
                                                    @change.prevent="selectExams(exam, index)" />
                                            </td>
                                            <td>
                                                {{exam.newExam_name}}
                                            </td>
                                            <td>
                                                Weightage
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <button type="submit" class="btn btn-danger mx-2" id="load" name="reset"
                                        data-loading-text="<i class='fa fa-spinner fa-spin '></i> Saving...">Reset Link
                                        Exam</button>
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-primary" id="load" name="save"
                                            data-loading-text="<i class='fa fa-spinner fa-spin '></i> Saving...">Save</button>
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
                    name: "Exam List",
                },
            ],
            tableHead: {
                items: {
                    item1: { label: 'Sr. No.' },
                    item2: { label: 'Exam Name' },
                    item3: { label: 'Session' },
                    // item4: { label: 'Subjects Included' },
                    item4: { label: 'Publish' },
                    item5: { label: 'Publish Result' },
                },
                actions: true,
            },

            tableData: [],
            isLoaded: false,
            noData: false,
            examSchedule: [],
            examModel: false,
            examModelClose: false,
            // subjectModelClose: false,
            // showStudentModel: false,
            showSubjectModel: false,
            examGroup_id: -1,
            examGroup_list: [],
            examGroup:{},
            exam_names: [],
            namesList: [],
            editItem: {
                examIds: []
            },
            examGroup_type:{},
        };
    },
    created() {
        if (this.$route.params.examGroup_id) {
            this.examGroup_id = this.$route.params.examGroup_id;
            toast = Toast.fire({
                icon: 'warning',
                title: 'Loading Data ..',
                timer: 0
            });
            this.showData();
        }
    },
    filterData() {
        if (this.selectedClass != -1) {
            if (this.selectedSection != -1) {
                return this.tableStudentData.filter(item => {
                    return item.data.item4 == (this.selectedClassName + ' ' + this.selectedSectionName);
                })
            }
            return this.tableStudentData.filter(item => {
                return item.data.item4.includes(this.selectedClassName);
            });
        }
        return this.tableStudentData;
    },
    mounted() {
        this.$parent.loadOtherScript();
    },
    methods: {
        goBack() {
            this.$router.go(-1);
        },
        selectExams(examId, index) {
            console.log('Exam link id',examId);
            if (this.editItem.examIds && this.editItem.examIds.includes(examId.newExam_id)) {
                this.editItem.examIds.splice(this.editItem.examIds.indexOf(examId.newExam_id), 1);
                $('#examChecked' + index).prop('checked', false)
            } else {
                this.editItem.examIds.push(examId.newExam_id);
                $('#examChecked' + index).prop('checked', true)
            }
        },

        async showData() {
            this.isLoaded = false;
            const res = await this.callApi(
                "get",
                `/api/school/examinations/addNew_exam/${this.examGroup_id}`,
                null,
            );
            // console.log("SHOWDATA>>>", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.namesList = data.exam_names;
                    this.examGroup = data.exam_group;
                    this.initTable();
                } else {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                    this.noData = true;
                }
            } else {
                toast = Toast.fire({
                    icon: data.status,
                    title: data.message,
                    timer: 2500,
                });
            }
            this.$refs.table.loadTable();
            this.isLoaded = true;
            toast.close();
        },
        initTable() {
            this.tableData = [];
            this.namesList.forEach((element) => {
                this.tableData.push({
                    item: element,
                    data: {
                        item1: element.newExam_id,
                        item2: element.newExam_name != null ? element.newExam_name : '',
                        item3: element.schoolSession != null ? element.schoolSession : '',
                        // item4: element.exam_subjects.length,
                        item4: element.newExam_publish == 1
                            ? '<i class="fas fa-check text-success"></i>'
                            : '<i class="fas fa-times text-danger"></i>',
                        item5: element.newExam_publish_result == 1
                            ? '<i class="fas fa-check text-success"></i>'
                            : '<i class="fas fa-times text-danger"></i>',
                        item6: {
                            type: "action",
                            options: {
                                style: "border:none",
                                // class: "btn btn-info",
                                icon: '<i class="fa fa-tag" title="VIEW STUDENT"></i>',
                                method: this.viewStudent
                            },
                        },
                        item7: {
                            type: "action",
                            options: {
                                style: "border:none",
                                icon: '<i class="fa fa-book" aria-hidden="true" title="VIEW SUBJECT MODEL"></i>',
                                method: this.viewSubjectModel
                            },
                        },
                        item8: {
                            type: "action",
                            options: {
                                style: "border:none",
                                icon: '<i class="fa fa-newspaper" aria-hidden="true" title="Assign Marks"></i>',
                                 method :this.assignMarksModel
                            },
                        },
                        item9: {
                            type: "action",
                            options: {
                                style: "border:none",
                                icon: '<i class="fa fa-comment" title="Teacher Remark"></i>',
                                method :this.teacherRemark
                            },
                        },
                    },
                    action: {
                        edit: true,
                        delete: true,
                    },
                });
            });
        },
        newExamForm() {
            this.$router.push({
                path: `/school/examinations/demo_new_exam/${this.examGroup_id}`
            });
        },
        // For Student Model //
        viewStudent(item) {
             this.$router.push({
                path: `/school/examinations/asign_students/${this.examGroup_id}/${item.newExam_id}`
            });
            this.log(item.newExam_id);
            // this.showStudentModel = true;
        },
        // Subject Model here
        viewSubjectModel(item) {
            // this.showSubjectModel = true;
            this.$router.push({
            path: `/school/examinations/exam_subject_model/${this.examGroup_id}/${item.newExam_id}`
        });
            this.log('view student method called');
        },
        assignMarksModel(item){
            this.$router.push({
            path: `/school/examinations/assign_marks_model/${this.examGroup_id}/${item.newExam_id}`
        });
        },
        teacherRemark(item){
            this.$router.push({
            path: `/school/examinations/teacher_remark_model/${this.examGroup_id}/${item.newExam_id}`
        });
        },
        edit(item, index) {
            this.$router.push({
                path: `/school/examinations/demo_new_exam/edit/${item.newExam_id}/${this.examGroup_id}`,
            });
        },
        async deleteData(item, index) {
            var data = new FormData();
            data.append("status", "deleted");
            const res = await this.callApi(
                "post",
                `/api/school/examinations/addNew_exam/delete/${item.newExam_id}`,
                data
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.namesList.splice(index, 1);
                    this.tableData.splice(index, 1);
                    if (!this.tableData.length) {
                        this.noData = true;
                    }
                    SwalCustomBtn.fire("Deleted!", data.message, "success");
                } else {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 0,
                    });
                }
            } else {
                toast = Toast.fire({
                    icon: data.status,
                    title: data.message,
                    timer: 0,
                });
            }
        },
    },
};

</script>

<style scoped>
.fixed .content-wrapper,
.fixed .right-side {
    padding-top: 50px;
}

.content-wrapper,
.right-side {
    min-height: 100%;
    background-color: #F3F3F3;
    z-index: 800;
}

.content-wrapper {
    transition: transform .3s ease-in-out, margin .3s ease-in-out;
}

* {
    box-sizing: border-box;
}

.content {
    min-height: 250px;
    padding: 10px;
    margin-right: auto;
    margin-left: auto;
    padding-left: 10px;
    padding-right: 10px;
}

.box {
    position: relative;
    border-radius: 3px;
    background: #ffffff;
    margin-bottom: 10px;
    width: 100%;
}

.box.box-primary {
    border-top-color: #faa21c;
    box-shadow: 0 0 0 0 rgb(90 113 208 / 11%), 0 4px 16px 0 rgb(167 175 183 / 33%) !important;
    border: solid 1px #dde4eb !important;
}

.ptbnull {
    border-bottom: 1px solid #f4f4f4;
}

.box-header {
    color: #444;
    display: block;
    padding: 10px;
    position: relative;
}

.impbtntitle {
    position: absolute;
    right: 10px;
    top: 5px;
}

.btn,
.btn {
    position: relative;
    overflow: hidden;
}

.btn {
    border-radius: 30px;
}

.btn-primary {
    background-color: #4ca1f6;
    border-color: #2c8ff3;
    transition: .3s;
    border-radius: 30px;
    outline: 0;
}

btn-group-sm>.btn,
.btn-sm {
    padding: 5px 10px;
    font-size: 12px;
    line-height: 1.5;
    border-radius: 3px;
}

.heading-layout {
    float: left;
}

.btn {
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
}

button,
input,
select,
textarea {
    font-family: inherit;
    font-size: inherit;
    line-height: inherit;
}

button,
input,
optgroup,
select,
textarea {
    margin: 0;
    font: inherit;
    color: inherit;
}

.pb10 {
    padding-bottom: 10px;
}

.row {
    margin-right: -5px;
    margin-left: -5px;
}

.col-md-3 {
    width: 25%;
}

.col-md-1,
.col-md-10,
.col-md-11,
.col-md-12,
.col-md-2,
.col-md-3,
.col-md-4,
.col-md-5,
.col-md-6,
.col-md-7,
.col-md-8,
.col-md-9 {
    float: left;
}

.examinfo {
    width: 100%;
    position: relative;
}

p {
    margin: 0 0 10px;
    display: block;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
}

.examinfo span {
    font: bold;
    display: block;
}
.add_exam_name{
    top: 0%;
}
</style>

