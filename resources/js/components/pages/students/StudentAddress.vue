<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb
                pageTitle="Student Address"
                :breadcrumbList="breadcrumbList"
            />
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Add Address</h3>
                                </div>
                            </div>

                            <form
                                class="new-added-form"
                                enctype="multipart/form-data"
                            >
                                <div class="item-title">
                                    <h5>Current Address :</h5>
                                </div>
                                <div class="row address-block">
                                    <div class="col-12 mt-4 form-group">
                                        <div class="form-check">
                                            <input
                                                type="checkbox"
                                                class="form-check-input checkAll"
                                                id="select_check"
                                                value="true"
                                                v-model="editItem.is_current"
                                                @change="setCurrentAddress()"
                                            />
                                            <label class="form-check-label">
                                                If Guardian Address is Current
                                                Address
                                            </label>
                                        </div>
                                        <div class="row">
                                            <div
                                                class="col-lg-6 col-12 form-group"
                                            >
                                                <label>
                                                    Address Line-1
                                                    <strong class="text-danger"
                                                        >*</strong
                                                    >
                                                </label>
                                                <textarea
                                                    class="textarea form-control"
                                                    name="address"
                                                    id="address"
                                                    cols="14"
                                                    rows="3"
                                                    v-model="
                                                        editItem.current
                                                            .address_line1
                                                    "
                                                    :class="
                                                        errorItem.current.address_line1 !=
                                                        ''
                                                            ? 'error-field'
                                                            : ''
                                                    "
                                                    @keypress="
                                                        errorItem.current.address_line1 =
                                                            ''
                                                    "
                                                ></textarea>
                                                <span
                                                    class="error-label"
                                                    v-if="
                                                        errorItem.current.address_line1 !=
                                                        ''
                                                    "
                                                    v-text="
                                                        errorItem.current.address_line1
                                                    "
                                                ></span>
                                            </div>

                                            <div
                                                class="col-lg-6 col-12 form-group"
                                            >
                                                <label>Address Line-2</label>
                                                <textarea
                                                    class="textarea form-control"
                                                    name="address"
                                                    id="address"
                                                    cols="14"
                                                    rows="3"
                                                    v-model="
                                                        editItem.current
                                                            .address_line2
                                                    "
                                                ></textarea>
                                            </div>
                                            <div class="col form-group">
                                                <label>
                                                    Location

                                                </label>
                                                <input
                                                    type="text"
                                                    placeholder
                                                    class="form-control"
                                                    v-model="
                                                        editItem.current
                                                            .location
                                                    "
                                                />
                                            </div>
                                            <div
                                                class="col-lg-2 col-12 form-group"
                                            >
                                                <label>Landmark</label>
                                                <input
                                                    type="text"
                                                    placeholder
                                                    class="form-control"
                                                    v-model="
                                                        editItem.current
                                                            .landmark
                                                    "
                                                />
                                            </div>
                                            <div class="col form-group">
                                                <label>
                                                    City
                                                    <strong class="text-danger"
                                                        >*</strong
                                                    >
                                                </label>
                                                <input
                                                    type="text"
                                                    placeholder
                                                    class="form-control"
                                                    v-model="
                                                        editItem.current.city
                                                    "
                                                    :class="
                                                        errorItem.current.city !=
                                                        ''
                                                            ? 'error-field'
                                                            : ''
                                                    "
                                                    @keypress="
                                                        errorItem.current.city =
                                                            ''
                                                    "
                                                />
                                                <span
                                                    class="error-label"
                                                    v-if="
                                                        errorItem.current.city !=
                                                        ''
                                                    "
                                                    v-text="
                                                        errorItem.current.city
                                                    "
                                                ></span>
                                            </div>
                                            <div class="col form-group">
                                                <label>
                                                    Pin Code
                                                    <strong class="text-danger"
                                                        >*</strong
                                                    >
                                                </label>
                                                <input
                                                    type="text"
                                                    placeholder
                                                    class="form-control"
                                                    v-model="
                                                        editItem.current.pincode
                                                    "
                                                    :class="
                                                        errorItem.current.pincode !=
                                                        ''
                                                            ? 'error-field'
                                                            : ''
                                                    "
                                                    @keypress="
                                                        errorItem.current.pincode =
                                                            ''
                                                    "
                                                />
                                                <span
                                                    class="error-label"
                                                    v-if="
                                                        errorItem.current.pincode
                                                    "
                                                    v-text="
                                                        errorItem.current.pincode
                                                    "
                                                ></span>
                                            </div>
                                            <div class="col form-group">
                                                <label>
                                                    State
                                                    <strong class="text-danger"
                                                        >*</strong
                                                    >
                                                </label>
                                                <input
                                                    type="text"
                                                    placeholder
                                                    class="form-control"
                                                    v-model="
                                                        editItem.current.state
                                                    "
                                                    :class="
                                                        errorItem.current.state !=
                                                        ''
                                                            ? 'error-field'
                                                            : ''
                                                    "
                                                    @keypress="
                                                        errorItem.current.state =
                                                            ''
                                                    "
                                                />
                                                <span
                                                    class="error-label"
                                                    v-if="
                                                        errorItem.current.state
                                                    "
                                                    v-text="
                                                        errorItem.current.state
                                                    "
                                                ></span>
                                            </div>
                                            <div class="col form-group">
                                                <label>
                                                    Country
                                                    <strong class="text-danger"
                                                        >*</strong
                                                    >
                                                </label>
                                                <input
                                                    type="text"
                                                    placeholder
                                                    class="form-control"
                                                    v-model="
                                                        editItem.current.country
                                                    "
                                                    :class="
                                                        errorItem.current.country !=
                                                        ''
                                                            ? 'error-field'
                                                            : ''
                                                    "
                                                    @keypress="
                                                        errorItem.current.country =
                                                            ''
                                                    "
                                                />
                                                <span
                                                    class="error-label"
                                                    v-if="
                                                        errorItem.current.country
                                                    "
                                                    v-text="
                                                        errorItem.current.country
                                                    "
                                                ></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-4 form-group">
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
                                        <div class="row">
                                            <div
                                                class="col-lg-6 col-12 form-group"
                                            >
                                                <label>
                                                    Address Line-1
                                                    <strong class="text-danger"
                                                        >*</strong
                                                    >
                                                </label>
                                                <textarea
                                                    class="textarea form-control"
                                                    name="address"
                                                    id="address"
                                                    cols="14"
                                                    rows="3"
                                                    v-model="
                                                        editItem.permanent
                                                            .address_line1
                                                    "
                                                    :class="
                                                        errorItem.permanent
                                                            .address_line1 !=
                                                        ''
                                                            ? 'error-field'
                                                            : ''
                                                    "
                                                    @keypress="
                                                        errorItem.permanent.address_line1 =
                                                            ''
                                                    "
                                                ></textarea>
                                                <span
                                                    class="error-label"
                                                    v-if="
                                                        errorItem.permanent
                                                            .address_line1 !=
                                                        ''
                                                    "
                                                    v-text="
                                                        errorItem.permanent
                                                            .address_line1
                                                    "
                                                ></span>
                                            </div>

                                            <div
                                                class="col-lg-6 col-12 form-group"
                                            >
                                                <label>Address Line-2</label>
                                                <textarea
                                                    class="textarea form-control"
                                                    name="address"
                                                    id="address"
                                                    cols="14"
                                                    rows="3"
                                                    v-model="
                                                        editItem.permanent
                                                            .address_line2
                                                    "
                                                ></textarea>
                                            </div>
                                            <div
                                                class="col-lg-2 col-12 form-group"
                                            >
                                                <label>
                                                    Location
                                                </label>
                                                <input
                                                    type="text"
                                                    placeholder
                                                    class="form-control"
                                                    v-model="
                                                        editItem.permanent
                                                            .location
                                                    "
                                                />
                                            </div>
                                            <div
                                                class="col-lg-2 col-12 form-group"
                                            >
                                                <label>Landmark</label>
                                                <input
                                                    type="text"
                                                    placeholder
                                                    class="form-control"
                                                    v-model="
                                                        editItem.permanent
                                                            .landmark
                                                    "
                                                />
                                            </div>
                                            <div
                                                class="col-lg-2 col-12 form-group"
                                            >
                                                <label>City*</label>
                                                <input
                                                    type="text"
                                                    placeholder
                                                    class="form-control"
                                                    v-model="
                                                        editItem.permanent.city
                                                    "
                                                    :class="
                                                        errorItem.permanent
                                                            .city == ''
                                                            ? ''
                                                            : 'error-field'
                                                    "
                                                    @keypress="
                                                        errorItem.permanent.city =
                                                            ''
                                                    "
                                                />
                                                <span
                                                    class="error-label"
                                                    v-if="
                                                        errorItem.permanent
                                                            .city != ''
                                                    "
                                                    v-text="
                                                        errorItem.permanent.city
                                                    "
                                                ></span>
                                            </div>
                                            <div
                                                class="col-lg-2 col-12 form-group"
                                            >
                                                <label>Pin Code*</label>
                                                <input
                                                    type="text"
                                                    placeholder
                                                    class="form-control"
                                                    v-model="
                                                        editItem.permanent
                                                            .pincode
                                                    "
                                                    :class="
                                                        errorItem.permanent
                                                            .pincode == ''
                                                            ? ''
                                                            : 'error-field'
                                                    "
                                                    @keypress="
                                                        errorItem.permanent.pincode =
                                                            ''
                                                    "
                                                />
                                                <span
                                                    class="error-label"
                                                    v-if="
                                                        errorItem.permanent
                                                            .pincode != ''
                                                    "
                                                    v-text="
                                                        errorItem.permanent
                                                            .pincode
                                                    "
                                                ></span>
                                            </div>
                                            <div
                                                class="col-lg-2 col-12 form-group"
                                            >
                                                <label>State*</label>
                                                <input
                                                    type="text"
                                                    placeholder
                                                    class="form-control"
                                                    v-model="
                                                        editItem.permanent.state
                                                    "
                                                    :class="
                                                        errorItem.permanent
                                                            .state == ''
                                                            ? ''
                                                            : 'error-field'
                                                    "
                                                    @keypress="
                                                        errorItem.permanent.state =
                                                            ''
                                                    "
                                                />
                                                <span
                                                    class="error-label"
                                                    v-if="
                                                        errorItem.permanent
                                                            .state != ''
                                                    "
                                                    v-text="
                                                        errorItem.permanent
                                                            .state
                                                    "
                                                ></span>
                                            </div>
                                            <div
                                                class="col-lg-2 col-12 form-group"
                                            >
                                                <label>Country*</label>
                                                <input
                                                    type="text"
                                                    placeholder
                                                    class="form-control"
                                                    v-model="
                                                        editItem.permanent
                                                            .country
                                                    "
                                                    :class="
                                                        errorItem.permanent
                                                            .country == ''
                                                            ? ''
                                                            : 'error-field'
                                                    "
                                                    @keypress="
                                                        errorItem.permanent.country =
                                                            ''
                                                    "
                                                />
                                                <span
                                                    class="error-label"
                                                    v-if="
                                                        errorItem.permanent
                                                            .country != ''
                                                    "
                                                    v-text="
                                                        errorItem.permanent
                                                            .country
                                                    "
                                                ></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-5">
                                    <button
                                        type="submit"
                                        class="btn btn-lg btn-gradient-yellow btn-hover-bluedark mx-3 text-white"
                                        @click="$router.push('guardian_detail')"
                                    >
                                        Back
                                    </button>
                                    <button
                                        type="submit"
                                         :class="formBtnClass"
                                        class="btn-fill-lg text-light shadow-dodger-blue bg-dodger-blue"
                                        @click.prevent="submitData()"
                                    >
                                       {{ formBtn }}
                                    </button>
                                </div>
                            </form>
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
                    name: "Student",
                },
                {
                    to: { name: "admin.students.admissions" },
                    name: "Admission",
                },
                {
                    name: "Student Address",
                },
            ],
            editItem: {
                permanent: {},
                current: {},
            },
            isLoaded: false,
            noData: false,
            permanenteditItem: {
                permanent: {},
                current: {},
            },
            guardian: {},
            isCurrentAddress: false,
            isPermanentAddress: false,
            editedIndex: -1,
            student_admission_id: -1,
            errorItem: {
                current: {
                    address_line1: "",
                    city: "",
                    pincode: "",
                    state: "",
                    country: "",
                },
                permanent: {
                    address_line1: "",
                    city: "",
                    pincode: "",
                    state: "",
                    country: "",
                },
            },
            isFormValid: false,
        };
    },
    mounted() {
        this.$parent.loadOtherScript();
        this.student_admission_id = this.$route.params.student_admission_id;
        if (this.$route.params.student_admission_id) {
            this.editedIndex = this.$route.params.student_admission_id;
            this.getEditItemData();
        }

        // console.log("IIDDD", this.editedIndex);
        this.getGuardianData();
    },
    computed: {
        formBtn: function () {
            return this.editedIndex != -1 ? "Update & Next" : "Save & Next";
        },
        formBtnClass: function () {
            return this.editedIndex != -1 ? "btn-warning" : "btn-success";
        },
    },
    methods: {
        isShowAddress() {
            if ($("#select_check").is(":checked")) {
                this.isShow = true;
            } else {
                this.isShow = false;
            }
        },
        isShowAddress1() {
            if ($("#select_address").is(":checked")) {
                this.isShow1 = true;
            } else {
                this.isShow1 = false;
            }
        },
        async getEditItemData() {
            var data = new FormData();
            data.append("admission", this.editedIndex);
            const res = await this.callApi(
                "post",
                `/api/school/students/student_addresses/edit`,
                data
            );
            // console.log("EDIT ITEM", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.editItem = data.edit_address;
                    this.editItem.is_current = data.edit_address.is_current;
                    this.editItem.is_permanent = data.edit_address.is_permanent;

                } else{
                   this.editedIndex =  -1 ;
                }
            }
        },
        async getGuardianData() {
            this.log('Guardian data function called')
            this.isLoaded = false;
            const res = await this.callApi(
                "get",
                `/api/school/students/student_addresses/${this.$route.params.student_admission_id}`,
                null
            );
            this.log('Guardian data',res)
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.guardian = data.student_guardian;
                } else {
                    this.noData = true;
                }
            }
            this.isLoaded = true;
            // toast.close();
        },
        setCurrentAddress() {
            if (this.editItem.is_current) {
                this.editItem.current = this.guardian;
            } else {
                this.editItem.current = {};
            }
        },
        setPermanentAddress() {
            if (this.editItem.is_permanent) {
                this.editItem.permanent = this.editItem.current;
            } else {
                this.editItem.permanent = {};
            }
        },

        async submitData() {
            var validForm = await this.validAddressForm();
            if (!validForm) {
                return;
            }

            var data = new FormData();
            data.append("school_id", 1);
            data.append("admission_id", this.student_admission_id);
            data.append("is_current_address",
            this.editItem.is_current ? 1 : 0);
            data.append("is_permanent_address",
            this.editItem.is_permanent ? 1 : 0);
            data.append(
                "permanent_address_line1",
                this.editItem.permanent.address_line1
                    ? this.editItem.permanent.address_line1
                    : ""
            );
            data.append(
                "permanent_address_line2",
                this.editItem.permanent.address_line2
                    ? this.editItem.permanent.address_line2
                    : ""
            );
            data.append(
                "permanent_location",
                this.editItem.permanent.location
                    ? this.editItem.permanent.location
                    : ""
            );
            data.append(
                "permanent_landmark",
                this.editItem.permanent.landmark
                    ? this.editItem.permanent.landmark
                    : ""
            );
            data.append(
                "permanent_city",
                this.editItem.permanent.city
                    ? this.editItem.permanent.city
                    : ""
            );
            data.append(
                "permanent_pincode",
                this.editItem.permanent.pincode
                    ? this.editItem.permanent.pincode
                    : ""
            );
            data.append(
                "permanent_state",
                this.editItem.permanent.state
                    ? this.editItem.permanent.state
                    : ""
            );
            data.append(
                "permanent_country",
                this.editItem.permanent.country
                    ? this.editItem.permanent.country
                    : ""
            );
            data.append(
                "current_address_line1",
                this.editItem.current.address_line1
                    ? this.editItem.current.address_line1
                    : ""
            );
            data.append(
                "current_address_line2",
                this.editItem.current.address_line2
                    ? this.editItem.current.address_line2
                    : ""
            );
            data.append(
                "current_location",
                this.editItem.current.location
                    ? this.editItem.current.location
                    : ""
            );
            data.append(
                "current_landmark",
                this.editItem.current.landmark
                    ? this.editItem.current.landmark
                    : ""
            );
            data.append(
                "current_city",
                this.editItem.current.city ? this.editItem.current.city : ""
            );
            data.append(
                "current_pincode",
                this.editItem.current.pincode
                    ? this.editItem.current.pincode
                    : ""
            );
            data.append(
                "current_state",
                this.editItem.current.state
                    ? this.editItem.current.state
                    : ""
            );
            data.append(
                "current_country",
                this.editItem.current.country
                    ? this.editItem.current.country
                    : ""
            );
            let url = "";
            if (this.editedIndex != -1) {
                url = `/api/school/students/student_addresses/update/${this.editedIndex}`;
            } else {
                url = `/api/school/students/student_addresses/save`;
            }
            const res = await this.callApi("post", url, data, "multipart");
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                    setTimeout(() => {
                        this.$router.push({
                            path: `/school/students/${this.student_admission_id}/transports`,
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
        validAddressForm() {
            this.isFormValid = true;

            if (
                this.editItem.current.address_line1 == null ||
                this.editItem.current.address_line1 == ""
            ) {
                this.errorItem.current.address_line1 =
                    "Address Line 1 is required";
                this.isFormValid = false;
            } else {
                this.errorItem.current.address_line1 = "";
            }
            if (
                this.editItem.current.city == null ||
                this.editItem.current.city == ""
            ) {
                this.errorItem.current.city = "City is required";
                this.isFormValid = false;
            } else {
                this.errorItem.current.city = "";
            }
            if (
                this.editItem.current.pincode == null ||
                this.editItem.current.pincode == ""
            ) {
                this.errorItem.current.pincode =
                    "Pincode is required";
                this.isFormValid = false;
            } else {
                this.errorItem.current.pincode = "";
            }
            if (
                this.editItem.current.state == null ||
                this.editItem.current.state == ""
            ) {
                this.errorItem.current.state = "State is required";
                this.isFormValid = false;
            } else {
                this.errorItem.current.state = "";
            }
            if (
                this.editItem.current.country == null ||
                this.editItem.current.country == ""
            ) {
                this.errorItem.current.country =
                    "Country is required";
                this.isFormValid = false;
            } else {
                this.errorItem.current.country = "";
            }
            if (
                this.editItem.permanent.address_line1 == null ||
                this.editItem.permanent.address_line1 == ""
            ) {
                this.errorItem.permanent.address_line1 =
                    "address is required";
                this.isFormValid = false;
            } else {
                this.errorItem.permanent.address_line_1 = "";
            }
            if (
                this.editItem.permanent.city == null ||
                this.editItem.permanent.city == ""
            ) {
                this.errorItem.permanent.city =
                    "city is required";
                this.isFormValid = false;
            } else {
                this.errorItem.permanent.city = "";
            }
            if (
                this.editItem.permanent.pincode == null ||
                this.editItem.permanent.pincode == ""
            ) {
                this.errorItem.permanent.pincode =
                    "pincode is required";
                this.isFormValid = false;
            } else {
                this.errorItem.permanent.pincode = "";
            }
            if (
                this.editItem.permanent.state == null ||
                this.editItem.permanent.state == ""
            ) {
                this.errorItem.permanent.state =
                    "state is required";
                this.isFormValid = false;
            } else {
                this.errorItem.permanent.state = "";
            }
            if (
                this.editItem.permanent.country == null ||
                this.editItem.permanent.country == ""
            ) {
                this.errorItem.permanent.country =
                    "country is required";
                this.isFormValid = false;
            } else {
                this.errorItem.permanent.country = "";
            }
            return this.isFormValid;
        },
    },

};
</script>
