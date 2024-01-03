<template>
	<div>
		<div class="dashboard-content-one">
			<Breadcrumb
				pageTitle="Employee Create"
				:breadcrumbList="breadcrumbList"
			/>
			<div class="col-12 mb-3">
				<div
					class="btn btn-outline-secondary"
					@click="
						$router.push({
							name: 'school.hr.employees.basic_info.create',
							params: { id: $route.params.id },
						})
					"
				>
					<i class="fas fa-arrow-left" aria-hidden="true"></i> Back
				</div>
			</div>
			<div class="row gutters-20">
				<div class="col-12">
					<div class="card height-auto">
						<div class="card-body">
							<div class="heading-layout1">
								<div class="item-title">
									<h3>Employee Address Detail</h3>
								</div>
							</div>
							<form
								class="new-added-form"
								enctype="multipart/form-data"
							>
								<div class="row">
									<div
										class="
											col-xl-12 col-lg-12 col-12
											form-group
										"
									>
										<div>
											<label class="ms-0 address-label"
												>Current Address</label
											>
										</div>
										<div class="col-xl-12 col-lg-12 col-12">
											<div class="row">
												<div
													class="
														col-md-4 col-12
														form-group
													"
												>
													<label for="address_line_1"
														>Address Line 1*</label
													>
													<input
														type="text"
														placeholder="Flat/Plot/House/Apartment No."
														class="form-control"
														v-model="
															editItem.current
																.address_line1
														"
														:class="
															errorItem.current
																.address_line1 !=
															''
																? 'error-field'
																: ''
														"
													/>
													<span
														class="error-label"
														v-if="
															errorItem.current
																.address_line1 !=
															''
														"
														v-text="
															errorItem.current
																.address_line1
														"
													></span>
												</div>
												<div
													class="
														col-md-4 col-12
														form-group
													"
												>
													<label for="address_line_2"
														>Address Line 2</label
													>
													<input
														type="text"
														placeholder="Building/Block/Section No."
														class="form-control"
														v-model="
															editItem.current
																.address_line2
														"
													/>
												</div>
												<div
													class="
														col-md-4 col-12
														form-group
													"
												>
													<label for="area"
														>Area</label
													>
													<input
														type="text"
														placeholder="Area/Street/Sector"
														class="form-control"
														v-model="
															editItem.current
																.area
														"
													/>
												</div>
												<div
													class="
														col-md-4 col-12
														form-group
													"
												>
													<label>Location</label>
													<input
														type="text"
														placeholder="Enter Your Location"
														class="form-control"
														v-model="
															editItem.current
																.location
														"
													/>
												</div>
												<div
													class="
														col-md-4 col-12
														form-group
													"
												>
													<label>Land Mark</label>
													<input
														type="text"
														placeholder="Enter Your Land Mark"
														class="form-control"
														v-model="
															editItem.current
																.landmark
														"
													/>
												</div>
												<div
													class="
														col-md-4 col-12
														form-group
													"
												>
													<label>Pincode</label>
													<input
														type="text"
														placeholder="Pincode"
														class="form-control"
														v-model="
															editItem.current
																.pincode
														"
													/>
												</div>
												<div
													class="
														col-md-4 col-12
														form-group
													"
												>
													<label>City*</label>
													<input
														type="text"
														placeholder="Enter Your City"
														class="form-control"
														v-model="
															editItem.current
																.city
														"
														:class="
															errorItem.current
																.city != ''
																? 'error-field'
																: ''
														"
													/>
													<span
														class="error-label"
														v-if="
															errorItem.current
																.city != ''
														"
														v-text="
															errorItem.current
																.city
														"
													></span>
												</div>
												<div
													class="
														col-md-4 col-12
														form-group
													"
												>
													<label>State*</label>
													<input
														type="text"
														placeholder="Enter Your State"
														class="form-control"
														v-model="
															editItem.current
																.state
														"
														:class="
															errorItem.current
																.state != ''
																? 'error-field'
																: ''
														"
													/>
													<span
														class="error-label"
														v-if="
															errorItem.current
																.state != ''
														"
														v-text="
															errorItem.current
																.state
														"
													></span>
												</div>
												<div
													class="
														col-md-4 col-12
														form-group
													"
												>
													<label>Country*</label>
													<input
														type="text"
														placeholder="Enter Your Country"
														class="form-control"
														v-model="
															editItem.current
																.country
														"
														:class="
															errorItem.current
																.country != ''
																? 'error-field'
																: ''
														"
													/>
													<span
														class="error-label"
														v-if="
															errorItem.current
																.country != ''
														"
														v-text="
															errorItem.current
																.country
														"
													></span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-12 form-group">
										<div class="d-flex">
											<label
												class="ms-0 mr-5 address-label"
												>Permanent Address</label
											>
											<div class="form-check ml-5">
												<input
													type="checkbox"
													class="
														form-check-input
														checkAll
													"
													id="permanent_address"
													v-model="isSameAddress"
													@change="
														setPermanentAddress()
													"
												/>
												<label class="form-check-label">
													Same as Current
													Address</label
												>
											</div>
										</div>
										<div
											class="col-12 animate_container"
											:class="
												!isSameAddress ? 'show' : ''
											"
										>
											<div class="row">
												<div
													class="
														col-md-4 col-12
														form-group
													"
												>
													<label for="address_line_1"
														>Address Line 1*</label
													>
													<input
														type="text"
														placeholder="Flat/Plot/House/Apartment No."
														class="form-control"
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
													/>
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
													class="
														col-md-4 col-12
														form-group
													"
												>
													<label for="address_line_2"
														>Address Line 2</label
													>
													<input
														type="text"
														placeholder="Building/Block/Section No."
														class="form-control"
														v-model="
															editItem.permanent
																.address_line2
														"
													/>
												</div>
												<div
													class="
														col-md-4 col-12
														form-group
													"
												>
													<label for="area"
														>Area</label
													>
													<input
														type="text"
														placeholder="Area/Street/Sector"
														class="form-control"
														v-model="
															editItem.permanent
																.area
														"
													/>
												</div>
												<div
													class="
														col-md-4 col-12
														form-group
													"
												>
													<label>Location</label>
													<input
														type="text"
														placeholder="Enter Your Location"
														class="form-control"
														v-model="
															editItem.permanent
																.location
														"
													/>
												</div>
												<div
													class="
														col-md-4 col-12
														form-group
													"
												>
													<label>Land Mark</label>
													<input
														type="text"
														placeholder="Enter Your Land Mark"
														class="form-control"
														v-model="
															editItem.permanent
																.landmark
														"
													/>
												</div>
												<div
													class="
														col-md-4 col-12
														form-group
													"
												>
													<label>Pin Code</label>
													<input
														type="text"
														placeholder="Pincode"
														class="form-control"
														v-model="
															editItem.permanent
																.pincode
														"
													/>
												</div>
												<div
													class="
														col-md-4 col-12
														form-group
													"
												>
													<label>City*</label>
													<input
														type="text"
														placeholder="Enter Your City"
														class="form-control"
														v-model="
															editItem.permanent
																.city
														"
														:class="
															errorItem.permanent
																.city != ''
																? 'error-field'
																: ''
														"
													/>
													<span
														class="error-label"
														v-if="
															errorItem.permanent
																.city != ''
														"
														v-text="
															errorItem.permanent
																.city
														"
													></span>
												</div>
												<div
													class="
														col-md-4 col-12
														form-group
													"
												>
													<label>State*</label>
													<input
														type="text"
														placeholder="Enter Your State"
														class="form-control"
														v-model="
															editItem.permanent
																.state
														"
														:class="
															errorItem.permanent
																.state != ''
																? 'error-field'
																: ''
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
													class="
														col-md-4 col-12
														form-group
													"
												>
													<label>Country*</label>
													<input
														type="text"
														placeholder="Enter Your Country"
														class="form-control"
														v-model="
															editItem.permanent
																.country
														"
														:class="
															errorItem.permanent
																.country != ''
																? 'error-field'
																: ''
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
			<!-- Add Staff Address Area End Here -->
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
					name: "Address",
				},
			],
			employeeId: -1,
			editedIndex: -1,
			editItem: {
				current: {},
				permanent: {},
			},
			errorItem: {
				current: {
					address_line1: "",
					city: "",
					state: "",
					country: "",
				},
				permanent: {
					address_line1: "",
					city: "",
					state: "",
					country: "",
				},
			},
			employee: "",
			isSameAddress: false,
		};
	},
	computed: {
		formBtn: function () {
			return this.editedIndex != -1 ? "update & next" : "save & next";
		},
		formBtnClass: function () {
			return this.editedIndex != -1 ? "btn-warning" : "btn-success";
		},
	},
	mounted() {
		this.$parent.loadOtherScript();
		if (this.$route.params.id) {
			this.employeeId = this.$route.params.id;
			this.getAddressData();
		}
	},
	watch: {
		"editItem.current.address_line1": function (val) {
			this.errorItem.current.address_line1 = "";
			if (val == null || val == "") {
				this.errorItem.current.address_line1 =
					"Address line 1 is required";
			}
		},
		"editItem.current.city": function (val) {
			this.errorItem.current.city = "";
			if (val == null || val == "") {
				this.errorItem.current.city = "City is Required";
			}
		},
		"editItem.current.state": function (val) {
			this.errorItem.current.state = "";
			if (val == null || val == "") {
				this.errorItem.current.state = "State is required";
			}
		},
		"editItem.current.country": function (val) {
			this.errorItem.current.country = "";
			if (val == null || val == "") {
				this.errorItem.current.country = "Country is required";
			}
		},
		"editItem.permanent.address_line1": function (val) {
			this.errorItem.permanent.address_line1 = "";
			if (val == null || val == "") {
				this.errorItem.permanent.address_line1 =
					"Address line 1 is required";
			}
		},
		"editItem.permanent.city": function (val) {
			this.errorItem.permanent.city = "";
			if (val == null || val == "") {
				this.errorItem.permanent.city = "City is Required";
			}
		},
		"editItem.permanent.state": function (val) {
			this.errorItem.permanent.state = "";
			if (val == null || val == "") {
				this.errorItem.permanent.state = "State is required";
			}
		},
		"editItem.permanent.country": function (val) {
			this.errorItem.permanent.country = "";
			if (val == null || val == "") {
				this.errorItem.permanent.country = "Country is required";
			}
		},
	},
	methods: {
		async getAddressData() {
			const res = await this.callApi(
				"get",
				`/api/school/hr/employees/edit/${this.employeeId}`,
				null
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.editItem = data.employee;
					if (this.editItem.current.address_line1 != null) {
						this.editedIndex = this.editItem.employee_id;
						this.isSameAddress = this.editItem.is_same_address;
					}
				}
			}
		},
		setPermanentAddress() {
			if (this.isSameAddress) {
				this.editItem.permanent.address_line1 =
					this.editItem.current.address_line1;
				this.editItem.permanent.address_line2 =
					this.editItem.current.address_line2;
				this.editItem.permanent.area = this.editItem.current.area;
				this.editItem.permanent.location =
					this.editItem.current.location;
				this.editItem.permanent.landmark =
					this.editItem.current.landmark;
				this.editItem.permanent.pincode = this.editItem.current.pincode;
				this.editItem.permanent.city = this.editItem.current.city;
				this.editItem.permanent.state = this.editItem.current.state;
				this.editItem.permanent.country = this.editItem.current.country;
			} else {
				this.editItem.permanent.address_line1 = "";
				this.editItem.permanent.address_line2 = "";
				this.editItem.permanent.area = "";
				this.editItem.permanent.location = "";
				this.editItem.permanent.landmark = "";
				this.editItem.permanent.pincode = "";
				this.editItem.permanent.city = "";
				this.editItem.permanent.state = "";
				this.editItem.permanent.country = "";
			}
		},
		async submitForm() {
			var data = new FormData();
			data.append(
				"employee_current_address1",
				this.editItem.current.address_line1
					? this.editItem.current.address_line1
					: ""
			);
			data.append(
				"employee_current_address2",
				this.editItem.current.address_line2
					? this.editItem.current.address_line2
					: ""
			);
			data.append(
				"employee_current_area",
				this.editItem.current.area ? this.editItem.current.area : ""
			);
			data.append(
				"employee_current_location",
				this.editItem.current.location
					? this.editItem.current.location
					: ""
			);
			data.append(
				"employee_current_landmark",
				this.editItem.current.landmark
					? this.editItem.current.landmark
					: ""
			);
			data.append(
				"employee_current_pincode",
				this.editItem.current.pincode
					? this.editItem.current.pincode
					: ""
			);
			data.append(
				"employee_current_city",
				this.editItem.current.city ? this.editItem.current.city : ""
			);
			data.append(
				"employee_current_state",
				this.editItem.current.state ? this.editItem.current.state : ""
			);
			data.append(
				"employee_current_country",
				this.editItem.current.country
					? this.editItem.current.country
					: ""
			);
			data.append("is_same_address", this.isSameAddress ? 1 : 0);
			data.append(
				"employee_permanent_address1",
				this.editItem.permanent.address_line1
					? this.editItem.permanent.address_line1
					: ""
			);
			data.append(
				"employee_permanent_address2",
				this.editItem.permanent.address_line2
					? this.editItem.permanent.address_line2
					: ""
			);
			data.append(
				"employee_permanent_area",
				this.editItem.permanent.area ? this.editItem.permanent.area : ""
			);
			data.append(
				"employee_permanent_location",
				this.editItem.permanent.location
					? this.editItem.permanent.location
					: ""
			);
			data.append(
				"employee_permanent_landmark",
				this.editItem.permanent.landmark
					? this.editItem.permanent.landmark
					: ""
			);
			data.append(
				"employee_permanent_pincode",
				this.editItem.permanent.pincode
					? this.editItem.permanent.pincode
					: ""
			);
			data.append(
				"employee_permanent_city",
				this.editItem.permanent.city ? this.editItem.permanent.city : ""
			);
			data.append(
				"employee_permanent_state",
				this.editItem.permanent.state
					? this.editItem.permanent.state
					: ""
			);
			data.append(
				"employee_permanent_country",
				this.editItem.permanent.country
					? this.editItem.permanent.country
					: ""
			);

			const res = await this.callApi(
				"post",
				`/api/school/hr/employees/address/update/${this.employeeId}`,
				data
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.editItem = {};
					toast = Toast.fire({
						icon: data.status,
						title: data.message,
						timer: 2500,
					});
					this.$router.push(
						`/school/hr/employees/documents_upload/${data.employee.employee_id}`
					);
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
	},
};
</script>


<style scoped>
.address-label {
	font-size: 20px;
}
.animate_container {
	height: 0;
	transform: scale(1, 0);
	transform-origin: 0 0;
	transition: all 0.3s ease-out;
}

.animate_container.show {
	height: 350px;
	transform: scale(1, 1);
}
</style>
