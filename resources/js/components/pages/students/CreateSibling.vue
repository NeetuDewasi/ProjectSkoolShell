<template>
	<div>
		<div class="">
			<div class="float-right mr-8 pointer">
				<i class="fa fa-times" @click="closeSilbilngForm(index)"></i>
			</div>
			<div class="row mt-3">
				<div class="col-xl-4 col-lg-6 col-12 form-group section">
					<label>Select Class</label>
					<Select2 ref="class_list" placeholder="--SELECT A CLASS--" :items="class_list" @change="selectClass" />
				</div>
				<div class="col-xl-4 col-lg-6 col-12 form-group section">
					<label>Select Section</label>
					<Select2 ref="section_list" :items="section_list" @change="selectSection" />
				</div>
				<div class="col-xl-4 col-lg-6 col-12 form-group section">
					<label>Select Student</label>
					<Select2 ref="student_list" :items="student_list" @change="getDataAdmission($event, index)" />
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: ["index"],
	data() {
		return {
			class_list: [],
			section_list: [],
			student_list: [],
			classId: -1,
			sectionId: -1,
			admissionId: -1,
		};
	},
	created() {
		this.getClass();
	},
	mounted() { },
	methods: {
		closeSilbilngForm(index) {
			this.$parent.closeSiblingForm(index);
		},
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
					this.sections = data.school_class_sections;
					this.$refs.section_list.updateList(
						data.school_class_sections
					);
				}
			}
		},
		async getClass() {
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
		getDataAdmission(admissionId, index) {
			this.$parent.getSiblingData(
				admissionId,
				this.classId,
				this.sectionId,
				index
			);
		},
	},
};
</script>
<style scoped>
.mr-8 {
	margin-right: 80px !important;
}
</style>
