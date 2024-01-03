<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb pageTitle="Student Guardian Details" :breadcrumbList="breadcrumbList" />
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <!-- <h3>Add Parent/Guardian Information</h3> -->
                                </div>
                            </div>

                            <div class="new-added-form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="">Father Detail</h4>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                                        <label>
                                            Father First Name
                                            <strong class="text-danger">*</strong>
                                        </label>
                                        <input type="text" placeholder class="form-control"
                                            v-model="editItem.father.first_name" :class="errorItem.father.first_name !=
                                                    ''
                                                    ? 'error-field'
                                                    : ''
                                                " @keyup="
        errorItem.father.first_name = ''
        " />
                                        <span class="error-label" v-if="errorItem.father.first_name !=
                                            ''
                                            " v-text="errorItem.father.first_name"></span>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                                        <label>Father Middle Name</label>
                                        <input type="text" placeholder class="form-control" v-model="editItem.father.middle_name
                                            " />
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                                        <label>Father Last Name</label>
                                        <input type="text" placeholder class="form-control"
                                            v-model="editItem.father.last_name" />
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                                        <label>
                                            Father Mobile
                                            <strong class="text-danger">*</strong>
                                        </label>
                                        <input type="text" placeholder class="form-control" v-model="editItem.father.mobile"
                                            @keydown="enterValue" :class="errorItem.father.mobile != ''
                                                    ? 'error-field'
                                                    : ''
                                                " @keyup="
        editItem.father.mobile != ''
            ? (errorItem.father.mobile =
                '')
            : ''
        " />
                                        <span class="error-label" v-if="errorItem.father.mobile != ''"
                                            v-text="errorItem.father.mobile"></span>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                                        <label>Father Alternative Mobile</label>
                                        <input type="text" placeholder class="form-control" @keydown="enterValue" v-model="editItem.father
                                                .alternative_mobile
                                            " />
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                                        <label>
                                            Father Occupation
                                            <strong class="text-danger">*</strong>
                                        </label>
                                        <input type="text" placeholder class="form-control"
                                            v-model="editItem.father.occupation" :class="errorItem.father.occupation !=
                                                    ''
                                                    ? 'error-field'
                                                    : ''
                                                " @keydown="
        editItem.father.occupation != ''
            ? (errorItem.father.occupation =
                '')
            : ''
        " />
                                        <span class="error-label" v-if="errorItem.father.occupation !=
                                            ''
                                            " v-text="errorItem.father.occupation"></span>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                                        <label>
                                            Father Email
                                            <strong class="text-danger">*</strong>
                                        </label>
                                        <input type="text" placeholder class="form-control" v-model="editItem.father.email"
                                            :class="errorItem.father.email != ''
                                                    ? 'error-field'
                                                    : ''
                                                " @keydown="
        editItem.father.email != ''
            ? (errorItem.father.email =
                '')
            : ''
        " />
                                        <span class="error-label" v-if="errorItem.father.email != ''"
                                            v-text="errorItem.father.email"></span>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                                        <label>Father Alternative Email</label>
                                        <input type="text" placeholder class="form-control" v-model="editItem.father.alternate_email
                                            " />
                                    </div>
                                </div>

                                <div class="row py-4">
                                    <div class="col-md-12">
                                        <h4>Mother Detail</h4>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                                        <label>
                                            Mother First Name
                                            <strong class="text-danger">*</strong>
                                        </label>
                                        <input type="text" placeholder class="form-control"
                                            v-model="editItem.mother.first_name" :class="errorItem.mother.first_name !=
                                                    ''
                                                    ? 'error-field'
                                                    : ''
                                                " @keydown="
        editItem.mother.first_name != ''
            ? (errorItem.mother.first_name =
                '')
            : ''
        " />
                                        <span class="error-label" v-if="errorItem.mother.first_name !=
                                            ''
                                            " v-text="errorItem.mother.first_name"></span>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                                        <label>Mother Middle Name</label>
                                        <input type="text" placeholder class="form-control" v-model="editItem.mother.middle_name
                                            " />
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                                        <label>Mother Last Name</label>
                                        <input type="text" placeholder class="form-control"
                                            v-model="editItem.mother.last_name" />
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                                        <label>
                                            Mother Mobile
                                            <strong class="text-danger">*</strong>
                                        </label>
                                        <input type="text" placeholder class="form-control" v-model="editItem.mother.mobile"
                                            @keydown="enterValue" :class="errorItem.mother.mobile != ''
                                                    ? 'error-field'
                                                    : ''
                                                " @keyup="
        editItem.mother.mobile != ''
            ? (errorItem.mother.mobile =
                '')
            : ''
        " />
                                        <span class="error-label" v-if="errorItem.mother.mobile != ''"
                                            v-text="errorItem.mother.mobile"></span>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                                        <label>Mother Alternative Mobile</label>
                                        <input type="text" placeholder class="form-control" @keydown="enterValue" v-model="editItem.mother
                                                .alternative_mobile
                                            " />
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                                        <label>
                                            Mother Occupation
                                            <strong class="text-danger">*</strong>
                                        </label>
                                        <input type="text" placeholder class="form-control"
                                            v-model="editItem.mother.occupation" :class="errorItem.mother.occupation !=
                                                    ''
                                                    ? 'error-field'
                                                    : ''
                                                " @keydown="
        editItem.mother.occupation != ''
            ? (errorItem.mother.occupation =
                '')
            : ''
        " />
                                        <span class="error-label" v-if="errorItem.mother.occupation !=
                                            ''
                                            " v-text="errorItem.mother.occupation"></span>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                                        <label>
                                            Mother Email
                                            <strong class="text-danger">*</strong>
                                        </label>
                                        <input type="text" placeholder class="form-control" v-model="editItem.mother.email"
                                            :class="errorItem.mother.email != ''
                                                    ? 'error-field'
                                                    : ''
                                                " @keydown="
        editItem.mother.email != ''
            ? (errorItem.mother.email =
                '')
            : ''
        " />
                                        <span class="error-label" v-if="errorItem.mother.email != ''"
                                            v-text="errorItem.mother.email"></span>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                                        <label>Mother Alternative Email</label>
                                        <input type="text" placeholder class="form-control" v-model="editItem.mother.alternate_email
                                            " />
                                    </div>
                                </div>
                                <h4>Photos</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <span class="error-label" v-if="errorItem.father_image !=
                                                    ''
                                                    " v-text="errorItem.father_image
        "></span>
                                                <div class="rounded-1 p-2 text-center position-relative" style="
                                                                    border: solid 1px
                                                                        #00000012;
                                                                ">
                                                    <img :src="selectedImageFather
                                                        " style="height: 180px" />
                                                    <div>Father Photo</div>
                                                    <input type="file" class="employee_avatar" accept=".png,.jpg,.jpeg"
                                                        @change="fatherImageSelect
                                                            " @click="
        errorItem.father_image =
        ''
        " />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <span class="error-label" v-if="errorItem.mother_image !=
                                                    ''
                                                    " v-text="errorItem.mother_image
        "></span>
                                                <div class="rounded-1 p-2 text-center position-relative" style="
                                                                    border: solid 1px
                                                                        #00000012;
                                                                ">
                                                    <img :src="selectedImageMother
                                                        " style="height: 180px" />
                                                    <div>Mother's Photo</div>
                                                    <input type="file" class="employee_avatar" accept=".png,.jpg,.jpeg"
                                                        @change="motherImageSelect
                                                            " @click="
        errorItem.mother_image =
        ''
        " />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row ml-2 py-4">
                                        <div class="col-md-12">
                                            <h4>Guardian Detail</h4>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-xl-2">
                                                    <label class>If Guardian Is :</label>
                                                </div>
                                                <div class="col-xl-10">
                                                    <span class="error-label" v-if="errorItem.guardian !=
                                                        ''
                                                        " v-text="errorItem.guardian
        "></span>
                                                    <input class="form-radio-input" type="radio" name="studentGuardian"
                                                        value="father" v-model="editItem.if_guardian
                                                            " @change="
        checkGuardian()
        " :class="errorItem.guardian !=
            ''
            ? 'error-field'
            : ''
        " @click="
        editItem.guardian !=
            ''
            ? (errorItem.guardian =
                '')
            : ''
        " />
                                                    <label class="form-label mr-5" for="father">Father</label>

                                                    <input class="form-radio-input" type="radio" name="studentGuardian"
                                                        value="mother" v-model="editItem.if_guardian
                                                            " @change="
        checkGuardian()
        " :class="errorItem.guardian !=
            ''
            ? 'error-field'
            : ''
        " @click="
        editItem.guardian !=
            ''
            ? (errorItem.guardian =
                '')
            : ''
        " />
                                                    <label class="form-label mr-5" for="mother">Mother</label>
                                                    <input class="form-radio-input" type="radio" name="studentGuardian"
                                                        value="other" v-model="editItem.if_guardian
                                                            " @change="
        checkGuardian()
        " :class="errorItem.guardian !=
            ''
            ? 'error-field'
            : ''
        " @click="
        editItem.guardian !=
            ''
            ? (errorItem.guardian =
                '')
            : ''
        " />

                                                    <label class="form-label" for="gender">Other</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-lg-6 col-12 mt-4 form-group">
                                            <label>
                                                Guardian First Name
                                                <strong class="text-danger">*</strong>
                                            </label>
                                            <input type="text" placeholder class="form-control" v-model="editItem.other.first_name
                                                " :class="errorItem.other
            .first_name != ''
            ? 'error-field'
            : ''
        " @click="
        editItem.other.first_name !=
            ''
            ? (errorItem.other.first_name =
                '')
            : ''
        " />
                                            <span class="error-label" v-if="errorItem.other
                                                    .first_name != ''
                                                " v-text="errorItem.other.first_name
        "></span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-12 mt-4 form-group">
                                            <label>Guardian Middle Name</label>
                                            <input type="text" placeholder class="form-control" v-model="editItem.other.middle_name
                                                " />
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-12 mt-4 form-group">
                                            <label>Guardian Last Name</label>
                                            <input type="text" placeholder class="form-control" v-model="editItem.other.last_name
                                                " />
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-12 mt-4 form-group">
                                            <label>Guardian Mobile *</label>
                                            <input type="text" placeholder class="form-control"
                                                v-model="editItem.other.mobile" @keydown="enterValue" :class="errorItem.other.mobile != ''
                                                        ? 'error-field'
                                                        : ''
                                                    " @keyup="
        editItem.other.mobile != ''
            ? (errorItem.other.mobile =
                '')
            : ''
        " />
                                            <span class="error-label" v-if="errorItem.other.mobile != ''
                                                " v-text="errorItem.other.mobile"></span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-12 mt-4 form-group">
                                            <label>
                                                Guardian Alternative Mobile
                                            </label>
                                            <input type="text" placeholder class="form-control" @keydown="enterValue"
                                                v-model="editItem.other
                                                        .alternate_mobile
                                                    " />
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-12 mt-4 form-group">
                                            <label>
                                                Guardian Occupation
                                                <strong class="text-danger">*</strong>
                                            </label>
                                            <input type="text" placeholder class="form-control" v-model="editItem.other.occupation
                                                " :class="errorItem.other
            .occupation != ''
            ? 'error-field'
            : ''
        " @keydown="
        editItem.other.occupation !=
            ''
            ? (errorItem.other.occupation =
                '')
            : ''
        " />
                                            <span class="error-label" v-if="errorItem.other
                                                    .occupation != ''
                                                " v-text="errorItem.other.occupation
        "></span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-12 mt-4 form-group">
                                            <label>
                                                Guardian Email
                                                <strong class="text-danger">*</strong>
                                            </label>
                                            <input type="text" placeholder class="form-control"
                                                v-model="editItem.other.email" :class="errorItem.other.email != ''
                                                        ? 'error-field'
                                                        : ''
                                                    " @keydown="
        editItem.other.email != ''
            ? (errorItem.other.email =
                '')
            : ''
        " />
                                            <span class="error-label" v-if="errorItem.other.email != ''
                                                " v-text="errorItem.other.email"></span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-12 mt-4 form-group">
                                            <label>Guardian Alternate Email</label>
                                            <input type="text" placeholder class="form-control" v-model="editItem.other
                                                    .alternate_email
                                                " />
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-12 mt-4 form-group">
                                            <label>
                                                Guardian Relation
                                                <strong class="text-danger">*</strong>
                                            </label>
                                            <input type="text" placeholder class="form-control" v-model="editItem.other.relation
                                                " :class="errorItem.other.relation !=
            ''
            ? 'error-field'
            : ''
        " @keydown="
        editItem.other.relation !=
            ''
            ? (errorItem.other.relation =
                '')
            : ''
        " />
                                            <span class="error-label" v-if="errorItem.other.relation !=
                                                ''
                                                " v-text="errorItem.other.relation
        "></span>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-12 mt-4 form-group">
                                            <div class="col-xl-6 col-lg-6 col-12 mt-4 form-group">
                                                <div class="row">
                                                    <label class="mr-5">Upload Guardian
                                                        Photo</label>
                                                    <span class="error-label" v-if="errorItem.guardian_image !=
                                                        ''
                                                        " v-text="errorItem.guardian_image
        ">
                                                    </span>
                                                    <div class="rounded-1 p-2 text-center position-relative" style="
                                                                        border: solid 1px
                                                                            #00000012;
                                                                    ">
                                                        <img :src="selectedImageGuardian
                                                            " style="
                                                                            height: 180px;
                                                                        " />
                                                        <input type="file" class="employee_avatar" accept=".png,.jpg,.jpeg"
                                                            @change="guardianImageSelect
                                                                " @click="
        errorItem.guardian_image =
        ''
        " />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <h2>Address</h2>
                                    <div class="row">
                                        <div class="col-lg-6 col-12 form-group">
                                            <label>
                                                Address Line-1
                                                <strong class="text-danger">*</strong>
                                            </label>
                                            <textarea class="textarea form-control" name="address" id="address" cols="14"
                                                rows="3" v-model="editItem.address_line1" @keyup="
                                                    editItem.address_line1 != ''
                                                        ? (errorItem.address_line1 =
                                                            '')
                                                        : ''
                                                    " :class="errorItem.address_line1 !=
            ''
            ? 'error-field'
            : ''
        "></textarea>
                                            <span class="error-label" v-if="errorItem.address_line1 !=
                                                ''
                                                " v-text="errorItem.address_line1"></span>
                                        </div>
                                        <div class="col-lg-6 col-12 form-group">
                                            <label>Address Line-2</label>
                                            <textarea class="textarea form-control" name="address" id="address" cols="14"
                                                rows="3" v-model="editItem.address_line2"></textarea>
                                        </div>
                                        <div class="col-lg-4 col-12 form-group">
                                            <label>
                                                Location
                                                <strong class="text-danger">*</strong>
                                            </label>
                                            <input type="text" placeholder class="form-control" v-model="editItem.location"
                                                :class="errorItem.location != ''
                                                        ? 'error-field'
                                                        : ''
                                                    " @keydown="
        editItem.location != ''
            ? (errorItem.location =
                '')
            : ''
        " />
                                            <span class="error-label" v-if="errorItem.location != ''"
                                                v-text="errorItem.location"></span>
                                        </div>
                                        <div class="col-lg-4 col-12 form-group">
                                            <label>
                                                Landmark
                                                <strong class="text-danger">*</strong>
                                            </label>
                                            <input type="text" placeholder class="form-control" v-model="editItem.landmark"
                                                :class="errorItem.landmark != ''
                                                        ? 'error-field'
                                                        : ''
                                                    " @keydown="
        editItem.landmark != ''
            ? (errorItem.landmark =
                '')
            : ''
        " />
                                            <span class="error-label" v-if="errorItem.landmark != ''"
                                                v-text="errorItem.landmark"></span>
                                        </div>
                                        <div class="col-lg-4 col-12 form-group">
                                            <label>
                                                City
                                                <strong class="text-danger">*</strong>
                                            </label>
                                            <input type="text" placeholder class="form-control" v-model="editItem.city"
                                                :class="errorItem.city != ''
                                                        ? 'error-field'
                                                        : ''
                                                    " @keydown="
        editItem.city != ''
            ? (errorItem.city = '')
            : ''
        " />
                                            <span class="error-label" v-if="errorItem.city != ''"
                                                v-text="errorItem.city"></span>
                                        </div>
                                        <div class="col-lg-4 col-12 form-group">
                                            <label>
                                                Pin Code
                                                <strong class="text-danger">*</strong>
                                            </label>
                                            <input type="text" placeholder class="form-control" v-model="editItem.pincode"
                                                :class="errorItem.pincode != ''
                                                        ? 'error-field'
                                                        : ''
                                                    " @keydown="
        editItem.pincode != ''
            ? (errorItem.pincode =
                '')
            : ''
        " />
                                            <span class="error-label" v-if="errorItem.pincode != ''"
                                                v-text="errorItem.pincode"></span>
                                        </div>
                                        <div class="col-lg-4 col-12 form-group">
                                            <label>
                                                State
                                                <strong class="text-danger">*</strong>
                                            </label>
                                            <input type="text" placeholder class="form-control" v-model="editItem.state"
                                                :class="errorItem.state != ''
                                                        ? 'error-field'
                                                        : ''
                                                    " @keydown="
        editItem.state != ''
            ? (errorItem.state = '')
            : ''
        " />
                                            <span class="error-label" v-if="errorItem.state != ''"
                                                v-text="errorItem.state"></span>
                                        </div>
                                        <div class="col-lg-4 col-12 form-group">
                                            <label>
                                                Country
                                                <strong class="text-danger">*</strong>
                                            </label>
                                            <input type="text" placeholder class="form-control" v-model="editItem.country"
                                                :class="errorItem.country != ''
                                                        ? 'error-field'
                                                        : ''
                                                    " @keydown="
        editItem.country != ''
            ? (errorItem.country =
                '')
            : ''
        " />
                                            <span class="error-label" v-if="errorItem.country != ''"
                                                v-text="errorItem.country"></span>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end mt-5">
                                        <button type="submit"
                                            class="btn btn-lg btn-gradient-yellow btn-hover-bluedark mx-3 text-white"
                                            @click="backToPrevious()">
                                            Back
                                        </button>
                                        <button type="submit" :class="formBtnClass"
                                            class="btn-fill-lg text-light shadow-dodger-blue bg-dodger-blue"
                                            @click.prevent="submitData()">
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
    </div>
