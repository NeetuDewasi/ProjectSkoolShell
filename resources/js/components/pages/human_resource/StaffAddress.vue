<template>
	<div>
		<div class="dashboard-content-one">
			<!-- Breadcubs Area Start -->
			<Breadcrumb
				pageTitle="Staff Address"
				:breadcrumbList="breadcrumbList"
			/>
			<!-- End Breadcubs Area -->
			<!-- Add staff Address Area Start Here -->
			<div class="row gutters-20">
				<div class="col-12">
					<div class="card height-auto">
						<div class="card-body">
							<div class="heading-layout1">
								<div class="item-title">
									<h3>Add Adress</h3>
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
											<label class="ms-0 current-address"
												>Current Address
											</label>
										</div>
										<div class="col-xl-12 col-lg-12 col-12">
											<div class="row">
												<div
													class="
														col-xl-4 col-lg-6 col-12
														form-group
													"
												>
													<label for="address_line_1"
														>Address Line 1</label
													>
													<textarea
														class="
															textarea
															form-control
														"
														v-model="
															editItem.current
																.address1
														"
														id=""
													></textarea>
												</div>
												<div
													class="
														col-xl-4 col-lg-6 col-12
														form-group
													"
												>
													<label for="address_line_2"
														>Address Line 2</label
													>
													<textarea
														class="
															textarea
															form-control
														"
														v-model="
															editItem.current
																.address2
														"
														id=""
													></textarea>
												</div>
												<div
													class="
														col-xl-4 col-lg-6 col-12
														form-group
													"
												>
													<label for="area"
														>Area</label
													>
													<input
														type="text"
														placeholder="Enter Your Area"
														class="form-control"
														v-model="
															editItem.current
																.area
														"
													/>
												</div>
												<div
													class="
														col-xl-4 col-lg-6 col-12
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
														col-xl-4 col-lg-6 col-12
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
														col-xl-4 col-lg-6 col-12
														form-group
													"
												>
													<label>Pin Code</label>
													<input
														type="text"
														placeholder="Enter Your Area Pin Code"
														class="form-control"
														v-model="
															editItem.current
																.pincode
														"
													/>
												</div>
												<div
													class="
														col-xl-4 col-lg-6 col-12
														form-group
													"
												>
													<label>City</label>
													<input
														type="text"
														placeholder="Enter Your City"
														class="form-control"
														v-model="
															editItem.current
																.city
														"
													/>
												</div>
												<div
													class="
														col-xl-4 col-lg-6 col-12
														form-group
													"
												>
													<label>State</label>
													<input
														type="text"
														placeholder="Enter Your State"
														class="form-control"
														v-model="
															editItem.current
																.state
														"
													/>
												</div>
												<div
													class="
														col-xl-4 col-lg-6 col-12
														form-group
													"
												>
													<label>country</label>
													<input
														type="text"
														placeholder="Enter Your Country"
														class="form-control"
														v-model="
															editItem.current
																.country
														"
													/>
												</div>
											</div>
										</div>
									</div>
									<div
										class="
											col-xl-12 col-lg-12 col-12
											form-group
										"
									>
										<div class="form-check">
											<input
												type="checkbox"
												class="
													form-check-input
													checkAll
												"
												id="permanent_address"
												v-model="isPermanentAddress"
												@change="setPermanentAddress()"
											/>
											<label class="form-check-label"
												>If Permanent Address is Current
												Address</label
											>
										</div>
										<div class="col-xl-12 col-lg-12 col-12">
											<div class="row">
												<div
													class="
														col-xl-4 col-lg-6 col-12
														form-group
													"
												>
													<label for="address_line_1"
														>Address Line 1</label
													>
													<textarea
														class="
															textarea
															form-control
														"
														v-model="
															editItem.permanent
																.address1
														"
														id=""
													></textarea>
												</div>
												<div
													class="
														col-xl-4 col-lg-6 col-12
														form-group
													"
												>
													<label for="address_line_2"
														>Address Line 2</label
													>
													<textarea
														class="
															textarea
															form-control
														"
														v-model="
															editItem.permanent
																.address2
														"
														id=""
													></textarea>
												</div>
												<div
													class="
														col-xl-4 col-lg-6 col-12
														form-group
													"
												>
													<label for="area"
														>Area</label
													>
													<input
														type="text"
														placeholder="Enter Your Area"
														class="form-control"
														v-model="
															editItem.permanent
																.area
														"
													/>
												</div>
												<div
													class="
														col-xl-4 col-lg-6 col-12
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
														col-xl-4 col-lg-6 col-12
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
														col-xl-4 col-lg-6 col-12
														form-group
													"
												>
													<label>Pin Code</label>
													<input
														type="text"
														placeholder="Enter Your Area Pin Code"
														class="form-control"
														v-model="
															editItem.permanent
																.pincode
														"
													/>
												</div>
												<div
													class="
														col-xl-4 col-lg-6 col-12
														form-group
													"
												>
													<label>City</label>
													<input
														type="text"
														placeholder="Ente Your City"
														class="form-control"
														v-model="
															editItem.permanent
																.city
														"
													/>
												</div>
												<div
													class="
														col-xl-4 col-lg-6 col-12
														form-group
													"
												>
													<label>State</label>
													<input
														type="text"
														placeholder="Enter Your State"
														class="form-control"
														v-model="
															editItem.permanent
																.state
														"
													/>
												</div>
												<div
													class="
														col-xl-4 col-lg-6 col-12
														form-group
													"
												>
													<label>country</label>
													<input
														type="text"
														placeholder="Enter Your Country"
														class="form-control"
														v-model="
															editItem.permanent
																.country
														"
													/>
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
											type="button"
											class="
												btn
												btn-gradient-yellow
												btn-lg
												btn-hover-bluedark
												mx-3
												text-white
											"
											@click="
												$router.push({
													name: 'admin.hr.add_staff',
												})
											"
										>
											Back
										</button>
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
					name: "Staff",
				},
				{
					to: { name: "admin.hr.add_staff" },
					name: "Staff Detial",
				},
				{
					name: "Staff Address",
				},
			],
			editItem: {
				current: {},
				permanent: {},
			},
			employee: "",
			isPermanentAddress: false,
		};
	},
	computed: {
		formBtn: function () {
			return this.$route.params.edit_id ? "update" : "save and next";
		},
	},
	mounted() {
		this.$parent.loadOtherScript();
		if (this.$route.params.employee_id) {
			// this.getEditData();
			this.employee = this.$route.params.employee_id;
		}
	},
	methods: {
		setPermanentAddress() {
			if (this.isPermanentAddress) {
				this.editItem.permanent.address1 =
					this.editItem.current.address1;
				this.editItem.permanent.address2 =
					this.editItem.current.address2;
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
				this.editItem.permanent.address1 = "";
				this.editItem.permanent.address2 = "";
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
				this.editItem.current.address1
			);
			data.append(
				"employee_current_address2",
				this.editItem.current.address2
			);
			data.append("employee_current_area", this.editItem.current.area);
			data.append(
				"employee_current_location",
				this.editItem.current.location
			);
			data.append(
				"employee_current_landmark",
				this.editItem.current.landmark
			);
			data.append(
				"employee_current_pincode",
				this.editItem.current.pincode
			);
			data.append("employee_current_city", this.editItem.current.city);
			data.append("employee_current_state", this.editItem.current.state);
			data.append(
				"employee_current_country",
				this.editItem.current.country
			);
			data.append(
				"employee_permanent_address1",
				this.editItem.permanent.address1
			);
			data.append(
				"employee_permanent_address2",
				this.editItem.permanent.address2
			);
			data.append(
				"employee_permanent_area",
				this.editItem.permanent.area
			);
			data.append(
				"employee_permanent_location",
				this.editItem.permanent.location
			);
			data.append(
				"employee_permanent_landmark",
				this.editItem.permanent.landmark
			);
			data.append(
				"employee_permanent_pincode",
				this.editItem.permanent.pincode
			);
			data.append(
				"employee_permanent_city",
				this.editItem.permanent.city
			);
			data.append(
				"employee_permanent_state",
				this.editItem.permanent.state
			);
			data.append(
				"employee_permanent_country",
				this.editItem.permanent.country
			);
			const res = await this.callApi(
				"post",
				`/api/school/hr/employee/save_address/${this.employee}`,
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
					setTimeout(() => {
						this.$router.push(
							`/admin/hr/staff_payroll_form/${data.employee.employee_id}`
						);
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
