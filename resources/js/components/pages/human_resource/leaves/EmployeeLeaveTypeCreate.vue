<template>
	<div class="card">
		<div class="card-body">
			<div class="heading-layout1">
				<div class="item-title">
					<h3>Add New Type</h3>
				</div>
			</div>

			<form class="new-added-form">
				<div class="d-flex">
					<div class="flex-grow-1 mx-5 form-group">
						<input
							class="form-control"
							v-model="editItem.leave_type_title"
							placeholder="Enter Leave Type Title"
							@keypress="errorItem.leave_type_title = ''"
							:class="errorItem.leave_type_title != '' ? 'error-field' : ''"
						/>
						<span class="error-label" v-if="errorItem.leave_type_title != ''" v-text="errorItem.leave_type_title"></span>
					</div>
					<div class="form-type">
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
			errorItem: {
				leave_type_title: "",
			},
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
    },
	methods: {
        async submitData() {
			let isValid = await this.validateForm();
			if (!isValid) {
				return;
			}
            this.$parent.submitData(this.editItem, this.editedIndex);
		},
		resetForm() {
			this.editItem = {};
			this.editedIndex = -1;
		},
		validateForm() {
			let isValid = true;
			if (
				this.editItem.leave_type_title == null ||
				this.editItem.leave_type_title == ""
			) {
				this.errorItem.leave_type_title = "Leave type title is required";
				isValid = false;
			} else {
				this.errorItem.leave_type_title = "";
			}
			return isValid;
		},
		edit(item, index) {
			this.editItem = item;
			this.editedIndex = index;
		},
	},
};
</script>