</template>

<script>
var toast;
export default {
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "school.dashboard" },
                    name: "Home",
                },
                {
                    name: "Student",
                },
                {
                    to: { name: "school.students.admissions" },
                    name: "Admission",
                },
                {
                    name: "Guardian Details",
                },
            ],
            isLoaded: false,
            noData: false,
            editItem: {
                father: {},
                mother: {},
                other: {},
            },
            isFormValid: false,
            errorItem: {
                father: {
                    first_name: "",
                    mobile: "",
                    email: "",
                    occupation: "",
                },
                mother: {
                    first_name: "",
                    mobile: "",
                    email: "",
                    occupation: "",
                },
                other: {
                    first_name: "",
                    mobile: "",
                    email: "",
                    occupation: "",
                    relation: "",
                },
                address_line1: "",
                location: "",
                landmark: "",
                city: "",
                pincode: "",
                state: "",
                country: "",
                father_image: "",
                mother_image: "",
                guardian_image: "",
            },
            student_admission_id: -1,
            edit_guardian: [],
            fatherScrImage: null,
            fatherImageFilePath: null,
            motherScrImage: null,
            motherImageFilePath: null,
            guardianScrImage: null,
            guardianImageFilePath: null,
            editedIndex: -1,
            emailRegex: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/,
        };
    },
    mounted() {
        this.$parent.loadOtherScript();
        console.log('edit id', this.$route.params.edit_id);
        if (this.$route.params.student_admission_id) {
            this.student_admission_id = this.$route.params.student_admission_id;

        }
        if (this.$route.params.edit_id && this.editedIndex == -1) {
            this.editedIndex = this.$route.params.edit_id;
            this.log('edit Id', this.editedIndex);
            this.getEditItemData();
        }
        this.$parent.loadOtherScript();
        // this.student_admission_id = this.$route.params.id;
        // // console.log("IIIIIDDDDDD", this.student_admission_id);
        // if (this.$route.params.id) {
        //     this.editedIndex = this.$route.params.id;

        //     this.getEditItemData();
        // }
    },
    computed: {
        formBtn: function () {
            return this.editedIndex != -1 ? "Update & Next" : "Save & Next";
        },
        formBtnClass: function () {
            return this.editedIndex != -1 ? "btn-warning" : "btn-success";
        },
        selectedImageFather: function () {
            return this.fatherScrImage != null
                ? this.fatherScrImage
                : "/assets/img/user_icon.png";
        },
        selectedImageMother: function () {
            return this.motherScrImage != null
                ? this.motherScrImage
                : "/assets/img/user_icon.png";
        },
        selectedImageGuardian: function () {
            return this.guardianScrImage != null
                ? this.guardianScrImage
                : "/assets/img/user_icon.png";
        },
    },
    watch: {
        //  'editItem.mother.email': function(val) {
        //         this.errorItem.mother.email = '';
        //         if(val == null || val == '') {
        //             this.errorItem.mother.email = 'Email is required'
        //         }
        //         if(val && !this.emailRegex.test(val)) {
        //             this.errorItem.mother.email = 'Enter Valid Email id'
        //         }
        //     },
    },
    methods: {
        backToPrevious(){
            this.$router.push(`/school/students/admission/${this.student_admission_id}`)
        },
        async getEditItemData() {
            const res = await this.callApi(
                "get",
                `/api/school/students/student_guardian_details/edit/${this.editedIndex}`,
                null
            );
            // console.log("EDIT ITEM", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.editItem = data.edit_guardian;
                    this.guardianScrImage = data.edit_guardian.other.photo;
                    this.fatherScrImage = data.edit_guardian.father.photo;
                    this.motherScrImage = data.edit_guardian.mother.photo;
                }
            }
        },

        checkGuardian() {
            if (this.editItem.if_guardian == "father") {
                this.editItem.other = this.editItem.father;
                this.guardianScrImage = this.fatherScrImage;
                this.guardianImageFilePath = this.fatherImageFilePath;
            } else if (this.editItem.if_guardian == "mother") {
                this.editItem.other = this.editItem.mother;
                this.guardianScrImage = this.motherScrImage;
                this.guardianImageFilePath = this.motherImageFilePath;
            } else {
                this.editItem.other = {};
                this.guardianScrImage = null;
                this.guardianImageFilePath = null;
            }
        },
        // async submitData() {
        // 	var isVaild = await this.validAdmissionForm();
        // 	if (!isVaild) {
        // 		return;
        // 	}
        // 	if (this.editedIndex === -1) {
        // 		this.saveData();
        // 	} else {
        // 		this.updateData();
        // 	}

        // },
        async submitData() {
            var isVaild = await this.validAdmissionForm();
            if (!isVaild) {
                return;
            }
            var data = new FormData();
            data.append("admission", this.student_admission_id);
            data.append("if_guardian", this.editItem.if_guardian);

            data.append(
                "father_first_name",
                this.editItem.father.first_name
                    ? this.editItem.father.first_name
                    : ""
            );
            data.append(
                "father_middle_name",
                this.editItem.father.middle_name
                    ? this.editItem.father.middle_name
                    : ""
            );
            data.append(
                "father_last_name",
                this.editItem.father.last_name
                    ? this.editItem.father.last_name
                    : ""
            );
            data.append(
                "father_mobile",
                this.editItem.father.mobile ? this.editItem.father.mobile : ""
            );
            data.append(
                "father_alternative_mobile",
                this.editItem.father.alternative_mobile
                    ? this.editItem.father.alternative_mobile
                    : ""
            );
            data.append(
                "father_occupation",
                this.editItem.father.occupation
                    ? this.editItem.father.occupation
                    : ""
            );
            data.append(
                "father_email",
                this.editItem.father.email ? this.editItem.father.email : ""
            );
            data.append(
                "father_alternate_email",
                this.editItem.father.alternate_email
                    ? this.editItem.father.alternate_email
                    : ""
            );
            data.append(
                "father_image",
                this.fatherImageFilePath ? this.fatherImageFilePath : ""
            );
            data.append(
                "mother_first_name",
                this.editItem.mother.first_name
                    ? this.editItem.mother.first_name
                    : ""
            );
            data.append(
                "mother_middle_name",
                this.editItem.mother.middle_name
                    ? this.editItem.mother.middle_name
                    : ""
            );
            data.append(
                "mother_last_name",
                this.editItem.mother.last_name
                    ? this.editItem.mother.last_name
                    : ""
            );
            data.append(
                "mother_mobile",
                this.editItem.mother.mobile ? this.editItem.mother.mobile : ""
            );
            data.append(
                "mother_alternative_mobile",
                this.editItem.mother.alternative_mobile
                    ? this.editItem.mother.alternative_mobile
                    : ""
            );
            data.append(
                "mother_occupation",
                this.editItem.mother.occupation
                    ? this.editItem.mother.occupation
                    : ""
            );
            data.append(
                "mother_email",
                this.editItem.mother.email ? this.editItem.mother.email : ""
            );
            data.append(
                "mother_alternate_email",
                this.editItem.mother.alternate_email
                    ? this.editItem.mother.alternate_email
                    : ""
            );
            data.append(
                "mother_image",
                this.motherImageFilePath ? this.motherImageFilePath : ""
            );
            data.append(
                "guardian_first_name",
                this.editItem.other.first_name
                    ? this.editItem.other.first_name
                    : ""
            );
            data.append(
                "guardian_middle_name",
                this.editItem.other.middle_name
                    ? this.editItem.other.middle_name
                    : ""
            );
            data.append(
                "guardian_last_name",
                this.editItem.other.last_name
                    ? this.editItem.other.last_name
                    : ""
            );
            data.append(
                "guardian_mobile",
                this.editItem.other.mobile ? this.editItem.other.mobile : ""
            );
            data.append(
                "guardian_alternative_mobile",
                this.editItem.other.alternate_mobile
            );
            data.append("guardian_occupation", this.editItem.other.occupation);
            data.append(
                "guardian_email",
                this.editItem.other.email ? this.editItem.other.email : ""
            );
            data.append(
                "guardian_alternate_email",
                this.editItem.other.alternate_email
                    ? this.editItem.other.alternate_email
                    : ""
            );
            data.append(
                "guardian_image",
                this.guardianImageFilePath ? this.guardianImageFilePath : ""
            );
            data.append(
                "guardian_relation",
                this.editItem.other.relation ? this.editItem.other.relation : ""
            );
            data.append("address_line1", this.editItem.address_line1);
            data.append(
                "address_line2",
                this.editItem.address_line2 ? this.editItem.address_line2 : ""
            );
            data.append(
                "location",
                this.editItem.location ? this.editItem.location : ""
            );
            data.append(
                "landmark",
                this.editItem.landmark ? this.editItem.landmark : ""
            );
            data.append("city", this.editItem.city ? this.editItem.city : "");
            data.append(
                "pincode",
                this.editItem.pincode ? this.editItem.pincode : ""
            );
            data.append(
                "state",
                this.editItem.state ? this.editItem.state : ""
            );
            data.append(
                "country",
                this.editItem.country ? this.editItem.country : ""
            );
            let url = "";
            if (this.editedIndex != -1) {
                url = `/api/school/students/student_guardian_details/update/${this.editedIndex}`;
            } else {
                url = `/api/school/students/student_guardian_details/save`;
            }
            const res = await this.callApi("post", url, data, "multipart");
            // console.log("SAVED ITEMS", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.editItem = {};
                    setTimeout(() => {
                        this.$router.push({
                            path: `/school/students/${this.student_admission_id}/address`,
                        });
                    }, 3000);
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                    this.editItem = {
                        father: {},
                        mother: {},
                        other: {},
                    };
                } else {
                    toast = Toast.fire({
                        icon: warning,
                        title: "Something Went Wrong....",
                        timer: 2500,
                    });
                }
            }
        },

        validAdmissionForm() {
            this.isFormValid = true;
            if (
                this.editItem.father.first_name == null ||
                this.editItem.father.first_name == ""
            ) {
                this.errorItem.father.first_name = "Father Name is required";
                this.isFormValid = false;
            } else {
                this.errorItem.father.first_name = "";
            }
            if (!/^\d+$/.test(this.editItem.father.mobile)) {
                this.errorItem.father.mobile = "Please Enter Numbers only.";
                this.isFormValid = false;
            } else if (!this.editItem.father.mobile) {
                this.errorItem.father.mobile = "Mobile Number is required";
                this.isFormValid = false;
            } else {
                this.errorItem.father.mobile = "";
            }
            if (
                this.editItem.father.occupation == null ||
                this.editItem.father.occupation == ""
            ) {
                this.errorItem.father.occupation =
                    "Father Occupation  is required";
                this.isFormValid = false;
            } else {
                this.errorItem.father.occupation = "";
            }
           if (
                this.editItem.father.email == null ||
                this.editItem.father.email == ""
            ) {
                this.errorItem.father.email = "Email is required";
                isFormValid = false;
            } else {
                if (!this.emailRegex.test(this.editItem.father.email)) {
                    this.errorItem.father.email = "Enter valid email";
                    isFormValid = false;
                } else {
                    this.errorItem.father.email = "";
                }
            }
            if (
                this.editItem.mother.first_name == null ||
                this.editItem.mother.first_name == ""
            ) {
                this.errorItem.mother.first_name =
                    "Mother First Name is required";
                this.isFormValid = false;
            } else {
                this.errorItem.mother.first_name = "";
            }
           if (!/^\d+$/.test(this.editItem.mother.mobile)) {
                this.errorItem.mother.mobile = "Please Enter Numbers only.";
                this.isFormValid = false;
            } else if (!this.editItem.mother.mobile) {
                this.errorItem.mother.mobile = "Mobile Number is required";
                this.isFormValid = false;
            } else {
                this.errorItem.mother.mobile = "";
            }

            if (
                this.editItem.mother.email == null ||
                this.editItem.mother.email == ""
            ) {
                this.errorItem.mother.email = "Email is required";
                isFormValid = false;
            } else {
                if (!this.emailRegex.test(this.editItem.mother.email)) {
                    this.errorItem.mother.email = "Enter valid email";
                    isFormValid = false;
                } else {
                    this.errorItem.mother.email = "";
                }
            }

            if (
                this.editItem.mother.occupation == null ||
                this.editItem.mother.occupation == ""
            ) {
                this.errorItem.mother.occupation =
                    "Mother Occupation is required";
                this.isFormValid = false;
            } else {
                this.errorItem.mother.occupation = "";
            }
            if (
                this.editItem.if_guardian == null ||
                this.editItem.if_guardian == ""
            ) {
                this.errorItem.guardian = "Guardian is required ";
            } else {
                this.errorItem.guardian = "";
            }

            if (
                this.editItem.other.first_name == null ||
                this.editItem.other.first_name == ""
            ) {
                this.errorItem.other.first_name = "Guardian Name is required";
                this.isFormValid = false;
            } else {
                this.errorItem.other.first_name = "";
            }
           if (!/^\d+$/.test(this.editItem.other.mobile)) {
                this.errorItem.other.mobile = "Please Enter Numbers only.";
                this.isFormValid = false;
            } else if (!this.editItem.other.mobile) {
                this.errorItem.other.mobile = "Mobile Number is required";
                this.isFormValid = false;
            } else {
                this.errorItem.other.mobile = "";
            }
            if (
                this.editItem.other.occupation == null ||
                this.editItem.other.occupation == ""
            ) {
                this.errorItem.other.occupation =
                    "Guardin Occupation  is required";
                this.isFormValid = false;
            } else {
                this.errorItem.other.occupation = "";
            }
            if (
                this.editItem.other.email == null ||
                this.editItem.other.email == ""
            ) {
                this.errorItem.other.email = "Email is required";
                isFormValid = false;
            } else {
                if (!this.emailRegex.test(this.editItem.other.email)) {
                    this.errorItem.other.email = "Enter valid email";
                    isFormValid = false;
                } else {
                    this.errorItem.other.email = "";
                }
            }
            if (
                this.editItem.location == null ||
                this.editItem.location == ""
            ) {
                this.errorItem.location = "Location is required";
                this.isFormValid = false;
            } else {
                this.errorItem.location = "";
            }
            if (
                this.editItem.address_line1 == null ||
                this.editItem.address_line1 == ""
            ) {
                this.errorItem.address_line1 = "Address Line 1 is required";
                this.isFormValid = false;
            } else {
                this.errorItem.address_line1 = "";
            }
            // if (
            // 	this.editItem.landmark == null ||
            // 	this.editItem.landmark == ""
            // ) {
            // 	this.errorItem.landmark = "Landmark is required";
            // 	this.isFormValid = false;
            // } else {
            // 	this.errorItem.landmark = "";
            // }
            if (this.editItem.city == null || this.editItem.city == "") {
                this.errorItem.city = "City is required";
                this.isFormValid = false;
            } else {
                this.errorItem.city = "";
            }

             if (this.editItem.pincode == null || this.editItem.pincode == "") {
                this.errorItem.pincode = "Pin Code is required";
                this.isFormValid = false;
            } else if (!/^\d+$/.test(this.editItem.pincode)) {
                this.errorItem.pincode = "Please Enter Numbers only.";
                this.isFormValid = false;
            } else {
                this.errorItem.pincode = "";
            }
            if (this.editItem.state == null || this.editItem.state == "") {
                this.errorItem.state = "State is required";
                this.isFormValid = false;
            } else {
                this.errorItem.state = "";
            }
            if (this.editItem.country == null || this.editItem.country == "") {
                this.errorItem.country = "Country is required";
                this.isFormValid = false;
            } else {
                this.errorItem.country = "";
            }
            if (this.fatherScrImage == null || this.fatherScrImage == "") {
                this.errorItem.father_image = "Father Image is required";
                this.isFormValid = false;
            } else {
                this.errorItem.father_image = "";
            }
            if (this.motherScrImage == null || this.motherScrImage == "") {
                this.errorItem.mother_image = "Mother Image is required";
                this.isFormValid = false;
            } else {
                this.errorItem.mother_image = "";
            }
            if (this.guardianScrImage == null || this.guardianScrImage == "") {
                this.errorItem.guardian_image = "Guardian Image is required";
                this.isFormValid = false;
            } else {
                this.errorItem.guardian_image = "";
            }
            return this.isFormValid;
        },

        enterValue(e) {
            if (
                e.which != 8 &&
                e.which != 9 &&
                e.which != 13 &&
                e.which != 46 &&
                (e.which < 37 || e.which > 40)
            ) {
                if (e.target.value.length >= 10) {
                    e.preventDefault();
                    return;
                }
            }

            if (!this.isNumberOnly(e)) {
                e.preventDefault();
                return;
            }
        },
        isNumberOnly(e) {
            if (
                e.which != 8 &&
                e.which != 9 &&
                e.which != 13 &&
                e.which != 46 &&
                (e.which < 37 || e.which > 40) &&
                (e.which < 48 || e.which > 57) &&
                (e.which < 96 || e.which > 105)
            )
                return false;
            return true;
        },
        fatherImageSelect(e) {
            const file = e.target.files[0];
            if (file) {
                this.fatherScrImage = URL.createObjectURL(file);
                URL.revokeObjectURL(file);
                this.fatherImageFilePath = file;
            } else {
                this.fatherScrImage = null;
                this.fatherImageFilePath = null;
            }
        },
        motherImageSelect(e) {
            const file = e.target.files[0];
            if (file) {
                this.motherScrImage = URL.createObjectURL(file);
                URL.revokeObjectURL(file);
                this.motherImageFilePath = file;
            } else {
                this.motherScrImage = null;
                this.motherImageFilePath = null;
            }
        },
        guardianImageSelect(e) {
            const file = e.target.files[0];
            if (file) {
                this.guardianScrImage = URL.createObjectURL(file);
                URL.revokeObjectURL(file);
                this.guardianImageFilePath = file;
            } else {
                this.guardianScrImage = null;
                this.guardianImageFilePath = null;
            }
        },
    },
};
</script>
<style scoped>
.section {
    margin-top: 4%;
}

.add-sibling-btn {
    font-size: 11px;
}

.imageContainer {
    width: 45%;
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

.student-photo-label {
    margin-top: 6rem !important;
    margin-left: 30px;
}

.employee_avatar {
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
    bottom: 0;
    right: 0;
}
</style>
