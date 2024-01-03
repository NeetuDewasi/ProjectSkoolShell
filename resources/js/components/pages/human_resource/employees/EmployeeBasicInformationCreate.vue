<template>
	<div>
		<div class="dashboard-content-one">
			<Breadcrumb
				pageTitle="Employee Create"
				:breadcrumbList="breadcrumbList"
			>
				<template v-slot:button>
					<button
						type="submit"
						class="btn btn-primary btn-sm text-white"
						@click="$router.push({ name: 'school.hr.employees' })"
					>
						<i class="fa fa-eye"></i> View All Employees
					</button>
				</template>
			</Breadcrumb>
			<div class="row gutters-20">
				<div class="col-12">
					<div class="card height-auto">
						<div class="card-body">
							<div class="heading-layout1">
								<div class="item-title">
									<h3>Add New Employee</h3>
								</div>
							</div>
							<form
								class="new-added-form"
								enctype="multipart/form-data"
							>
								<div class="row">
									<div class="col-md-4 col-12 form-group">
										<label>Registration Id *</label>
										<input
											type="text"
											placeholder="Enter Registration ID"
											class="form-control"
											v-model="
												editItem.employee_registration_id
											"
											@keypress="
												errorItem.employee_registration_id =
													''
											"
											:class="
												errorItem.employee_registration_id !=
												''
													? 'error-field'
													: ''
											"
										/>
										<span
											class="error-label"
											v-if="
												errorItem.employee_registration_id !=
												''
											"
											v-text="
												errorItem.employee_registration_id
											"
										></span>
									</div>
									<div class="col-md-4 col-12 form-group">
										<label>Department *</label>
										<Select2
											ref="department_list"
											@change="selectDepartment"
											:items="department_list"
											:selectedId="selectedDepartmentId"
											:class="
												errorItem.employee_department_id !=
												''
													? 'error-field'
													: ''
											"
										/>
										<span
											class="error-label"
											v-if="
												errorItem.employee_department_id !=
												''
											"
											v-text="
												errorItem.employee_department_id
											"
										></span>
									</div>
									<div class="col-md-4 col-12 form-group">
										<label>Date Of Joining *</label>
										<DatePicker
											format="DD-MMM-YYYY"
											value-type="format"
											type="date"
											placeholder="Select a date"
											v-model="displayJoiningDate"
											:default-value="new Date()"
											:disabled-date="disabledAfterToday"
											class="
												form-control
												vue-datepicker
												my-0
											"
											:class="
												errorItem.joiningDate != ''
													? 'error-field'
													: ''
											"
										/>
										<span
											class="error-label"
											v-if="errorItem.joiningDate != ''"
											v-text="errorItem.joiningDate"
										></span>
									</div>
									<div class="col-md-4">
										<div
											class="
												rounded-1
												p-2
												text-center
												position-relative
											"
											style="border: solid 1px #00000012"
										>
											<img
												:src="employeeImageSrc"
												style="height: 180px"
											/>
											<div>Employee Photo</div>
											<input
												type="file"
												class="employee_avatar"
												accept=".png,.jpg,.jpeg"
												@change="
													selectEmployeeImageFile
												"
											/>
										</div>
									</div>
									<div class="col-md-8">
										<div class="row">
											<div
												class="
													col-md-6 col-12
													form-group
												"
											>
												<label>First Name *</label>
												<input
													type="text"
													placeholder="Enter First Name"
													class="form-control"
													v-model="
														editItem.employee_first_name
													"
													:class="
														errorItem.employee_first_name !=
														''
															? 'error-field'
															: ''
													"
												/>
												<span
													class="error-label"
													v-if="
														errorItem.employee_first_name !=
														''
													"
													v-text="
														errorItem.employee_first_name
													"
												></span>
											</div>
											<div
												class="
													col-md-6 col-12
													form-group
												"
											>
												<label>Last Name</label>
												<input
													type="text"
													placeholder="Enter Last Name"
													class="form-control"
													v-model="
														editItem.employee_last_name
													"
												/>
											</div>
											<div
												class="
													col-md-6 col-12
													form-group
												"
											>
												<label>Father Name *</label>
												<input
													type="text"
													placeholder="Enter Your Father Name"
													class="form-control"
													v-model="
														editItem.employee_father_name
													"
													:class="
														errorItem.employee_father_name !=
														''
															? 'error-field'
															: ''
													"
												/>
												<span
													class="error-label"
													v-if="
														errorItem.employee_father_name !=
														''
													"
													v-text="
														errorItem.employee_father_name
													"
												></span>
											</div>
											<div
												class="
													col-md-6 col-12
													form-group
												"
											>
												<label>Mother Name</label>
												<input
													type="text"
													placeholder="Enter Your Mother Name"
													class="form-control"
													v-model="
														editItem.employee_mother_name
													"
												/>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-12 form-group">
										<label>Email *</label>
										<input
											type="email"
											placeholder=""
											class="form-control"
											v-model="editItem.employee_email"
											:class="
												errorItem.employee_email != ''
													? 'error-field'
													: ''
											"
										/>
										<span
											class="error-label"
											v-if="
												errorItem.employee_email != ''
											"
											v-text="errorItem.employee_email"
										></span>
									</div>
									<div class="col-md-3 col-12 form-group">
										<label>Gender *</label>
										<select
											class="form-control"
											@change="
												errorItem.employee_gender = ''
											"
											v-model="editItem.employee_gender"
											:class="
												errorItem.employee_gender != ''
													? 'error-field'
													: ''
											"
										>
											<option selected disabled>
												Please Select
											</option>
											<option value="male">Male</option>
											<option value="female">
												Female
											</option>
											<option value="other">Other</option>
										</select>
										<span
											class="error-label"
											v-if="
												errorItem.employee_gender != ''
											"
											v-text="errorItem.employee_gender"
										></span>
									</div>
									<div class="col-md-3 col-12 form-group">
										<label>Date Of Birth</label>
										<input
											type="date"
											placeholder="dd/mm/yyyy"
											class="form-control"
											v-model="editItem.employee_dob"
										/>
									</div>
									<div
										class="
											col-xl-3 col-lg-6 col-12
											form-group
										"
									>
										<label>Mobile *</label>
										<input
											type="text"
											placeholder="Enter Mobile Number"
											class="form-control"
											v-model="editItem.employee_mobile"
											:class="
												errorItem.employee_mobile != ''
													? 'error-field'
													: ''
											"
										/>
										<span
											class="error-label"
											v-if="
												errorItem.employee_mobile != ''
											"
											v-text="errorItem.employee_mobile"
										></span>
									</div>
									<div
										class="
											col-xl-3 col-lg-6 col-12
											form-group
										"
									>
										<label>Emergency Contact Name</label>
										<input
											type="text"
											placeholder="Enter Contact Name"
											class="form-control"
											v-model="editItem.employee_ecp"
										/>
									</div>

									<div
										class="
											col-xl-3 col-lg-6 col-12
											form-group
										"
									>
										<label>Marital Status</label>
										<select
											class="form-control"
											v-model="
												editItem.employee_marital_status
											"
										>
											<option selected disabled>
												Please Select
											</option>
											<option value="married">
												Married
											</option>
											<option value="unmarried">
												Unmarried
											</option>
										</select>
									</div>
									<div
										class="
											col-12
											form-group
											mg-t-8
											d-flex
											justify-content-end
										"
									>
										<button
											type="submit"
											:class="formBtnClass"
											class="btn btn-fill-sm rounded text-light shadow-dodger-blue bg-dodger-blue"
											@click.prevent="submitForm()"
										>
											{{ formBtn }}
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- Add Staff Area End Here -->
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
					name: "Employees",
				},
				{
					name: "Basic Information",
				},
			],
			editedIndex: -1,
			editItem: {},
			errorItem: {
				employee_registration_id: "",
				employee_department_id: "",
				joiningDate: "",
				employee_first_name: "",
				employee_father_name: "",
				employee_email: "",
				employee_mobile: "",
				employee_gender: "",
			},
			selectedDepartmentId: -1,
			designation_list: [],
			department_list: [],
			employeeImagePath: null,
			employeeImageSrc: "/assets/img/user_icon.png",
			displayJoiningDate: "",
			joiningDate: "",
			emailRegex: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/,
			mobileRegex: /^[5-9][0-9]{9}$/,
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
	created() {
		this.getDepartmentList();
	},
	watch: {
		displayJoiningDate: function (val) {
			this.displayJoiningDate = val;
			this.joiningDate = moment(new Date(val)).format("YYYY-MM-DD");
			this.errorItem.joiningDate = "";
			if (val == null || val == "")
				this.errorItem.joiningDate = "Date of joining is required";
		},
		"editItem.employee_registration_id": function (val) {
			if (val == null || val == "") {
				this.errorItem.employee_registration_id =
					"Registration Id is required";
			}
		},
		"editItem.employee_first_name": function (val) {
			this.errorItem.employee_first_name = "";
			if (val == null || val == "") {
				this.errorItem.employee_first_name = "First Name is Required";
			}
		},
		"editItem.employee_father_name": function (val) {
			this.errorItem.employee_father_name = "";
			if (val == null || val == "") {
				this.errorItem.employee_father_name = "Father name is required";
			}
		},
		"editItem.employee_email": function (val) {
			this.errorItem.employee_email = "";
			if (val == null || val == "") {
				this.errorItem.employee_email = "Email is required";
			}
			if (val && !this.emailRegex.test(val)) {
				this.errorItem.employee_email = "Enter Valid Email Id";
            }
        },
		"editItem.employee_mobile": function (val) {
			this.errorItem.employee_mobile = "";
			if (val == null || val == "") {
				this.errorItem.employee_mobile = "Mobile is required";
			}
			if (val && !this.mobileRegex.test(val)) {
				this.errorItem.employee_mobile =
					"Enter Valid 10 Digit Mobile id";
			}
		},
	},
	mounted() {
		this.$parent.loadOtherScript();
		if (this.$route.params.id ) {
			this.editedIndex = this.$route.params.id;
			this.getEditData();
		}
		this.displayJoiningDate = moment(new Date()).format("DD-MMM-YYYY");
	},
	methods: {
		disabledAfterToday(date) {
			const today = new Date();
			today.setHours(0, 0, 0, 0);
			return date > today;
		},
		selectEmployeeImageFile(e) {
			let file = e.target.files[0];
			if (file) {
				this.employeeImageSrc = URL.createObjectURL(file);
				URL.revokeObjectURL(file);
				this.employeeImagePath = file;
			} else {
				this.employeeImageSrc = "/assets/img/user_icon.png";
				this.employeeImagePath = null;
			}
		},
		selectDepartment(val) {
			this.selectedDepartmentId = val;
			this.errorItem.employee_department_id = "";
			if (val == null || val == "" || val == -1)
				this.errorItem.employee_department_id =
					"Department ID is required";
		},
		async getEditData() {
			const res = await this.callApi(
				"get",
				`/api/school/hr/employees/edit/${this.editedIndex}`,
				null
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.editItem = data.employee;
					this.selectedDepartmentId =
						data.employee.employee_department.value;
					this.$refs.department_list.setSelected(
						this.selectedDepartmentId
					);
					this.selectDepartment(this.selectedDepartmentId);
				}
			}
		},
		async getDepartmentList() {
			const res = await this.callApi(
				"get",
				`/api/school/general/get_department_list`,
				null
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.department_list && data.department_list.length) {
					this.department_list = data.department_list;
					this.$refs.department_list.updateList(data.department_list);
				} else {
					this.department_list = [];
					this.$refs.department_list.updateList([]);
				}
			}
		},

		async submitForm() {
			var isValid = await this.validSectionForm();
			if (!isValid) {
				return;
			}
			var data = new FormData();
			data.append(
				"employee_registration_id",
				this.editItem.employee_registration_id ? this.editItem.employee_registration_id : ''
			);
			data.append("employee_department", this.selectedDepartmentId ? this.selectedDepartmentId : '');
			data.append(
				"employee_first_name",
				this.editItem.employee_first_name
			);
			data.append("employee_last_name", this.editItem.employee_last_name ? this.editItem.employee_last_name : '');
			data.append(
				"employee_father_name",
				this.editItem.employee_father_name ? this.editItem.employee_father_name : ''
			);
			data.append(
				"employee_mother_name",
				this.editItem.employee_mother_name ? this.editItem.employee_mother_name : ''
			);
			data.append("employee_email", this.editItem.employee_email ? this.editItem.employee_email : '');
			data.append("employee_gender", this.editItem.employee_gender);
			data.append("employee_dob", this.editItem.employee_dob ? this.editItem.employee_dob : '');
			data.append("employee_date_of_join", this.joiningDate);
			data.append("employee_mobile", this.editItem.employee_mobile);
			data.append("employee_ecp", this.editItem.employee_ecp ? this.editItem.employee_ecp : '');
			data.append("employee_ecn", this.editItem.employee_ecn ? this.editItem.employee_ecn : '');
			data.append(
				"employee_marital_status",
				this.editItem.employee_marital_status ? this.editItem.employee_marital_status : ''
			);
			data.append("employee_photo", this.employeeImagePath ? this.employeeImagePath : '');

			let url = "";
			if (this.editedIndex != -1) {
				url = `/api/school/hr/employees/basic_information/update/${this.editedIndex}`;
			} else {
				url = `/api/school/hr/employees/basic_information/save`;
			}
			const res = await this.callApi("post", url, data, "multipart");
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.editItem = {};
					this.$router.push(
						`/school/hr/employees/address/create/${data.employee.employee_id}`
					);

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
					icon: warning,
					title: "Something Went Wrong....",
					timer: 2500,
				});
			}
		},
		validSectionForm() {
			let isFormValid = true;
			if (
				this.editItem.employee_registration_id == null ||
				this.editItem.employee_registration_id == ""
			) {
				this.errorItem.employee_registration_id =
					"Registration Id is required";
				isFormValid = false;
			} else {
				this.errorItem.employee_registration_id = "";
			}
			if (
				this.selectedDepartmentId == null ||
				this.selectedDepartmentId == -1
			) {
				this.errorItem.employee_department_id =
					"Registration Id is required";
				isFormValid = false;
			} else {
				this.errorItem.employee_department_id = "";
			}
			if (this.joiningDate == null || this.joiningDate == "") {
				this.errorItem.joiningDate = "Date of joining is required";
				isFormValid = false;
			} else {
				this.errorItem.joiningDate = "";
			}

			if (
				this.editItem.employee_first_name == null ||
				this.editItem.employee_first_name == ""
			) {
				this.errorItem.employee_first_name = "First Name is required";
				isFormValid = false;
			} else {
				this.errorItem.employee_first_name = "";
			}

			if (
				this.editItem.employee_father_name == null ||
				this.editItem.employee_father_name == ""
			) {
				this.errorItem.employee_father_name = "Father name is required";
				isFormValid = false;
			} else {
				this.errorItem.employee_father_name = "";
			}

			if (
				this.editItem.employee_email == null ||
				this.editItem.employee_email == ""
			) {
				this.errorItem.employee_email = "Email is required";
				isFormValid = false;
			} else {
				if (!this.emailRegex.test(this.editItem.employee_email)) {
					this.errorItem.employee_email = "Enter valid email";
					isFormValid = false;
				} else {
					this.errorItem.employee_email = "";
				}
			}

			if (
				this.editItem.employee_mobile == null ||
				this.editItem.employee_mobile == ""
			) {
				this.errorItem.employee_mobile = "Mobile is required";
				isFormValid = false;
			} else {
				if (!this.mobileRegex.test(this.editItem.employee_mobile)) {
					this.errorItem.employee_mobile =
						"Enter valid mobile number";
					isFormValid = false;
				}
				this.errorItem.employee_mobile = "";
			}

			if (
				this.editItem.employee_gender == null ||
				this.editItem.employee_gender == ""
			) {
				this.errorItem.employee_gender = "Gender is required";
				isFormValid = false;
			} else {
				this.errorItem.employee_gender = "";
			}

			return isFormValid;
		},
	},
};
</script>


<style scoped>
.current-address {
	margin-left: -5px !important;
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
