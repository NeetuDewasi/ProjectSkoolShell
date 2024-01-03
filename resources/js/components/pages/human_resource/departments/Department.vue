<template>
	<div>
		<div class="dashboard-content-one">
			<Breadcrumb
				pageTitle="Departments"
				:breadcrumbList="breadcrumbList"
			/>
			<div class="row gutters-20">
				<div class="col-12">
					<DepartmentCreate ref="departmentCreate" />
				</div>
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div class="item-title">
								<h3>Department List</h3>
							</div>
							<div class="table" v-show="!noData">
								<Table
									ref="table"
									:tableData="tableData"
									:tableHead="tableHead"
								/>
							</div>
							<NoData v-show="noData" />
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
import DepartmentCreate from "./DepartmentCreate.vue";
export default {
	components: { DepartmentCreate },
	data() {
		return {
			breadcrumbList: [
				{
					to: { name: "admin.dashboard" },
					name: "Home",
				},
				{
					name: "Departments",
				},
			],
			departments: [],
			tableHead: {
				items: {
					item1: { label: "Sr.No." },
					item2: { label: "Department Name" },
				},
				actions: true,
			},
			tableData: [],
			isLoaded: false,
			noData: false,
		};
	},
	created() {
		toast = Toast.fire({
			icon: "warning",
			title: "Loading data...",
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
				`/api/school/hr/departments`,
				null
			);
			this.log('departments',res);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.departments = data.departments;
					this.initTable();
				} else {
					toast = Toast.fire({
						icon: data.status,
						title: data.message,
						timer: 2500,
					});
					this.noData = true;
				}
			} else {
				toast = Toast.fire({
					icon: data.status,
					title: data.message,
					timer: 2500,
				});
			}
			this.$refs.table.loadTable();
			this.isLoaded = true;
			toast.close();
		},
		initTable() {
			this.tableData = [];
			this.departments.forEach((element) => {
				this.tableData.push({
					item: element,
					data: {
						item1: element.department_id,
						item2: element.department_name,
					},
					action: {
						delete: true,
					},
				});
			});
		},
		async submitData(editItem, index) {
			var data = new FormData();
			data.append("department_name", editItem.department_name);
			let url = `/api/school/hr/departments/save`;
			if (index != -1) {
				url = `/api/school/hr/departments/update/${editItem.department_id}`;
			}
			const res = await this.callApi("post", url, data);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					if (this.noData) {
						this.noData = false;
					}
					if (index != -1) {
						this.departments.splice(index, 1);
					}
					this.departments.unshift(data.department);
					this.tableData.unshift({
						item: data.department,
						data: {
							item1: data.department.department_id,
							item2: data.department.department_name,
						},
						action: {
							delete: true,
						},
					});
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

				this.$refs.departmentCreate.reset();
			} else {
				toast = Toast.fire({
					icon: data.status,
					title: data.message,
					timer: 2500,
				});
			}
		},
		edit(item) {
			this.$refs.departmentCreate.edit(item);
			window.scrollTo(0, 0);
		},
		async deleteData(item, index) {
			var data = new FormData();
			data.append("department_status", "deleted");
			const res = await this.callApi(
				"post",
				`/api/school/hr/departments/delete/${item.department_id}`,
				data
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.departments.splice(index, 1);
					this.initTable();
					SwalCustomBtn.fire("Deleted!", data.message, "success");
					if (this.departments.length == 0) {
						this.noData = true;
					}
				} else {
					toast = Toast.fire({
						icon: data.status,
						title: data.message,
						timer: 0,
					});
				}
			} else {
				toast = Toast.fire({
					icon: data.status,
					title: data.message,
					timer: 0,
				});
			}
		},
	},
};
</script>

