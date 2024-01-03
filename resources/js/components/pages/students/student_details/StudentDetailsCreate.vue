<template>
	<div>
		<div class="card">
			<div class="card-body">
				<div class="heading-layout1">
					<div class="item-title">
						<h3>Select Criteria</h3>
					</div>
				</div>
				<form class="new-added-form">
					<div class="row">
						<div class="col-lg-6 col-md-12 form-group">
							<label>Select Class</label>
							<Select2
								ref="class_list"
								placeholder="--SELECT A CLASS--"
								:items="class_list"
								@change="selectClass"
							/>
						</div>
						<div class="col-lg-6 col-md-12 form-group">
							<label>Select Section</label>
							<Select2
								placeholder="--SELECT A SECTION--"
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
</template>

<script>
var toast;

export default {
	data() {
		return {
			class_list: [],
			section_list: [],
            selectedClass:[],
            selectedSection:[],

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
     computed: {
        filterData() {
            if (this.selectedClass != -1) {
                if (this.selectedSection != -1) {
                    return this.tableData.filter(item => {
                        return item.data.item3 == (this.selectedClassName + ' ' + this.selectedSectionName);
                    })
                }
                return  this.tableData.filter(item => {
                    return item.data.item3.includes(this.selectedClassName);
                });
            }
            return this.tableData;
        }
    },
	methods: {
		async selectClass(val) {
			this.classId = val;
            this.getSelectedClassName();
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
            this.$parent.getData(this.classId,this.sectionId);
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
			toast.close();
		},
		selectSection(sectionId) {
            this.sectionId = sectionId;
            this.getSelectedSectionName();
            if(this.sectionId != -1){
			this.$parent.getData(this.classId,this.sectionId);
            }
		},
         getSelectedClassName() {
            if (this.selectedClass != -1) {
                this.class_list.forEach(element => {
                    if (element.value == this.selectedClass) {
                        this.selectedClassName = element.name;
                    }
                });
            }
        },
        getSelectedSectionName() {
            if (this.selectedSection != -1) {
                this.section_list.forEach(element => {
                    if (element.value == this.selectedSection) {
                        this.selectedSectionName = element.name;
                    }
                });
            }
        },
	},
};
</script>
