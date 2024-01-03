<template>
	<div>
		<div class="dashboard-content-one">
			<Breadcrumb pageTitle="Student Attendance" :breadcrumbList="breadcrumbList" />
			<div class="row gutters-20">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<form class="new-added-form">
								<div class="row">
									<div class="col-4 form-group">
										<label>Class</label>
										<Select2
											key="class_list"
											ref="class_list"
											:item="classList"
											@change="selectClass" />
									</div>
									<div class="col-4 form-group">
										<label>Section</label>
										<Select2
											key="section_list"
											ref="section_list"
											:item="sectionList"
											@change="selectSection" />
									</div>
									<div class="col-4 form-group">
										<label>Date</label>
										<DatePicker
											format="DD-MMM-YYYY"
											value-type="format"
											type="date"
											placeholder="Select a date"
											v-model="displayDate"
											:default-value="new Date()"
											:disabled-date="disabledAfterToday"
											class="form-control vue-datepicker my-0"
										/>
									</div>
								</div>
							</form>

							<div class="heading-layout1 row">
								<div class="col-xl-9 form-group">
									<input
										type="text"
										placeholder="Search Student"
										class="form-control"
									/>
								</div>
								<div
									class="
										col-md-3
										d-flex
										justify-content-between
									"
								>
									<div class="text-center mx-2">
										<div class="btn att-p-btn">P</div>
										<div>Present</div>
									</div>
									<div class="text-center mx-2">
										<div class="btn att-l-btn">L</div>
										<div>Late</div>
									</div>
									<div class="text-center mx-2">
										<div class="btn att-h-btn">H</div>
										<div>Half Day</div>
									</div>
									<div class="text-center mx-2">
										<div class="btn att-a-btn">A</div>
										<div>Absent</div>
									</div>
								</div>
							</div>
							<div>
								<div class="row">
									<div
										class="
											card
											shadow-lg
											col-2
											rounded-2
											d-flex mt-4
											align-items-center
											m-3
										"
										:class="
											selectBackground(student.attendance)
										"
										v-for="(student, index) in students"
										:key="index"
									>
										<div class="mt-5">
											<div class="text-center">
												<img
													class="student-avatar"
													src="/assets/img/figure/student.png"
													width="50"
													height="50"
												/>

												<div>
													{{
														`${student.student_first_name} ${student.student_last_name}`
													}}
												</div>

												<div
													class="
														d-flex
														justify-content-between
														align-items-baseline
													"
												>
													<div
														class="text-center mr-2"
													>
														<div
															style="
																font-size: 12px;
															"
														>
															Adm. No.
														</div>
													</div>
													<div class="text-center">
														<div>
															{{
																student.student_admission_number
															}}
														</div>
													</div>
												</div>

												<div
													class="
														d-flex
														justify-content-between
														align-items-baseline
													"
												>
													<div
														class="text-center mr-2"
													>
														<div
															style="
																font-size: 12px;
															"
														>
															Role No.
														</div>
													</div>
													<div class="text-center">
														<div>
															{{
																student.student_role_number
															}}
														</div>
													</div>
												</div>
											</div>
											<div
												class="
													d-flex
													w-100
													justify-content-between
												"
											>
												<div
													class="btn att-p-btn mx-2"
													@click="
														student.attendance = 1
													"
												>
													P
												</div>
												<div
													class="btn att-l-btn mx-2"
													@click="
														student.attendance = 2
													"
												>
													L
												</div>
												<div
													class="btn att-h-btn mx-2"
													@click="
														student.attendance = 3
													"
												>
													H
												</div>
												<div
													class="btn att-a-btn mx-2"
													@click="
														student.attendance = 4
													"
												>
													A
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<button
									type="button"
									class="
										btn-fill-lg
										text-light
										shadow-dodger-blue
										bg-dodger-blue
									"
									@click.prevent="saveData()"
								>
									SAVE
								</button>
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
import StudentAttendanceTableRow from "../StudentAttendanceTableRow.vue";

