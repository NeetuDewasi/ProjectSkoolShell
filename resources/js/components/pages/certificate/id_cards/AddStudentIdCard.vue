<template>
    <div>
        <div class="row gutters-20">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Add Student Id Card</h3>
                            </div>
                        </div>
                        <form class="new-added-form">
                            <div class="row">
                                <div class="col-lg-12 col-12 form-group">
                                    <label>School Name</label>
                                    <input type="text" placeholder=" " class="form-control"
                                        v-model="editItem.id_school_name" />
                                </div>
                                <div class="col-lg-8 col-12 form-group">
                                    <label>Id Card Title</label>
                                    <input type="text" class="form-control" v-model="editItem.id_title" />
                                </div>

                                <div class="col-lg-4 col-12 form-group">
                                    <label>Header Color</label>
                                    <input type="text" class="form-control" v-model="editItem.id_header_color" />
                                </div>

                                <div class="col-lg-12 form-group">
                                    <label>Address/Phone/Email</label>
                                    <textarea class="form-control" name="message" id="form-message" cols="10" rows="4"
                                        v-model="editItem.address_phone_email"></textarea>
                                </div>

                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-3 col-12 form-check mr-5">
                                            <input type="checkbox" class="form-check-input checkAll" id="permanent_address"
                                                v-model="editItem.id_admission_number" />
                                            <label class="form-check-label">Admission Number</label>

                                        </div>
                                        <div class="col-lg-3 col-12 form-check mr-5">
                                            <input type="checkbox" class="form-check-input checkAll" id="permanent_address"
                                                v-model="editItem.id_student_name" />
                                            <label class="form-check-label">Student Name</label>
                                        </div>

                                        <div class="col-lg-3 col-12 form-check mr-5">
                                            <input type="checkbox" class="form-check-input checkAll" id="permanent_address"
                                                v-model="editItem.id_class" />
                                            <label class="form-check-label">Class</label>
                                        </div>

                                        <div class="col-lg-3 col-12 form-check mr-5">
                                            <input type="checkbox" class="form-check-input checkAll" id="permanent_address"
                                                v-model="editItem.id_father_name" />
                                            <label class="form-check-label">Father Name</label>
                                        </div>

                                        <div class="col-lg-3 col-12 form-check mr-5">
                                            <input type="checkbox" class="form-check-input checkAll" id="permanent_address"
                                                v-model="editItem.id_mother_name" />
                                            <label class="form-check-label">Mother Name</label>
                                        </div>

                                        <div class="col-lg-3 col-12 form-check mr-5">
                                            <input type="checkbox" class="form-check-input checkAll" id="permanent_address"
                                                v-model="editItem.id_address" />
                                            <label class="form-check-label">Student Address</label>
                                        </div>

                                        <div class="col-lg-3 col-12 form-check mr-5">
                                            <input type="checkbox" class="form-check-input checkAll" id="permanent_address"
                                                v-model="editItem.id_phone_number" />
                                            <label class="form-check-label">Phone Number</label>
                                        </div>

                                        <div class="col-lg-3 col-12 form-check mr-5">
                                            <input type="checkbox" class="form-check-input checkAll" id="permanent_address"
                                                v-model="editItem.id_date_of_birth" />
                                            <label class="form-check-label">Date of Birth</label>
                                        </div>

                                        <div class="col-lg-3 col-12 form-check mr-5">
                                            <input type="checkbox" class="form-check-input checkAll" id="permanent_address"
                                                v-model="editItem.id_blood_group" />
                                            <label class="form-check-label">Blood Group</label>
                                        </div>
                                        <div class="col-lg-12 col-12 form-check mr-5">
                                            <input type="checkbox" class="form-check-input checkAll"
                                                v-model="editItem.student_photo" />
                                            <label class="form-check-label">Student Photo</label>
                                        </div>
                                    </div>


                                    <div class="col-6 mt-3">
                                        <label for="background_image" class="background_image-label">Background
                                            Image</label>
                                        <div class="imageContainer">
                                            <img :src="selectedBackImage" alt />
                                            <input type="file" accept="image/*" @change="imageFileSelect2" />
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <label for="signature" class="background_image-label">Student Signature</label>
                                        <div class="imageContainer">
                                            <img :src="selectedSignImage" alt />
                                            <input type="file" accept="image/*" @change="imageFileSelect3" />
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <label for="signature" class="background_image-label">Logo</label>
                                        <div class="imageContainer">
                                            <img :src="selectedLogoImage" alt />
                                            <input type="file" accept="image/*" @change="imageFileSelect4" />
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end ml-4">
                                                <button type="submit"
                                                    class="btn btn-fill-sm rounded text-light shadow-dodger-blue bg-dodger-blue"
                                                    @click.prevent="submitData()">
                                                    {{ formBtn }}
                                                </button>
                                                <button type="button"
                                                    class="ml-1 btn btn-fill-sm rounded text-light shadow-dodger-blue btn-gradient-yellow"
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
            imageFilePath2: null,
            imageFilePath3: null,
            imageFilePath4: null,
            srcImageFile2: null,
            srcImageFile3: null,
            srcImageFile4: null,
            tableHead: {
                items: {
                    item1: { label: "Sr.No." },
                    item2: { label: "Id Card Title" },
                    item3: { label: "Background Image" },
                    item4: { label: "" },
                },
                actions: true,
            },
        };
    },
    computed: {
        formBtn: function () {
            return this.editedIndex != -1 ? "Update" : "Save";
        },
        resetButton: function () {
            return this.editedIndex === -1 ? "Reset" : "Cancel";
        },
        selectedBackImage: function () {
            return this.srcImageFile2 != null
                ? this.srcImageFile2
                : "/assets/img/nb.jpg";
        },
        selectedSignImage: function () {
            return this.srcImageFile3 != null
                ? this.srcImageFile3
                : "/assets/img/nb.jpg";
        },
        selectedLogoImage: function () {
            return this.srcImageFile4 != null
                ? this.srcImageFile4
                : "/assets/img/nb.jpg";
        }
    },

    methods: {
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
                title: "Please wait! Creating new Id Card"
            });
            var data = new FormData();
            data.append('school_name', this.editItem.id_school_name ? this.editItem.id_school_name : "");
            data.append('title', this.editItem.id_title ? this.editItem.id_title : "");
            data.append('header_color', this.editItem.id_header_color ? this.editItem.id_header_color : "");
            data.append('address_phone_email', this.editItem.address_phone_email ? this.editItem.address_phone_email : "");
            data.append('admission_number', this.editItem.id_admission_number ? 1 : 0);
            data.append('student_name', this.editItem.id_student_name ? 1 : 0);
            data.append('class', this.editItem.id_class ? 1 : 0);
            data.append('father_name', this.editItem.id_father_name ? 1 : 0);
            data.append('mother_name', this.editItem.id_mother_name ? 1 : 0);
            data.append('student_address', this.editItem.id_address ? 1 : 0);
            data.append('phone_number', this.editItem.id_phone_number ? 1 : 0);
            data.append('date_of_birth', this.editItem.id_date_of_birth ? 1 : 0);
            data.append('blood_group', this.editItem.id_blood_group ? 1 : 0);
            data.append('is_student_photo', this.editItem.student_photo ? 1 : 0);
            data.append('background_image', this.imageFilePath2 ? this.imageFilePath2 : "");
            data.append('signature', this.imageFilePath3 ? this.imageFilePath3 : "");
            data.append('logo', this.imageFilePath4 ? this.imageFilePath4 : "");
            let url = "";
            if (this.editedIndex != -1) {
                url = `/api/school/certificate/id_card/update/${this.editedIndex}`;
            } else {
                url = `/api/school/certificate/id_card/save`;
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
            this.editItem = {}
            this.editedIndex = -1,
                this.srcImageFile3 = null,
                this.srcImageFile2 = null,
                this.srcImageFile4 = null,
                this.imageFilePath2 = null,
                this.imageFilePath3 = null,
                this.imageFilePath4 = null
        },
        edit(item) {
            this.editItem = item;
            this.editedIndex = item.idCard_id;
            this.srcImageFile2 = item.idCard_background_image;
            this.imageFilePath2 = item.idCard_background_image;
            this.imageFilePath3 = item.idCard_signature;
            this.srcImageFile3 = item.idCard_signature;
            this.srcImageFile4 = item.idCard_logo;
            this.imageFilePath4 = item.idCard_logo;
        },
    },
};
</script>

<style scoped>
.form-group i {
    position: unset;

}

.font-20 {
    font-size: 20px !important;
    width: 200px !important;
}
</style>
