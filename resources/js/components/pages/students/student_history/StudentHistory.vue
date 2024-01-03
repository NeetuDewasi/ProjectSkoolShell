<template>
	<div>
		<div class="dashboard-content-one">
			<Breadcrumb
				pageTitle="Student History "
				:breadcrumbList="breadcrumbList"
			/>
			<div class="row gutters-20">
				<div class="col-12">
					<StudentHistoryCreate ref="HistoryCreate" />
				</div>
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div class="col-12">
								<div class="card">
									<div class="card-body">
										<div class="item-title">
											<h3>History</h3>
										</div>
										<div
											class="table-responsive"
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
			</div>
		</div>
	</div>
</template>

<script>
var toast;
import StudentHistoryCreate from "./StudentHistoryCreate.vue";

export default {
	components: {
		StudentHistoryCreate,
	},
	data() {
		return {
			breadcrumbList: [
				{
					to: { name: "admin.dashboard" },
					name: "Home",
				},
				{
					name: "Student History",
				},
			],
			studentList: [],
			tableHead: {
				items: {
					item1: { label: "Sr.No." },
					item2: { label: "Admission Number" },
					item3: { label: "Admission Date" },
					// item1: { label: "Class(Start-End)" },
					// item1: { label: "Session(Start-End)" },
					// item1: { label: "Years" },
					item4: { label: "Student First Name" },
					item5: { label: "Student Last Name" },
					item6: { label: "Student Mobile Number" },
					item7: { label: "Father First Name" },
					item8: { label: "Father Last Name" },
					item9: { label: "Father Mobile Number" },
				},
				actions: true,
			},
			tableData: [],
			isLoaded: false,
			noData: false,
			editedIndex: -1,
		};
	},
	created() {
		toast = Toast.fire({
			icon: "warning",
			title: "Loading data..",
			timer: 0,
		});
		// this.showData();
	},

	mounted() {
		this.$parent.loadOtherScript();
	},

	methods: {
		getStudentData(admissionId, classId, sectionId) {
			this.sibling_classId = classId;
			this.sibling_sectionId = sectionId;
			this.sibling_admissionId = admissionId;
		},
		async getData(sectionId, classId) {
			this.isLoaded = false;
			const res = await this.callApi(
				"get",
				`/api/school/students/student_admissions/${sectionId}/${classId}`,
				null
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.studentList = data.student_admissions;
					this.initTable();
				}
			}
			this.$refs.table.loadTable();
			this.isLoaded = true;
			// toast.close();
		},
		initTable() {
			this.tableData = [];
			this.studentList.forEach((element) => {
				this.tableData.push({
					item: element,
					data: {
						item1: element.student_admission_id,
						item2: element.student_admission_number,
						item3: element.student_admission_date,
						// item4: `${element.school_class.class_name} ${element.school_section.section_name}`,
						// item5:element.student_session,
						// item6:element.years,
						item4: element.student_first_name,
						item5: element.student_last_name,
						item6: element.student_mobile,
						item7:
							element.student_guardian != null
								? element.student_guardian.father_first_name !=
								  null
									? element.student_guardian.father_first_name
									: ""
								: "",
						item8:
							element.student_guardian != null
								? element.student_guardian.father_last_name !=
								  null
									? element.student_guardian.father_last_name
									: ""
								: "",
						item9:
							element.student_guardian != null
								? element.student_guardian.father_mobile != null
									? element.student_guardian.father_mobile
									: ""
								: "",
					},
					action: {
						edit: true,
						delete: true,
					},
				});
			});
		},
		edit(item, index) {
			this.$router.push({
				path: `/school/students/admission/${item.student_admission_id}`,
			});
		},

		async deleteData(item, index) {
			var data = new FormData();
			data.append("status", "deleted");
			const res = await this.callApi(
				"post",
				`/api/school/students/student_details/delete/${item.student_admission_id}`,
				data
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.categoryList.splice(index, 1);
					this.tableData.splice(index, 1);
					SwalCustomBtn.fire("Deleted!", data.message, "success");
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
