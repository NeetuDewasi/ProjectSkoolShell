<template>
	<div>
		<form class="new-added-form">
			<div class="row">
				<div class="col-12 form-group">
					<label>Income Head <span class="error-s">*</span></label>
					<input
						type="text"
						name="income_head"
						v-model="editItem.income_head"
						placeholder=""
						class="form-control"
						:class="
							errorItem.income_head != '' ? 'error-field' : ''
						"
						@keyup="
							editItem.income_head != ''
								? (errorItem.income_head = '')
								: ''
						"
					/>
					<span
						class="error-label"
						v-if="errorItem.income_head != ''"
						v-text="errorItem.income_head"
					>
					</span>
				</div>
				<div class="col-12 form-group">
					<label>Description </label>
					<textarea
						class="textarea form-control"
						v-model="editItem.description"
						name="message"
						id="form-message"
						cols="10"
						rows="6"
					/>

				</div>
				<div class="col-12 form-group">
					<button
						@click.prevent="submitForm()"
						class="
							btn-lg btn btn-gradient-yellow btn-hover-bluedark
							text-white
						"
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
		</form>
	</div>
</template>
<script>
var toast;
export default {
	// props: ['itemCategories'],
	data() {
		return {
			editedIndex: -1,
			editItem: {
				categoryId: -1,
			},
			errorItem: {
				income_id: "",
				income_head: "",

			},
			itemCategoriesList: [],
		};
	},
	created() {},
	mounted() {
		// this.itemCategoriesList = this.itemCategories;
		//
	},
	computed: {
		formBtn: function () {
			return this.editedIndex !== -1 ? "update" : "save";
		},
	},
	methods: {
		getCategoryId(val) {
			this.editItem.categoryId = val;
			this.errorItem.itemCategoriesList = "";
		},
		updateList(item) {
			this.itemCategoriesList = item;
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
			this.editedIndex = item.id;
		},
		validItemForm() {
			this.isFormValid = true;
			if (
				this.editItem.income_head == null ||
				this.editItem.income_head == ""
			) {
				this.errorItem.income_head = "income head is required";
				this.isFormValid = false;
			} else {
				this.errorItem.income_head = "";
			}
			return this.isFormValid;
		},
	},
};
</script>
<style scoped>
.error-s {
	color: red;
}
</style>


















