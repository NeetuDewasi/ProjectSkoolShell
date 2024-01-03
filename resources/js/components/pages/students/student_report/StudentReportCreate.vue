<template>
	<div>
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<div class="heading-layout1">
						<div class="item-title">
							<h3>Select Criteria</h3>
						</div>
					</div>

					<form class="new-added-form">
						<div class="row">
							<div class="col-xl-6 col-lg-12 form-group">
								<label>Select Class</label>
								<Select2
									ref="class_list"
									placeholder="--SELECT A CLASS--"
									:items="class_list"
									@change="selectClass"
								/>
							</div>
							<div class="col-xl-6 col-lg-12 form-group">
								<label>Select Section</label>
								<Select2
									ref="section_list"
									:items="section_list"
									@change="selectSection"
								/>
							</div>
						</div>
					</form>
				</div>
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
		};
	},
	created() {
		toast = Toast.fire({
			icon: "warning",
			title: "Loading data..",
			timer: 0,
		});
		this.getClassList();
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
					this.sections = data.school_class_sections;
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
			this.$parent.getData(sectionId, this.classId);
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
