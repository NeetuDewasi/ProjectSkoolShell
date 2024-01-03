<template>
	<div class="card">
		<div class="card-body">
			<div class="heading-layout1">
				<div class="item-title">
					<h3>Add Department</h3>
				</div>
			</div>

			<form class="new-added-form">
				<div class="d-flex">
					<div class="flex-grow-1 mr-5 form-group">
						<input
							class="form-control"
							v-model="editItem.department_name"
							placeholder="Enter Department name"
							@keypress="errorItem.department_name = ''"
							:class="
								errorItem.department_name != ''
									? 'error-field'
									: ''"
						/>
						<span
							class="error-label"
							v-if="errorItem.department_name != ''"
							v-text="errorItem.department_name"
						></span>
					</div>
					<div class="form-group">
						<button
							type="button"
							class="
								btn-fill-lg
								text-light
								shadow-dodger-blue
								bg-dodger-blue"
							@click.prevent="submitData()"
						>
							{{ formButton }}
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
				department_name: "",
			},
		};
	},
    computed: {
		formButton: function () {
			return this.editedIndex === -1 ? "Save" : "Update";
		},
	},
	methods: {
		reset() {
            this.editItem = {};
			this.editedIndex = -1;
            this.errorItem = {
				department_name: "",
			};
        },
		async submitData() {
			var isValid = await this.validateForm();
			if (!isValid) {
				return;
			}
            this.$parent.submitData(this.editItem, this.editedIndex);
		},
        edit(item, index) {
			this.editItem = item;
			this.editedIndex = index;
		},
		validateForm() {
			let isFormValid = true;
			if (
				this.editItem.department_name == null ||
				this.editItem.department_name == ""
			) {
				this.errorItem.department_name = "Department Name is required";
				isFormValid = false;
			}
			return isFormValid;
		},
	},
};
</script>
