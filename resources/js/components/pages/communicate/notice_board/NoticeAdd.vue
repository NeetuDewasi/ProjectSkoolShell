<template>
  <div>
    <div class="dashboard-content-one">
      <div class="d-flex justify-content-between">
        <Breadcrumb pageTitle="Add Notice Board" :breadcrumbList="breadcrumbList" />
      </div>
    </div>
    <div class="row gutters-20">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="heading-layout1">
              <div class="item-title">
                <h3>Add Notice</h3>
              </div>
            </div>
            <form class="new-added-form">
              <div class="row">
                <div class="col-8 mb-5">
                  <div class="row">
                    <div class="flex-grow-1 form-group col-12">
                      <label>Title <span class="text-danger"></span>*</label>

                      <input
                        class="form-control"
                        v-model="editItem.noticeBoard_title"
                        placeholder="Enter Title "
                        @keypress="errorItem.noticeBoard_title = ''"
                        :class="
                                                    errorItem.noticeBoard_title != ''
                                                        ? 'error-field'
                                                        : ''
                                                "
                      />
                      <span
                        class="error-label"
                        v-if="errorItem.noticeBoard_title != ''"
                        v-text="errorItem.noticeBoard_title"
                      ></span>
                    </div>
                    <div class="flex-grow-1 col-12 form-group">
                      <label>Description *</label>
                      <VueTrix style="width:auto;height:auto"
                        class="form-control"
                        v-model="editItem.noticeBoard_description"
                        placeholder="Enter description"
                        @keypress="errorItem.noticeBoard_description = ''"
                        :class="
                                                    errorItem.noticeBoard_description != ''
                                                        ? 'error-field'
                                                        : ''
                                                "
                      />
                      <span
                        class="error-label"
                        v-if="errorItem.noticeBoard_description != ''"
                        v-text="errorItem.noticeBoard_description"
                      ></span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="col-lg-12 form-group">
                    <label>Notice On</label>
                    <DatePicker
                      format="DD-MMM-YYYY"
                      value-type="format"
                      type="date"
                      placeholder="Select a date"
                      v-model="notice_date"
                      class="form-control vue-datepicker my-0 w-100"
                      :default-value="new Date()"
                      :disabled-date="disabledAfterToday"
                    />
                  </div>
                  <div class="col-lg-12 form-group">
                    <label>Publish On</label>
                    <DatePicker
                      format="DD-MMM-YYYY"
                      value-type="format"
                      type="date"
                      placeholder="Select a date"
                      v-model="publish_date"
                      class="form-control vue-datepicker my-0 w-100"
                      :default-value="new Date()"
                      :disabled-date="disabledAfterToday"
                    />
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label>Notice For</label>
                    </div>

                    <div class="col-12">
                      <div
                        v-for="(department, index) in department_list"
                        :key="index"
                      >
                        <div>
                          <span>
                            <input
                              :id="`departmentChecked${index}`"
                              type="checkbox" @change="selectDepartment(department.value, index)"
                            />
                          </span>
                          <span >
                            {{
                            department.name
                            }}
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <br />
              <div class="col-xl-12 col-lg-12 form-group">
                <button
                  type="submit"
                  class="btn btn-lg btn-gradient-yellow btn-hover-bluedark mx-3 text-white"
                  @click.prevent="submitData()"
                >{{ formBtn }}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <Footer />
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
                    name: "Add Notice Board",
                },
            ],
            errorItem: {
                noticeBoard_title: "",
                noticeBoard_description: "",
            },
            isLoaded: false,
            editItem: {},
            isFormValid: false,
            editedIndex: -1,
            department_list: [],
            departmentId: -1,
            notice_date:"",
            publish_date:"",
            editItem: {
                departmentIds: [],
            },
        };
    },
    mounted() {
        this.$parent.loadOtherScript();
        this.getDepartment();
        if (this.$route.params.noticeBoard_id) {
            this.editedIndex = this.$route.params.noticeBoard_id;
            this.getEditItemData(this.$route.params.noticeBoard_id);
        }
        this.notice_date = moment(new Date()).format('DD-MMM-YYYY');
        this.publish_date = moment(new Date()).format('DD-MMM-YYYY');
    },
    computed: {
        formBtn: function () {
            return this.editedIndex !== -1 ? "Update" : "Save";
        },
    },
    watch: {
        notice_date: function (val) {
            this.notice_date = val;
            this.editItem.noticeBoard_notice_on = moment(new Date(val)).format('YYYY-MM-DD');
        },
        publish_date: function (val) {
            this.publish_date = val;
            this.editItem.noticeBoard_publish_on = moment(new Date(val)).format('YYYY-MM-DD');
        }
    },
    methods: {
        disabledAfterToday(date) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            return date < today;
        },
        selectDepartment(value, index) {
            this.log('value', value);
            if (!this.editItem.departmentIds) {
                this.$set(this.editItem, 'departmentIds', []);
            }

            if (this.editItem.departmentIds.includes(value)) {
                this.editItem.departmentIds.splice(
                    this.editItem.departmentIds.indexOf(value),
                    1
                );
                $("#departmentChecked" + index).prop("checked", false);
            } else {
                this.editItem.departmentIds.push(value);
                $("#departmentChecked" + index).prop("checked", true);
                console.log('depart ids', this.editItem.departmentIds);
            }
        },
        async getDepartment() {
            var formData = new FormData();
            const res = await this.callApi(
                "get",
                `/api/school/communicate/send_email/department`,
                formData,
            );
            console.log("check Department>>>", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.department_list = data.departments;
                } else {
                    this.department_list = [];
                }
            }
        },

        async saveData() {
            this.log('departments', this.editItem.departmentIds);
            var data = new FormData();
            data.append("title", this.editItem.noticeBoard_title ? this.editItem.noticeBoard_title : '');
            data.append("description", this.editItem.noticeBoard_description ?  this.editItem.noticeBoard_description : '');
            data.append("notice_on", this.editItem.noticeBoard_notice_on ?  this.editItem.noticeBoard_notice_on : '');
            data.append("publish_on", this.editItem.noticeBoard_publish_on ? this.editItem.noticeBoard_publish_on : '');
            data.append("message_for", this.editItem.departmentIds ? this.editItem.departmentIds : '');
            const res = await this.callApi(
                "post",
                `/api/school/communicate/notice_board/save`,
                data
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    // this.houseList.push(data.student_house);
                    // this.initTable();
                    if (data.status == "success") {
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
            }
        },

        async submitData() {
            var isVaild = await this.validNoticeForm();
            if (!isVaild) {
                return;
            }
            if (this.editedIndex !== -1) {
                this.updateData();
            } else {
                this.saveData();
            }

        },
        resetForm(){
            this.editItem = {}
            this.editItem.departmentIds = [];
            this.editedIndex = -1;
            this.notice_date = null;
            this.publish_date = null;
            $("#departmentChecked").splice("checked", false);
        },
        validNoticeForm() {
            this.isFormValid = true;
            if (
                this.editItem.noticeBoard_title == null ||
                this.editItem.notice_title == ""
            ) {
                this.errorItem.noticeBoard_title = "Title is required";
                this.isFormValid = false;
            } else {
                this.errorItem.noticeBoard_title = "";
            }
            if (
                this.editItem.noticeBoard_description == null ||
                this.editItem.noticeBoard_description == ""
            ) {
                this.errorItem.noticeBoard_description = "Description is required";
                this.isFormValid = false;
            } else {
                this.errorItem.noticeBoard_description = "";
            }
            return this.isFormValid;
        },
        async getEditItemData(id) {
            const res = await this.callApi(
                "get",
                `/api/school/communicate/notice_board/edit/${id}`,
                null
            );
            this.log('EDITED DATA', res)
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.editItem = {
                        noticeBoard_title: data.edited_notice.noticeBoard_title,
                        noticeBoard_description: data.edited_notice.noticeBoard_description,
                        noticeBoard_message_for: data.edited_notice.noticeBoard_message_for,
                    };
                        this.notice_date = data.edited_notice.noticeBoard_notice_on != null ? moment(String(data.edited_notice.noticeBoard_notice_on)).format('DD-MMM-YYYY') : null;
                        this.editItem.noticeBoard_notice_on = moment(String( data.edited_notice.noticeBoard_notice_on)).format("YYYY-MM-DD");
                        this.notice_date = moment(String(this.editItem.noticeBoard_notice_on)).format("DD-MMM-YYYY");

                        this.publish_date = data.edited_notice.noticeBoard_publish_on != null ? moment(String(data.edited_notice.noticeBoard_publish_on)).format('DD-MMM-YYYY') : null;
                        this.editItem.noticeBoard_publish_on = moment(String( data.edited_notice.noticeBoard_publish_on)).format("YYYY-MM-DD");
                        this.publish_date = moment(String(this.editItem.noticeBoard_publish_on)).format("DD-MMM-YYYY");
                        console.log('gygygui0', data.edited_notice.noticeBoard_department)
                        this.department_list.forEach((element, index) => {
                            data.edited_notice.noticeBoard_department.forEach(e => {
                            if (element.value == e.value) {
                                this.selectDepartment(element.value, index);
                            }
                        });
                    });
                }
            }
        },
        async updateData() {
            this.log('departments', this.editItem.departmentIds);
            var data = new FormData();
            data.append("title", this.editItem.noticeBoard_title ? this.editItem.noticeBoard_title : '');
            data.append("description", this.editItem.noticeBoard_description ?  this.editItem.noticeBoard_description : '');
            data.append("notice_on", this.editItem.noticeBoard_notice_on ?  this.editItem.noticeBoard_notice_on : '');
            data.append("publish_on", this.editItem.noticeBoard_publish_on ? this.editItem.noticeBoard_publish_on : '');
            data.append("message_for", this.editItem.departmentIds ? this.editItem.departmentIds : '');
            const res = await this.callApi(
                "post",
                `/api/school/communicate/notice_board/update/${this.editedIndex}`,
                data
            );
            var data = res.data;
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
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
            }
        },
    },
};
</script>
