<template>
	<div>
		<div class="dashboard-content-one">
			<Breadcrumb pageTitle="Hostel" :breadcrumbList="breadcrumbList" >
                <template v-slot:button>
                    <button type="submit" class="btn btn-success btn-sm text-white"  @click="$router.push({name: 'school.hostel.add_hostel'})">
                        <i class="fa fa-plus"></i> Add Hostel
                    </button>
                </template>
            </Breadcrumb>
			<div class="row gutters-20">
				<div class="col-12">
					<div class="card height-auto">
						<div class="card-body">
							<div class="heading-layout1">
								<div class="item-title">
									<h3>Hostel List</h3>
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
			<!-- Hostel List Area End Here -->
			<Footer />
		</div>
	</div>
</template>

<script>
var toast;
import AddHostelForm from "./AddHostelForm.vue";

export default {
	components: {
		AddHostelForm,
	},
	data() {
		return {
			breadcrumbList: [
				{
					to: { name: "school.dashboard" },
					name: "Home",
				},
				{
					name: "Hostel",
				},
			],
			hostels: [],
			tableHead: {
				items: {
					item1: { label: "Sr.No." },
					item2: { label: "Hostel Name" },
					item3: { label: "Hostel Type" },
					item4: { label: "Intake/Capacity" },
					item5: { label: "Warden Name" },
					item6: { label: "Contact Number" },
					item7: { label: "Email" },
					item8: { label: "Address" },
				},
				actions: true,
			},
			tableData: [],
			isLoaded: true,
			noData: false,
		};
	},
	created() {
		toast = Toast.fire({
			icon: "warning",
			title: "Loading Data..",
			timer: 0,
		});
	},
	mounted() {
		this.$parent.loadOtherScript();
		this.showData();
	},
	methods: {
		async showData() {
			this.isLoaded = false;
			const res = await this.callApi(
				"get",
				`/api/school/hostel/hostel`,
				null
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.hostels = data.hostels;
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
			this.hostels.forEach((element) => {
				this.tableData.push({
					item: element,
					data: {
						item1: element.hostel_id,
						item2: element.hostel_name,
						item3: element.hostel_type,
						item4: element.hostel_intake,
						item5: element.hostel_person,
						item6: element.hostel_number,
						item7: element.hostel_email,
						item8: `${element.hostel_address_line1} ${element.hostel_area}`,
					},
					action: {
						edit: true,
						delete: true,
					},
				});
			});
		},
		edit(item) {
			this.$router.push({
				path: `/school/edit_hostel/${item.hostel_id}`,
			});
		},
		async deleteData(item, index) {
			var data = new FormData();
			data.append("hostel_status", "deleted");
			const res = await this.callApi(
				"post",
				`/api/school/hostel/hostel/delete/${item.hostel_id}`,
				data
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.hostels.splice(index, 1);
					this.tableData.splice(index, 1);
					SwalCustomBtn.fire("Deleted!", data.message, "success");
				} else {
					toast = Toast.fire({
						icon: data.status,
						title: data.message,
						timer: 0,
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
