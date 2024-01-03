<template>
    <div class="dashboard-content-one">
        <Breadcrumb pageTitle="Upload Documents " :breadcrumbList="breadcrumbList" />
        <div class="row gutters-20">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Add Documents</h3>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input form-control p-3" id="fileInput" ref="fileInput"
                                    @change="handleFileChange" multiple>
                                <label class="custom-file-label" for="fileInput">Choose files</label>
                            </div>
                        </div>
                        <div v-if="files">
                            <h5>Selected Files:{{ files.length }}</h5>

                            <div class="row">
                                <div class="col-md-4" v-for="(file, index) in files" :key="index">
                                    <input v-model="fileTitles[index]" type="text" class="form-group p-2 mb-2"
                                        placeholder="Enter title">
                                    <p>{{ file.name }}</p>
                                </div>
                            </div>
                        </div>
                            <div v-if="schoolDoc.documents">
                                <h5>Existing Documents:</h5>
                                <div class="row">
                                    <div class="card col-md-4 text-center align-items-center shadow p-3 rounded" v-for="(document, index) in schoolDoc.documents" :key="index">
                                        <div class="card-body">
                                            <input v-model="document.fileTitles" type="text" class="form-control mb-2 text-center" placeholder="Enter title">
                                            <img :src="'/storage/images' + document.files"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="d-flex justify-content-end mt-5">
                            <button type="submit" class="btn btn-lg btn-gradient-yellow btn-hover-bluedark mx-3 text-white"
                                @click="goBack()">
                                Back
                            </button>
                            <button type="submit" class="btn btn-lg btn-gradient-yellow btn-hover-bluedark mx-3 text-white"
                                @click.prevent="submitData()" >
                                {{ formButton }}
                            </button>
                        </div>
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
                    name: "Schools",
                    to: { name: "admin.school.list" },
                },
                {
                   name: "School Documents",
                   to: {name: "admin.school.documents"},
                },
                {
                    name: "Create",
                }
            ],
            files: [],
            selectedFiles: [],
            fileTitles: [],
            documents: [],
            isUpdate: false,
            school_id: -1,
            edit_id : -1,
            schoolDoc: {},
            editItems: [
            { title: "", imageFiles: [], srcImageFiles: [] },
            ],
            errorItem: {
                title1: "",
                imageFilePath1: "",
            },
        };
    },
    computed: {
        formButton: function () {
            return this.isUpdate ? "Update" : "Save";
        },
    },
    mounted() {

        if(this.$route.params.edit_id
        ){
            this.edit_id = this.$route.params.edit_id;
            console.log('docs id', this.edit_id);
            this.getEditData();
        } else{
            this.school_id = this.$route.params.school_id;
              console.log('school id', this.school_id);
        }
    },
    methods: {
        goBack() {
            this.$router.push(`/admin/school/documents/${this.school_id}`)
        },
        submitData(){
            if(this.isUpdate = true){
                this.updateData();

            }else{
                this.saveData();
            }
        },
        async getEditData() {
            console.log('dkgngr',this.edit_id);
            const res = await this.callApi(
                "get",
                `/api/admin/schools/schoolDoc_edit/${this.edit_id}`,
                null
            );
            this.log("Document", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.schoolDoc = data.schoolDoc;
                    this.editfileTitles = data.schoolDoc.documents.fileTitles;
                    console.log('school docs',this.files);
                    this.isUpdate = true;

                } else {
                    this.isUpdate = false;
                }
            }
        },
        closeForm(index) {
            this.editItems.splice(index, 1);
        },

        handleFileChange() {
            this.files = this.$refs.fileInput.files;
            this.fileTitles = Array(this.files.length).fill('');
            const label = this.$refs.fileInput.nextElementSibling;
            label.innerHTML = Array.from(this.files).map(file => file.name).join(', ');
        },

        async saveData() {
            toast = Toast.fire({
                icon: "warning",
                title: "Please Wait!! Creating new Admission",
                timer: 0,
            });
            var formData = new FormData();
            console.log('files', this.files);
            formData.append('school_id', this.school_id);
            for (let i = 0; i < this.files.length; i++) {
                formData.append('images[]', this.files[i]);
                formData.append('titles[]', this.fileTitles[i]);
            }

            let url = "";
            url = `/api/admin/schools/create_schoolDocs`;

            try {
                const res = await this.callApi("post", url, formData, "multipart");
                if (res.status === 200) {
                    const data = res.data;

                    if (data.status === "success") {
                        toast = Toast.fire({
                            icon: data.status,
                            title: data.message,
                            timer: 2500,
                        });

                        setTimeout(() => {
                            this.$router.push({
                                path: `/admin/school/list`,
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
                        icon: "error",
                        title: "Error submitting the form",
                        timer: 2500,
                    });
                }
            } catch (error) {
                toast = Toast.fire({
                    icon: "error",
                    title: "Error submitting the form",
                    timer: 2500,
                });
                console.error(error);
            }
        },
        async updateData() {
           toast = Toast.fire({
                icon: "warning",
                title: "Please Wait!! Updating School Documents",
                timer: 0,
            });
            const formData = new FormData();

            // Append existing documents
            this.schoolDoc.documents.forEach((document, index) => {
                formData.append(`existing_titles[${index}]`, document.fileTitles);
                formData.append(`existing_files[${index}]`, document.files);
            });

            // Append new documents
            for (let i = 0; i < this.files.length; i++) {
                formData.append('images[]', this.files[i]);
                formData.append('titles[]', this.fileTitles[i]);
                // Append any other fields as needed
            }

            let url = `/api/admin/schools/update_schoolDocs/${this.edit_id}`;

            try {
                const res = await this.callApi("post", url, formData, "multipart");
                if (res.status === 200) {
                    const data = res.data;
                    // Handle success
                }
            } catch (error) {
                // Handle errors
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

