<template>
	<div>
		<div class="dashboard-content-one">
			<Breadcrumb pageTitle="Subjects" :breadcrumbList="breadcrumbList" />
			<div class="row gutters-20">
				<div class="col-12">
                    <div class="row d-flex">
                        <div class="col-4">
					<SubjectCreate ref="subjectCreate" />
				</div>
				<div class="col-8">
					<div class="card">
						<div class="card-body">
							<div class="item-title">
								<h3>Subject List</h3>
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
import SubjectCreate from "./SubjectCreate.vue";
export default {
	components: {
		SubjectCreate,
	},
	data() {
		return {
			breadcrumbList: [
				{
					to: { name: "school.dashboard" },
					name: "Home",
				},
				{
					name: "Subjects",
				},
			],
			subjectList: [],
			tableHead: {
				items: {
					item1: { label: "Sr.No." },
					item2: { label: "Subject" },
                    item3: { label: "Subject Code" },
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
			title: "Loading data..",
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
				`/api/school/academics/school_subjects/get`,
				null
			);
            this.log("Subjects",res);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.subjectList = data.school_subjects;

					this.initTable();
				} else {
					toast = Toast.fire({
						icon: data.status,
						title: data.message,
						timer: 0,
					});
					this.noData = true;
				}
			} else {
				toast = Toast.fire({
					icon: data.status,
					title: data.message,
					timer: 0,
				});
			}
			this.$refs.table.loadTable();
			this.isLoaded = true;
			toast.close();
		},
		initTable() {
			this.tableData = [];
			this.subjectList.forEach((element) => {
				this.tableData.push({
					item: element,
					data: {
						item1: element.subject_id,
						item2: element.subject_name,
                        item3: element.sub_code,
					},
					action: {
						edit: true,
						delete: true,
					},
				});
			});
		},
		edit(item) {
			this.$refs.subjectCreate.edit(item);
		},
		async submitData(items, itemId) {
			this.editItem = items;
			this.editedIndex = itemId;
			let $url = "";
			if (this.editedIndex === -1) {
				$url = `/api/school/academics/school_subjects/save`;
			} else {
				$url = `/api/school/academics/school_subjects/update/${this.editedIndex}`;
			}
			var data = new FormData();
			data.append("name", this.editItem.subject_name ? this.editItem.subject_name : '');
            data.append("subject_code", this.editItem.sub_code ? this.editItem.sub_code : '');
            data.append("subject_type", this.$refs.subjectCreate.subject_type ? this.$refs.subjectCreate.subject_type : '');
			const res = await this.callApi("post", $url, data);
			if (res.status == 200) {
				var data = res.data;
				this.$refs.subjectCreate.resetForm();
				if (data.status == "success") {
					toast = Toast.fire({
						icon: "success",
						title: data.message,
						timer: 2500,
					});
					if (this.editedIndex === -1) {
						if (this.noData) {
							this.noData = false;
						}
						this.subjectList.unshift(data.school_subject);
						this.initTable();
						// this.tableData.unshift({
						// 	item: data.school_subject,
						// 	data: {
						// 		item1: data.school_subject.subject_id,
						// 		item2: data.school_subject.subject_name,
						// 	},
						// 	action: {
						// 		edit: true,
						// 		delete: true,
						// 	},
						// });
					} else {
						this.initTable();
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
		async deleteData(item) {
			var data = new FormData();
			data.append("status", "deleted");
			const res = await this.callApi(
				"post",
				`/api/school/academics/school_subjects/delete/${item.subject_id}`,
				data
			);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.subjectList.splice(this.subjectList.indexOf(item), 1);
					// this.tableData.splice(this.subjectList.indexOf(item), 1);
					this.initTable();
                    SwalCustomBtn.fire("Deleted!", data.message, "success");
					if (this.subjectList.length == 0) {
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

