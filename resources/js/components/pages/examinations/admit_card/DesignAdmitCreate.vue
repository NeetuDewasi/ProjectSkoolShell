<template>
    <div>
        <div class="row gutters-20">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Add Student Admit Card</h3>
                            </div>
                        </div>
                        <form class="new-added-form">
                            <div class="row">
                                <div class="col-lg-12 col-12 form-group">
                                    <label>Template </label>
                                    <input type="text" placeholder=" " class="form-control"
                                        v-model="editItem.admit_template"
                                        :class="errorItem.admit_template != '' ? 'error-field' : ''"
                                        @keyup="editItem.admit_template != '' ? (errorItem.admit_template = '') : ''" />
                                    <span class="error-label" v-if="errorItem.admit_template != ''"
                                        v-text="errorItem.admit_template"></span>
                                </div>
                                <div class="col-lg-12 col-12 form-group">
                                    <label>Heading </label>
                                    <input type="text" class="form-control" v-model="editItem.admit_heading"
                                        :class="errorItem.admit_heading != '' ? 'error-field' : ''"
                                        @keyup="editItem.admit_heading != '' ? (errorItem.admit_heading = '') : ''" />
                                    <span class="error-label" v-if="errorItem.admit_heading != ''"
                                        v-text="errorItem.admit_heading"></span>
                                </div>

                                <div class="col-lg-12 col-12 form-group">
                                    <label>Title </label>
                                    <input type="text" class="form-control" v-model="editItem.admit_title"
                                        :class="errorItem.admit_title != '' ? 'error-field' : ''"
                                        @keyup="editItem.admit_title != '' ? (errorItem.admit_title = '') : ''" />
                                    <span class="error-label" v-if="errorItem.admit_title != ''"
                                        v-text="errorItem.admit_title"></span>
                                </div>
                                <div class="col-lg-12 col-12 form-group">
                                    <label>Exam Name </label>
                                    <Select2 ref="examNames_list" placeholder="--Select Exam--" :items="examNames_list"
                                        @change="selectExam" />
                                </div>

                                <div class="col-lg-12 form-group">
                                    <label>School Name</label>
                                    <textarea class="form-control" name="message" id="form-message" cols="10" rows="4"
                                        v-model="editItem.admit_school_name"
                                        :class="errorItem.admit_school_name != '' ? 'error-field' : ''"
                                        @keyup="editItem.admit_school_name != '' ? (errorItem.admit_school_name = '') : ''" />
                                    <span class="error-label" v-if="errorItem.admit_school_name != ''"
                                        v-text="errorItem.admit_school_name"></span>
                                </div>

                                <div class="col-lg-12 col-12 form-group">
                                    <label>Exam Center </label>
                                    <input type="text" class="form-control" v-model="editItem.admit_exam_center" />
                                </div>

                                <div class="col-lg-12 col-12 form-group">
                                    <label>Footer Text </label>
                                    <input type="text" class="form-control" v-model="editItem.admit_footer_text" />
                                </div>

                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-3 col-12 form-check mr-5">
                                            <input type="checkbox" class="form-check-input checkAll" id="permanent_address"
                                                v-model="editItem.admit_admission_number"
                                                :class="errorItem.admit_admission_number != '' ? 'error-field' : ''"
                                                @keyup="editItem.admit_admission_number != '' ? (errorItem.admit_admission_number = '') : ''" />
                                            <span class="error-label" v-if="errorItem.admit_admission_number != ''"
                                                v-text="errorItem.admit_admission_number"></span>
                                            <label class="form-check-label">Admission Number</label>

                                        </div>
                                        <div class="col-lg-12 col-12 form-check mr-5">
                                            <input type="checkbox" class="form-check-input checkAll" id="permanent_address"
                                                v-model="editItem.admit_student_name" />
                                            <label class="form-check-label">Student Name</label>
                                        </div>

                                        <div class="col-lg-12 col-12 form-check mr-5">
                                            <input type="checkbox" class="form-check-input checkAll" id="permanent_address"
                                                v-model="editItem.admit_class"
                                                :class="errorItem.admit_class != '' ? 'error-field' : ''"
                                                @keyup="editItem.admit_class != '' ? (errorItem.admit_class = '') : ''" />
                                            <span class="error-label" v-if="errorItem.admit_class != ''"
                                                v-text="errorItem.admit_class"></span>
                                            <label class="form-check-label">Class</label>
                                        </div>

                                        <div class="col-lg-12 col-12 form-check mr-5">
                                            <input type="checkbox" class="form-check-input checkAll" id="permanent_address"
                                                v-model="editItem.admit_father_name"
                                                :class="errorItem.admit_father_name != '' ? 'error-field' : ''"
                                                @keyup="editItem.admit_father_name != '' ? (errorItem.admit_father_name = '') : ''" />
                                            <span class="error-label" v-if="errorItem.admit_father_name != ''"
                                                v-text="errorItem.admit_father_name"></span>
                                            <label class="form-check-label">Father Name</label>
                                        </div>

                                        <div class="col-lg-12 col-12 form-check mr-5">
                                            <input type="checkbox" class="form-check-input checkAll" id="permanent_address"
                                                v-model="editItem.admit_mother_name" />
                                            <label class="form-check-label">Mother Name</label>
                                        </div>

                                        <div class="col-lg-12 col-12 form-check mr-5">
                                            <input type="checkbox" class="form-check-input checkAll" id="permanent_address"
                                                v-model="editItem.admit_address" />
                                            <label class="form-check-label">Student Address</label>
                                        </div>

                                        <div class="col-lg-12 col-12 form-check mr-5">
                                            <input type="checkbox" class="form-check-input checkAll" id="permanent_address"
                                                v-model="editItem.admit_phone_number" />
                                            <label class="form-check-label">Phone Number</label>
                                        </div>

                                        <div class="col-lg-12 col-12 form-check">
                                            <input type="checkbox" class="form-check-input checkAll" id="permanent_address"
                                                v-model="editItem.admit_date_of_birth" />
                                            <label class="form-check-label">Date of Birth</label>
                                        </div>

                                        <div class="col-lg-12 col-12 form-check mr-5">
                                            <input type="checkbox" class="form-check-input checkAll" id="permanent_address"
                                                v-model="editItem.admit_roll_no" />
                                            <label class="form-check-label">Roll No.</label>
                                        </div>

                                        <div class="col-lg-12 col-12 form-check mr-5">
                                            <input type="checkbox" class="form-check-input checkAll" id="permanent_address"
                                                v-model="editItem.admit_gender" />
                                            <label class="form-check-label">Gender </label>
                                        </div>
                                        <div class="col-lg-12 col-12 form-check mr-5">
                                            <input type="checkbox" class="form-check-input checkAll" id="permanent_address"
                                                v-model="editItem.admit_section"
                                                :class="errorItem.admit_section != '' ? 'error-field' : ''"
                                                @keyup="editItem.admit_section != '' ? (errorItem.admit_section = '') : ''" />
                                            <span class="error-label" v-if="errorItem.admit_section != ''"
                                                v-text="errorItem.admit_section"></span>
                                            <label class="form-check-label">Section</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="background_image" class="background_image-label">Background
                                            Image</label>
                                        <div class="imageContainer">
                                            <img :src="selectedBackImage" alt />
                                            <input type="file" accept="image/*" @change="imageFileSelect1" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="signature" class="background_image-label">Left Logo</label>
                                        <div class="imageContainer">
                                            <img :src="selectedLeftLogo" alt />
                                            <input type="file" accept="image/*" @change="imageFileSelect2" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="signature" class="background_image-label">Right Logo</label>
                                        <div class="imageContainer">
                                            <img :src="selectedRightLogo" alt />
                                            <input type="file" accept="image/*" @change="imageFileSelect3" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="signature" class="background_image-label">Student Signature</label>
                                        <div class="imageContainer">
                                            <img :src="selectedSignImage" alt />
                                            <input type="file" accept="image/*" @change="imageFileSelect4" />
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
                                        class="ml-2 btn btn-fill-sm rounded text-light shadow-dodger-blue btn-gradient-yellow"
                                        @click="resetForm">
                                        {{ resetButton }}
                                    </button>
                                </div>
                            </div>
                        </form>
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
            editItem: {},
            editedIndex: -1,
            admit_exam_id: -1,
            examNames_list: [],
            imageFilePath1: null,
            imageFilePath2: null,
            imageFilePath3: null,
            imageFilePath4: null,
            srcImageFile1: null,
            srcImageFile2: null,
            srcImageFile3: null,
            srcImageFile4: null,
            errorItem: {
                admit_template: "",
                admit_title: "",
                admit_heading: "",
                admit_school_name: "",
                admit_father_name: "",
                admit_class: "",
                admit_section: "",
                admit_admission_number: ""
            },
        };
    },
    mounted() {
        this.getExamNames();
    },
    computed: {
        formBtn: function () {
            return this.editedIndex != -1 ? "Update" : "Save";
        },
        resetButton: function () {
            return this.editedIndex === -1 ? "Reset" : "Cancel";
        },
        selectedBackImage: function () {
            return this.srcImageFile1 != null
                ? this.srcImageFile1
                : "/assets/img/nb.jpg";
        },
        selectedLeftLogo: function () {
            return this.srcImageFile2 != null
                ? this.srcImageFile2
                : "/assets/img/nb.jpg";
        },
        selectedRightLogo: function () {
            return this.srcImageFile3 != null
                ? this.srcImageFile3
                : "/assets/img/nb.jpg";
        },
        selectedSignImage: function () {
            return this.srcImageFile4 != null
                ? this.srcImageFile4
                : "/assets/img/nb.jpg";
        },
    },

    methods: {
        async getExamNames() {
            const res = await this.callApi(
                "get",
                `/api/school/examinations/admit_card`,
                null,
            );
            this.log('EXAM NAMES', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.examNames_list = data.exam_names_list;
                    this.$refs.examNames_list.updateList(data.exam_names_list);
                }
            }
        },
        selectExam(exam_id) {
            this.admit_exam_id = exam_id;
        },
        imageFileSelect1(e) {
            const file = e.target.files[0];
            if (file) {
                this.srcImageFile1 = URL.createObjectURL(file);
                URL.revokeObjectURL(file);
                this.imageFilePath1 = file;
            } else {
                this.srcImageFile1 = null;
                this.imageFilePath1 = null;
            }
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
        imageFileSelect3(e) {
            const file = e.target.files[0];
            if (file) {
                this.srcImageFile3 = URL.createObjectURL(file);
                URL.revokeObjectURL(file);
                this.imageFilePath3 = file;
            } else {
                this.srcImageFile3 = null;
                this.imageFilePath3 = null;
            }
        },
        imageFileSelect4(e) {
            const file = e.target.files[0];
            if (file) {
                this.srcImageFile4 = URL.createObjectURL(file);
                URL.revokeObjectURL(file);
                this.imageFilePath4 = file;
            } else {
                this.srcImageFile4 = null;
                this.imageFilePath4 = null;
            }
        },
        async submitData() {
            var isVaild = await this.validAdmitForm();
            if (!isVaild) {
                return;
            }
            toast = Toast.fire({
                icon: "warning",
                title: "Please wait! Creating new Id Card"
            });
            var data = new FormData();
            data.append('template', this.editItem.admit_template ? this.editItem.admit_template : "");
            data.append('heading', this.editItem.admit_heading ? this.editItem.admit_heading : "");
            data.append('title', this.editItem.admit_title ? this.editItem.admit_title : "");
            data.append('exam_name', this.admit_exam_id ? this.admit_exam_id : "");
            data.append('school_name', this.editItem.admit_school_name ? this.editItem.admit_school_name : "");
            data.append('exam_center', this.editItem.admit_exam_center ? this.editItem.admit_exam_center : "");
            data.append('footer_text', this.editItem.admit_footer_text ? this.editItem.admit_footer_text : "");
            data.append('student_name', this.editItem.admit_student_name ? 1 : 0);
            data.append('father_name', this.editItem.admit_father_name ? 1 : 0);
            data.append('mother_name', this.editItem.admit_mother_name ? 1 : 0);
            data.append('date_of_birth', this.editItem.admit_date_of_birth ? 1 : 0);
            data.append('admission_number', this.editItem.admit_admission_number ? 1 : 0);
            data.append('roll_number', this.editItem.admit_roll_number ? 1 : 0);
            data.append('student_address', this.editItem.admit_address ? 1 : 0);
            data.append('gender', this.editItem.admit_gender ? 1 : 0);
            data.append('phone_number', this.editItem.admit_phone_number ? 1 : 0);
            data.append('class', this.editItem.admit_class ? 1 : 0);
            data.append('section', this.editItem.admit_section ? 1 : 0);
            data.append('background_image', this.imageFilePath1 ? this.imageFilePath1 : "");
            data.append('signature', this.imageFilePath4 ? this.imageFilePath4 : "");
            data.append('left_logo', this.imageFilePath2 ? this.imageFilePath2 : "");
            data.append('right_logo', this.imageFilePath3 ? this.imageFilePath3 : "");

            let url = "";
            if (this.editedIndex != -1) {
                url = `/api/school/examinations/admit_card/update/${this.editedIndex}`;
            } else {
                url = `/api/school/examinations/admit_card/save`;
            }
            const res = await this.callApi("post", url, data, "multipart");
            this.log('DAATAA', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == 'success') {
                    this.resetForm();
                    this.$parent.showData();
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
        resetForm() {
            this.editItem = {}
            this.editedIndex = -1,
                this.admit_exam_id = -1,
                this.srcImageFile1 = null,
                this.srcImageFile2 = null,
                this.srcImageFile3 = null,
                this.srcImageFile4 = null,
                this.imageFilePath1 = null,
                this.imageFilePath2 = null,
                this.imageFilePath3 = null
            this.imageFilePath4 = null
        },
        edit(item) {
            this.editItem = item;
            this.editedIndex = item.admitCard_id;
        },
        validAdmitForm() {
            this.isFormValid = true;
            if (
                this.editItem.admit_template == null ||
                this.editItem.admit_template == ""
            ) {
                this.errorItem.admit_template = "Template Name is required";
                this.isFormValid = false;
            } else {
                this.errorItem.admit_template = "";
            }
            if (
                this.editItem.admit_heading == null ||
                this.editItem.admit_heading == ""
            ) {
                this.errorItem.admit_heading = "Heading is required";
                this.isFormValid = false;
            } else {
                this.errorItem.admit_heading = "";
            }
            if (
                this.editItem.admit_title == null ||
                this.editItem.admit_title == ""
            ) {
                this.errorItem.admit_title = "Title is required";
                this.isFormValid = false;
            } else {
                this.errorItem.admit_title = "";
            }
            if (
                this.editItem.admit_school_name == null ||
                this.editItem.admit_school_name == ""
            ) {
                this.errorItem.admit_school_name = "School Name is required";
                this.isFormValid = false;
            } else {
                this.errorItem.admit_school_name = "";
            }
            if (
                this.editItem.admit_class == null ||
                this.editItem.admit_class == ""
            ) {
                this.errorItem.admit_class = "Class Name is required";
                this.isFormValid = false;
            } else {
                this.errorItem.admit_class = "";
            }
            if (
                this.editItem.admit_section == null ||
                this.editItem.admit_section == ""
            ) {
                this.errorItem.admit_section = "Section Name is required";
                this.isFormValid = false;
            } else {
                this.errorItem.admit_section = "";
            }
            if (
                this.editItem.admit_father_name == null ||
                this.editItem.admit_father_name == ""
            ) {
                this.errorItem.admit_father_name = "Father Name is required";
                this.isFormValid = false;
            } else {
                this.errorItem.admit_father_name = "";
            }
            if (
                this.editItem.admit_admission_number == null ||
                this.editItem.admit_admission_number == ""
            ) {
                this.errorItem.admit_admission_number = "Father Name is required";
                this.isFormValid = false;
            } else {
                this.errorItem.admit_admission_number = "";
            }
            return this.isFormValid;
        }
    },
};
</script>

<style scoped>
.imageContainer {
    width: 80%;
    height: 150px;
    border: grey dashed 2px;
    border-radius: 10px;
    position: relative;
    background: #ffffff;
    text-align: center;
    padding: 10px;
    margin: auto;
    margin-bottom: 40px;
    cursor: pointer;
}

.imageContainer img {
    /* width: 100%; */
    height: 100%;
}

.imageContainer input {
    width: 100%;
    height: 100%;
    opacity: 0;
    position: absolute;
    top: 0;
    left: 0;
}
</style>
