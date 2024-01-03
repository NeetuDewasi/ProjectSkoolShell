<template>
    <div class="dashboard-content-one">
        <Breadcrumb pageTitle="School " :breadcrumbList="breadcrumbList" />
        <div class="row gutters-20">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Add New School</h3>
                            </div>
                        </div>

                        <form class="new-added-form">
                            <div class="row">
                                <div
                                    class="col-xl-6 col-lg-6 col-12 form-group"
                                >
                                    <label>
                                        Group Name
                                        <strong class="text-danger">*</strong>
                                    </label>

                                    <Select2
                                        ref="group_list_select2"
                                        placeholder="--SELECT A GROUP--"
                                        :items="group_list"
                                        @change="selectGroup"
                                    />
                                </div>
                                <div
                                    class="col-xl-6 col-lg-6 col-12 form-group"
                                >
                                    <label>
                                        School Name
                                        <strong class="text-danger">*</strong>
                                    </label>
                                    <input
                                        type="text"
                                        v-model="editItem.school_name"
                                        placeholder = "Enter School Name"
                                        class="form-control"
                                        :class="
                                            errorItem.school_name != ''
                                                ? 'error-field'
                                                : ''
                                        "
                                        @keyup="
                                            editItem.school_name != ''
                                                ? (errorItem.school_name = '')
                                                : ''
                                        "
                                    />
                                    <span
                                        class="error-label"
                                        v-if="errorItem.school_name != ''"
                                        v-text="errorItem.school_name"
                                    ></span>
                                </div>

                                <div
                                    class="col-xl-6 col-lg-6 col-12 form-group"
                                >
                                    <label>
                                        Contact Person Name
                                        <strong class="text-danger">*</strong>
                                    </label>
                                    <input
                                        type="text"
                                        v-model="editItem.contact_person_name"
                                        placeholder
                                        class="form-control"
                                        :class="
                                            errorItem.contact_person_name != ''
                                                ? 'error-field'
                                                : ''
                                        "
                                        @keyup="
                                            editItem.contact_person_name != ''
                                                ? (errorItem.contact_person_name =
                                                      '')
                                                : ''
                                        "
                                    />
                                    <span
                                        class="error-label"
                                        v-if="
                                            errorItem.contact_person_name != ''
                                        "
                                        v-text="errorItem.contact_person_name"
                                    ></span>
                                </div>
                                <div
                                    class="col-xl-6 col-lg-6 col-12 form-group"
                                >
                                    <label>
                                        Mobile Number
                                        <strong class="text-danger">*</strong>
                                    </label>
                                    <input
                                        type="text"
                                        v-model="editItem.mobile_number"
                                        placeholder
                                        class="form-control"
                                    />
                                </div>
                                <div
                                    class="col-xl-6 col-lg-6 col-12 form-group"
                                >
                                    <label>
                                        Alternative Mobile Number

                                    </label>
                                    <input
                                        type="text"
                                        v-model="
                                            editItem.alternative_mobile_number
                                        "
                                        placeholder
                                        class="form-control"
                                    />
                                </div>
                                <div
                                    class="col-xl-6 col-lg-6 col-12 form-group"
                                >
                                    <label>
                                        Email
                                        <strong class="text-danger">*</strong>
                                    </label>
                                    <input
                                        type="text"
                                        v-model="editItem.email_id"
                                        placeholder
                                        class="form-control"
                                        :class="
                                            errorItem.email != ''
                                                ? 'error-field'
                                                : ''
                                        "
                                        @keyup="
                                            editItem.email != ''
                                                ? (errorItem.email = '')
                                                : ''
                                        "
                                    />
                                    <span
                                        class="error-label"
                                        v-if="errorItem.email != ''"
                                        v-text="errorItem.email"
                                    ></span>
                                </div>
                                <div
                                    class="col-xl-6 col-lg-6 col-12 form-group"
                                >
                                    <label>
                                        Alternative Email
                                    </label>
                                    <input
                                        type="text"
                                        v-model="editItem.alternative_email_id"
                                        placeholder
                                        class="form-control"
                                    />
                                </div>
                                <div class="col-xl-6 col-lg-6 col-12 form-group">
                                                <label>
                                                    Password
                                                    <strong class="text-danger">*</strong>
                                                </label>
                                                <input
                                                    type="text"
                                                    placeholder
                                                    class="form-control"
                                                    v-model="editItem.password"
                                                    :class="errorItem.password != ''
                                                        ? 'error-field'
                                                        : ''
                                                        "
                                                    @keydown="editItem.password != ''
                                                        ? (errorItem.password = '')
                                                        : ''
                                                        "
                                                />
                                                <span
                                                    class="error-label"
                                                    v-if="errorItem.password != ''"
                                                    v-text="errorItem.password"
                                                ></span>
                                            </div>
                            </div>
                            <h2>Address</h2>
                            <div class="row" v-if="editItem.current">
                                <div class="col-lg-6 col-12 form-group" >
                                    <label>
                                        Address Line-1
                                        <strong class="text-danger">*</strong>
                                    </label>
                                    <textarea
                                        class="textarea form-control"
                                        name="address"
                                        id="address"
                                        cols="14"
                                        rows="3"
                                        v-model="editItem.current.address_line1"
                                        @keydown="
                                            editItem.current.address_line1 != ''
                                                ? (errorItem.current.address_line1 = '')
                                                : ''
                                        "
                                        :class="
                                            errorItem.current.address_line1 != ''
                                                ? 'error-field'
                                                : ''
                                        "
                                    ></textarea>
                                    <span
                                        class="error-label"
                                        v-if="errorItem.current.address_line1 != ''"
                                        v-text="errorItem.current.address_line1"
                                    ></span>
                                </div>
                                <div class="col-lg-6 col-12 form-group">
                                    <label>Address Line-2</label>
                                    <textarea
                                        class="textarea form-control"
                                        name="address"
                                        id="address"
                                        cols="14"
                                        rows="3"
                                        v-model="editItem.current.address_line2"
                                    ></textarea>
                                </div>
                                <div class="col-lg-4 col-12 form-group">
                                    <label>
                                        Location
                                    </label>
                                    <input
                                        type="text"
                                        placeholder
                                        class="form-control"
                                        v-model="editItem.current.location"
                                    />

                                </div>
                                <div class="col-lg-4 col-12 form-group">
                                    <label>
                                        Landmark
                                    </label>
                                    <input
                                        type="text"
                                        placeholder
                                        class="form-control"
                                        v-model="editItem.current.landmark"

                                    />

                                </div>
                                <div class="col-lg-4 col-12 form-group">
                                    <label>
                                        City
                                        <strong class="text-danger">*</strong>
                                    </label>
                                    <input
                                        type="text"
                                        placeholder
                                        class="form-control"
                                        v-model="editItem.current.city"
                                        :class="
                                            errorItem.current.city != ''
                                                ? 'error-field'
                                                : ''
                                        "
                                        @keydown="
                                            editItem.current.city != ''
                                                ? (errorItem.current.city = '')
                                                : ''
                                        "
                                    />
                                    <span
                                        class="error-label"
                                        v-if="errorItem.current.city != ''"
                                        v-text="errorItem.current.city"
                                    ></span>
                                </div>
                                <div class="col-lg-4 col-12 form-group">
                                    <label>
                                        Pin Code
                                        <strong class="text-danger">*</strong>
                                    </label>
                                    <input
                                        type="text"
                                        placeholder
                                        class="form-control"
                                        v-model="editItem.current.pincode"
                                        :class="
                                            errorItem.current.pincode != ''
                                                ? 'error-field'
                                                : ''
                                        "
                                        @keydown="
                                            editItem.current.pincode != ''
                                                ? (errorItem.current.pincode = '')
                                                : ''
                                        "
                                    />
                                    <span
                                        class="error-label"
                                        v-if="errorItem.current.pincode != ''"
                                        v-text="errorItem.current.pincode"
                                    ></span>
                                </div>
                                <div class="col-lg-4 col-12 form-group">
                                    <label>
                                        State
                                        <strong class="text-danger">*</strong>
                                    </label>
                                    <input
                                        type="text"
                                        placeholder
                                        class="form-control"
                                        v-model="editItem.current.state"
                                        :class="
                                            errorItem.current.state != ''
                                                ? 'error-field'
                                                : ''
                                        "
                                        @keydown="
                                            editItem.current.state != ''
                                                ? (errorItem.current.state = '')
                                                : ''
                                        "
                                    />
                                    <span
                                        class="error-label"
                                        v-if="errorItem.current.state != ''"
                                        v-text="errorItem.current.state"
                                    ></span>
                                </div>
                                <div class="col-lg-4 col-12 form-group">
                                    <label>
                                        Country
                                        <strong class="text-danger">*</strong>
                                    </label>
                                    <input
                                        type="text"
                                        placeholder
                                        class="form-control"
                                        v-model="editItem.current.country"
                                        :class="
                                            errorItem.current.country != ''
                                                ? 'error-field'
                                                : ''
                                        "
                                        @keydown="
                                            editItem.current.country != ''
                                                ? (errorItem.current.country = '')
                                                : ''
                                        "
                                    />
                                    <span
                                        class="error-label"
                                        v-if="errorItem.current.country != ''"
                                        v-text="errorItem.current.country"
                                    ></span>
                                </div>
                            </div>


                             <div class="row">
                                <div class="item-title">
                                                <h5>Permanent Address :</h5>
                                            </div>
                                            <div class="form-check">
                                                <input
                                                    type="checkbox"
                                                    class="form-check-input checkAll"
                                                    id="permanent_address"
                                                    v-model="editItem.is_permanent"
                                                    @change="setPermanentAddress()"
                                                />
                                                <label class="form-check-label">
                                                    If Permanent Address is Current
                                                    Address
                                                </label>
                                            </div>
                             </div>
                                <div class="row" v-if="editItem.permanent">
                                    <div class="col-lg-6 col-12 form-group">
                                        <label>
                                            Address Line-1
                                            <strong class="text-danger">*</strong>
                                        </label>
                                        <textarea
                                            class="textarea form-control"
                                            name="address"
                                            id="address"
                                            cols="14"
                                            rows="3"
                                            v-model="editItem.permanent.address_line1"
                                            @keyup="editItem.permanent.address_line1 != ''
                                                    ? (errorItem.permanent.address_line1 = '')
                                                    : ''
                                                "
                                            :class="errorItem.permanent.address_line1 != ''
                                                    ? 'error-field'
                                                    : ''
                                                "
                                        ></textarea>
                                        <span
                                            class="error-label"
                                            v-if="errorItem.permanent.address_line1 != ''"
                                            v-text="errorItem.permanent.address_line1"
                                        ></span>
                                    </div>
                                    <div class="col-lg-6 col-12 form-group">
                                        <label>Address Line-2</label>
                                        <textarea
                                            class="textarea form-control"
                                            name="address"
                                            id="address"
                                            cols="14"
                                            rows="3"
                                            v-model="editItem.permanent.address_line2"
                                        ></textarea>
                                    </div>
                                    <div class="col-lg-4 col-12 form-group">
                                        <label>
                                            Location
                                        </label>
                                        <input
                                            type="text"
                                            placeholder
                                            class="form-control"
                                            v-model="editItem.permanent.location">
                                    </div>
                                    <div class="col-lg-4 col-12 form-group">
                                        <label>
                                            Landmark
                                        </label>
                                        <input
                                            type="text"
                                            placeholder
                                            class="form-control"
                                            v-model="editItem.permanent.landmark">

                                    </div>
                                    <div class="col-lg-4 col-12 form-group">
                                        <label>
                                            City
                                            <strong class="text-danger">*</strong>
                                        </label>
                                        <input
                                            type="text"
                                            placeholder
                                            class="form-control"
                                            v-model="editItem.permanent.city"
                                            :class="errorItem.permanent.city != ''
                                                    ? 'error-field'
                                                    : ''
                                                "
                                            @keydown="editItem.permanent.city != ''
                                                    ? (errorItem.permanent.city = '')
                                                    : ''
                                                "
                                        />
                                        <span
                                            class="error-label"
                                            v-if="errorItem.permanent.city != ''"
                                            v-text="errorItem.permanent.city"
                                        ></span>
                                    </div>
                                    <div class="col-lg-4 col-12 form-group">
                                        <label>
                                            Pin Code
                                            <strong class="text-danger">*</strong>
                                        </label>
                                        <input
                                            type="text"
                                            placeholder
                                            class="form-control"
                                            v-model="editItem.permanent.pincode"
                                            :class="errorItem.permanent.pincode != ''
                                                    ? 'error-field'
                                                    : ''
                                                "
                                            @keydown="editItem.permanent.pincode != ''
                                                    ? (errorItem.permanent.pincode = '')
                                                    : ''
                                                "
                                        />
                                        <span
                                            class="error-label"
                                            v-if="errorItem.permanent.pincode != ''"
                                            v-text="errorItem.permanent.pincode"
                                        ></span>
                                    </div>
                                    <div class="col-lg-4 col-12 form-group">
                                        <label>
                                            State
                                            <strong class="text-danger">*</strong>
                                        </label>
                                        <input
                                            type="text"
                                            placeholder
                                            class="form-control"
                                            v-model="editItem.permanent.state"
                                            :class="errorItem.permanent.state != ''
                                                    ? 'error-field'
                                                    : ''
                                                "
                                            @keydown="editItem.permanent.state != ''
                                                    ? (errorItem.permanent.state = '')
                                                    : ''
                                                "
                                        />
                                        <span
                                            class="error-label"
                                            v-if="errorItem.permanent.state != ''"
                                            v-text="errorItem.permanent.state"
                                        ></span>
                                    </div>
                                    <div class="col-lg-4 col-12 form-group">
                                        <label>
                                            Country
                                            <strong class="text-danger">*</strong>
                                        </label>
                                        <input
                                            type="text"
                                            placeholder
                                            class="form-control"
                                            v-model="editItem.permanent.country"
                                            :class="errorItem.permanent.country != ''
                                                    ? 'error-field'
                                                    : ''
                                                "
                                            @keydown="editItem.permanent.country != ''
                                                    ? (errorItem.permanent.country = '')
                                                    : ''
                                                "
                                        />
                                        <span
                                            class="error-label"
                                            v-if="errorItem.permanent.country != ''"
                                            v-text="errorItem.permanent.country"
                                        ></span>
                                    </div>
                                </div>

                            <div class="row ml-3">
                                <div class="col-12 form-group mb-5">
                                    <button
                                        type="button"
                                        class="btn-fill-md text-light shadow-dodger-blue bg-dodger-blue"
                                        @click.prevent="submitData()"
                                    >
                                        {{ formBtn }}
                                    </button>

                                    <button
                                        type="button"
                                        class="btn-fill-md text-light shadow-dodger-blue btn-gradient-yellow"
                                        @click.prevent="resetForm()"
                                    >
                                        {{ resetButton }}
                                    </button>
                                </div>
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
import AssetFileInput from "./AssetFileInput.vue";
import AssetDocumentDisplay from "./AssetDocumentDisplay.vue";