export default {
	components: {
		StudentAttendanceTableRow,
	},
	data() {
		return {
			breadcrumbList: [
				{
					to: { name: "admin.dashboard" },
					name: "Home",
				},
				{
					name: "Add Attendance",
				},
			],
			students: [],
			classList: [],
			sectionList: [],
			isLoaded: false,
			noData: false,
			editItem: {},
			displayDate: "",
			attendanceDate: moment(new Date()).format("YYYY-MM-DD"),
			selectedClass: -1,
			selectedSection: -1,
		};
	},
	watch: {
		displayDate: function (val) {
			this.displayDate = val;
			this.attendanceDate = moment(new Date(val)).format("YYYY-MM-DD");
			this.getStudents();
		},
	},
	mounted() {
		this.$parent.loadOtherScript();
		this.getClassList();
		this.displayDate = moment(new Date()).format("DD-MMM-YYYY");
	},
	methods: {
		disabledAfterToday(date) {
			const today = new Date();
			today.setHours(0, 0, 0, 0);
			return date > today;
		},
		selectBackground(attendance) {
			if (attendance == 1) return "att-p";
			else if (attendance == 2) return "att-l";
			else if (attendance == 3) return "att-h";
			else if (attendance == 4) return "att-a";
		},
		async getClassList() {
			const res = await this.callApi(
				"get",
				`/api/school/general/get_class_list`,
				null
			);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.classList = data.class_list;
					this.$refs.class_list.updateList(this.classList);
				}
			}
		},
		selectClass(val) {
			this.selectedClass = val;
			this.getSectionList();
		},
		selectSection(val) {
			this.selectedSection = val;
            this.log('Section Id',this.selectedSection);
			this.getStudents();
		},
		async getSectionList() {
			const res = await this.callApi(
				"get",
				`/api/school/general/get_section_list/${this.selectedClass}`,
				null
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.sectionList = data.section_list;
					this.$refs.section_list.updateList(this.sectionList);
				}
			}
		},
		async getStudents() {
			if (
				this.selectedClass === -1 ||
				this.selectedSection === -1 ||
				this.attendanceDate == null ||
				this.attendanceDate == ""
			)
				return;
			var data = new FormData();
			data.append("school_class_id", this.selectedClass);
			data.append("school_section_id", this.selectedSection);
			data.append("attendance_date", this.attendanceDate);
			const res = await this.callApi(
				"post",
				`/api/school/attendance/student_attendance/`,
				data
			);
                this.log('STUDENTS',res);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.students = data.students;
				}
			}
		},
		async saveData() {
			var studentAttendances = [];
			this.students.forEach((student) => {
				studentAttendances.push({
					id: student.student_id,
					attendance: student.attendance,
				});
			});

			var data = new FormData();
			data.append(
				"student_attendance",
				JSON.stringify(studentAttendances)
			);
			data.append("school_class_id", this.selectedClass);
			data.append("school_section_id", this.selectedSection);
			data.append("attendance_date", this.attendanceDate);
			const res = await this.callApi(
				"post",
				`/api/school/attendance/student_attendance/save`,
				data
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.classList.push(data.school_class);
					toast = Toast.fire({
						icon: "success",
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
	},
};
</script>


<style scoped>
.student-avatar {
	border-radius: 50%;
	border: black 1px solid;
}

.att-p {
	background-color: rgb(193, 255, 208);
}
.att-l {
	background-color: rgb(255, 249, 193);
}
.att-h {
	background-color: rgb(193, 235, 255);
}
.att-a {
	background-color: rgb(255, 193, 193);
}

.att-p-btn {
	background-color: rgb(102, 172, 119);
	color: white;
}
.att-l-btn {
	background-color: rgb(173, 167, 106);
	color: white;
}
.att-h-btn {
	background-color: rgb(95, 150, 175);
	color: white;
}
.att-a-btn {
	background-color: rgb(187, 104, 104);
	color: white;
}

.form-control.mx-datepicker {
	width: 100%;
}

.mx-input-wrapper input.mx-input {
	background-color: transparent;
	box-shadow: none;
	border: none;
}
.form-control.mx-datepicker .mx-input-wrapper i {
	top: auto;
}
</style>
