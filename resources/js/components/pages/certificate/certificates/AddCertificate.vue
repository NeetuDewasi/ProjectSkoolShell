<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb pageTitle="Student Certificate" :breadcrumbList="breadcrumbList" />
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Add Student Certificate</h3>
                                </div>
                            </div>
                            <form class="new-added-form">
                                <div class="row">
                                    <div class="col-lg-12 col-12 form-group">
                                        <label>Certificate Name</label>
                                        <input type="text" placeholder class="form-control"
                                            v-model="editItem.student_certificate_name"
                                            :class="errorItem.certificate_name != '' ? 'error-field' : ''"
                                            @keyup="editItem.certificate_name != '' ? (errorItem.certificate_name = '') : ''" />
                                        <span class="error-label" v-if="errorItem.certificate_name != ''"
                                            v-text="errorItem.certificate_name"></span>
                                    </div>
                                    <div class="col-lg-12 col-12 form-group">
                                        <label>Header Center Text</label>
                                        <input type="text" placeholder class="form-control"
                                            v-model="editItem.certificate_header_center_text"
                                            :class="errorItem.header_center_text != '' ? 'error-field' : ''"
                                            @keyup="editItem.header_center_text != '' ? (errorItem.header_center_text = '') : ''" />
                                        <span class="error-label" v-if="errorItem.header_center_text != ''"
                                            v-text="errorItem.header_center_text"></span>
                                    </div>
                                    <div class="col-lg-12 col-12 form-group">
                                        <label>Header Left Text</label>
                                        <input type="text" placeholder class="form-control"
                                            v-model="editItem.certificate_header_left_text"
                                            :class="errorItem.header_left_text != '' ? 'error-field' : ''"
                                            @keyup="editItem.header_left_text != '' ? (errorItem.header_left_text = '') : ''" />
                                        <span class="error-label" v-if="errorItem.header_left_text != ''"
                                            v-text="errorItem.header_left_text"></span>
                                    </div>
                                    <div class="col-lg-12 col-12 form-group">
                                        <label>Header Right Text</label>
                                        <input type="text" placeholder class="form-control"
                                            v-model="editItem.certificate_header_right_text"
                                            :class="errorItem.header_right_text != '' ? 'error-field' : ''"
                                            @keyup="editItem.header_right_text != '' ? (errorItem.header_right_text = '') : ''" />
                                        <span class="error-label" v-if="errorItem.header_right_text != ''"
                                            v-text="errorItem.header_right_text"></span>
                                    </div>
                                    <div class="col-xl-12 form-group">
                                        <label>Body Text</label>
                                        <textarea class="textarea form-control" name="message" id="form-message" cols="10"
                                            rows="4" v-model="editItem.certificate_body_text"
                                            :class="errorItem.body_text != '' ? 'error-field' : ''"
                                            @keyup="editItem.body_text != '' ? (errorItem.body_text = '') : ''"></textarea>
                                    </div>
                                    <div class="col-lg-12 col-12 form-group">
                                        <label>Footer Left Text</label>
                                        <input type="text" placeholder class="form-control"
                                            v-model="editItem.certificate_footer_left_text"
                                            :class="errorItem.footer_left_text != '' ? 'error-field' : ''"
                                            @keyup="editItem.footer_left_text != '' ? (errorItem.footer_left_text = '') : ''" />
                                        <span class="error-label" v-if="errorItem.footer_left_text != ''"
                                            v-text="errorItem.footer_left_text"></span>
                                    </div>
                                    <div class="col-lg-12 col-12 form-group">
                                        <label>Footer Right Text</label>
                                        <input type="text" placeholder class="form-control"
                                            v-model="editItem.certificate_footer_right_text"
                                            :class="errorItem.footer_right_text != '' ? 'error-field' : ''"
                                            @keyup="editItem.footer_right_text != '' ? (errorItem.footer_right_text = '') : ''" />
                                        <span class="error-label" v-if="errorItem.footer_right_text != ''"
                                            v-text="errorItem.footer_right_text"></span>
                                    </div>
                                    <div class="col-lg-12 col-12 form-group">
                                        <label>Footer Center Text</label>
                                        <input type="text" placeholder class="form-control"
                                            v-model="editItem.certificate_footer_center_text"
                                            :class="errorItem.footer_center_text != '' ? 'error-field' : ''"
                                            @keyup="editItem.footer_center_text != '' ? (errorItem.footer_center_text = '') : ''" />
                                        <span class="error-label" v-if="errorItem.footer_center_text != ''"
                                            v-text="errorItem.footer_center_text"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <label>Certificate Design</label>
                                    <div class="col-12">
                                        <input type="text" placeholder="Header Height" class="form-control"
                                            v-model="editItem.certificate_header_height"
                                            :class="errorItem.header_height != '' ? 'error-field' : ''"
                                            @keyup="editItem.header_height != '' ? (errorItem.header_height = '') : ''" />
                                        <span class="error-label" v-if="errorItem.header_height != ''"
                                            v-text="errorItem.header_height"></span>
                                    </div>
                                    <div class="col-lg-12 col-6 form-group">
                                        <input type="text" placeholder="Footer Height" class="form-control"
                                            v-model="editItem.certificate_footer_height"
                                            :class="errorItem.footer_height != '' ? 'error-field' : ''"
                                            @keyup="editItem.footer_height != '' ? (errorItem.footer_height = '') : ''" />
                                        <span class="error-label" v-if="errorItem.footer_height != ''"
                                            v-text="errorItem.footer_height"></span>
                                    </div>

                                    <div class="col-lg-12 col-6 form-group">
                                        <input type="text" placeholder="Body Height" class="form-control"
                                            v-model="editItem.certificate_body_height"
                                            :class="errorItem.body_height != '' ? 'error-field' : ''"
                                            @keyup="editItem.body_height != '' ? (errorItem.body_height = '') : ''" />
                                        <span class="error-label" v-if="errorItem.body_height != ''"
                                            v-text="errorItem.body_height"></span>
                                    </div>
                                    <div class="col-lg-12 col-6 form-group">
                                        <input type="text" placeholder="Body Width" class="form-control"
                                            v-model="editItem.certificate_body_width"
                                            :class="errorItem.body_width != '' ? 'error-field' : ''"
                                            @keyup="editItem.body_width != '' ? (errorItem.body_width = '') : ''" />
                                        <span class="error-label" v-if="errorItem.body_width != ''"
                                            v-text="errorItem.body_width"></span>
                                    </div>
                                </div>
                                <div class="col-5 form-group d-flex">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="selectStudentPhoto"
                                            v-model="editItem.is_student_photo" />

                                        <label for="student_photo" class="form-check-label">Student Photo</label>
                                    </div>
                                </div>
                                <div class="col-6 d-flex">
                                    <div class="row">
                                        <label for="background_image" class="background_image-label">background
                                            Image</label>
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
                                        @click.prevent="submitForm()">
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
                    name: "Certificate",
                },
            ],

            editItem: {},
            errorItem: {
                certificate_name: "",
                header_center_text: "",
                header_left_text: "",
                header_right_text: "",
                body_text: "",
                footer_left_text: "",
                footer_right_text: "",
                footer_center_text: "",
                header_height: "",
                footer_height: "",
                body_height: "",
                body_width: "",
                imageFilePath2: "",
                srcImageFile2: "",
            },

            imageFilePath2: null,
            srcImageFile2: null,
            editedIndex: -1,

        };
    },
    mounted() {
        this.$parent.loadOtherScript();
    },
    computed: {

        formBtn: function () {
            return this.editedIndex != -1 ? "Update" : "Save";
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
            data.append('header_center_text', this.editItem.certificate_header_center_text);
            data.append('header_left_text', this.editItem.certificate_header_left_text);
            data.append('header_right_text', this.editItem.certificate_header_right_text);
            data.append('header_height', this.editItem.certificate_header_height);
            data.append('header_width', this.editItem.certificate_header_width);
            data.append('body_text', this.editItem.certificate_body_text);
            data.append('footer_left_text', this.editItem.certificate_footer_left_text);
            data.append('footer_right_text', this.editItem.certificate_footer_right_text);
            data.append('footer_center_text', this.editItem.certificate_footer_center_text);
            data.append('footer_height', this.editItem.certificate_footer_height);
            data.append('body_height', this.editItem.certificate_body_height);
            data.append('body_width', this.editItem.certificate_body_width);
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
                    this.$parent.showData();
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
            this.editedIndex = -1;
        },
        async getEditData() {
            const res = await this.callApi(
                "get"
                    `api/school/certificate/student_certificate/edit/${id}`,
                null,
            );
            this.log('DATAA', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.srcImageFile1 = data.edit_certificate.student_photo;
                    this.srcImageFile2 = data.edit_certificate.selectedBackgroundImage;
                    this.editItem = data.edit_certificate;
                }
            };
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

        validCertificateForm() {
            this.isFormValid = true;
            if (
                this.editItem.student_certificate_name == null ||
                this.editItem.student_certificate_name == ""
            ) {
                this.errorItem.certificate_name = "Certificate Name  is required";
                this.isFormValid = false;
            } else {
                this.errorItem.header_center_text = "";
            }
            if (
                this.editItem.certificate_header_center_text == null ||
                this.editItem.certificate_header_center_text == ""
            ) {
                this.errorItem.header_center_text = "Header Text  is required";
                this.isFormValid = false;
            } else {
                this.errorItem.header_center_text = "";
            }
            if (
                this.editItem.certificate_header_left_text == null ||
                this.editItem.certificate_header_left_text == ""
            ) {
                this.errorItem.header_left_text = "Header Left Text  is required";
                this.isFormValid = false;
            } else {
                this.errorItem.header_left_text = "";
            }
            if (
                this.editItem.certificate_header_right_text == null ||
                this.editItem.certificate_header_right_text == ""
            ) {
                this.errorItem.header_right_text = "Header Right Text is required";
                this.isFormValid = false;
            } else {
                this.errorItem.header_right_text = "";
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
            if (
                this.editItem.certificate_footer_left_text == null ||
                this.editItem.certificate_footer_left_text == ""
            ) {
                this.errorItem.footer_left_text = "Footer Left Text is required";
                this.isFormValid = false;
            } else {
                this.errorItem.footer_left_text = "";
            }
            if (
                this.editItem.certificate_footer_right_text == null ||
                this.editItem.certificate_footer_right_text == ""
            ) {
                this.errorItem.footer_right_text = "Admission Number  is required";
                this.isFormValid = false;
            } else {
                this.errorItem.footer_right_text = "";
            }
            if (
                this.editItem.certificate_footer_center_text == null ||
                this.editItem.certificate_footer_center_text == ""
            ) {
                this.errorItem.footer_center_text = "Admission Number  is required";
                this.isFormValid = false;
            } else {
                this.errorItem.footer_center_text = "";
            }
            if (
                this.editItem.certificate_header_height == null ||
                this.editItem.certificate_header_height == ""
            ) {
                this.errorItem.header_height = "Admission Number  is required";
                this.isFormValid = false;
            } else {
                this.errorItem.header_height = "";
            }
            if (
                this.editItem.certificate_footerr_height == null ||
                this.editItem.certificate_footerr_height == ""
            ) {
                this.errorItem.footerr_height = "Admission Number  is required";
                this.isFormValid = false;
            } else {
                this.errorItem.footerr_height = "";
            }
            if (
                this.editItem.certificate_body_height == null ||
                this.editItem.certificate_body_height == ""
            ) {
                this.errorItem.body_height = "Admission Number  is required";
                this.isFormValid = false;
            } else {
                this.errorItem.body_height = "";
            }
            if (
                this.editItem.certificate_body_width == null ||
                this.editItem.certificate_body_width == ""
            ) {
                this.errorItem.body_width = "Admission Number  is required";
                this.isFormValid = false;
            } else {
                this.errorItem.body_width = "";
            }
            if (this.imageFilePath == null || this.imageFilePath == "") {
                this.errorItem.imageFilePath = "Image field is required";
                this.isFormValid = false;
            } else {
                this.errorItem.imageFilePath = "";
            }
            return this.isFormValid;
        }
    },
};
</script>

<style scoped>
.new-added-form .form-group i {
    position: unset;

}

.new-added-form {
    margin-bottom: 0 !important;
}

.font-20 {
    font-size: 20px !important;
    width: 200px !important;
}
</style>
