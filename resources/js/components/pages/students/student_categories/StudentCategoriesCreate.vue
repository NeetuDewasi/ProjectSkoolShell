<template>
	<div>
		<div class="card">
			<div class="card-body">
				<div class="heading-layout1">
					<div class="item-title">
						<h3>Add Category</h3>
					</div>
				</div>
				<div class="new-added-form">
					<div class="d-flex">
						<div class="col-md-7 form-group">
							<label>Category Name <span class="text-danger">*</span></label>
							<input
								class="form-control"
								v-model="editItem.category_name"
								placeholder="Enter Category name"
								@keypress="errorItem.category_name = ''"
								:class="
									errorItem.category_name != ''
										? 'error-field'
										: ''
								"
							/>
							<span
								class="error-label"
								v-if="errorItem.category_name != ''"
								v-text="errorItem.category_name"
							></span>
						</div>

						<div class="col-md-5 form-group mt-5 pt-3">
							<button
								type="button"
								class="
									btn-fill-md
									text-light
									shadow-dodger-blue
									bg-dodger-blue border-2
								"
								@click.prevent="submitData()"
							>
								{{ formBtn }}
							</button>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	data() {
		return {
			breadcrumbList: [
				{
					to: { name: "admin.dashboard" },
					name: "Home",
				},
				{
					name: "Student Categories",
				},
			],
			editItem: {},
			editedIndex: -1,
			errorItem: {
				category_name: "",
			},
			isFormValid: false,
		};
	},
	computed: {
		formBtn: function () {
			return this.editedIndex !== -1 ? "Update" : "Save";
		},
		resetButton: function () {
			return this.editedIndex === -1 ? "Reset" : "Cancel";
		},
	},

	methods: {
		async submitData() {
			var isVaild = await this.validCategoryForm();
			if (!isVaild) {
				return;
			}
			if (this.editedIndex === -1) {
				this.$parent.saveData(this.editItem);
			} else {
				this.$parent.updateData(this.editItem, this.editedIndex);
			}
		},
		resetForm() {
			this.editItem = {};
			this.editedIndex = -1;
		},
		validCategoryForm() {
			this.isFormValid = true;
			if (
				this.editItem.category_name == null ||
				this.editItem.category_name == ""
			) {
				this.errorItem.category_name = "Category Name is required";
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


