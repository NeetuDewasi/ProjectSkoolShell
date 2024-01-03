<template>
	<div>
		<div class="dashboard-content-one">
			<Breadcrumb
				pageTitle="Assign Subjects"
				:breadcrumbList="breadcrumbList"
			/>
			<div class="row gutters-20">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<div
								class="
									heading-layout1
									d-flex
									justify-content-between
								"
							>
								<div class="item-title">
									<h3>Assign Teacher Subject</h3>
								</div>
							</div>
						</div>

						<div class="card-body">
							<div class="new-added-form">
								<div class="form-group">
									<label
										>Select Teachers
										<strong class="text-danger">*</strong>
									</label>
									<Select2
										ref="teacher_list"
										:items="teachers"
										placeholder="--SELECT A TEACHER--"
										@change="selectedTeacher"
										:class="
											teacherError != ''
												? 'errorField'
												: ''
										"
									/>
									<span
										v-if="teacherError != ''"
										class="error-label"
										v-text="teacherError"
									></span>
								</div>
							</div>
							<div class="mt-5">
								<div
									class="
										btn
										items items-name
										rounded-pill
										shadow
										p-3
										m-4
									"
									v-for="(subject, index) in subjects"
									:key="index"
									@click="updateSection(subject)"
									:class="
										isSelected(subject) ? 'bg-selected' : ''
									"
								>
									{{ subject.subject_name }}
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
export default {
	data() {
		return {
			breadcrumbList: [
				{
					to: { name: "admin.dashboard" },
					name: "Home",
				},
				{
					name: "Teacher Assign Subjects",
				},
			],
			editItem: {},
			class_sections: [],
			selectedClassId: -1,
			sectionId: -1,
			classError: "",
			sectionError: "",
			subjects: [],
			teachers: [],
			class_subjects: [],
			teacherId: -1,
			teacherError: "",
			teacherSubject: [],
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
			const res = await this.callApi(
				"get",
				`/api/school/academics/assign/subjects/teachers`,
				null
			);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.subjects = data.school_subjects;
					this.teachers = data.teachers;
					this.$refs.teacher_list.updateList(data.teachers);
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
			toast.close();
		},
		selectedTeacher(val) {
			this.teacherId = val;
			this.getSubject();
			this.teacherError = "";
			this.teacherSubject = [];
		},
		async getSubject() {
			var formData = new FormData();
			formData.append("teacher", this.teacherId);
			const res = await this.callApi(
				"post",
				`/api/school/academics/assign/teacher/subjects`,
				formData
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.teacherSubject = data.teacher_subjects;
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
		isSelected(mySubject) {
			var selected = false;
			if (this.teacherSubject.length) {
				this.teacherSubject.forEach((subject) => {
					if (subject.subject_id == mySubject.subject_id) {
						selected = true;
						return true;
					}
				});
			}
			return selected;
		},
		async updateSection(mySubject) {
			if (this.teacherId === -1) {
				this.teacherError = "teacher is required";
				return;
			}
			var selectedIndex = -1;
			if (this.teacherSubject.length) {
				this.teacherSubject.forEach((subject, index) => {
					if (subject.subject_id == mySubject.subject_id) {
						selectedIndex = index;
						return;
					}
				});
			}

			if (selectedIndex !== -1) {
				this.teacherSubject.splice(selectedIndex, 1);
			} else {
				this.teacherSubject.push(mySubject);
			}
			var subjectIds = [];
			this.teacherSubject.forEach((subject) => {
				subjectIds.push(subject.subject_id);
			});
			var formData = new FormData();
			formData.append("subject_ids", subjectIds);
			const res = await this.callApi(
				"post",
				`/api/school/academics/assign/teacher/subjects/${this.teacherId}`,
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
	},
};
</script>

