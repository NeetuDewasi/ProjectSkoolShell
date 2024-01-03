<template>
	<div>
		<form class="new-added-form">
			<div class="row">
				<div class="col-12 form-group">
					<label
						>Item Supplier Name &nbsp;<strong
							class="text-danger bolder"
							>*</strong
						></label
					>
					<input
						type="text"
						placeholder=""
						class="form-control"
						v-model="editItem.supplier_name"
						:class="
							errorItem.supplier_name != '' ? 'error-field' : ''
						"
						@keyup="
							editItem.supplier_name != ''
								? (errorItem.supplier_name = '')
								: ''
						"
					/>
					<span
						class="error-label"
						v-if="errorItem.supplier_name != ''"
						v-text="errorItem.supplier_name"
					>
					</span>
				</div>
				<div class="col-12 form-group">
					<label
						>Email ID &nbsp;<strong class="text-danger bolder"
							>*</strong
						></label
					>
					<input
						type="text"
						placeholder=""
						class="form-control"
						v-model="editItem.email"
						:class="errorItem.email != '' ? 'error-field' : ''"
						@keyup="
							editItem.email != '' ? (errorItem.email = '') : ''
						"
					/>
					<span
						class="error-label"
						v-if="errorItem.email != ''"
						v-text="errorItem.email"
					>
					</span>
				</div>
				<div class="col-12 form-group">
					<label
						>Address &nbsp;<strong class="text-danger bolder"
							>*</strong
						></label
					>
					<input
						type="text"
						placeholder=""
						class="form-control"
						v-model="editItem.address"
						:class="errorItem.address != '' ? 'error-field' : ''"
						@keyup="
							editItem.address != ''
								? (errorItem.address = '')
								: ''
						"
					/>
					<span
						class="error-label"
						v-if="errorItem.address != ''"
						v-text="errorItem.address"
					>
					</span>
				</div>
				<div class="col-12 form-group">
					<label
						>Phone Number &nbsp;<strong class="text-danger bolder"
							>*</strong
						></label
					>
					<input
						type="text"
						placeholder=""
						class="form-control"
						v-model="editItem.phone"
						:class="errorItem.phone != '' ? 'error-field' : ''"
						@keyup="
							editItem.phone != '' ? (errorItem.phone = '') : ''
						"
					/>
					<span
						class="error-label"
						v-if="errorItem.phone != ''"
						v-text="errorItem.phone"
					>
					</span>
				</div>
				<div class="col-12 form-group">
					<label
						>Contect Person &nbsp;<strong class="text-danger bolder"
							>*</strong
						></label
					>
					<input
						type="text"
						placeholder=""
						class="form-control"
						v-model="editItem.contact_person_name"
						:class="
							errorItem.contact_person_name != ''
								? 'error-field'
								: ''
						"
						@keyup="
							editItem.contact_person_name != ''
								? (errorItem.contact_person_name = '')
								: ''
						"
					/>
					<span
						class="error-label"
						v-if="errorItem.contact_person_name != ''"
						v-text="errorItem.contact_person_name"
					>
					</span>
				</div>
				<div class="col-12 form-group">
					<label
						>Contact Person Phone &nbsp;<strong
							class="text-danger bolder"
							>*</strong
						></label
					>
					<input
						type="text"
						placeholder=""
						class="form-control"
						v-model="editItem.contact_person_phone"
						:class="
							errorItem.contact_person_phone != ''
								? 'error-field'
								: ''
						"
						@keyup="
							editItem.contact_person_phone != ''
								? (errorItem.contact_person_phone = '')
								: ''
						"
					/>
					<span
						class="error-label"
						v-if="errorItem.contact_person_phone != ''"
						v-text="errorItem.contact_person_phone"
					>
					</span>
				</div>
				<div class="col-12 form-group">
					<label
						>Contact Person Emai &nbsp;<strong
							class="text-danger bolder"
							>*</strong
						></label
					>
					<input
						type="text"
						placeholder=""
						class="form-control"
						v-model="editItem.contact_person_email"
						:class="
							errorItem.contact_person_email != ''
								? 'error-field'
								: ''
						"
						@keyup="
							editItem.contact_person_email != ''
								? (errorItem.contact_person_email = '')
								: ''
						"
					/>
					<span
						class="error-label"
						v-if="errorItem.contact_person_email != ''"
						v-text="errorItem.contact_person_email"
					>
					</span>
				</div>

				<div class="col-xl-12 col-lg-12 col-12 form-group">
					<label
						>Description </label
					>
					<textarea
						class="textarea form-control"
						name="message"
						v-model="editItem.description"
						id="form-message"
						cols="10"
						rows="6"
					></textarea>
				</div>
				<div class="col-12 form-group mg-t-8">
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
				supplier_name: "",
				email: "",
				address: "",
				phone: "",
				contact_person_name: "",
				contact_person_phone: "",
				contact_person_email: "",
				description: "",
			},
			itemCategoriesList: [],
            emailRegex: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/,
            mobileRegex: /^[5-9][0-9]{9}$/,
            isFormValid: false
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
			this.editedIndex = item.id;
		},
		validItemForm() {
			this.isFormValid = true;
			if (
				this.editItem.supplier_name == null ||
				this.editItem.supplier_name == ""
			) {
				this.errorItem.supplier_name = "Supplier Name  is required";
				this.isFormValid = false;
			} else {
				this.errorItem.supplier_name = "";
			}

			if (this.editItem.email == null || this.editItem.email == "") {
				this.errorItem.email = "Supplier Email  is required";
				this.isFormValid = false;
			}   if (!this.emailRegex.test(this.editItem.email)) {
                this.errorItem.email = "Enter valid email";
                this.isFormValid = false;
            }
            else {
				this.errorItem.email = "";
			}

			if (this.editItem.address == null || this.editItem.address == "") {
				this.errorItem.address = "Supplier Address  is required";
				this.isFormValid = false;
			} else {
				this.errorItem.address = "";
			}

			if (this.editItem.phone == null || this.editItem.phone == "") {
				this.errorItem.phone = "Supplier Phone  is required";
				this.isFormValid = false;
			}
            else if (!this.mobileRegex.test(this.editItem.phone)) {
                this.errorItem.phone =
                    "Enter valid mobile number";
                this.isFormValid = false;
            }else {
				this.errorItem.phone = "";
			}

			if (
				this.editItem.contact_person_name == null ||
				this.editItem.contact_person_name == ""
			) {
				this.errorItem.contact_person_name =
					"Supplier Contect Person is required";
				this.isFormValid = false;
			} else {
				this.errorItem.contact_person_name = "";
			}

			if (
				this.editItem.contact_person_phone == null ||
				this.editItem.contact_person_phone == ""
			) {
				this.errorItem.contact_person_phone =
					"Supplier Contect Phone Number is required";
				this.isFormValid = false;
			}else if(!this.mobileRegex.test(this.editItem.contact_person_phone)) {
                this.errorItem.contact_person_phone = "Enter valid mobile number";
                this.isFormValid = false;
            }else {
				this.errorItem.contact_person_phone = "";
			}

			if (
				this.editItem.contact_person_email == null ||
				this.editItem.contact_person_email == ""
			) {
				this.errorItem.contact_person_email =
					"Supplier Contect Email id is required";
				this.isFormValid = false;
			}
             else if (!this.emailRegex.test(this.editItem.contact_person_email)) {
                this.errorItem.contact_person_email = "Enter valid email";
                this.isFormValid = false;
            } else
              {
				this.errorItem.contact_person_email = "";
			}

			return this.isFormValid;
		},
	},
};
</script>
<style scoped>
</style>

