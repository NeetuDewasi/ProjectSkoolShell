<template>
	<div>
		<div class="dashboard-content-one">
			<div class="row gutters-20">
				<div class="col-12">
					<StudentHouseCreate ref="studentHouseCreate" />
				</div>

				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div class="item-title">
								<h3>Student Houses</h3>
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
import StudentHouseCreate from "./StudentHouseCreate.vue";
export default {
	components: {
		StudentHouseCreate,
	},
	data() {
		return {
			breadcrumbList: [
				{
					to: { name: "admin.dashboard" },
					name: "Home",
				},
				{
					name: "Student House",
				},
			],
			houseList: [],
			tableHead: {
				items: {
					item1: { label: "Sr.No." },
					item2: { label: "House Name" },
					item3: { label: "House Description" },
				},
				actions: true,
			},
			tableData: [],
			isLoaded: false,
			noData: false,
			editItem: {},
			editedIndex: -1,
		};
	},

	mounted() {
		this.$parent.loadOtherScript();
		toast = Toast.fire({
			icon: "warning",
			title: "Loading data...",
			timer: 2500,
		});
		this.showData();
	},
	methods: {
		async showData() {
			this.isLoaded = false;
			const res = await this.callApi(
				"get",
				`/api/school/students/student_houses`,
				null
			);
            this.log('ndngfg',res);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.houseList = data.student_houses;
					this.initTable();
				} else {
					this.noData = true;
				}
			}
			this.$refs.table.loadTable();
			this.isLoaded = true;
			toast.close();
		},
		initTable() {
			this.tableData = [];
			this.houseList.forEach((element) => {
				this.tableData.push({
					item: element,
					data: {
						item1: element.house_id,
						item2: element.name ? element.name:'',
						item3: element.description ? element.description:'',
					},
					action: {
						edit: true,
						delete: true,
					},
				});
			});
		},

		async saveData(items) {
			this.editItem = items;
			var data = new FormData();
			data.append("name", this.editItem.house_name ? this.editItem.house_name:'');
			data.append("description", this.editItem.description ? this.editItem.description:'');
			const res = await this.callApi(
				"post",
				`/api/school/students/student_houses/save`,
				data
			);

			if (res.status == 200) {
                this.$refs.studentHouseCreate.resetForm();
				var data = res.data;
				if (data.status == "success") {
                    if(this.noData){
                        this.noData = false;
                    }
					this.houseList.unshift(data.student_house);
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
                this.tableData.unshift({
                    item:data.student_house,
                    data:{
                        item1:data.student_house.house_id,
                        item2:data.student_house.house_name,
                        item3:data.student_house.description,
                    },
                   action: {
						edit: true,
						delete: true,
					},
                });
			}
		},
		edit(item) {
			this.$refs.studentHouseCreate.edit(item);
			window.scrollTo(0, 0);
			this.editItem = item;
			this.editedIndex = item.house_id;
		},
		async updateData() {
			var data = new FormData();
			data.append("name", this.editItem.house_name ? this.editItem.house_name:'');
			data.append("description", this.editItem.description ? this.editItem.description:'');

			const res = await this.callApi(
				"post",
				`/api/school/students/student_houses/update/${this.editedIndex}`,
				data
			);
			if (res.status == 200) {
                this.$refs.studentHouseCreate.resetForm();
				var data = res.data;
				if (data.status == "success") {
					this.initTable();
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
			}
		},
		async deleteData(item, index) {
			var data = new FormData();
			data.append("status", "deleted");
			const res = await this.callApi(
				"post",
				`/api/school/students/student_houses/delete/${item.house_id}`,
				data
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.houseList.splice(this.houseList.indexOf(item), 1);
					this.tableData.splice(this.houseList.indexOf(item), 1);
					SwalCustomBtn.fire("Deleted!", data.message, "success");
					if (this.houseList.length == 0) {
						this.noData = true;
					}
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
			}
		},
	},
};
</script>

