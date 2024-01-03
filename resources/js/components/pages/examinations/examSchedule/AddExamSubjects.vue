<template>
	<div>
		<div class="">
			<div class="mt-3">
				<div class=" form-group section">
					<label>Select Subject</label>
					<Select2
						ref="subject_list"
						placeholder="--SELECT A CLASS--"
						:items="subject_list"
						@change="getDataSubjects"
					/>
				</div>

			</div>
		</div>
	</div>
</template>

<script>
export default {
	data() {
		return {
			subject_list: [],
		};
	},
	created() {
		this.getSubjects();
	},
	mounted() {},
	methods: {
		async getSubjects() {
			const res = await this.callApi(
				"get",
				`/api/school/academics/school_subjects`,
				null
			);
            this.log('SUBJECTS',res);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.subject_list = data.school_subjects;
					this.$refs.subject_list.updateList(data.school_subjects);
				}
			}
		},
		selectSubject(subjectId) {
			this.subjectId = subjectId;
		},

		getDataSubjects(subjectId) {
			this.$parent.getSubjectData(
				subjectId,
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
