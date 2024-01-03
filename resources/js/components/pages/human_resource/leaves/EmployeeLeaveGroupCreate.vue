<template>
	<div class="card">
		<div class="card-body">
			<div class="heading-layout1">
				<div class="item-title">
					<h3>Add New Group</h3>
				</div>
			</div>

			<form class="new-added-form">
				<div class="d-flex">
                    <div class="col-md-4 form-group">
                        <Select2 ref="department_list" :items="department_list" placeholder="--SELECT A DEPARTMENT--" @change="selectDepartment"
                            :class="errorItem.department_id != '' ? 'error-field' : ''"/>
                        <span class="error-label" v-if="errorItem.department_id != ''" v-text="errorItem.department_id"></span>
                    </div>
					<div class="flex-grow-1 mx-5 form-group">
						<input
							class="form-control"
							v-model="editItem.leave_group_title"
							placeholder="Enter Group Title"
							@keypress="errorItem.leave_group_title = ''"
							:class="errorItem.leave_group_title != '' ? 'error-field' : ''"
						/>
						<span class="error-label" v-if="errorItem.leave_group_title != ''" v-text="errorItem.leave_group_title"></span>
					</div>
					<div class="form-group">
						<button type="button" class="btn-fill-lg text-light shadow-dodger-blue bg-dodger-blue" @click.prevent="submitData()">
							{{ formButton }}
						</button>
						<button type="button" class="ml-3 btn-fill-lg text-light shadow-dodger-blue btn-gradient-yellow" @click="resetForm">
							{{ resetButton }}
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</template>
<script>
export default {
	data() {
		return {
			editItem: {},
			editedIndex: -1,
            department_list: [],
			errorItem: {
                department_id: '',
				leave_group_title: "",
			},
            selectedDepartmentId: "-1",
		};
	},
	computed: {
		formButton: function () {
			return this.editedIndex === -1 ? "Save" : "Update";
		},
		resetButton: function () {
			return this.editedIndex === -1 ? "Reset" : "Cancel";
		},
	},
    created() {
        this.getDepartmentList();
    },
	methods: {
        selectDepartment(val) {
            this.selectedDepartmentId = val;
            this.errorItem.employee_department_id = "";
            if (val == null || val == "" || val == -1)
                this.errorItem.employee_department_id =
                    "Department ID is required";
        },
		async getDepartmentList() {
			const res = await this.callApi(
				"get",
				`/api/school/general/get_department_list`,
				null
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.department_list && data.department_list.length) {
					this.department_list = data.department_list;
					this.$refs.department_list.updateList(data.department_list);
				} else {
					this.department_list = [];
					this.$refs.department_list.updateList([]);
				}
			}
		},
        async submitData() {
			let isValid = await this.validSectionForm();
			if (!isValid) {
				return;
			}
            this.editItem.department_id = this.selectedDepartmentId;
            this.$parent.submitData(this.editItem, this.editedIndex);
		},
		resetForm() {
            this.selectedDepartmentId = "-1";
            this.$refs.department_list.setSelected("-1");
			this.editItem = {};
			this.editedIndex = -1;
		},
		validSectionForm() {
			let isValid = true;
			if (
				this.selectedDepartmentId == null ||
				this.selectedDepartmentId == "-1"
			) {
				this.errorItem.department_id = "Department is required";
				isValid = false;
			} else {
				this.errorItem.department_id = "";
			}
			if (
				this.editItem.leave_group_title == null ||
				this.editItem.leave_group_title == ""
			) {
				this.errorItem.leave_group_title = "Leave group title is required";
				isValid = false;
			} else {
				this.errorItem.leave_group_title = "";
			}
			return isValid;
		},
		edit(item, index) {
			this.editItem = item;
             this.$refs.department_list.setSelected(item.department.id);
			this.editedIndex = index;
		},
	},
};
</script>
