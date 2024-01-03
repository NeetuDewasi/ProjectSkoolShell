<template>
	<div>
		<div class="dashboard-content-one">
			<Breadcrumb
				pageTitle="Assignments"
				:breadcrumbList="breadcrumbList"
			/>

      <div class="row gutters-20">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="item-title text-center bg-danger">
                <h3>Assignment List</h3>
              </div>
              <!-- <div class="table" v-show="!noData">
                <Table ref="table" :tableData="filterData" :tableHead="tableHead" />
              </div>
              <NoData v-show="noData" />-->
							<div class="row">
								<div class="col-12">
									<label>Content Title :</label>
									{{ content.upload_title }}
								</div>
								<div class="col-12">
									<label>Class :</label>
									{{ content.upload_school_class }}
								</div>
								<div class="col-12">
									<label>Section :</label>
									{{ content.upload_school_section }}
								</div>
								<div class="col-12">
									<label>Content type :</label>
									{{ content.upload_content_type }}
								</div>
								<div class="col-12">
									<label>Upload Date :</label>
									{{ content.upload_published_at }}
								</div>
								<div class="col-12">
									<label>Description :</label>
									{{ content.upload_description }}
								</div>
								<div class="col-12">
									<label>Uploaded Document :</label>

									<img :src="content.upload_documents" />
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<Footer />
	</div>
</template>

