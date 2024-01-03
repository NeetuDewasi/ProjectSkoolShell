<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb pageTitle="Download Center" :breadcrumbList="breadcrumbList" />
            <!-- <div class>
        <div
          class="btn btn-gradient-yellow btn-hover-bluedark mx-3 text-white"
          @click="$router.push({name:'school.add_certificate.student',})">

        Add Certificate
      </div>
      </div>-->
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="row d-flex">
                        <div class="col-5">
                            <div class="card">
                                <div class="card-body">
                                    <div class="heading-layout1">
                                        <div class="item-title">
                                            <h3>Add Student Certificate</h3>
                                        </div>
                                    </div>
                                    <form class="new-added-form">
                                        <div class="row">
                                            <div class="col-xl-12 col-12 form-group">
                                                <label>Certificate Name</label>
                                                <input type="text" placeholder class="form-control"
                                                    v-model="editItem.student_certificate_name"
                                                    :class="errorItem.certificate_name != '' ? 'error-field' : ''"
                                                    @keyup="editItem.certificate_name != '' ? (errorItem.certificate_name = '') : ''" />
                                                <span class="error-label" v-if="errorItem.certificate_name != ''"
                                                    v-text="errorItem.certificate_name"></span>
                                            </div>
                                            <!-- <div class="col-xl-12 col-12 form-group">
                        <label>Header Center Text</label>
                        <input
                          type="text"
                          placeholder
                          class="form-control"
                          v-model="editItem.certificate_header_center_text"/>
                      </div> -->
                                            <div class="col-xl-12 col-12 form-group">
                                                <label>Header Left Text</label>
                                                <input type="text" placeholder class="form-control"
                                                    v-model="editItem.certificate_header_left_text" />

                                            </div>
                                            <div class="col-xl-12 col-12 form-group">
                                                <label>Header Right Text</label>
                                                <input type="text" placeholder class="form-control"
                                                    v-model="editItem.certificate_header_right_text" />

                                            </div>
                                            <div class="col-xl-12 form-group">
                                                <label>Body Text</label>
                                                <textarea class="textarea form-control" name="message" id="form-message"
                                                    cols="10" rows="4" v-model="editItem.certificate_body_text"
                                                    :class="errorItem.body_text != '' ? 'error-field' : ''"
                                                    @keyup="editItem.body_text != '' ? (errorItem.body_text = '') : ''"></textarea>
                                                <span class="text-primary">
                                                    [name] [dob] [created_at] [admission_no] [roll_no] [class] [section]
                                                    [father first name] [father middle name] [father last name] [mother
                                                    first name] [mother middle name][mother last name]

                                                </span>
                                            </div>
                                            <div class="col-xl-12 col-12 form-group">
                                                <label>Footer Left Text</label>
                                                <input type="text" placeholder class="form-control"
                                                    v-model="editItem.certificate_footer_left_text" />

                                            </div>
                                            <div class="col-xl-12 col-lg-12 form-group">
                                                <label>Footer Right Text</label>
                                                <input type="text" placeholder class="form-control"
                                                    v-model="editItem.certificate_footer_right_text" />

                                            </div>
                                            <div class="col-xl-12 col-lg-12 form-group">
                                                <label>Footer Center Text</label>
                                                <input type="text" placeholder class="form-control"
                                                    v-model="editItem.certificate_footer_center_text" />

                                            </div>
                                            <!-- <div class="col-xl-8 col-lg-12 form-group text-center">
                        <label>Certificate Design</label>
                        <div class="row">
                          <div class="col-lg-12 col-12 form-group">
                            <input
                              type="text"
                              placeholder="Header Height"
                              class="form-control"
                              v-model="editItem.certificate_header_height"
                            />

                          </div>
                          <div class="col-lg-12 col-12 form-group">
                            <input
                              type="text"
                              placeholder="Footer Height"
                              class="form-control"
                              v-model="editItem.certificate_footer_height"
                            />

                          </div>
                          <div class="col-lg-12 col-12 form-group">
                            <input
                              type="text"
                              placeholder="Body Height"
                              class="form-control"
                              v-model="editItem.certificate_body_height"
                            />

                          </div>
                          <div class="col-lg-12 col-12 form-group">
                            <input
                              type="text"
                              placeholder="Body Width"
                              class="form-control"
                              v-model="editItem.certificate_body_width"
                            />
                          </div>
                        </div>
                      </div> -->
                                        </div>

                                        <div class="col-12 form-group d-flex">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="selectStudentPhoto"
                                                    v-model="editItem.is_student_photo" />

                                                <label for="student_photo" class="form-check-label">Student Photo</label>
                                            </div>
                                        </div>
                                        <div class="col-6 d-flex">
                                            <div class="row">
                                                <label>background Image</label>
                                                <span class="error-label" v-if="errorItem.imageFilePath2 != ''"
                                                    v-text="errorItem.imageFilePath2"></span>
                                                <div class="imageContainer">
                                                    <img :src="selectedBackgroundImage" alt />
                                                    <input type="file" accept="image/*" @change="imageFileSelect2"
                                                        :class="errorItem.imageFilePath2 != '' ? 'error-field' : ''" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <button type="submit"
                                                class="btn btn-fill-sm rounded text-light shadow-dodger-blue bg-dodger-blue"
                                                @click.prevent="submitData()">
                                                {{ formBtn }}
                                            </button>
                                            <button type="button"
                                                class="btn btn-fill-sm rounded text-light shadow-dodger-blue btn-gradient-yellow"
                                                @click="resetForm">
                                                {{ resetButton }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="card">
                                <div class="card-body">
                                    <div class="heading-layout1">
                                        <div class="item-title">
                                            <h3>Certificate List</h3>
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
                </div>
            </div>
            <Footer />
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
                    name: "Student Certificate",
                },
            ],
            tableData: [],
            showCertificateList: [],
            isLoaded: false,
            noData: false,
            editedIndex: -1,
            classId: -1,
            sectionId: -1,
            editItem: {},
            errorItem: {
                certificate_name: "",

                body_text: "",
                imageFilePath2: "",
                srcImageFile2: "",
            },
            imageFilePath2: null,
            srcImageFile2: null,
            editedIndex: -1,
            tableHead: {
                items: {
                    item1: { label: "Sr.No." },
                    item2: { label: "Certificate Name" },
                    item3: { label: "Background Image" },

                },
                actions: true,
            },
            showCertificateList: [],
        };
    },
    mounted() {
        this.$parent.loadOtherScript();
        this.showData();
    },
    computed: {
        formBtn: function () {
            return this.editedIndex != -1 ? "Update" : "Save";
        },
        resetButton: function () {
            return this.editedIndex === -1 ? "Reset" : "Cancel";
        },
        selectedBackgroundImage: function () {
            return this.srcImageFile2 != null
                ? this.srcImageFile2
                : "/assets/img/nb.jpg";
        }
    },
    methods: {
        async submitData() {
            toast = Toast.fire({
                icon: "warning",
                title: "Please Wait!! Creating new Certificate",
                timer: 0,
            });
            var data = new FormData();
            data.append('certificate_name', this.editItem.student_certificate_name);
            data.append('header_center_text', this.editItem.certificate_header_center_text ? this.editItem.certificate_header_center_text : "");
            data.append('header_left_text', this.editItem.certificate_header_left_text ? this.editItem.certificate_header_left_text : "");
            data.append('header_right_text', this.editItem.certificate_header_right_text ? this.editItem.certificate_header_right_text : "");
            data.append('header_height', this.editItem.certificate_header_height ? this.editItem.certificate_header_height : "");
            data.append('header_width', this.editItem.certificate_header_width ? this.editItem.certificate_header_width : "");
            data.append('body_text', this.editItem.certificate_body_text ? this.editItem.certificate_body_text : "");
            data.append('footer_left_text', this.editItem.certificate_footer_left_text ? this.editItem.certificate_footer_left_text : "");
            data.append('footer_right_text', this.editItem.certificate_footer_right_text ? this.editItem.certificate_footer_right_text : "");
            data.append('footer_center_text', this.editItem.certificate_footer_center_text ? this.editItem.certificate_footer_center_text : "");
            data.append('footer_height', this.editItem.certificate_footer_height ? this.editItem.certificate_footer_height : "");
            data.append('body_height', this.editItem.certificate_body_height ? this.editItem.certificate_body_height : "");
            data.append('body_width', this.editItem.certificate_body_width ? this.editItem.certificate_body_width : "");
            data.append('student_photo', this.editItem.is_student_photo ? 1 : 0);
            data.append('background_image', this.imageFilePath2 ? this.imageFilePath2 : "");
            let url = "";
            if (this.editedIndex != -1) {
                url = `/api/school/certificate/student_certificate/update/${this.editedIndex}`;
            } else {
                url = `/api/school/certificate/student_certificate/save`;
            }

            const res = await this.callApi("post", url, data, "multipart");
            this.log('API Called', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.resetForm();
                    this.showData();
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
            this.editItem = {};
            this.srcImageFile2 = null;
            this.imageFilePath2 = null;
            this.editedIndex = -1;
        },
        resetForm() {
            this.editItem = {};
            this.editedIndex = -1;
            this.imageFilePath2 = null;
            this.srcImageFile2 = null;
        },
        imageFileSelect2(e) {
            const file = e.target.files[0];
            if (file) {
                this.srcImageFile2 = URL.createObjectURL(file);
                URL.revokeObjectURL(file);
                this.imageFilePath2 = file;
            } else {
                this.srcImageFile2 = null;
                this.imageFilePath2 = null;
            }
        },
        edit(item, index) {
            this.editItem = item;
            this.editedIndex = item.certificate_id;
            this.srcImageFile2 = item.certificate_background_image;

            this.log('ITEM DATA', item.certificate_student_photo);
            if (this.editItem.is_student_photo != null) {
                $('.form-check-input').prop('checked', true);
            }
            this.editItem.is_student_photo = item.certificate_student_photo;
        },
        async deleteData(item, index) {
            var data = new FormData();
            data.append("status", "deleted");
            const res = await this.callApi(
                "post",
                `/api/school/certificate/student_certificate/delete/${item.certificate_id}`,
                data
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.showCertificateList.splice(index, 1);
                    this.tableData.splice(index, 1);
                    SwalCustomBtn.fire("Deleted!", data.message, "success");
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                }
                else {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                }
            }

        },
        validCertificateForm() {
            this.isFormValid = true;
            if (
                this.editItem.student_certificate_name == null ||
                this.editItem.student_certificate_name == ""
            ) {
                this.errorItem.certificate_name = "Certificate Name  is required";
                this.isFormValid = false;
            } else {
                this.errorItem.certificate_name = "";
            }

            if (
                this.editItem.certificate_body_text == null ||
                this.editItem.certificate_body_text == ""
            ) {
                this.errorItem.body_text = "Body Text is required";
                this.isFormValid = false;
            } else {
                this.errorItem.body_text = "";
            }

            return this.isFormValid;
        },
        async showData() {
            this.isLoaded = false;
            const res = await this.callApi(
                "get",
                `/api/school/certificate/student_certificate/show_list`,
                null
            );
            this.log('DATAA', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.showCertificateList = data.show_certificate_list;
                    this.initTable();
                }
            }
            this.$refs.table.loadTable();
            this.isLoaded = true;

        },
        initTable() {
            this.tableData = [];
            this.showCertificateList.forEach((element) => {
                this.tableData.push({
                    item: element,
                    data: {
                        item1: element.certificate_id,
                        item2: element.student_certificate_name ? element.student_certificate_name : '',
                        item3: element.certificate_background_image ?
                            {
                                type: 'file',
                                path: element.certificate_background_image,
                                height: 100
                            } : '',
                        // item4: {
                        //     type: 'action',
                        //     options: {
                        //         style: 'border:none',
                        //         icon: '<i class="fa fa-bars" aria-hidden="true"></i>',
                        //     }
                        // },
                    },
                    action: {
                        edit: true,
                        delete: true,
                    },
                });
            });
        },
    },
};
</script>


