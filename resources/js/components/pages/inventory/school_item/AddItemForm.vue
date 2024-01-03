<template>
	<div>
		<form class="new-added-form">
			<div class="row">
				<div class="col-12 form-group">
					<label>Item Category &nbsp; <strong class="text-danger bolder">*</strong></label>
					<Select2
						:items="itemCategoriesList"
						@change="getCategoryId"
						ref="select2"
						:class="
							errorItem.itemCategoriesList != ''
								? 'error-field'
								: ''
						"
					/>
					<span
						class="error-label"
						v-if="errorItem.itemCategoriesList != ''"
						v-text="errorItem.itemCategoriesList"
					>
					</span>
				</div>
				<div class="col-12 form-group">
					<label>Item Name &nbsp; <strong class="text-danger bolder">*</strong></label>
					<input
						type="text"
						v-model="editItem.item_name"
						placeholder=""
						class="form-control"
						:class="errorItem.item_name != '' ? 'error-field' : ''"
						@keyup="
							editItem.item_name != ''
								? (errorItem.item_name = '')
								: ''
						"
					/>
					<span
						class="error-label"
						v-if="errorItem.item_name != ''"
						v-text="errorItem.item_name"
					>
					</span>
				</div>

				<div class="col-12 form-group">
					<div class="justify-content-end">
						<button
							type="submit"
							class="
								btn-lg
								btn
								btn-gradient-yellow
								btn-hover-bluedark
								text-white
							"
							@click.prevent="submitForm"
						>
							{{ formBtn }}
						</button>
						<button
							type="reset"
							class="
								btn-lg btn
								bg-blue-dark
								btn-hover-yellow
								text-white
							"
						>
							Reset
						</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</template>
<script>
var toast;
export default {
	props: ["itemCategories"],
	data() {
		return {
			editedIndex: -1,
			editItem: {
				categoryId: -1,
			},
			errorItem: {
				item_name: "",
				itemCategoriesList: "",
			},
			itemCategoriesList: [],
		};
	},
	created() {},
	mounted() {
		this.itemCategoriesList = this.itemCategories;
	},
	computed: {
		formBtn: function () {
			return this.editedIndex !== -1 ? "Update" : "Save";
		},
	},
	methods: {
		getCategoryId(val) {
			this.editItem.categoryId = val;
			this.errorItem.itemCategoriesList = "";
		},
		updateList(item) {
			this.itemCategoriesList = item;
			this.$refs.select2.updateList(item);
		},
		async submitForm() {
			var isVaild = await this.validItemForm();
			if (!isVaild) {
				return;
			}
			toast = Toast.fire({
				icon: "warning",
				title: "Please Wait!! Creating new Item",
				timer: 0,
			});
			this.$parent.submitForm(this.editItem, this.editedIndex);
			this.editItem = {};
			this.editedIndex = -1;
		},
		edit(item) {
			this.editItem = item;
			// this.$refs.select2.changeItemId(item.category.value);
			this.editedIndex = item.item_id;
		},
		validItemForm() {
			this.isFormValid = true;
			if (
				this.editItem.item_name == null ||
				this.editItem.item_name == ""
			) {
				this.errorItem.item_name = "Item Name  is required";
				this.isFormValid = false;
			} else {
				this.errorItem.item_name = "";
				this.isFormValid = true;
			}
			if (
				this.editItem.categoryId == null ||
				this.editItem.categoryId == "" ||
				this.editItem.categoryId === -1
			) {
				this.errorItem.itemCategoriesList =
					"Item Category  is required";
				this.isFormValid = false;
			} else {
				this.errorItem.itemCategoriesList = "";
				this.isFormValid = true;
			}
			return this.isFormValid;
		},
	},
};
</script>
