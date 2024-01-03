<template>
    <div class="dashboard-content-one">
        <Breadcrumb
            pageTitle="Upload Documents "
            :breadcrumbList="breadcrumbList"
        />
        <div class="row gutters-20">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Add Documents</h3>
                            </div>
                        </div>

                        <form
                            class="new-added-form"
                            enctype="multipart/form-data"
                        >
                            <div class="d-flex">
                                <div
                                    class="col-md-6 col-12 mt-4 form-group"
                                >
                                    <label>
                                        Title
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        placeholder=" "
                                        class="form-control"
                                        v-model="editItem.title1"
                                        :class="
                                            errorItem.title1 != ''
                                                ? 'error-field'
                                                : ''
                                        "
                                        @keypress="errorItem.title1 = ''"
                                    />
                                    <span
                                        class="error-label"
                                        v-if="errorItem.title1"
                                        v-text="errorItem.title1"
                                    ></span>
                                </div>
                                <div
                                    class="col-md-6 col-12 form-group mt-5 "
                                >
                                    <label>
                                        Attach Document
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="rounded-1 p-2 text-center position-relative"
		                                                            style="height:200px;">
                                         <img
		                                                                    :src="selectedImage1
		                                                                    	"
		                                                                    style="
                                                                        width: 100px;
                                                                        max-width: 100%;
                                                                    "
		                                                                />
                                        <input
                                            type="file"
                                            accept="jpg,jpeg,png,pdf"
                                            @change="imageFileSelect1"
                                            :class="
                                                errorItem.imageFilePath1 != ''
                                                    ? 'error-field'
                                                    : ''
                                            "
                                        />
                                        <span
                                            class="error-label"
                                            v-if="
                                                errorItem.imageFilePath1 != ''
                                            "
                                            v-text="errorItem.imageFilePath1"
                                        ></span>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div
                                    class="col-md-6 col-12 mt-4 form-group"
                                >
                                    <label>Title</label>
                                    <input
                                        type="text"
                                        placeholder
                                        class="form-control"
                                        v-model="editItem.title2"
                                    />
                                </div>
                                <div
                                    class="col-md-6 col-12 form-group mt-5"
                                >
                                    <label>Attach Document</label>
									<div class="imageContainer" >
	                                        <img :src="selectedImage2" alt/>
                                    <input
                                        type="file"
                                        accept="jpg,jpeg,png,pdf"
                                        @change="imageFileSelect2"
                                    />
									</div>
                                </div>
                            </div>
                            <div class="row">
                                <div
                                    class="col-md-6 col-12 mt-4 form-group"
                                >
                                    <label>Title</label>
                                    <input
                                        type="text"
                                        placeholder=" "
                                        class="form-control"
                                        v-model="editItem.title3"
                                    />
                                </div>
                                <div
                                    class="col-md-6 col-12 form-group mt-5"
                                >
                                    <label>Attach Document</label>
									<div class="imageContainer" >
	                                        <img :src="selectedImage3" alt/>
                                    <input
                                        type="file"
                                        accept="jpg,jpeg,png,pdf"
                                        @change="imageFileSelect3"
                                    />
									</div>
                                </div>
                            </div>
                            <div class="row">
                                <div
                                    class="col-md-6 col-12 mt-4 form-group"
                                >
                                    <label>Title</label>
                                    <input
                                        type="text"
                                        placeholder
                                        class="form-control"
                                        v-model="editItem.title4"
                                    />
                                </div>
                                <div
                                    class="col-md-6 col-12 mt-5 form-group"
                                >
                                    <label>Attach Document</label>
									<div class="imageContainer imageContainStyle" >
	                                        <img :src="selectedImage4" alt/>
                                    <input
                                        type="file"
                                        accept="jpg,jpeg,png,pdf"
                                        @change="imageFileSelect4"
                                    />
									</div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-5">
                                <button
                                    type="submit"
                                    class="btn btn-lg btn-gradient-yellow btn-hover-bluedark mx-3 text-white"
                                    @click="$router.push('miscellaneous')"
                                >
                                    Back
                                </button>
                                <button
                                    type="submit"
                                    class="btn btn-lg btn-gradient-yellow btn-hover-bluedark mx-3 text-white"
                                    @click.prevent="submitData()"
                                >
                                    {{ formButton }}
                                </button>
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
                    name: "Student",
                },
                {
                    to: { name: "admin.students.admissions" },
                    name: "Admission",
                },
                {
                    name: "Upload Documents ",
                },
            ],
            isLoaded: false,
            noData: false,
              errorItem: {
                title1: "",
                imageFilePath1: "",
            },
            editItem: {
                title1: "",
                title2: "",
                title3: "",
                title4: "",
            },

            imageFilePath1: null,
            imageFilePath2: null,
            imageFilePath3: null,
            imageFilePath4: null,
            srcImageFile1: null,
            srcImageFile2: null,
            srcImageFile3: null,
            srcImageFile4: null,
            editedIds: [],
            documents: [],
            isUpdate: false,
        };
    },
    computed: {
        selectedImage1: function () {
            return this.srcImageFile1 != null
                ? this.srcImageFile1
                : "/assets/img/nb.jpg";
        },
		selectedImage2: function () {
			return this.srcImageFile2 != null
				? this.srcImageFile2
				: "/assets/img/nb.jpg";
		},
		selectedImage3: function () {
			return this.srcImageFile3 != null
				? this.srcImageFile3
				: "/assets/img/nb.jpg";
		},
		selectedImage4: function () {
			return this.srcImageFile4 != null
				? this.srcImageFile4
				: "/assets/img/nb.jpg";
		},
        formButton: function () {
            return this.isUpdate ? "Update" : "Save";
        },
    },
    mounted() {
        this.$parent.loadOtherScript();
        this.admission_id = this.$route.params.admission_id;
        if (this.$route.params.admission_id) {
            this.getEditData();
        }
    },
    methods: {
        async getEditData() {
            var data = new FormData();
            data.append("admission_id", this.admission_id);
            const res = await this.callApi(
                "post",
                `/api/school/students/student_documents/edit`,
                data
            );
            this.log("Document", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.documents = data.documents;
                    this.isUpdate = true;
                    this.documents.forEach((element, index) => {
                        if (index == 0) {
                            this.editItem.title1 = element.title;
                            this.srcImageFile1 = element.document;
                            this.imageFilePath1 = element.document;
                        }
                        if (index == 1) {
                            this.editItem.title2 = element.title;
                            this.srcImageFile2 = element.document;
                            this.imageFilePath2 = element.document;
                        }
                        if (index == 2) {
                            this.editItem.title3 = element.title;
                            this.srcImageFile3 = element.document;
                            this.imageFilePath3 = element.document;
                        }
                        if (index == 3) {
                            this.editItem.title4 = element.title;
                            this.srcImageFile4 = element.document;
                            this.imageFilePath4 = element.document;
                        }
                        this.editedIds.push(element.document_id);
                    });
                } else {
                    this.isUpdate = false;
                }
            }
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
            toast = Toast.fire({
                icon: "warning",
                title: "Please Wait!! Creating new Admission",
                timer: 0,
            });
            var data = new FormData();
            data.append("admission", this.admission_id);
            this.editedIds.forEach((e) => {
                data.append("ids[]", e);
            });
            data.append(
                "title1",
                this.editItem.title1 ? this.editItem.title1 : ""
            );
            data.append(
                "image1",
                this.imageFilePath1 ? this.imageFilePath1 : ""
            );
            data.append(
                "title2",
                this.editItem.title2 ? this.editItem.title2 : ""
            );
            data.append(
                "image2",
                this.imageFilePath2 ? this.imageFilePath2 : ""
            );
            data.append(
                "title3",
                this.editItem.title3 ? this.editItem.title3 : ""
            );
            data.append(
                "image3",
                this.imageFilePath3 ? this.imageFilePath3 : ""
            );
            data.append(
                "title4",
                this.editItem.title4 ? this.editItem.title4 : ""
            );
            data.append(
                "image4",
                this.imageFilePath4 ? this.imageFilePath4 : ""
            );
            let url = "";
            if (!this.isUpdate) {
                url = `/api/school/students/student_documents/save`;
            } else {
                url = `/api/school/students/student_documents/update`;
            }
            const res = await this.callApi("post", url, data);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                    // this.resetForm();
                    setTimeout(() => {
                        this.$router.push({
                            path: `/school/students/details`,
                        });
                    }, 3000);
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
            this.srcImageFile1 = null;
            this.imageFilePath1 = null;
            this.srcImageFile2 = null;
            this.imageFilePath2 = null;
            this.srcImageFile3 = null;
            this.imageFilePath3 = null;
            this.srcImageFile4 = null;
            this.imageFilePath4 = null;
            this.isUpdate = false;
        },
    },
};
</script>
