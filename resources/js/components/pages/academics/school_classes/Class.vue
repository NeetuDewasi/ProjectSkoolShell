<template>
	<div>
		<div class="dashboard-content-one">
			<Breadcrumb pageTitle="Class" :breadcrumbList="breadcrumbList" />
			<div class="row gutters-20">
				<div class="col-12">
                    <div class="row d-flex">
                        <div class="col-4">
					<ClassCreate />
				</div>
				<div class="col-8">
					<div class="card">
						<div class="card-body">
							<div class="item-title">
								<h3>Classes</h3>
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
            </div>
            </div>
			<Footer />
		</div>
	</div>
</template>

<script>
var toast;
import ClassCreate from "./ClassCreate.vue";
export default {
	components: {
		ClassCreate,
	},
	data() {
		return {
			breadcrumbList: [
				{
					to: { name: "admin.dashboard" },
					name: "Home",
				},
				{
					name: "Class",
				},
			],
			classList: [],
			tableHead: {
				items: {
					item1: { label: "Sr.No." },
					item2: { label: "Class" },
				},
				actions: true,
			},
			tableData: [],
			isLoaded: false,
			noData: false,
			editItem: {
				class_number: "",
			},
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
				`/api/school/academics/school_classes`,
				null
			);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.classList = data.school_classes;
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
			this.classList.forEach((element) => {
				this.tableData.push({
					item: element,
					data: {
						item1: element.class_id,
						item2: element.class_name,
					},
					action: {
						delete: true,
					},
				});
			});
		},
		async saveData(items) {
			this.editItem = items;
			var data = new FormData();
			data.append("number", this.editItem.class_number);
			const res = await this.callApi(
				"post",
				`/api/school/academics/school_classes/save`,
				data
			);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					if (this.noData) {
						this.noData = false;
					}
					this.classList.unshift(data.school_class);
					this.tableData.unshift({
						item: data.school_class,
						data: {
							item1: data.school_class.class_id,
							item2: data.school_class.class_name,
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
			} else {
				toast = Toast.fire({
					icon: data.status,
					title: data.message,
					timer: 2500,
				});
			}
		},

		async deleteData(item) {
			var data = new FormData();
			data.append("status", "deleted");
			const res = await this.callApi(
				"post",
				`/api/school/academics/school_classes/delete/${item.class_id}`,
				data
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.classList.splice(this.classList.indexOf(item), 1);
					// this.tableData.splice(this.classList.indexOf(item), 1);
					this.initTable();
					SwalCustomBtn.fire("Deleted!", data.message, "success");
					if (this.classList.length == 0) {
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