<script>
// var toast;
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
        this.student_admission_id = this.$route.params.id;
        this.log('IIIIIDDDDDD', this.student_admission_id);
        if (this.$route.params.id) {
            this.editedIndex = this.$route.params.id;

            this.getEditItemData();
        }
    },
    computed: {
        formBtn: function () {
            return this.editedIndex != -1 ? "Update & Next" : "Save & Next";
        },
        formBtnClass: function () {
            return this.editedIndex != -1 ? 'btn-warning' : 'btn-success';
        }
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
        async getEditItemData() {
            const res = await this.callApi(
                "get",
                `/api/school/students/student_guardian_details/edit/${this.editedIndex}`,
                null,
            );
            this.log('EDIT ITEM', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.editItem = data.edit_guardian;
                    this.guardianScrImage =
                        data.edit_guardian.other.photo;
                    this.fatherScrImage = data.edit_guardian.father.photo;
                    this.motherScrImage = data.edit_guardian.mother.photo;

                }
            }
        },

        checkGuardian() {
            if (this.editItem.guardian == "father") {
                this.editItem.other = this.editItem.father;
                this.guardianScrImage = this.fatherScrImage;
                this.guardianImageFilePath = this.fatherImageFilePath;
            } else if (this.editItem.guardian == "mother") {
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

            data.append("father_first_name", this.editItem.father.first_name ? this.editItem.father.first_name : '');
            data.append("father_middle_name", this.editItem.father.middle_name ? this.editItem.father.middle_name : '');
            data.append("father_last_name", this.editItem.father.last_name ? this.editItem.father.last_name : '');
            data.append("father_mobile", this.editItem.father.mobile ? this.editItem.father.mobile : '');
            data.append(
                "father_alternative_mobile",
                this.editItem.father.alternative_mobile ? this.editItem.father.alternative_mobile : ''
            );
            data.append("father_occupation", this.editItem.father.occupation ? this.editItem.father.occupation : '');
            data.append("father_email", this.editItem.father.email ? this.editItem.father.email : '');
            data.append(
                "father_alternate_email",
                this.editItem.father.alternate_email ? this.editItem.father.alternate_email : ''
            );
            data.append(
                "father_image",
                this.fatherImageFilePath ? this.fatherImageFilePath : ""
            );
            data.append("mother_first_name", this.editItem.mother.first_name ? this.editItem.mother.first_name : '');
            data.append("mother_middle_name", this.editItem.mother.middle_name ? this.editItem.mother.middle_name : '');
            data.append("mother_last_name", this.editItem.mother.last_name ? this.editItem.mother.last_name : '');
            data.append("mother_mobile", this.editItem.mother.mobile ? this.editItem.mother.mobile : '');
            data.append(
                "mother_alternative_mobile",
                this.editItem.mother.alternative_mobile ? this.editItem.mother.alternative_mobile : ''
            );
            data.append("mother_occupation", this.editItem.mother.occupation ? this.editItem.mother.occupation : '');
            data.append("mother_email", this.editItem.mother.email ? this.editItem.mother.email : '');
            data.append(
                "mother_alternate_email",
                this.editItem.mother.alternate_email ? this.editItem.mother.alternate_email : ''
            );
            data.append(
                "mother_image",
                this.motherImageFilePath ? this.motherImageFilePath : ""
            );
            data.append("guardian_first_name", this.editItem.other.first_name ? this.editItem.other.first_name : '');
            data.append(
                "guardian_middle_name",
                this.editItem.other.middle_name ? this.editItem.other.middle_name : ''
            );
            data.append("guardian_last_name", this.editItem.other.last_name ? this.editItem.other.last_name : '');
            data.append("guardian_mobile", this.editItem.other.mobile ? this.editItem.other.mobile : '');
            data.append(
                "guardian_alternative_mobile",
                this.editItem.other.alternate_mobile
            );
            data.append("guardian_occupation", this.editItem.other.occupation);
            data.append("guardian_email", this.editItem.other.email ? this.editItem.other.email : '');
            data.append(
                "guardian_alternate_email",
                this.editItem.other.alternate_email ? this.editItem.other.alternate_email : ''
            );
            data.append(
                "guardian_image",
                this.guardianImageFilePath ? this.guardianImageFilePath : ""
            );
            data.append("guardian_relation", this.editItem.other.relation ? this.editItem.other.relation : '');
            data.append("address_line1", this.editItem.address_line1);
            data.append("address_line2", this.editItem.address_line2 ? this.editItem.address_line2 : '');
            data.append("location", this.editItem.location ? this.editItem.location : '');
            data.append("landmark", this.editItem.landmark ? this.editItem.landmark : '');
            data.append("city", this.editItem.city ? this.editItem.city : '');
            data.append("pincode", this.editItem.pincode ? this.editItem.pincode : '');
            data.append("state", this.editItem.state ? this.editItem.state : '');
            data.append("country", this.editItem.country ? this.editItem.country : '');
            let url = '';
            if (this.editedIndex != -1) {
                url = `/api/school/students/student_guardian_details/update/${this.editedIndex}`
            } else {
                url = `/api/school/students/student_guardian_details/save`;
            }
            const res = await this.callApi(
                "post",
                url,
                data,
                "multipart"
            );
            this.log('SAVED ITEMS', res)
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
                        title: 'Something Went Wrong....',
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
            if (
                this.editItem.father.mobile == null ||
                this.editItem.father.mobile == ""
            ) {
                this.errorItem.father.mobile = "Father mobile is required";
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
                this.errorItem.father.email = "Father Email is required";
                this.isFormValid = false;
            } else {
                this.errorItem.father.email = "";
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
            if (
                this.editItem.mother.mobile == null ||
                this.editItem.mother.mobile == ""
            ) {
                this.errorItem.mother.mobile = "Mother Mobile is required";
                this.isFormValid = false;
            } else {
                this.errorItem.mother.mobile = "";
            }

            if (
                this.editItem.mother.email == null ||
                this.editItem.mother.email == ""
            ) {
                this.errorItem.mother.email = "Mother Email is required";
                this.isFormValid = false;
            }
            //  else {
            // if(!this.emailRegex.test(this.editItem.mother.email)) {
            //         this.errorItem.mother.email = "Enter valid email";
            //         isFormValid = false;
            //     }
            else {
                this.errorItem.mother.email = "";
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
                this.editItem.guardian == null ||
                this.editItem.guardian == ""
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
            if (
                this.editItem.other.mobile == null ||
                this.editItem.other.mobile == ""
            ) {
                this.errorItem.other.mobile = "Guardian mobile is required";
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
                this.errorItem.other.email = "Guardin Email is required";
                this.isFormValid = false;
            } else {
                this.errorItem.other.email = "";
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
            if (
                this.fatherImageFilePath == null ||
                this.fatherImageFilePath == ""
            ) {
                this.errorItem.father_image = "Father Image is required";
                this.isFormValid = false;
            } else {
                this.errorItem.father_image = "";
            }
            if (
                this.motherImageFilePath == null ||
                this.motherImageFilePath == ""
            ) {
                this.errorItem.mother_image = "Mother Image is required";
                this.isFormValid = false;
            } else {
                this.errorItem.mother_image = "";
            }
            if (
                this.guardianImageFilePath == null ||
                this.guardianImageFilePath == ""
            ) {
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
