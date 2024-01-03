
<template>
	<div>
		<div class="dashboard-content-one">
			<Breadcrumb
				pageTitle="Complain Type "
				:breadcrumbList="breadcrumbList"
			/>
			<div class="row gutters-20">
				<div class="col-5">
					<AddComplainTypeForm ref="complain_types" />
				</div>
				<div class="col-7">
					<div class="card height-auto">
						<div class="card-body">
							<div class="heading-layout1">
								<div class="item-title">
									<h3>All Complain Type</h3>
								</div>
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
import AddComplainTypeForm from "./AddComplainTypeForm.vue";
export default {
	components: {
		AddComplainTypeForm,
	},
	data() {
		return {
			breadcrumbList: [
				{
					to: { name: "school.dashboard" },
					name: "Home",
				},
				{
					name: "Complain Type",
				},
			],
			complain_types: [],
			initComplainTypes: [],
			tableHead: {
				items: {
					item1: { label: "Sr.No." },
					item2: { label: "Complain Type Name" },
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
				`/api/school/front_office/complain_type`,
				null
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.initComplainTypes = JSON.parse(
						JSON.stringify(data.complain_types)
					);
					this.complain_types = data.complain_types;
					this.initTable();
				} else {
					toast = Toast.fire({
						icon: "error",
						title: "Something went wrong",
						timer: 0,
					});
					this.noData = true;
				}
			}
			this.$refs.table.loadTable();
			this.isLoaded = true;
			toast.close();
		},
		initTable() {
			this.tableData = [];
			this.complain_types.forEach((element) => {
				this.tableData.push({
					item: element,
					data: {
						item1: element.complain_type_id,
						item2: element.complain_type_name,
					},
					action: {
						edit: true,
						delete: true,
					},
				});
			});
		},
		async submitForm(item) {
			this.editItem = item;
			// this.editedIndex = itemId;
			var data = new FormData();
			data.append(
				"complain_type_name",
				this.editItem.complain_type_name
					? this.editItem.complain_type_name
					: ""
			);
			data.append(
				"complain_type_description",
				this.editItem.complain_type_description
					? this.editItem.complain_type_description
					: ""
			);
			let $url = "";
			if (this.editedIndex !== -1) {
				$url = `/api/school/front_office/complain_type/update/${this.editItem.complain_type_id}`;
			} else {
				$url = `/api/school/front_office/complain_type/save`;
			}
			const res = await this.callApi("post", $url, data);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.editItem = {};
					if (this.noData) {
						this.noData = false;
					}
					if (this.editedIndex !== -1) {
						if (this.editIndex !== -1) {
							this.initTable();
						}
					} else {
						this.complain_types.unshift(data.complain_type);
						var element = data.complain_type;
						this.tableData.unshift({
							item: element,
							data: {
								item1: element.complain_type_id,
								item2: element.complain_type_name,
							},
							action: {
								edit: true,
								delete: true,
							},
						});
					}
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
			this.editedIndex = -1;
		},
		edit(item) {
			this.$refs.complain_types.edit(item);
			this.editedIndex = item.complain_type_id;
		},
		async deleteData(item, index) {
			var data = new FormData();
			data.append("complain_type_status", "deleted");
			const res = await this.callApi(
				"post",
				`/api/school/front_office/complain_type/delete/${item.complain_type_id}`,
				data
			);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.complain_types.splice(index, 1);
					this.tableData.splice(index, 1);
					SwalCustomBtn.fire("Deleted!", data.message, "success");
				} else {
					toast = Toast.fire({
						icon: data.status,
						title: data.message,
						timer: 2500,
					});
				}
			} else {
				toast = Toast.fire({
					icon: "error",
					title: "Something Went Wrong, Not able to delete",
					timer: 0,
				});
			}
		},
	},
};
</script>


<style scoped>
</style>
