<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb
                pageTitle="Download Center"
                :breadcrumbList="breadcrumbList"
            />
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-4 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="heading-layout1">
                                        <div class="item-title">
                                            <h3>Upload Content</h3>
                                        </div>
                                    </div>
                                    <form class="new-added-form">
                                        <div class="row">
                                            <div class="col-12 form-group">
                                                <label
                                                    >Title<strong
                                                        class="text-danger bolder"
                                                        >*</strong
                                                    ></label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control mb-4"
                                                    v-model="
                                                        editItem.upload_title
                                                    "
                                                    :class="
                                                        errorItem.upload_title !=
                                                        ''
                                                            ? 'error-field'
                                                            : ''
                                                    "
                                                    @keyup="
                                                        editItem.upload_title !=
                                                        ''
                                                            ? (errorItem.upload_title =
                                                                  '')
                                                            : ''
                                                    "
                                                />
                                                <span
                                                    class="error-label"
                                                    v-if="
                                                        errorItem.upload_title !=
                                                        ''
                                                    "
                                                    v-text="
                                                        errorItem.upload_title
                                                    "
                                                ></span>
                                            </div>
                                            <div class="col-12 form-group">
                                                <label
                                                    >Content Type<strong
                                                        class="text-danger bolder"
                                                        >*</strong
                                                    ></label
                                                >
                                                <select
                                                    class="form-control"
                                                    v-model="
                                                        editItem.upload_content_type
                                                    "
                                                    :class="
                                                        errorItem.upload_content_type !==
                                                        ''
                                                            ? 'error-field'
                                                            : ''
                                                    "
                                                    @change="
                                                        editItem.upload_content_type !=
                                                        ''
                                                            ? (errorItem.upload_content_type =
                                                                  '')
                                                            : ''
                                                    "
                                                >
                                                    <option value>
                                                        Select Type
                                                    </option>
                                                    <option value="assignments">
                                                        Assignments
                                                    </option>
                                                    <option value="syllabus">
                                                        Syllabus
                                                    </option>
                                                    <option
                                                        value="study_material"
                                                    >
                                                        Study Material
                                                    </option>
                                                    <option
                                                        value="other_downloads"
                                                    >
                                                        Other Downloads
                                                    </option>
                                                </select>
                                                <span
                                                    class="error-label"
                                                    v-if="
                                                        errorItem.upload_title !=
                                                        ''
                                                    "
                                                    v-text="
                                                        errorItem.upload_title
                                                    "
                                                ></span>
                                            </div>
                                            <div
                                                class="col-lg-12 col-12 classSection form-group"
                                            >
                                                <label
                                                    >Class<strong
                                                        class="text-danger bolder"
                                                        >*</strong
                                                    ></label
                                                >
                                                <Select2
                                                    ref="class_list_select2"
                                                    placeholder="--SELECT A CLASS--"
                                                    :items="class_list"
                                                    @change="selectClass"
                                                />
                                            </div>
                                            <div
                                                class="col-lg-12 col-12 classSection form-group"
                                            >
                                                <label
                                                    >Section<strong
                                                        class="text-danger bolder"
                                                        >*</strong
                                                    ></label
                                                >
                                                <Select2
                                                    ref="section_list_select2"
                                                    :items="section_list"
                                                    @change="selectSection"
                                                />
                                            </div>
                                            <div class="col-12">
                                                <div
                                                    v-for="(
                                                        student, index
                                                    ) in studentList"
                                                    :key="
                                                        student.student_admission_id
                                                    "
                                                >
                                                    <div>
                                                        <span>
                                                            <input
                                                                :id="`studentChecked${index}`"
                                                                type="checkbox"
                                                                :checked="
                                                                    isStudentSelected(
                                                                        student.student_admission_id
                                                                    )
                                                                "
                                                                @change.prevent="
                                                                    toggleStudentSelection(
                                                                        student.student_admission_id
                                                                    )
                                                                "
                                                            />
                                                        </span>
                                                        <span>
                                                            {{
                                                                getStudentFullName(
                                                                    student
                                                                )
                                                            }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-check">
                                                <input
                                                    type="checkbox"
                                                    id="checkDate"
                                                    class="form-check-input checkAll"
                                                    value="true"
                                                    v-model="
                                                        editItem.upload_is_publish
                                                    "
                                                    @change="isShowDate"
                                                />
                                                <label class="form-check-label"
                                                    >Publish Date</label
                                                >
                                            </div>
                                            <div
                                                class="col-12 form-group"
                                                v-if="isShowing"
                                            >
                                                <DatePicker
                                                    format="DD-MMM-YYYY"
                                                    value-type="format"
                                                    type="date"
                                                    placeholder="Select a date"
                                                    v-model="published_date"
                                                    class="form-control vue-datepicker my-0 w-100"
                                                    ref="published_at"
                                                    :default-value="new Date()"
                                                    :class="
                                                        errorItem.upload_published_at !==
                                                        ''
                                                            ? 'error-field'
                                                            : ''
                                                    "
                                                    @click="
                                                        editItem.upload_published_at !=
                                                        ''
                                                            ? (errorItem.upload_published_at =
                                                                  '')
                                                            : ''
                                                    "
                                                />
                                                <span
                                                    class="error-label"
                                                    v-if="
                                                        errorItem.upload_published_at !=
                                                        ''
                                                    "
                                                    v-text="
                                                        errorItem.upload_published_at
                                                    "
                                                ></span>
                                            </div>
                                            <div class="col-12">
                                                <label
                                                    for="background_image"
                                                    class="background_image-label"
                                                    >Upload File</label
                                                >
                                                <div class="imageContainer">
                                                    <img
                                                        :src="selectFile"
                                                        alt
                                                    />
                                                    <input
                                                        type="file"
                                                        accept="image/*"
                                                        @change="
                                                            imageFileSelect
                                                        "
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-12 form-group">
                                                <label>Description</label>
                                                <textarea
                                                    class="textarea form-control"
                                                    name="message"
                                                    id="form-message"
                                                    cols="10"
                                                    rows="4"
                                                    v-model="
                                                        editItem.upload_description
                                                    "
                                                ></textarea>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button
                                                type="submit"
                                                class="btn btn-fill-sm rounded text-light shadow-dodger-blue bg-dodger-blue"
                                                @click.prevent="submitData()"
                                            >
                                                {{ formBtn }}
                                            </button>
                                            <button
                                                type="button"
                                                class="btn btn-fill-sm rounded text-light shadow-dodger-blue btn-gradient-yellow"
                                                @click="resetForm"
                                            >
                                                {{ resetButton }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8 col-12">
                            <UploadContent ref="uploadContent" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
var toast;
import UploadContent from "./UploadContent.vue";

export default {
    components: {
        UploadContent,
    },
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "admin.dashboard" },
                    name: "Home",
                },
                {
                    name: "Upload Content",
                },
            ],
            contentList: [],
            isLoaded: false,

            editedIndex: -1,
            isShow: true,
            imageFilePath: null,
            srcImageFile: null,
            // contentFor:[],
            class_list: [],
            section_list: [],
            errorItem: {
                upload_title: "",
                upload_published_at: "",
                upload_content_type: "",
            },
            classId: -1,
            sectionId: -1,
            studentList: [],
            editItem: {
                studentIds: [],
            },

            studentId: -1,
            published_date: "",
            isShowing: false,
            contentSrcImage: null,
            checkedStudents: [],
        };
    },
    computed: {
        formBtn: function () {
            return this.editedIndex !== -1 ? "Update" : "Save";
        },
        resetButton: function () {
            return this.editedIndex === -1 ? "Reset" : "Cancel";
        },
        selectFile: function () {
            return this.srcImageFile != null
                ? this.srcImageFile
                : "/assets/img/nb.jpg";
        },
        //   isStudentSelected() {
        //     return (studentId) => this.editItem.studentIds.includes(studentId);
        // },
    },
    mounted() {
        if (this.$route.params.upload_content_id) {
            this.editedIndex = this.$route.params.upload_content_id;
            this.getEditItemData();
        }
        this.$parent.loadOtherScript();
        this.getClassList();
        this.published_date = moment(new Date()).format("DD-MMM-YYYY");
    },
    watch: {
        published_date: function (val) {
            this.published_date = val;
            this.editItem.upload_published_at = moment(new Date(val)).format(
                "YYYY-MM-DD"
            );
        },
    },
    methods: {
        toggleStudentSelection(studentId) {
            if (this.editItem.studentIds.includes(studentId)) {
                this.editItem.studentIds = this.editItem.studentIds.filter(
                    (id) => id !== studentId
                );
            } else {
                this.editItem.studentIds.push(studentId);
            }
        },

        edit(item, index) {
            this.editItem = item;
            this.editedIndex = item.upload_content_id;
            this.log("ITEMS", item);
            if (this.editItem.upload_published_at != null) {
                $("#checkDate").prop("checked", true);
                this.isShowing = true;
            }
            this.editItem.upload_is_publish = item.upload_is_publish;
            this.published_date =
                this.editItem.upload_published_at != null
                    ? moment(String(this.editItem.upload_published_at)).format(
                          "DD-MMM-YYYY"
                      )
                    : null;
            this.editItem.upload_published_at = moment(
                String(this.editItem.upload_published_at)
            ).format("YYYY-MM-DD");
            this.$refs.class_list_select2.setSelected(
                item.upload_school_class_id
            );
            this.selectClass(item.upload_school_class_id);
            this.selectSection(item.upload_school_section_id);
            this.sectionId = item.upload_school_section_id;
            this.imageFilePath = item.upload_documents;
            this.srcImageFile = item.upload_documents;

            this.classId = item.upload_school_class_id;
            this.sectionId = item.upload_school_section_id;
            this.checkedStudents = item.upload_students.map(
                (e) => e.student_admission_id
            );
        },
        isStudentSelected(studentId) {
            return this.checkedStudents.includes(studentId);
        },
        async selectClass(val) {
            this.classId = val;
            const res = await this.callApi(
                "get",
                `/api/school/general/class/${this.classId}/sections`,
                null
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.sections = data.school_class_sections;
                    this.$refs.section_list_select2.updateList(
                        data.school_class_sections
                    );
                    if (this.editedIndex !== -1) {
                        this.$refs.section_list_select2.setSelected(
                            this.sectionId
                        );
                    }
                }
            }
            this.getStudents();
        },
        isShowDate() {
            if ($("#checkDate").is(":checked")) {
                this.isShowing = true;
            } else {
                this.isShowing = false;
            }
        },
        selectSection(val) {
            this.sectionId = val;
            this.getStudents();
        },
        async getClassList() {
            const res = await this.callApi(
                "get",
                `/api/school/general/get_class_list`,
                null
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.class_list = data.class_list;
                    this.$refs.class_list_select2.updateList(data.class_list);
                }
            }
        },

        imageFileSelect(e) {
            const file = e.target.files[0];
            if (file) {
                this.srcImageFile = URL.createObjectURL(file);
                URL.revokeObjectURL(file);
                this.imageFilePath = file;
            } else {
                this.srcImageFile = null;
                this.imageFilePath = null;
            }
        },
        async getStudents() {
            var formData = new FormData();
            formData.append("class_id", this.classId);
            formData.append("section_id", this.sectionId);

            const res = await this.callApi(
                "post",
                `/api/school/students/student_admissions`,
                formData
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.studentList = data.student_admissions;
                    this.editItem.studentIds = [];
                } else {
                    this.studentList = [];
                }
            }
        },
        async saveData() {
            var isVaild = await this.validContentForm();
            if (!isVaild) {
                return;
            }
            toast = Toast.fire({
                icon: "warning",
                title: "Please Wait!! Creating new Content",
                timer: 0,
            });
            var data = new FormData();
            data.append(
                "class",
                this.classId && this.classId != null ? this.classId : ""
            );
            data.append(
                "section",
                this.sectionId && this.sectionId != null ? this.sectionId : ""
            );
            data.append(
                "content_type",
                this.editItem.upload_content_type &&
                    this.editItem.upload_content_type != null
                    ? this.editItem.upload_content_type
                    : ""
            );
            data.append("title", this.editItem.upload_title);
            data.append(
                "content_for",
                this.editItem.studentIds && this.editItem.studentIds != null
                    ? this.editItem.studentIds
                    : ""
            );
            data.append("is_publish", this.editItem.upload_is_publish ? 1 : 0);
            data.append(
                "published_at",
                this.editItem.upload_published_at &&
                    this.editItem.upload_published_at != null
                    ? this.editItem.upload_published_at
                    : ""
            );
            data.append(
                "description",
                this.editItem.upload_description &&
                    this.editItem.upload_description != null
                    ? this.editItem.upload_description
                    : ""
            );
            data.append("image", this.imageFilePath ? this.imageFilePath : "");
            const res = await this.callApi(
                "post",
                `/api/school/download_center/upload_content/save`,
                data,
                "multipart"
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.contentList.push(data.upload_content);
                    this.resetForm();
                    this.$refs.uploadContent.showData();
                    toast = Toast.fire({
                        icon: "success",
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
        async submitData() {
            if (this.editedIndex !== -1) {
                this.updateData();
            } else {
                this.saveData();
            }
        },
        resetForm() {
            this.editItem = {};
            this.editedIndex = -1;
            (this.isShowing = false), (this.studentList = null);
            this.published_date = null;
            this.imageFilePath = null;
            this.srcImageFile = null;
            this.editItem.upload_is_publish = 0;
            this.$refs.class_list_select2.setSelected(-1);
            this.$refs.section_list_select2.setSelected(-1);
        },
        validContentForm() {
            this.isFormValid = true;
            if (
                this.editItem.upload_title == null ||
                this.editItem.upload_title == ""
            ) {
                this.errorItem.upload_title = "title is required";
                this.isFormValid = false;
            } else {
                this.errorItem.upload_title = "";
            }
            if (
                this.editItem.upload_published_at == null ||
                this.editItem.upload_published_at == ""
            ) {
                this.errorItem.upload_published_at =
                    "Publish Date  is required";
                this.isFormValid = false;
            } else {
                this.errorItem.upload_published_at = "";
            }
            if (
                this.editItem.upload_content_type == null ||
                this.editItem.upload_content_type == ""
            ) {
                this.errorItem.upload_content_type = "Content type is required";
                this.isFormValid = false;
            } else {
                this.errorItem.upload_content_type = "";
            }
            return this.isFormValid;
        },
        getStudentFullName(student) {
            return (
                student.student_first_name +
                (student.student_middle_name
                    ? " " + student.student_middle_name
                    : "") +
                (student.student_last_name
                    ? " " + student.student_last_name
                    : "")
            );
        },
        selectStudent(studentId, index) {
            if (
                this.editItem.studentIds &&
                this.editItem.studentIds.includes(studentId)
            ) {
                this.editItem.studentIds.splice(
                    this.editItem.studentIds.indexOf(studentId),
                    1
                );
                $("#studentChecked" + index).prop("checked", false);
            } else {
                this.editItem.studentIds.push(studentId);
                $("#studentChecked" + index).prop("checked", true);
            }
        },
        async getEditItemData(editedIndex) {
            const res = await this.callApi(
                "get",
                `/api/school/download_center/upload_content/edit/${this.editedIndex}`,
                null
            );
            this.log("SELECTED DATA", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.imageFilePath = data.upload_content.upload_documents;
                    this.srcImageFile = data.upload_content.upload_documents;

                    this.$refs.class_list_select2.setSelected(
                        data.upload_content.upload_school_class_id
                    );
                    this.classId = data.upload_content.upload_school_class_id;
                    this.selectClass(
                        data.upload_content.upload_school_class_id
                    );
                    this.$refs.section_list_select2.setSelected(
                        data.upload_content.upload_school_section_id
                    );
                    this.sectionId =
                        data.upload_content.upload_school_section_id;
                    this.selectSection(
                        data.upload_content.upload_school_section_id
                    );
                    this.editItem = {
                        upload_title: data.upload_content.upload_title,
                        upload_content_type:
                            data.upload_content.upload_content_type,
                        upload_is_publish: data.upload_content.is_publish,
                        upload_published_at:
                            data.upload_content.upload_published_at,
                        upload_description:
                            data.upload_content.upload_description,
                    };
                    if (this.editItem.upload_published_at != null) {
                        $("#checkDate").prop("checked", true);
                        this.isShowing = true;
                    }

                    this.editItem.upload_is_publish =
                        data.upload_content.upload_is_publish;
                    this.published_date =
                        this.editItem.upload_published_at != null
                            ? moment(
                                  String(this.editItem.upload_published_at)
                              ).format("DD-MMM-YYYY")
                            : null;
                    this.editItem.upload_published_at = moment(
                        String(this.editItem.upload_published_at)
                    ).format("YYYY-MM-DD");
                    // this.studentList.forEach((element, index) => {
                    //     data.upload_content.upload_students.forEach((e) => {
                    //         if (
                    //             element.student_admission_id ==
                    //             e.student_admission_id
                    //         ) {
                    //             this.selectStudent(
                    //                 element.student_admission_id,
                    //                 index
                    //             );
                    //             if (
                    //                 this.editItem.studentIds &&
                    //                 this.editItem.studentIds.includes(studentId)
                    //             ) {
                    //                 this.editItem.studentIds.splice(
                    //                     this.editItem.studentIds.indexOf(
                    //                         studentId
                    //                     ),
                    //                     1
                    //                 );
                    //             }
                    //             this.editItem.studentIds.push(studentId);
                    //             $("#studentChecked" + index).push(
                    //                 "checked",
                    //                 true
                    //             );
                    //         }
                    //     });
                    // });

                    this.checkedStudents =
                        data.upload_content.upload_students.map(
                            (e) => e.student_admission_id
                        );
                }
            }
        },
        async updateData() {
            var data = new FormData();
            data.append("class", this.classId);
            data.append("section", this.sectionId);
            data.append("content_type", this.editItem.upload_content_type);
            data.append("title", this.editItem.upload_title);
            data.append("content_for", this.editItem.studentIds);
            console.log("content_for", this.editItem.studentIds);
            data.append("is_publish", this.editItem.upload_is_publish ? 1 : 0);
            data.append("published_at", this.editItem.upload_published_at);
            data.append(
                "description",
                this.editItem.upload_description != null &&
                    this.editItem.upload_description != ""
                    ? this.editItem.upload_description
                    : ""
            );
            data.append("image", this.imageFilePath ? this.imageFilePath : "");

            const res = await this.callApi(
                "post",
                `/api/school/download_center/upload_content/update/${this.editedIndex}`,
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
            this.editedIndex = -1;
        },
    },
};
</script>
<style scoped>
/*.classSection{
    background-color: #efececf7 !important;
}  */
.available-class-section {
    margin-top: 15px !important;
}
</style>
