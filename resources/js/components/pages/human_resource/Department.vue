<template>
	<div>
		<div class="dashboard-content-one">
			<!-- Breadcubs Area Start -->
			<Breadcrumb
				pageTitle="Department"
				:breadcrumbList="breadcrumbList"
			/>
			<!-- End Breadcubs Area -->
			<!-- Add Department Area Start Here -->
			<div class="row gutters-20">
				<div class="col-12">
					<div class="card height-auto">
						<div class="card-body">
							<div class="heading-layout1">
								<div class="item-title">
									<h3>Add Department</h3>
								</div>
							</div>
							<form class="new-added-form">
								<div
									class="
										row
										gutters-20
										d-flex
										justify-content-between
									"
								>
									<div
										class="
											col-xl-9 col-lg-9 col-12
											form-group
										"
									>
										<label> Department Name *</label>
										<input
											type="text"
											placeholder="Enter Department Name"
											class="form-control"
											v-model="editItem.department_name"
										/>
									</div>
									<div
										class="
											col-xl-3 col-lg-3 col-12
											form-group
											justify-content-end
											mt-5
											ms-5
										"
									>
										<button
											type="submit"
											class="
												btn
												btn-lg
												btn-gradient-yellow
												btn-hover-bluedark
												mx-3
												text-white
												mt-4
											"
											@click.prevent="submitForm()"
										>
											{{ formBtn }}
										</button>
										<button
											type="reset"
											class="
												btn btn-lg
												bg-blue-dark
												btn-hover-yellow
												text-white
												mt-4
											"
										>
											Reset
										</button>
									</div>
								</div>
							</form>
							<div class="col-8-xxxl col-12">
								<div class="card height-auto">
									<div class="card-body">
										<div class="heading-layout1">
											<div class="item-title">
												<h3>All Department Lists</h3>
											</div>
										</div>
										<div
											class="table-responsive"
											v-if="!noData"
										>
											<table
												class="
													table
													display
													text-nowrap
												"
											>
												<thead>
													<tr>
														<th>
															<div
																class="
																	form-check
																"
															>
																<input
																	type="checkbox"
																	class="
																		form-check-input
																		checkAll
																	"
																/>
																<label
																	class="
																		form-check-label
																	"
																	>ID</label
																>
															</div>
														</th>
														<th>Name</th>
														<th>Status</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<DepartmentReport
														:departments="
															departmentItem
														"
														:index="index"
														v-for="(
															departmentItem,
															index
														) in departments"
														:key="index"
													/>
												</tbody>
											</table>
										</div>
										<div v-else>No Data Found</div>
									</div>
								</div>
							</div>
							<!-- All Department List Area End Here -->
						</div>
					</div>
				</div>
			</div>
		</div>
		<Footer />
	</div>
</template>
<script>
var toast;
import DepartmentReport from "./DepartmentReport.vue";
export default {
	components: {
		DepartmentReport,
	},
	data() {
		return {
			breadcrumbList: [
				{
					to: { name: "admin.dashboard" },
					name: "Home",
				},
				{
					name: "Department",
				},
			],
			editItem: {},
			initDepartments: [],
			departments: [],
			isLoaded: false,
			noData: false,
			editedIndex: -1,
		};
	},
	computed: {
		formBtn: function () {
			return this.editedIndex !== -1 ? "update" : "save";
		},
	},
	created() {
		toast = Toast.fire({
			icon: "warning",
			title: "Loading Data..",
			timer: 0,
		});
		this.showData();
	},
	mounted() {
		this.$parent.loadOtherScript();
	},
	methods: {
		async showData() {
			this.isLoaded = false;
			const res = await this.callApi(
				"get",
				`/api/school/hr/department`,
				null
			);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.initDepartments = JSON.parse(
						JSON.stringify(data.departments)
					);
					this.departments = data.departments;
				} else {
					toast = Toast.fire({
						icon: "error",
						title: "Something went wrong",
						timer: 2500,
					});
					this.noData = true;
				}
			}
			this.isLoaded = true;
			toast.close();
		},
		editData(item, index) {
			this.departments = JSON.parse(JSON.stringify(this.initDepartments));
			this.editItem = item;
			this.editedIndex = index;
		},
		async submitForm() {
			var data = new FormData();
			data.append("department_name", this.editItem.department_name);
			let $url = "";
			if (this.editedIndex !== -1) {
				$url = `/api/school/hr/department/update/${this.editItem.department_id}`;
			} else {
				$url = `/api/school/hr/department/save`;
			}
			const res = await this.callApi("post", $url, data);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					if (this.editedIndex !== -1) {
						this.departments[this.editedIndex].department_name =
							this.editItem.department_name;
					} else {
						this.departments.unshift(data.department);
					}
					this.editItem = {};
					this.editedIndex = -1;
					this.initDepartments = JSON.parse(
						JSON.stringify(this.departments)
					);
				}
				toast = Toast.fire({
					icon: data.status,
					title: data.message,
					timer: 2500,
				});
			} else {
				toast = Toast.fire({
					icon: "error",
					title: "Something went wrong",
					timer: 2500,
				});
			}
		},
		async deleteData(item, department_status) {
			var data = new FormData();
			data.append("department_status", department_status);
			const res = await this.callApi(
				"post",
				`/api/school/hr/department/delete/${item.department_id}`,
				data
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.departments.splice(this.departments.indexOf(item), 1);
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
