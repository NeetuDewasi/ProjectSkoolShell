<template>
	<div>
		<div class="dashboard-content-one">
			<Breadcrumb
				pageTitle="Fees Type"
				:breadcrumbList="breadcrumbList"
			/>
			<div class="row gutters-20">
				<div class="col-5">
					<AddFeesType ref="fees_types" />
				</div>
				<div class="col-7">
					<div class="card height-auto">
						<div class="card-body">
							<div class="heading-layout1">
								<div class="item-title">
									<h3>All Fees Type</h3>
								</div>
							</div>
							<div
								class="table table-responsive"
								v-show="!noData"
							>
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
import AddFeesType from "./AddFeesType.vue";
export default {
	components: {
		AddFeesType,
	},
	data() {
		return {
			breadcrumbList: [
				{
					to: { name: "school.dashboard" },
					name: "Home",
				},
				{
					name: "Fees Type",
				},
			],
			fees_types: [],
			initFeesTypes: [],
			tableHead: {
				items: {
					item1: { label: "Sr.No." },
					item2: { label: "Name" },
					item3: { label: "Fees Code" },
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
				`/api/school/fees_collection/fees_types`,
				null
			);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.initFeesTypes = JSON.parse(
						JSON.stringify(data.fees_types)
					);
					this.fees_types = data.fees_types;
					this.initTable();
				} else {
					toast = Toast.fire({
						icon: "error",
						title: "Something went wrong",
						timer: 2500,
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
			this.fees_types.forEach((element) => {
				this.tableData.push({
					item: element,
					data: {
						item1: element.fees_type_id,
						item2: element.fees_type_name,
						item3: element.fees_type_fees_code,
					},
					action: {
						edit: true,
						delete: true,
					},
				});
			});
		},
		async submitForm(item, itemId) {
			this.editItem = item;
			this.editedIndex = itemId;
			var data = new FormData();
			data.append(
				"fees_type_name",
				this.editItem.fees_type_name ? this.editItem.fees_type_name : ""
			);
			data.append(
				"fees_type_fees_code",
				this.editItem.fees_type_fees_code
					? this.editItem.fees_type_fees_code
					: ""
			);
			data.append(
				"fees_type_description",
				this.editItem.fees_type_description
					? this.editItem.fees_type_description
					: ""
			);
			let $url = "";
			if (this.editedIndex !== -1) {
				$url = `/api/school/fees_collection/fees_types/update/${this.editedIndex}`;
			} else {
				$url = `/api/school/fees_collection/fees_types/save`;
			}
			const res = await this.callApi("post", $url, data);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					if (this.noData) {
						this.noData = false;
					}
					this.editItem = {};
					if (this.editedIndex !== -1) {
						// if (this.editIndex !== -1) {
							this.initTable();
						// }
					} else {
						this.fees_types.unshift(data.fees_type);
						var element = data.fees_type;
						this.tableData.unshift({
							item: element,
							data: {
								item1: element.fees_type_id,
								item2: element.fees_type_name,
								item3: element.fees_type_fees_code,
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
			this.$refs.fees_types.edit(item);
			this.editedIndex = item.fees_type_id;
		},
		async deleteData(item, index) {
			var data = new FormData();
			data.append("fees_type_status", "deleted");
			const res = await this.callApi(
				"post",
				`/api/school/fees_collection/fees_types/delete/${item.fees_type_id}`,
				data
			);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.fees_types.splice(index, 1);
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
					timer: 2500,
				});
			}
		},
	},
};
</script>


<style scoped>
</style>
