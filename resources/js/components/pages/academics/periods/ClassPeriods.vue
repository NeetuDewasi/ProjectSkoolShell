<template>
	<div>
		<div class="dashboard-content-one">
			<Breadcrumb pageTitle="Periods" :breadcrumbList="breadcrumbList" />
			<div class="row gutters-20">
				<div class="col-12">
                    <div class="
                    "> </div>
					<div class="card">
						<div class="card-body">
							<div class="heading-layout1">
								<div class="item-title">
									<h3>Create Periods</h3>
								</div>
							</div>
							<div class="row">
								<div class="col-12">
									<create-periods ref="create_period" />
								</div>
								<div
									class="
										col-12
										mt-5
										py-5
										table table-responsive
									"
									v-show="!noData"
								>
									<Table
										ref="table"
										:tableHead="tableHead"
										:tableData="tableData"
									/>
								</div>
								<NoData v-show="noData" />
							</div>
						</div>
					</div>

				</div>

				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<div
								class="
									heading-layout1
									d-flex
									justify-content-between">
								<div class="item-title">
									<h3>Assign Class Periods</h3>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="mt-3">
								<div class="row">
									<div class="col-6 form-group">
										<label
											>Select Class
											<strong class="text-danger"
												>*</strong
											></label>
										<Select2
											ref="class_list"
											:items="classes"
											placeholder="--SELECT A CLASS--"
											@change="selectClass"
										/>
										<span
											class="error-label"
											v-if="classError != ''"
											v-text="classError"
										></span>
									</div>
									<div class="col-6 form-group">
										<label
											>Select Section
											<span class="text-danger"
												>*</span
											></label
										>
										<Select2
											ref="section_list"
											:items="sections"
											placeholder="--SELECT A CLASS--"
											@change="selectSection"
										/>
										<span
											class="error-label"
											v-if="sectionError != ''"
											v-text="sectionError"
										></span>
									</div>
								</div>
							</div>
							<div class="mt-5">
								<div
									v-for="(period, index) in periods"
									:key="index"
									class="
										btn
										p-3
										m-4
										items items-name
										rounded-pill
										shadow
									"
									@click="updatePeriod(period)"
									:class="
										isSelected(period) ? 'bg-selected' : ''
									"
								>
									<div>
										<div>
											{{ period.period_name }}
										</div>
									</div>
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
import CreatePeriods from "../periods/CreatePeriods.vue";
var toast;
export default {
	components: { CreatePeriods },
	data() {
		return {
			breadcrumbList: [
				{
					to: { name: "admin.dashboard" },
					name: "Home",
				},
				{
					name: "Periods Create/Assign",
				},
			],
			isStudentPhoto: false,
			sections: [],
			classes: [],
			editItem: {},
			class_sections: [],
			selectedClassId: -1,
			editedIndex: -1,
			sectionId: -1,
			classError: "",
			sectionError: "",
			class_periods: [],
			oldClassSubject: [],
			periods: [],
			noData: false,
			tableHead: {
				items: {
					item1: { label: "Sr.No." },
					item2: { label: "Name" },
					item3: { label: "Start" },
					item4: { label: "End" },
				},
				actions: true,
			},
			tableData: [],
		};
	},

	mounted() {
		this.$parent.loadOtherScript();
	},
	created() {
		toast = Toast.fire({
			icon: "warning",
			title: "Loading data..",
			timer: 0,
		});
		this.showData();
	},
	methods: {
		async showData() {
			this.isLoaded = false;
			const res = await this.callApi(
				"get",
				`/api/school/academics/periods`,
				null
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.classes = data.classes;
					this.$refs.class_list.updateList(data.classes);
					this.periods = data.periods;
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
			this.periods.forEach((element) => {
				this.tableData.push({
					item: element,
					data: {
						item1: element.period_id,
						item2: element.period_name,
						item3: {
							type: "filter",
							value: element.period_start,
							options: {
								filter: "formatTime",
							},
						},
						item4: Vue.filter("formatTime")(element.period_end),
					},
					action: {
						edit: true,
						delete: true,
					},
				});
			});
		},
		async submitData(itemId, items) {
			this.editItem = items;
			var data = new FormData();
			data.append("name", this.editItem.period_name);
			data.append("start", this.editItem.period_start);
			data.append("end", this.editItem.period_end);
			let $url = "";
			if (itemId != -1) {
				$url = `/api/school/academics/periods/update/${itemId}`;
			} else {
				$url = `/api/school/academics/periods/save`;
			}
			const res = await this.callApi("post", $url, data);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.$refs.create_period.resetForm();
					if (this.noData) {
						this.noData = false;
					}
					toast = Toast.fire({
						icon: data.status,
						title: data.message,
						timer: 2500,
					});
					if (itemId == -1) {
						this.periods.unshift(data.period);
						this.tableData.unshift({
							item: data.period,
							data: {
								item1: data.period.period_id,
								item2: data.period.period_name,
								item3: {
									type: "filter",
									value: data.period.period_start,
									options: {
										filter: "formatTime",
									},
								},
								item4: Vue.filter("formatTime")(
									data.period.period_end
								),
							},
							action: {
								edit: true,
								delete: true,
							},
						});
						this.initTable();
					} else {
						this.initTable();
					}
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
		selectClass(val) {
			this.selectedClassId = val;
			this.classError = "";
			this.getSections(val);
			this.class_periods = [];
			this.sections = [];
		},
		async getSections(val) {
			this.classError = "";
			var formData = new FormData();
			formData.append("classId", val);
			const res = await this.callApi(
				"post",
				`/api/school/academics/periods/class/sections`,
				formData
			);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.sections = data.school_class_sections;
					this.$refs.section_list.updateList(
						data.school_class_sections
					);
					this.getClassSectionPeriods();
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
		},
		selectSection(val) {
			this.sectionId = val;
			this.getClassSectionPeriods();
			this.sectionError = "";
			this.class_periods = [];
		},
		async getClassSectionPeriods() {
			var formData = new FormData();
			formData.append("sectionId", this.sectionId);
			formData.append("classId", this.selectedClassId);
			const res = await this.callApi(
				"post",
				`/api/school/academics/assign/class/section/periods`,
				formData
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.class_periods = data.school_class_section_periods;
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
		isSelected(myPeriod) {
			var selected = false;
			if (this.class_periods.length) {
				this.class_periods.forEach((period) => {
					if (period.period_id == myPeriod.period_id) {
						selected = true;
						return true;
					}
				});
			}
			return selected;
		},
		async updatePeriod(myPeriod) {
			var selectedIndex = -1;
			if (this.class_periods.length) {
				this.class_periods.forEach((period, index) => {
					if (period.period_id == myPeriod.period_id) {
						selectedIndex = index;
						return;
					}
				});
			}

			if (selectedIndex !== -1) {
				this.class_periods.splice(selectedIndex, 1);
			} else {
				this.class_periods.push(myPeriod);
			}

			if (this.selectedClassId === -1) {
				this.classError = "class is required";
				return;
			}
			var periodsIds = [];
			this.class_periods.forEach((period) => {
				periodsIds.push(period.period_id);
			});
			var formData = new FormData();
			formData.append("period_ids[]", periodsIds);
			formData.append("class", this.selectedClassId);
			formData.append("section", this.sectionId);
			const res = await this.callApi(
				"post",
				`/api/school/academics/assign/class_section/period`,
				formData
			);

			if (res.status == 200) {
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
		},
		edit(item) {
			this.$refs.create_period.edit(item);
		},
		deleteItem(item, index) {
			SwalCustomBtn.fire({
				title: "Are you sure?",
				text: "You won't be able to revert this!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonText: "Yes, Delete it!",
				cancelButtonText: "No, cancel!",
				reverseButtons: true,
			}).then((result) => {
				if (result.isConfirmed) {
					this.deleteData(item, index);
				}
			});
		},
		async deleteData(item, index) {
			var data = new FormData();
			data.append("status", "deleted");
			const res = await this.callApi(
				"post",
				`/api/school/academics/periods/delete/${item.period_id}`,
				data
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.periods.splice(this.periods.indexOf(item), 1);
					this.tableData.splice(this.periods.indexOf(item), 1);
					SwalCustomBtn.fire("Deleted!", data.message, "success");
					if (this.periods.length == 0) {
						this.noData = true;
					}
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

