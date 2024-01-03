 <template>
	<div>
		<div class="dashboard-content-one">
			<Breadcrumb
				pageTitle="Student Report "
				:breadcrumbList="breadcrumbList"
			/>
			<div class="row gutters-20">
				<div class="col-12">
					<StudentReportCreate ref="studentReportCreate" />
				</div>
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div class="item-title">
								<h3>Report List</h3>
							</div>
							<div class="table-responsive" v-show="!noData">
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
import StudentReportCreate from "./StudentReportCreate.vue";
export default {
	components: {
		StudentReportCreate,
	},
	data() {
		return {
			breadcrumbList: [
				{
					to: { name: "admin.dashboard" },
					name: "Home",
				},
				{
					name: "Student Report",
				},
			],
			tableData: [],
			isLoaded: false,
			noData: false,
			editItem: {},
			editedIndex: -1,
			tableHead: {
				items: {
					item1: { label: "Sr.No." },
					item2: { label: "Admission Number" },
					item3: { label: "First Name" },
					item4: { label: "Last Name" },
					item6: { label: "User Name" },
					item7: { label: "Password" },
					item8: { label: "Parent Username" },
					item9: { label: "Parent Password" },
					item10: { label: "Action" },
				},
				actions: true,
			},
		};
	},
	mounted() {
		this.$parent.loadOtherScript();
	},
	methods: {
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
						item3: element.student_first_name,
						item4: element.student_last_name,
						item5: `${element.school_class.class_name} ${element.school_section.section_name}`,
						item6:
							element.student_guardian != null
								? element.student_guardian.father_first_name !=
								  null
									? element.student_guardian.father_first_name
									: ""
								: "",
						item7:
							element.student_guardian != null
								? element.student_guardian.father_last_name !=
								  null
									? element.student_guardian.father_last_name
									: ""
								: "",
						item8:
							element.student_guardian != null
								? element.student_guardian.mother_first_name !=
								  null
									? element.student_guardian.mother_first_name
									: ""
								: "",
						item9:
							element.student_guardian != null
								? element.student_guardian.mother_last_name !=
								  null
									? element.student_guardian.mother_last_name
									: ""
								: "",
						item10:
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
	},
};
</script>
