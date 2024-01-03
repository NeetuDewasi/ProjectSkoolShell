<template>
    <div>
        <div class="dashboard-content-one">
            <div style="width: -webkit-fill-available">
                <Breadcrumb
                    pageTitle="Examination"
                    :breadcrumbList="breadcrumbList"
                />
                <form
                    id="formadd"
                    action="https://smart.ezyschool.in/admin/examgroup/ajaxaddexam"
                >
                    <div class="modal-content">
                        <div class="modal-body">
                            <input type="hidden" name="exam_id" value="0" />
                            <div class="row">
                                <div
                                    class="form-group col-xs-12 col-sm-9 col-md-9 col-lg-9"
                                >
                                    <label for="exam">
                                        Exam
                                        <small class="req">*</small>
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="exam"
                                        name="exam"
                                        autocomplete="off"
                                        v-model="editItem.newExam_name"
                                    />
                                    <span
                                        class="text text-danger"
                                        id="exam_error"
                                    ></span>
                                </div>
                                <div
                                    class="form-group col-xs-12 col-sm-3 col-md-3 col-lg-3"
                                >
                                    <label for="exam">Session</label>
                                    <Select2
                                        :item="sessionList"
                                        ref="sessionList"
                                        @change="selectSession"
                                        placeholder="--SELECT A CLASS--"
                                    />
                                    <span
                                        class="text text-danger"
                                        id="session_id_error"
                                    ></span>
                                </div>
                                <div class="clearfix"></div>
                                <div
                                    class="col-xs-12 col-sm-2 col-md-2 col-lg-2"
                                >
                                    <div class="checkbox-inline">
                                        <label>
                                            <input
                                                type="checkbox"
                                                value="true"
                                                autocomplete="off"
                                                v-model="
                                                    editItem.newExam_publish
                                                "
                                            />
                                            Publish
                                        </label>
                                    </div>
                                </div>
                                <div
                                    class="col-xs-12 col-sm-2 col-md-2 col-lg-2"
                                >
                                    <div class="checkbox-inline">
                                        <label>
                                            <input
                                                type="checkbox"
                                                value="true"
                                                autocomplete="off"
                                                v-model="
                                                    editItem.newExam_publish_result
                                                "
                                            />
                                            Publish Result
                                        </label>
                                    </div>
                                </div>
                                <div
                                    class="col-xs-12 col-sm-8 col-md-8 col-lg-8"
                                >
                                    <label class="radio-inline mr-5">
                                        <input
                                            type="radio"
                                            value="admitCard_rollNo"
                                            checked="checked"
                                            v-model="newExam_rollNo"
                                        />Admit Card Roll No
                                    </label>

                                    <label class="radio-inline">
                                        <input
                                            type="radio"
                                            value="profile_rollNo"
                                            autocomplete="off"
                                            v-model="newExam_rollNo"
                                        />Profile Roll No
                                    </label>
                                </div>

                                <div
                                    class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                >
                                    <label for="description">Description</label>
                                    <textarea
                                        class="form-control"
                                        v-model="editItem.newExam_description"
                                        id="description"
                                    ></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                             <button
                                    type="submit"
                                    class="btn btn-info"
                                    @click="goBack()"

                                >
                                   Go Back
                                </button>
                            <button
                                type="submit"
                                class="btn btn-primary"
                                @click.prevent="submitData()"
                                data-loading-text="<i class='fa fa-spinner fa-spin '></i> Saving..."
                            >
                                {{ frmBtn }}
                            </button>
                        </div>
                    </div>
                </form>
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
                    name: "New Exam",
                },
            ],
            sessionList: [],
            newExam_rollNo: "admitCard_rollNo",
            editedIndex: -1,
            editItem: {},
            examGroup_id: -1,
        };
    },
    computed: {
        frmBtn: function () {
            return this.editedIndex !== -1 ? "Update" : "Save";
        },
    },
    created() {
        if (this.$route.params.examGroup_id) {
            this.log("Group");
            this.examGroup_id = this.$route.params.examGroup_id;
        }
        if (this.$route.params.edit_id) {
            this.editedIndex = this.$route.params.edit_id;
            this.examGroup_id = this.$route.params.examGroup_id;
            this.log("EDITED INDEX", this.editedIndex);
            this.getEditItemData();
        }
    },
    mounted() {
        this.getSession();
    },
    methods: {
         goBack() {
            this.$router.go(-1);
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

        async submitData() {
            var data = new FormData();
            data.append("group_id", this.examGroup_id ? this.examGroup_id : "");
            data.append("session_id", this.session_id ? this.session_id : "");
            data.append(
                "exam_name",
                this.editItem.newExam_name ? this.editItem.newExam_name : ""
            );
            data.append("is_publish", this.editItem.newExam_publish ? 1 : 0);
            data.append(
                "publishResult",
                this.editItem.newExam_publish_result ? 1 : 0
            );
            data.append("rollNo", this.newExam_rollNo);
            data.append(
                "description",
                this.editItem.newExam_description
                    ? this.editItem.newExam_description
                    : ""
            );
            let url = "";
            if (this.editedIndex != -1) {
                url = `/api/school/examinations/addNew_exam/update/${this.editedIndex}`;
            } else {
                url = `/api/school/examinations/addNew_exam/save`;
            }
            const res = await this.callApi("post", url, data);
            this.log("REQUEST", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    // this.examGroups.push(data.exam_groups);
                    // this.$parent.showData();
                    this.resetForm();
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
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
            this.editItem = {};
            this.session_id = -1;
            this.editedIndex = -1;
        },
        async getEditItemData(editedIndex) {
            this.log(this.editedIndex);
            const res = await this.callApi(
                "get",
                `/api/school/examinations/addNew_exam/edit/${this.editedIndex}`,
                null
            );
            this.log("SELECTED DATA", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.editItem = data.exam_details;
                    this.$refs.sessionList.setSelected(
                        data.exam_details.session_id
                    );
                    this.session_id = data.exam_details.session_id;
                    this.selectSession(data.exam_details.session_id);
                }
            }
        },
    },
};
</script>

<style scoped>
form {
    display: block;
    margin-top: 0em;
}
.col-md-8 {
    width: 66.66666667%;
}
</style>
