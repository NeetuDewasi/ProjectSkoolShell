<template>
	<div>
		<div class="dashboard-content-one">
			<!-- Breadcubs Area Start -->
			<Breadcrumb
				pageTitle="Add Disabled Staff"
				:breadcrumbList="breadcrumbList"
			/>
			<!-- End Breadcubs Area -->
			<!-- Add Income Area Start Here -->
			<div class="row gutters-20">
				<div class="col-12">
					<div class="card height-auto">
						<div class="card-body">
							<div class="heading-layout1">
								<div class="item-title">
									<h3>Add Disabled Staff</h3>
								</div>
							</div>
							<form class="new-added-form">
								<div class="row">
									<div
										class="
											col-xl-12 col-lg-12 col-12
											form-group
										"
									>
										<label>Disabled Staff Name *</label>
										<input
											type="text"
											placeholder=""
											v-model="
												editItem.disabled_staff_name
											"
											class="form-control"
										/>
									</div>
									<div class="col-lg-12 col-12 form-group">
										<label>Description</label>
										<textarea
											class="textarea form-control"
											name="message"
											id="form-message"
											v-model="editItem.description"
											cols="10"
											rows="6"
										></textarea>
									</div>
									<div class="col-12 form-group mg-t-8">
										<button
											@click.prevent="submit()"
											class="
												btn-lg
												btn
												btn-gradient-yellow
												btn-hover-bluedark
												text-white
											"
										>
											{{ formBtn }}
										</button>
										<button
											type="reset"
											class="
												btn-lg btn
												bg-blue-dark
												btn-hover-yellow
												text-white
											"
										>
											Reset
										</button>
									</div>
								</div>
							</form>
						</div>
						<!-- All Subjects Area End Here -->
						<Footer />
					</div>
				</div>
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
					to: { name: "admin.dashboard" },
					name: "Home",
				},
				{
					name: "AddIncomeStaff",
				},
			],
			IncomeReport: [],
			Income: [],
			isLoaded: false,
			noData: false,
			editItem: {},
		};
	},
	mounted() {
		this.$parent.loadOtherScript();
		if (this.$route.params.edit_id) {
			this.showData();
		}
	},
	computed: {
		formBtn: function () {
			return this.$route.params.edit_id ? "Update" : "Save";
		},
	},
	methods: {
		submit() {
			if (this.$route.params.edit_id) {
				toast = Toast.fire({
					icon: "warning",
					title: "please wait ! update Data...  ",
					timer: 0,
				});
				this.updateData();
			} else {
				toast = Toast.fire({
					icon: "warning",
					title: "please wait ! save Data...  ",
					timer: 0,
				});
				this.saveData();
			}
		},
		async showData() {
			this.isLoaded = false;
			const res = await this.callApi(
				"get",
				`/api/school/income/AddIncomeStaff/editData/${this.$route.params.edit_id}`,
				null,
				headers
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.editItem = data.Income;
				} else {
					this.noData = true;
				}
			}
			this.isLoaded = true;
		},
		async saveData() {
			var formData = new FormData();
			formData.append(
				"disabled_staff_name",
				this.editItem.disabled_staff_name
			);
			formData.append("description", this.editItem.description);
			const res = await this.callApi(
				"post",
				`/api/school/income/AddIncomeStaff/save`,
				formData
			);

			if (res.status == 200) {
				toast.close();
				var data = res.data;
				if (data.status == "success") {
					toast = Toast.fire({
						icon: data.status,
						title: data.message,
						timer: 2500,
					});
				} else {
					toast = Toast.fire({
						icon: data.status,
						title: data.message,
						timer: 0,
					});
				}
			}
		},
		async updateData() {
			var formData = new FormData();
			formData.append(
				"disabled_staff_name",
				this.editItem.disabled_staff_name
			);
			formData.append("description", this.editItem.description);
			const res = await this.callApi(
				"post",
				`/api/school/income/AddIncomeStaff/update/${this.$route.params.edit_id}`,
				formData
			);

			if (res.status == 200) {
				toast.close();
				var data = res.data;
				if (data.status == "success") {
					toast = Toast.fire({
						icon: data.status,
						title: data.message,
						timer: 2500,
					});
				} else {
					toast = Toast.fire({
						icon: data.status,
						title: data.message,
						timer: 0,
					});
				}
			}
		},
	},
};
</script>


<style scoped>
</style>
