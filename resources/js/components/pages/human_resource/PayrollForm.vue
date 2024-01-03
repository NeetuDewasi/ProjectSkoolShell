<template>
	<div>
		<div class="dashboard-content-one">
			<!-- Breadcubs Area Start -->
			<Breadcrumb
				pageTitle="Human Resource"
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
									<h3>Payroll Form</h3>
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
										<label>EPF Number</label>
										<input
											type="text"
											placeholder="Enter Employee EPF Number"
											class="form-control"
											v-model="editItem.payroll_epf_no"
										/>
									</div>
									<div
										class="
											col-xl-4 col-lg-6 col-12
											form-group
										"
									>
										<label>Basic Salary</label>
										<input
											type="text"
											placeholder=""
											class="form-control"
											v-model="
												editItem.payroll_basic_salary
											"
										/>
									</div>
									<div
										class="
											col-xl-4 col-lg-6 col-12
											form-group
										"
									>
										<label>Contract Type</label>
										<select
											class="form-control"
											v-model="
												editItem.payroll_contract_type
											"
										>
											<option selected disabled>
												Please Select
											</option>
											<option value="permanent">
												Permanent
											</option>
											<option value="probation">
												Probation
											</option>
										</select>
									</div>
									<div
										class="
											col-xl-4 col-lg-6 col-12
											form-group
										"
									>
										<label>Work Shift</label>
										<select
											class="form-control"
											v-model="
												editItem.payroll_working_shift
											"
										>
											<option selected disabled>
												Please Select
											</option>
											<option value="morning">
												Morning
											</option>
											<option value="evening">
												Evening
											</option>
											<option value="night">Night</option>
										</select>
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
											placeholder=""
											class="form-control"
											v-model="editItem.payroll_location"
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
													name: 'admin.hr.add_staff_address',
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
			<!-- Add Payroll Area End Here -->
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
					name: "Payroll Information",
				},
			],
			editItem: {},
			employee: "",
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
			this.employee = this.$route.params.employee_id;
		}
	},
	methods: {
		async submitForm() {
			var data = new FormData();
			data.append("payroll_employee", this.employee);
			data.append("payroll_epf_no", this.editItem.payroll_epf_no);
			data.append(
				"payroll_basic_salary",
				this.editItem.payroll_basic_salary
			);
			data.append(
				"payroll_contract_type",
				this.editItem.payroll_contract_type
			);
			data.append(
				"payroll_working_shift",
				this.editItem.payroll_working_shift
			);
			data.append("payroll_location", this.editItem.payroll_location);
			const res = await this.callApi(
				"post",
				`/api/school/hr/pay_roll/save`,
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
							`/admin/hr/staff_leave_form/${data.employee.employee_id}`
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
.add-more {
	background: #f0f1f3;
	width: 100%;
}
</style>
