<template>
	<div>
		<div class="dashboard-content-one">
			<!-- Breadcubs Area Start -->
			<Breadcrumb
				pageTitle="Staff Details"
				:breadcrumbList="breadcrumbList"
			/>
			<!-- End Breadcubs Area -->
			<!-- Add staff Area Start Here -->
			<div class="row gutters-20">
				<div class="col-12">
					<div class="card height-auto">
						<div class="card-body">
							<div class="heading-layout1">
								<div class="item-title">
									<h3>Add New Staff</h3>
								</div>
							</div>
							<form
								class="new-added-form"
								enctype="multipart/form-data"
							>
								<div class="row">
									<div
										class="
											col-xl-4 col-lg-6 col-12
											form-group
										"
									>
										<label>Staff Id *</label>
										<input
											type="text"
											placeholder="Enter Staff ID"
											class="form-control"
											v-model="editItem.employee_staff_id"
										/>
									</div>
									<div
										class="
											col-xl-4 col-lg-6 col-12
											form-group
										"
									>
										<label>Designation *</label>
										<Select2
											ref="designation_list"
											:items="designation_list"
										/>
									</div>
									<div
										class="
											col-xl-4 col-lg-6 col-12
											form-group
										"
									>
										<label>Department *</label>
										<Select2
											ref="department_list"
											:items="department_list"
										/>
									</div>
									<div
										class="
											col-xl-3 col-lg-6 col-12
											form-group
										"
									>
										<label>First Name *</label>
										<input
											type="text"
											placeholder="Enter First Name"
											class="form-control"
											v-model="editItem.employee_f_name"
										/>
									</div>
									<div
										class="
											col-xl-3 col-lg-6 col-12
											form-group
										"
									>
										<label>Last Name *</label>
										<input
											type="text"
											placeholder="Enter Last Name"
											class="form-control"
											v-model="editItem.employee_l_name"
										/>
									</div>
									<div
										class="
											col-xl-3 col-lg-6 col-12
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
										/>
									</div>
									<div
										class="
											col-xl-3 col-lg-6 col-12
											form-group
										"
									>
										<label>Mother Name *</label>
										<input
											type="text"
											placeholder="Enter Your Mother Name"
											class="form-control"
											v-model="
												editItem.employee_mother_name
											"
										/>
									</div>
									<div
										class="
											col-xl-3 col-lg-6 col-12
											form-group
										"
									>
										<label>Email(Login Username) *</label>
										<input
											type="email"
											placeholder=""
											class="form-control"
											v-model="editItem.employee_email"
										/>
									</div>
									<div
										class="
											col-xl-3 col-lg-6 col-12
											form-group
										"
									>
										<label>Gender *</label>
										<select
											class="form-control"
											v-model="editItem.employee_gender"
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
									</div>
									<div
										class="
											col-xl-3 col-lg-6 col-12
											form-group
										"
									>
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
										<label>Date Of Joining</label>
										<input
											type="date"
											placeholder="dd/mm/yyyy"
											class="form-control"
											v-model="
												editItem.employee_date_of_join
											"
										/>
									</div>
									<div
										class="
											col-xl-3 col-lg-6 col-12
											form-group
										"
									>
										<label>Phone</label>
										<input
											type="phone"
											placeholder="Entet your Phone Number"
											class="form-control"
											v-model="editItem.employee_phone"
										/>
									</div>
									<div
										class="
											col-xl-3 col-lg-6 col-12
											form-group
										"
									>
										<label>Emergency Contact Number</label>
										<input
											type="phone"
											placeholder="Enter Your Alternate Number"
											class="form-control"
											v-model="
												editItem.employee_alt_phone
											"
										/>
									</div>
									<div
										class="
											col-xl-3 col-lg-6 col-12
											form-group
										"
									>
										<label>Marital Status *</label>
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
											col-xl-3 col-lg-6 col-12
											form-group
										"
									>
										<label class="text-dark-medium"
											>Photo</label
										>
										<input
											type="file"
											class="form-control-file"
										/>
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
											class="
												btn
												btn-lg
												btn-gradient-yellow
												btn-hover-bluedark
												text-white
											"
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
					name: "Staff",
				},
				{
					name: "Staff Detial",
				},
				{
					name: "Basic Information",
				},
			],
			editItem: {},
			designation_list: [],
			department_list: [],
		};
	},
	computed: {
		formBtn: function () {
			return this.$route.params.edit_id ? "update" : "save and next";
		},
	},
	created() {
		this.getDesignationDepartmentData();
	},
	mounted() {
		this.$parent.loadOtherScript();
		if (this.$route.params.edit_id) {
			this.getEditData();
		}
	},
	methods: {
		async getEditData() {
			const res = await this.callApi(
				"get",
				`/api/school/hr/employee/edit/${this.$route.params.edit_id}`,
				null
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					//
					this.editItem = data.employee;
					this.editedIndex = -1;
				}
			}
			// toast.close();
		},
		async getDesignationDepartmentData() {
			const res = await this.callApi(
				"get",
				`/api/school/hr/employee/data_list`,
				null
			);

			if (res.status == 200) {
				var data = res.data;
				this.designation_list = data.designation_list;
				this.$refs.designation_list.updateList(data.designation_list);
				this.department_list = data.department_list;
				this.$refs.department_list.updateList(data.department_list);
			}
		},

		async submitForm() {
			var data = new FormData();
			data.append("employee_designation", 1);
			data.append("employee_department", 1);
			data.append("employee_staff_id", this.editItem.employee_staff_id);
			data.append("employee_f_name", this.editItem.employee_f_name);
			data.append("employee_l_name", this.editItem.employee_l_name);
			data.append(
				"employee_father_name",
				this.editItem.employee_father_name
			);
			data.append(
				"employee_mother_name",
				this.editItem.employee_mother_name
			);
			data.append("employee_email", this.editItem.employee_email);
			data.append("employee_gender", this.editItem.employee_gender);
			data.append("employee_dob", this.editItem.employee_dob);
			data.append(
				"employee_date_of_join",
				this.editItem.employee_date_of_join
			);
			data.append("employee_phone", this.editItem.employee_phone);
			data.append("employee_alt_phone", this.editItem.employee_alt_phone);
			data.append(
				"employee_marital_status",
				this.editItem.employee_marital_status
			);
			data.append("employee_photo", null);

			let apiUrl = "";
			let routeUrl = "";
			if (this.$route.params.edit_id) {
				apiUrl = `/api/school/hr/employee/save_address/${this.$route.params.edit_id}`;
			} else {
				apiUrl = `/api/school/hr/employee/save`;
			}
			const res = await this.callApi("post", apiUrl, data);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.editItem = {};
					this.$router.push(
						`/admin/hr/add_staff_address/${data.employee.employee_id}`
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
					icon: warnning,
					title: "Somthing Went Wrong....",
					timer: 2500,
				});
			}
		},
	},
};
</script>


<style scoped>
.current-address {
	margin-left: -5px !important;
}
</style>
