<template>
    <div>
        <div class="row gutters-20">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Create Marksheet</h3>
                            </div>
                        </div>
                        <form class="new-added-form">
                            <div class="row">
                                <div class="col-lg-12 col-12 form-group">
                                    <label>Template </label>
                                    <input type="text" placeholder=" " class="form-control"
                                        v-model="editItem.marksheet_template"
                                        :class="errorItem.marksheet_template != '' ? 'error-field' : ''"
                                        @keyup="editItem.marksheet_template != '' ? (errorItem.marksheet_template = '') : ''" />
                                        <span class="error-label" v-if="errorItem.marksheet_template != ''"
                                        v-text="errorItem.marksheet_template"></span>
                                </div>
                                <div class="col-lg-12 col-12 form-group">
                                    <label>Heading </label>
                                    <input type="text" class="form-control" v-model="editItem.marksheet_heading"
                                        :class="errorItem.marksheet_heading != '' ? 'error-field' : ''"
                                        @keyup="editItem.marksheet_heading != '' ? (errorItem.marksheet_heading = '') : ''" />
                                        <span class="error-label" v-if="errorItem.marksheet_heading != ''"
                                        v-text="errorItem.marksheet_heading"></span>
                                </div>

                                <div class="col-lg-12 col-12 form-group">
                                    <label>Title </label>
                                    <input type="text" class="form-control" v-model="editItem.marksheet_title"
                                        :class="errorItem.marksheet_title != '' ? 'error-field' : ''"
                                        @keyup="editItem.marksheet_title != '' ? (errorItem.marksheet_title = '') : ''" />
                                        <span class="error-label" v-if="errorItem.marksheet_title != ''"
                                        v-text="errorItem.marksheet_title"></span>
                                </div>
                                <div class="col-lg-12 col-12 form-group">
                                    <label>Exam Name </label>
                                    <Select2 ref="examNames_list" placeholder="--Select Exam--" :items="examNames_list"
                                        @change="selectExam" />
                                </div>

                                <div class="col-lg-12 form-group">
                                    <label>School Name</label>
                                    <textarea class="form-control" name="message" id="form-message" cols="10" rows="4"
                                        v-model="editItem.marksheet_school_name"
                                        :class="errorItem.marksheet_school_name != '' ? 'error-field' : ''"
                                        @keyup="editItem.marksheet_school_name != '' ? (errorItem.marksheet_school_name = '') : ''" />
                                        <span class="error-label" v-if="errorItem.marksheet_school_name != ''"
                                        v-text="errorItem.marksheet_school_name"></span>

                                </div>

                                <div class="col-lg-12 col-12 form-group">
                                    <label>Exam Center </label>
                                    <input type="text" class="form-control" v-model="editItem.marksheet_exam_center" />
                                </div>
                                <div class="col-lg-12 col-12 form-group">
                                    <label>Body Text </label>
                                    <input type="text" class="form-control" v-model="editItem.marksheet_body_text" />
                                </div>
                                <div class="col-lg-12 col-12 form-group">
                                    <label>Footer Text </label>
                                    <input type="text" class="form-control" v-model="editItem.marksheet_footer_text" />
                                </div>
                                <div class="col-lg-12 col-12 form-group">
                                    <label>Printing Date </label>
                                    <DatePicker format="DD-MMM-YYYY" value-type="format" type="date"
                                        placeholder="Select a date" class="form-control vue-datepicker my-0 w-100"
                                        v-model="printed_date" :default-value="new Date()" />
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
                                    <label for="signature" class="background_image-label">Left Sign</label>
                                    <div class="imageContainer">
                                        <img :src="selectedLeftSign" alt />
                                        <input type="file" accept="image/*" @change="imageFileSelect1" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="signature" class="background_image-label">Middle Sign</label>
                                    <div class="imageContainer">
                                        <img :src="selectedMiddleSign" alt />
                                        <input type="file" accept="image/*" @change="imageFileSelect4" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="signature" class="background_image-label">Right Sign</label>
                                    <div class="imageContainer">
                                        <img :src="selectedRightSign" alt />
                                        <input type="file" accept="image/*" @change="imageFileSelect5" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="background_image" class="background_image-label">Background
                                        Image</label>
                                    <div class="imageContainer">
                                        <img :src="selectedBackImage" alt />
                                        <input type="file" accept="image/*" @change="imageFileSelect6" />
                                    </div>
                                </div>

                                <div class="col-lg-12 col-12 form-check mr-5">
                                    <input type="checkbox" class="form-check-input checkAll" id="permanent_address"
                                        v-model="editItem.marksheet_student_name" />
                                    <label class="form-check-label">Student Name</label>
                                </div>
                                <div class="col-lg-12 col-12 form-check mr-5">
                                    <input type="checkbox" class="form-check-input checkAll" id="permanent_address"
                                        v-model="editItem.marksheet_father_name" />
                                    <label class="form-check-label">Father Name</label>
                                </div>
                                <div class="col-lg-12 col-12 form-check mr-5">
                                    <input type="checkbox" class="form-check-input checkAll" id="permanent_address"
                                        v-model="editItem.marksheet_mother_name" />
                                    <label class="form-check-label">Mother Name</label>
                                </div>
                                <div class="col-lg-12 col-12 form-check mr-5">
                                    <input type="checkbox" class="form-check-input checkAll" id="permanent_address"
                                        v-model="editItem.marksheet_session" />
                                    <label class="form-check-label">Exam Session</label>
                                </div>
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-3 col-12 form-check mr-5">
                                            <input type="checkbox" class="form-check-input checkAll"
                                                id="permanent_address" v-model="editItem.marksheet_admission_no" />
                                            <label class="form-check-label">Admission Number</label>
                                        </div>
                                        <div class="col-lg-12 col-12 form-check mr-5">
                                            <input type="checkbox" class="form-check-input checkAll"
                                                id="permanent_address" v-model="editItem.marksheet_division" />
                                            <label class="form-check-label">Division </label>
                                        </div>
                                        <div class="col-lg-12 col-12 form-check mr-5">
                                            <input type="checkbox" class="form-check-input checkAll"
                                                id="permanent_address" v-model="editItem.marksheet_roll_no" />
                                            <label class="form-check-label">Roll Number</label>
                                        </div>
                                        <div class="col-lg-12 col-12 form-check mr-5">
                                            <input type="checkbox" class="form-check-input checkAll"
                                                id="permanent_address" v-model="editItem.marksheet_photo" />
                                            <label class="form-check-label">Photo </label>
                                        </div>
                                        <div class="col-lg-12 col-12 form-check mr-5">
                                            <input type="checkbox" class="form-check-input checkAll"
                                                id="permanent_address" v-model="editItem.marksheet_class" />
                                            <label class="form-check-label">Class</label>
                                        </div>
                                        <div class="col-lg-12 col-12 form-check mr-5">
                                            <input type="checkbox" class="form-check-input checkAll"
                                                id="permanent_address" v-model="editItem.marksheet_section" />

                                            <label class="form-check-label">Section</label>
                                        </div>

                                        <div class="col-lg-12 col-12 form-check">
                                            <input type="checkbox" class="form-check-input checkAll"
                                                id="permanent_address" v-model="editItem.marksheet_date_of_birth" />

                                            <label class="form-check-label">Date of Birth</label>
                                        </div>
                                        <div class="col-lg-12 col-12 form-check mr-5">
                                            <input type="checkbox" class="form-check-input checkAll"
                                                id="permanent_address" v-model="editItem.marksheet_remark" />
                                            <label class="form-check-label">Remark </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 form-group mg-t-8">
                                    <button type="submit"
                                        class="btn btn-lg btn-gradient-yellow btn-hover-bluedark mx-3 text-white"
                                        @click.prevent="submitData()">{{ formBtn }}</button>
                                    <button type="reset"
                                        class="btn btn-lg btn-gradient-yellow btn-hover-bluedark mx-3 text-white">Reset</button>
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
            printed_date: '',
            editedIndex: -1,
            marksheet_exam_id: -1,
            examNames_list: [],
            imageFilePath1: null,
            imageFilePath2: null,
            imageFilePath3: null,
            imageFilePath4: null,
            imageFilePath5: null,
            imageFilePath6: null,
            srcImageFile1: null,
            srcImageFile2: null,
            srcImageFile3: null,
            srcImageFile4: null,
            srcImageFile5: null,
            srcImageFile6: null,
            errorItem:{
                marksheet_template:"",
                marksheet_heading:"",
                marksheet_title:"",
                marksheet_school_name:"",
                marksheet_exam_center:"",
            },
            tableHead: {
                items: {
                    item1: { label: "Sr.No." },
                    item2: { label: "Title" },
                    item3: { label: "Background Image" },
                    item4: { label: "" },
                },
                actions: true,
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
        selectedLeftSign: function () {
            return this.srcImageFile1 != null
                ? this.srcImageFile1
                : "/assets/img/nb.jpg";
        },
        selectedMiddleSign: function () {
            return this.srcImageFile4 != null
                ? this.srcImageFile4
                : "/assets/img/nb.jpg";
        },
        selectedRightSign: function () {
            return this.srcImageFile5 != null
                ? this.srcImageFile5
                : "/assets/img/nb.jpg";
        },
        selectedBackImage: function () {
            return this.srcImageFile6 != null
                ? this.srcImageFile6
                : "/assets/img/nb.jpg";
        },
    },
    watch: {
        printed_date: function (val) {
            this.printed_date = val;
            this.editItem.marksheet_printed_at = moment(new Date(val)).format('YYYY-MM-DD');
        }
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
            this.marksheet_exam_id = exam_id;
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
        imageFileSelect5(e) {
            const file = e.target.files[0];
            if (file) {
                this.srcImageFile5 = URL.createObjectURL(file);
                URL.revokeObjectURL(file);
                this.imageFilePath5 = file;
            } else {
                this.srcImageFile5 = null;
                this.imageFilePath5 = null;
            }
        },
        imageFileSelect6(e) {
            const file = e.target.files[0];
            if (file) {
                this.srcImageFile6 = URL.createObjectURL(file);
                URL.revokeObjectURL(file);
                this.imageFilePath6 = file;
            } else {
                this.srcImageFile6 = null;
                this.imageFilePath6 = null;
            }
        },
        async submitData() {
            var isVaild = await this.validMarksheetForm();
            if (!isVaild) {
                return;
            }
            toast = Toast.fire({
                icon: "warning",
                title: "Please wait! Creating new Marksheet "
            });
            var data = new FormData();
            data.append('template', this.editItem.marksheet_template ? this.editItem.marksheet_template : "");
            data.append('heading', this.editItem.marksheet_heading ? this.editItem.marksheet_heading : "");
            data.append('title', this.editItem.marksheet_title ? this.editItem.marksheet_title : "");
            data.append('exam_name', this.marksheet_exam_id ? this.marksheet_exam_id : "");
            data.append('school_name', this.editItem.marksheet_school_name ? this.editItem.marksheet_school_name : "");
            data.append('exam_center', this.editItem.marksheet_exam_center ? this.editItem.marksheet_exam_center : "");
            data.append('body_text', this.editItem.marksheet_body_text ? this.editItem.marksheet_body_text : "");
            data.append('footer_text', this.editItem.marksheet_footer_text ? this.editItem.marksheet_footer_text : "");
            data.append('printing_date', this.editItem.marksheet_printed_at ? this.editItem.marksheet_printed_at : "");
            data.append('student_name', this.editItem.marksheet_student_name ? 1 : 0);
            data.append('father_name', this.editItem.marksheet_father_name ? 1 : 0);
            data.append('mother_name', this.editItem.marksheet_mother_name ? 1 : 0);
            data.append('exam_session', this.editItem.marksheet_exam_session ? 1 : 0);
            data.append('date_of_birth', this.editItem.marksheet_date_of_birth ? 1 : 0);
            data.append('admission_number', this.editItem.marksheet_admission_number ? 1 : 0);
            data.append('division', this.editItem.marksheet_division ? 1 : 0);
            data.append('roll_number', this.editItem.marksheet_roll_number ? 1 : 0);
            data.append('student_photo', this.editItem.marksheet_student_photo ? 1 : 0);
            data.append('class', this.editItem.marksheet_class ? 1 : 0);
            data.append('section', this.editItem.marksheet_section ? 1 : 0);
            data.append('remark', this.editItem.marksheet_remark ? 1 : 0);
            data.append('left_logo', this.imageFilePath2 ? this.imageFilePath2 : "");
            data.append('right_logo', this.imageFilePath3 ? this.imageFilePath3 : "");
            data.append('left_sign', this.imageFilePath1 ? this.imageFilePath1 : "");
            data.append('middle_sign', this.imageFilePath4 ? this.imageFilePath4 : "");
            data.append('right_sign', this.imageFilePath5 ? this.imageFilePath5 : "");
            data.append('background_image', this.imageFilePath6 ? this.imageFilePath6 : "");

            let url = "";
            if (this.editedIndex != -1) {
                url = `/api/school/examinations/design_marksheet/update/${this.editedIndex}`;
            } else {
                url = `/api/school/examinations/design_marksheet/save`;
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
                this.$refs.examNames_list.setSelected(-1)
                this.srcImageFile1 = null,
                this.srcImageFile2 = null,
                this.srcImageFile3 = null,
                this.srcImageFile4 = null,
                this.imageFilePath1 = null,
                this.imageFilePath2 = null,
                this.imageFilePath3 = null,
                this.imageFilePath5 = null,
                this.imageFilePath6 = null
                this.imageFilePath4 = null
        },
        edit(item) {
            this.editItem = item;
            this.editedIndex = item.marksheet_id;
            this.$refs.examNames_list.setSelected(item.marksheet_exam_id);
            this.selectExam(item.marksheet_exam_id);
        },
        validMarksheetForm() {
            this.isFormValid = true;
            if (
                this.editItem.marksheet_template == null ||
                this.editItem.marksheet_template == ""
            ) {
                this.errorItem.marksheet_template = "Template Name is required";
                this.isFormValid = false;
            } else {
                this.errorItem.marksheet_template = "";
            }
            if (
                this.editItem.marksheet_title == null ||
                this.editItem.marksheet_title == ""
            ) {
                this.errorItem.marksheet_title = "Title is required";
                this.isFormValid = false;
            } else {
                this.errorItem.marksheet_title = "";
            }
            if (
                this.editItem.marksheet_heading == null ||
                this.editItem.marksheet_heading == ""
            ) {
                this.errorItem.marksheet_heading = "Heading is required";
                this.isFormValid = false;
            } else {
                this.errorItem.grade = "";
            }
            if (
                this.editItem.marksheet_school_name == null ||
                this.editItem.marksheet_school_name == ""
            ) {
                this.errorItem.marksheet_school_name = "School Name is required";
                this.isFormValid = false;
            } else {
                this.errorItem.grade = "";
            }
            if (
                this.editItem.marksheet_exam_center == null ||
                this.editItem.marksheet_exam_center == ""
            ) {
                this.errorItem.marksheet_exam_center = "Exam Center is required";
                this.isFormValid = false;
            } else {
                this.errorItem.grade = "";
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