export default {
    components: {
        AssetFileInput,
        AssetDocumentDisplay,
    },
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "admin.dashboard" },
                    name: "Home",
                },
                {
                    name: "School",
                },
            ],
            school:{},
            editItem: {
                current: {
                    address_line1: "",
                    address_line2: "",
                    landmark: "",
                    location: "",
                    city: "",
                    pincode: "",
                    state: "",
                    country: "",
                },
                permanent: {
                    address_line1: "",
                    address_line2: "",
                    landmark: "",
                    location: "",
                    city: "",
                    pincode: "",
                    state: "",
                    country: "",
                },
                is_permanent:1
                },
            editedIndex: -1,
            errorItem: {
                school_name: "",
                contact_person_name: "",
                mobile: "",
                email: "",
                password: "",
                title1: "",
                imageFilePath1: "",
                 permanent: {
                    address_line1: "",
                    city: "",
                    pincode: "",
                    state: "",
                    country: "",
                },
                current: {
                    address_line1: "",
                    city: "",
                    pincode: "",
                    state: "",
                    country: "",
                },
            },
            group_list: [],
            group_id: -1,
            group_list_select2: [],
            isFormValid: false,
            documentItems: [
                { titles: [], files: [] },
                { titles: [], files: [] },
            ],
            srcImageFileList: [],
            imageFilePathList: [],
            imageFileNameList: [],
            extensions: [],
            files: [],
            assetDocumentDisplay: [],
            srcImageFile: null,
            imageFilePath: null,
            school_id: -1,
            storeDocs: {
                srcImageFileList: [],
                extensions: [],
                imageFilePathList: [],
                imageFileNameList: [],
            },
              images: [],
              edit_id: -1,
        };
    },
    computed: {
        formBtn: function () {
            return this.editedIndex === -1 ? "Save" : "Update";
        },
        resetButton: function () {
            return this.editedIndex === -1 ? "Reset" : "Cancel";
        },
        selectedImage: function () {
            return this.srcImageFile != null
                ? this.srcImageFile
                : "/assets/img/nb.jpg";
        },
    },
    mounted() {
         if (this.$route.params.edit_id) {
            this.edit_id = this.$route.params.edit_id;
            console.log('edit id', this.edit_id);
            this.getDataEdit();
        }
        this.getGroupList();
    },
    methods: {
          uploadImages(event) {
            const files = event.target.files;
            for (let i = 0; i < files.length; i++) {
                const reader = new FileReader();

                reader.onload = (e) => {
                    this.images.push(e.target.result);
                };

                reader.readAsDataURL(files[i]);
            }
        },

        handleFileChange(event, documentIndex, fileIndex) {
            const file = event.target.files[0];
            this.documentItems[documentIndex].files[fileIndex] = file;
        },
        uploadImages(docs, label) {
            let newDocs = {
                srcImageFileList: this.srcImageFileList,
                extensions: this.extensions,
                files: this.files,
                imageFileNameList: this.imageFileNameList,
                imageFilePathList: this.imageFilePathList,
            };
            console.log("new OLD12 >>", newDocs);
            this.srcImageFileList = docs.srcImageFileList;
            this.extensions = docs.extensions;
            this.files = docs.files;
            const labelToCheck = label;
            const newObject = this.imageFilePathList.findIndex(item => item.label === labelToCheck);
            if (newObject > -1) {
                var oldDocArr = [];
                this.imageFilePathList[newObject].files.forEach((ele, index) => {
                    if (typeof ele === 'string' && ele.includes('/storage/documents/assets')) {
                        oldDocArr.push(ele);
                    }
                });
                if (docs.imageFilePathList.length > 0) {
                    docs.imageFilePathList.forEach((ele, index) => {
                        if (typeof ele != 'string') {
                            oldDocArr.push(ele);
                        }
                    });
                }
                this.imageFilePathList[newObject].files = oldDocArr;
                let newArr = [];
                newDocs.imageFilePathList[newObject].files.forEach((e) => {
                    newArr.push(e);
                });
                newDocs.imageFilePathList = newArr;
            }
            else {
                this.imageFilePathList.push({
                    label: label,
                    files: docs.imageFilePathList,
                });

                let newArr = [];
                const newObject = this.imageFilePathList.findIndex(item => item.label === labelToCheck);
                console.log('first 333', newObject);
                newDocs.imageFilePathList[newObject].files.forEach((e) => {
                    newArr.push(e);
                });
                newDocs.imageFilePathList = newArr;
            }
            this.imageFileNameList = docs.imageFileNameList;
            newDocs.srcImageFileList.push(...docs.srcImageFileList);
            newDocs.extensions.push(...docs.extensions);
            newDocs.files.push(...docs.files);
            newDocs.imageFileNameList.push(...docs.imageFileNameList);
            console.log('refs',this.$refs.assetDocumentDisplay);
            // this.$refs.assetDocumentDisplay.forEach((e) => {
            //     if (label == e.getLabel()) {
            //         e.showDocuments(newDocs);
            //     }
            // });
        },
        async getGroupList() {
            this.isLoaded = false;
            const res = await this.callApi(
                "get",
                `/api/admin/schools/group_list`,
                null
            );
            this.log("showData function", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.group_list = data.groups;
                    this.$refs.group_list_select2.updateList(data.groups);
                }
            }
        },
        selectGroup(group_id) {
            console.log('group',group_id);
            this.group_id = group_id;
            this.log("iiidddd selected", this.group_id);
        },
        setPermanentAddress() {
            if (this.editItem.is_permanent) {
                this.editItem.permanent = this.editItem.current;
            } else {
                this.editItem.permanent = {};
            }
        },
        async submitData() {
            // var isVaild = await this.validSchoolForm();
            // if (!isVaild) {
            //     return;
            // }
            toast = Toast.fire({
                icon: "warning",
                title: "Please Wait!! Creating new Group",
                timer: 0,
            });
            // const title = this.documentItems[documentIndex].titles[titleIndex];
            // const file = this.documentItems[documentIndex].files[fileIndex];

            var data = new FormData();
            console.log('group id', this.group_id);
            data.append("group_id", this.group_id ? this.group_id : "");
            data.append(
                "school_name",
                this.editItem.school_name ? this.editItem.school_name : ""
            );
            data.append(
                "contact_person",
                this.editItem.contact_person_name
                    ? this.editItem.contact_person_name
                    : ""
            );
            data.append(
                "mobile_number",
                this.editItem.mobile_number ? this.editItem.mobile_number : ""
            );
            data.append(
                "alternative_mobile_number",
                this.editItem.alternative_mobile_number
                    ? this.editItem.alternative_mobile_number
                    : ""
            );
            data.append(
                "email_id",
                this.editItem.email_id ? this.editItem.email_id : ""
            );
            data.append(
                "alternative_email_id",
                this.editItem.alternative_email_id
                    ? this.editItem.alternative_email_id
                    : ""
            );
            data.append(
                "password",
                this.editItem.password ? this.editItem.password : ""
            );

            data.append(
                "current_address_line1",
                this.editItem.current.address_line1 ? this.editItem.current.address_line1 : ""
            );
            data.append(
                "current_address_line2",
                this.editItem.current.address_line2 ? this.editItem.current.address_line2 : ""
            );
            data.append(
                "current_location",
                this.editItem.current.location ? this.editItem.current.location : ""
            );
            data.append(
                "current_landmark",
                this.editItem.current.landmark ? this.editItem.current.landmark : ""
            );

            data.append("current_city", this.editItem.current.city ? this.editItem.current.city : "");
            data.append(
                "current_pincode",
                this.editItem.current.pincode ? this.editItem.current.pincode : ""
            );
            data.append(
                "current_state",
                this.editItem.current.state ? this.editItem.current.state : ""
            );
            data.append(
                "current_country",
                this.editItem.current.country ? this.editItem.current.country : ""
            );
            data.append(
                "permanent_address_line1",
                this.editItem.permanent.address_line1 ? this.editItem.permanent.address_line1 : ""
            );
            data.append(
                "permanent_address_line2",
                this.editItem.permanent.address_line2 ? this.editItem.permanent.address_line2 : ""
            );
            data.append(
                "permanent_location",
                this.editItem.permanent.location ? this.editItem.permanent.location : ""
            );
            data.append(
                "permanent_landmark",
                this.editItem.permanent.landmark ? this.editItem.permanent.landmark : ""
            );
             data.append("permanent_city", this.editItem.permanent.city ? this.editItem.permanent.city : "");
            data.append(
                "permanent_pincode",
                this.editItem.permanent.pincode ? this.editItem.permanent.pincode : ""
            );
            data.append(
                "permanent_state",
                this.editItem.permanent.state ? this.editItem.permanent.state : ""
            );
            data.append(
                "permanent_country",
                this.editItem.permanent.country ? this.editItem.permanent.country : ""
            );
            data.append(
                "is_permanent",
                this.editItem.is_permanent ? this.editItem.is_permanent : 0
            );
            for (let i = 0; i < this.images.length; i++) {
                // Convert data URL back to a Blob
                fetch(this.images[i])
                    .then((response) => response.blob())
                    .then((blob) => {
                        data.append("images[]", blob, `image_${i}.png`);
                    });
            }
            console.log('images',this.images);
            let url = "";
            if (this.editedIndex == -1) {
                url = `/api/admin/schools/save`;
            } else {
                url = `/api/admin/schools/update/${this.editedIndex}`;
            }
            const res = await this.callApi("post", url, data);
            this.log("added dataa", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                    this.resetForm();
                    setTimeout(() => {
                        this.$router.push({
                            path: `/admin/school/list`,
                        });
                    }, 3000);
                }
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
        },
        validSchoolForm() {
            this.isFormValid = true;

            if (
                this.editItem.school_name == null ||
                this.editItem.school_name == ""
            ) {
                this.errorItem.school_name = " School Name is required";
                this.isFormValid = false;
            } else {
                this.errorItem.school_name = "";
            }
            if (
                this.editItem.contact_person_name == null ||
                this.editItem.contact_person_name == ""
            ) {
                this.errorItem.contact_person_name =
                    "Contact Person Name is required";
                this.isFormValid = false;
            } else {
                this.errorItem.contact_person_name = "";
            }
            if (
                this.editItem.mobile_number == null ||
                this.editItem.mobile_number == ""
            ) {
                this.errorItem.mobile_number = "mobile_number is required";
                this.isFormValid = false;
            } else {
                this.errorItem.mobile_number = "";
            }
            if (
                this.editItem.email_id == null ||
                this.editItem.email_id == ""
            ) {
                this.errorItem.email_id = "email_id is required";
                this.isFormValid = false;
            } else {
                this.errorItem.email_id = "";
            }
            if (
                this.editItem.current.address_line1 == null ||
                this.editItem.current.address_line1 == ""
            ) {
                this.errorItem.current.address_line1 = "address_line1 is required";
                this.isFormValid = false;
            } else {
                this.errorItem.current.address_line1 = "";
            }
            if (this.editItem.current.city == null || this.editItem.current.city == "") {
                this.errorItem.current.city = "city is required";
                this.isFormValid = false;
            } else {
                this.errorItem.current.city = "";
            }
            if (this.editItem.current.pincode == null || this.editItem.current.pincode == "") {
                this.errorItem.current.pincode = "pincode is required";
                this.isFormValid = false;
            } else {
                this.errorItem.current.pincode = "";
            }
            if (this.editItem.current.state == null || this.editItem.current.state == "") {
                this.errorItem.current.state = "state is required";
                this.isFormValid = false;
            } else {
                this.errorItem.current.state = "";
            }
            if (this.editItem.current.country == null || this.editItem.current.country == "") {
                this.errorItem.current.country = "country is required";
                this.isFormValid = false;
            } else {
                this.errorItem.current.country = "";
            }
             if (this.editItem.password == null || this.editItem.password == "") {
                this.errorItem.password = "password is required";
                this.isFormValid = false;
            } else {
                this.errorItem.password = "";
            }

            return this.isFormValid;
        },
        async getDataEdit() {
            console.log('data edit', this.user_id);
         const res = await this.callApi('get',`/api/admin/schools/edit/${this.edit_id}`,null);
            this.log('editd ddaaataaa',res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == 'success') {
                    this.school = data.school;
                    this.editItem = {
                        school_name: data.school.school_name,
                        contact_person_name: data.school.contact_person_name,
                        email_id: data.school.email_id,
                        mobile_number: data.school.mobile_number,
                        alternative_mobile_number: data.school.alternative_mobile_number,
                        alternative_email_id: data.school.alternative_email_id,
                        current: {
                            address_line1: data.school.current.current_address_line1,
                            address_line2: data.school.current.current_address_line2,
                            city: data.school.current.current_city,
                            landmark: data.school.current.current_landmark,
                            location: data.school.current.current_location,
                            country: data.school.current.current_country,
                            state: data.school.current.current_state,
                            pincode: data.school.current.current_pincode,
                        },
                        permanent: {
                            address_line1: data.school.permanent.permanent_address_line1,
                            address_line2: data.school.permanent.permanent_address_line2,
                            city: data.school.permanent.permanent_city,
                            landmark: data.school.permanent.permanent_landmark,
                            location: data.school.permanent.permanent_location,
                            country: data.school.permanent.permanent_country,
                            state: data.school.permanent.permanent_state,
                            pincode: data.school.permanent.permanent_pincode,
                        },
                        is_permanent: data.school.is_permanent,
                        password: data.school.password
                    };
                     this.$refs.group_list_select2.setSelected(
                        data.school.group_id);
                         this.group_id = data.school.group_id;
                    this.selectGroup(
                        data.school.group_id
                    );
                    this.editedIndex = data.school.school_id
                }
            }
        },
        resetForm() {
            this.editItem = {};
            this.editedIndex = -1;
            this.group_list = [];
            this.group_id = -1;
        },
    },
};
</script>
