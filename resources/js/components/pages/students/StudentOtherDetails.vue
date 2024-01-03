<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb
                pageTitle="Other Information "
                :breadcrumbList="breadcrumbList"
            />
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div
                                class="new-added-form"
                                enctype="multipart/form-data"
                            >
                                <div class="row">
                                    <div
                                        class="col-xl-4 col-lg-6 col-12 form-group"
                                    >
                                        <label
                                            >National Identification
                                            Number</label
                                        >
                                        <input
                                            type="text"
                                            placeholder
                                            class="form-control"
                                            v-model="
                                                editItem.national_identification_number
                                            "
                                            :class="
                                                errorItem.national_identification_number !=
                                                ''
                                                    ? 'error-field'
                                                    : ''
                                            "
                                            @keyup="
                                                editItem.national_identification_number !=
                                                ''
                                                    ? (errorItem.national_identification_number =
                                                          '')
                                                    : ''
                                            "
                                        />
                                        <span
                                            class="error-label"
                                            v-if="
                                                errorItem.national_identification_number !=
                                                ''
                                            "
                                            v-text="
                                                errorItem.national_identification_number
                                            "
                                        ></span>
                                    </div>
                                    <div
                                        class="col-xl-4 col-lg-6 col-12 form-group"
                                    >
                                        <label
                                            >Local Identification Number</label
                                        >
                                        <input
                                            type="text"
                                            placeholder
                                            class="form-control"
                                            v-model="
                                                editItem.local_identification_number
                                            "
                                            :class="
                                                errorItem.local_identification_number !=
                                                ''
                                                    ? 'error-field'
                                                    : ''
                                            "
                                            @keyup="
                                                editItem.local_identification_number !=
                                                ''
                                                    ? (errorItem.local_identification_number =
                                                          '')
                                                    : ''
                                            "
                                        />
                                        <span
                                            class="error-label"
                                            v-if="
                                                errorItem.local_identification_number !=
                                                ''
                                            "
                                            v-text="
                                                errorItem.local_identification_number
                                            "
                                        ></span>
                                    </div>

                                    <div
                                        class="col-xl-3 col-lg-6 col-12 form-group"
                                    >
                                        <label>RTE*</label>
                                        <select
                                            class="form-control"
                                            v-model="editItem.rte"
                                            :class="
                                                errorItem.rte != ''
                                                    ? 'error-field'
                                                    : ''
                                            "
                                            @change="
                                                editItem.rte != ''
                                                    ? (errorItem.rte = '')
                                                    : ''
                                            "
                                        >
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                        <span
                                            class="error-label"
                                            v-if="errorItem.rte != ''"
                                            v-text="errorItem.rte"
                                        ></span>
                                    </div>
                                    <div
                                        class="col-xl-6 col-lg-6 col-12 form-group"
                                    >
                                        <label>Previous School Details</label>
                                        <textarea
                                            class="textarea form-control"
                                            name="address"
                                            id="address"
                                            cols="9"
                                            rows="3"
                                            v-model="editItem.previous_school"
                                            :class="
                                                errorItem.previous_school != ''
                                                    ? 'error-field'
                                                    : ''
                                            "
                                            @keypress="
                                                errorItem.previous_school = ''
                                            "
                                        ></textarea>
                                        <span
                                            class="error-label"
                                            v-if="
                                                errorItem.previous_school != ''
                                            "
                                            v-text="errorItem.previous_school"
                                        ></span>
                                    </div>
                                    <div
                                        class="col-xl-6 col-lg-6 col-12 mt-4 form-group"
                                    >
                                        <label>Note</label>
                                        <textarea
                                            class="textarea form-control"
                                            name="address"
                                            id="address"
                                            cols="9"
                                            rows="3"
                                            v-model="editItem.note"
                                        ></textarea>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-5">
                                    <button
                                        type="submit"
                                        class="btn btn-lg btn-gradient-yellow btn-hover-bluedark mx-3 text-white"
                                        @click="$router.push('hostels')"
                                    >
                                        Back
                                    </button>
                                    <button
                                        type="submit"
                                        class="btn btn-lg btn-gradient-yellow btn-hover-bluedark mx-3 text-white"
                                        :class="formBtnClass"
                                        @click.prevent="submitData()"
                                    >
                                        {{ formBtn }}
                                    </button>
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
                    name: "Student",
                },
                {
                    to: { name: "admin.students.admissions" },
                    name: "Admission",
                },
                {
                    name: "Other",
                },
            ],
            isLoaded: false,
            noData: false,
            editItem: {},
            errorItem: {
                national_identification_number: "",
                local_identification_number: "",
                rte: "",
                previous_school: "",
            },
            admission_id: -1,
            editedIndex: -1,
        };
    },
    computed: {
        formBtn: function () {
            return this.editedIndex != -1 ? "Update & Next" : "Save & Next";
        },
        formBtnClass: function () {
            return this.editedIndex != -1 ? "btn-warning" : "btn-success";
        },
    },
    mounted() {
        this.$parent.loadOtherScript();
        if (this.$route.params.student_admission_id) {
            this.admission_id = this.$route.params.student_admission_id;
            this.getEditData()
        }
    },
    methods: {
        async getEditData(){
              var data = new FormData();
            data.append("admission", this.admission_id);
            const res = await this.callApi(
                "post",
                `/api/school/students/student_other_details/edit`,
                data
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.editItem = data.student_other_detail;
                    this.editedIndex = data.student_other_detail.student_other_detail;
                } else {
                    this.editedIndex = -1;
                }
            }
        },
        async submitData() {
            // var isVaild = await this.validOtherDetailsForm();
            // if (!isVaild) {
            //     return;
            // }

            toast = Toast.fire({
                icon: "warning",
                title: "Please Wait!! Creating new Admission",
                timer: 0,
            });
            var data = new FormData();
            data.append("admission_id", this.admission_id);
            data.append(
                "national_identification_number",
                this.editItem.national_identification_number
                    ? this.editItem.national_identification_number
                    : ""
            );
            data.append(
                "local_identification_number",
                this.editItem.local_identification_number
                    ? this.editItem.local_identification_number
                    : ""
            );
            data.append("rte", this.editItem.rte ? this.editItem.rte : "");
            data.append(
                "previous_school",
                this.editItem.previous_school
                    ? this.editItem.previous_school
                    : ""
            );
            data.append("note", this.editItem.note ? this.editItem.note : "");
            let url = "";
            if(this.editedIndex == -1){
                url=`/api/school/students/student_other_details/save`;
            }else{
                url = `/api/school/students/student_other_details/update/${this.editedIndex}`;
            }
            const res = await this.callApi(
                "post",
                url,
                data
            );

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
                            path: `/school/students/${this.admission_id}/documents`,
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
        validOtherDetailsForm() {
            this.isFormValid = true;
            if (
                this.editItem.national_identification_number == null ||
                this.editItem.national_identification_number == ""
            ) {
                this.errorItem.national_identification_number =
                    "This Field is required";
                this.isFormValid = false;
            } else {
                this.errorItem.national_identification_number = "";
            }
            if (
                this.editItem.local_identification_number == null ||
                this.editItem.local_identification_number == ""
            ) {
                this.errorItem.local_identification_number =
                    "This Field is required";
                this.isFormValid = false;
            } else {
                this.errorItem.local_identification_number = "";
            }
            if (this.editItem.rte == null || this.editItem.rte == "") {
                this.errorItem.rte = "This Field is required";
                this.isFormValid = false;
            } else {
                this.errorItem.rte = "";
            }
            if (
                this.editItem.previous_school == null ||
                this.editItem.previous_school == ""
            ) {
                this.errorItem.previous_school = "This Field is required";
                this.isFormValid = false;
            } else {
                this.errorItem.previous_school = "";
            }
            return this.isFormValid;
        },
    },
};
</script>
