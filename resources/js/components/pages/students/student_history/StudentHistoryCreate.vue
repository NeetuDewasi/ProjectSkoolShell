<template>
	<div>
		<div class="card">
			<div class="card-body">
				<div class="item-title">
					<h3>Select Criteria</h3>
				</div>

				<form class="new-added-form">
					<div class="row form-group">
						<div class="col-xl-2">
							<label>Select Class</label>
							<Select2
								ref="class_list"
								placeholder="--SELECT A CLASS--"
								:items="class_list"
								@change="selectClass"
							/>
						</div>
						<div class="col-xl-2">
							<label>Select Section</label>

							<Select2
								ref="section_list"
								:items="section_list"
								@change="selectSection"
							/>
						</div>
						<div class="col-xl-6">
							<label>Select Student</label>
							<Select2
								ref="student_list"
								:items="student_list"
								@change="getDataAdmission"
							/>
						</div>
						<div class="col-xl-2 form-group">
							<label>Admission Year</label>
							<select class="select2" @change="getData()">
								<option value>Select</option>
								<option
									:value="year - (index - 1)"
									v-for="index in 100"
									:key="index"
								>
									{{ year - (index - 1) }}
								</option>
							</select>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
var toast;

export default {
	data() {
		return {
			class_list: [],
			section_list: [],
			student_list: [],
			year: "",
		};
	},
	created() {
		toast = Toast.fire({
			icon: "warning",
			title: "Loading data..",
			timer: 0,
		});
		this.getClassList(), (this.year = new Date().getFullYear().toString());
	},

	methods: {
		async selectClass(val) {
			this.classId = val;
			const res = await this.callApi(
				"get",
				`/api/school/class/sections/${this.classId}`,
				null
			);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.section_list = data.school_class_sections;
					this.$refs.section_list.updateList(
						data.school_class_sections
					);
				}
			}
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
					this.class_list = data.class_list;

					this.$refs.class_list.updateList(data.class_list);
				}
			}
		},
		selectSection(sectionId) {
			this.getStudents(sectionId, this.classId);
			this.sectionId = sectionId;
		},
		async getStudents(sectionId, classId) {
			const res = await this.callApi(
				"get",
				`/api/school/class/${classId}/section/${sectionId}/students`,
				null
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.student_list = data.student_admission;

					this.$refs.student_list.updateList(data.student_admission);
				}
			}
		},

		getDataAdmission(admissionId) {
			this.$parent.getData(admissionId, this.classId, this.sectionId);
		},
	},
};
</script>
