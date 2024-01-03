<template>
	<div class="card">
		<div class="card-body">
			<div class="heading-layout1">
				<div class="item-title">
					<h3>Add New Reck &amp; Shelves</h3>
				</div>
			</div>

			<form class="new-added-form">
				<div class="d-flex">
					<div class="flex-grow-1 mr-5 form-group">
						<input
							class="form-control"
							v-model="editItem.reck_name"
							placeholder="Enter reck name"
							@keypress="errorItem.reck_name = ''"
							:class="
								errorItem.reck_name != ''
									? 'error-field'
									: ''"
						/>
						<span
							class="error-label"
							v-if="errorItem.reck_name != ''"
							v-text="errorItem.reck_name"
						></span>
					</div>
					<div class="flex-shrike-1 mr-5 form-group">
						<input
                            type="number"
							class="form-control"
							v-model="editItem.shelf_count"
							placeholder="Enter shelf count"
							@keypress="errorItem.shelf_count = ''"
							:class="
								errorItem.shelf_count != ''
									? 'error-field'
									: ''"
						/>
						<span
							class="error-label"
							v-if="errorItem.shelf_count != ''"
							v-text="errorItem.shelf_count"
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
				reck_name: "",
				shelf_count: "",
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
				this.editItem.reck_name == null ||
				this.editItem.reck_name == ""
			) {
				this.errorItem.reck_name = "Reck name is required";
				this.isFormValid = false;
			} else {
				this.errorItem.reck_name = "";
			}
            if (
				this.editItem.shelf_count == null ||
				this.editItem.shelf_count == ""
			) {
				this.errorItem.shelf_count = "Shelf count is required";
				this.isFormValid = false;
			} else {
				this.errorItem.shelf_count = "";
			}
			return this.isFormValid;
		},
		edit(item) {
			this.editItem = item;
			this.editedIndex = item.reck_id;
		},
	},
};
</script>
