<template>
	<div class="card">
		<div class="card-body">
			<div class="heading-layout1">
				<div class="item-title">
					<h3>Add New Category</h3>
				</div>
			</div>

			<form class="new-added-form">
				<div class="d-flex">
					<div class="flex-grow-1 mr-5 form-group">
						<input
							class="form-control"
							v-model="editItem.category_name"
							placeholder="Enter category name"
							@keypress="errorItem.category_name = ''"
							:class="
								errorItem.category_name != ''
									? 'error-field'
									: ''"
						/>
						<span
							class="error-label"
							v-if="errorItem.category_name != ''"
							v-text="errorItem.category_name"
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
				category_name: "",
			},
			isFormValid: false,
		};
	},
	computed: {
		formButton: function () {
			return this.editedIndex === -1 ? "Save" : "Update";
		},
	},
	methods: {
		async submitData() {
			var isValid = await this.validateForm();
			if (!isValid) {
				return;
			}
			if (this.editedIndex === -1) {
				this.$parent.saveData(this.editItem);
			} else {
				this.$parent.updateData(this.editItem, this.editedIndex);
			}
			this.editItem = {};
			this.editedIndex = -1;
		},
		validateForm() {
			this.isFormValid = true;
			if (
				this.editItem.category_name == null ||
				this.editItem.category_name == ""
			) {
				this.errorItem.category_name = "Category name is required";
				this.isFormValid = false;
			} else {
				this.errorItem.category_name = "";
			}
			return this.isFormValid;
		},
		edit(item) {
			this.editItem = item;
			this.editedIndex = item.category_id;
		},
	},
};
</script>
