   <template>
	<div>
		<form class="new-added-form">
			<div class="row">
				<div class="col-12 form-group">
					<label
						>Vehicle Number
						<span class="text-danger">*</span></label
					>
					<span
						class="error-label"
						v-text="errorItem.vehicle_no"
					></span>
					<input
						type="text"
						name="vehicle_no"
						:class="errorItem.vehicle_no != '' ? 'error-field' : ''"
						v-model="editItem.vehicle_no"
						placeholder="Number"
						@keyup="errorItem.vehicle_no = ''"
						class="form-control"
					/>
				</div>
				<div class="col-12 form-group">
					<label
						>Registration Number
						<span class="text-danger">*</span></label
					>
					<span
						class="error-label"
						v-text="errorItem.vehicle_registration_no"
					></span>
					<input
						type="text"
						name="vehicle_registration_no"
						:class="
							errorItem.vehicle_registration_no != ''
								? 'error-field'
								: ''
						"
						v-model="editItem.vehicle_registration_no"
						placeholder="eg . AP 00 BP 0000"
						@keyup="errorItem.vehicle_registration_no = ''"
						class="form-control"
					/>
				</div>
				<div class="col-12 form-group">
					<label
						>Vehicle Model <span class="text-danger">*</span></label
					><span
						class="error-label"
						v-text="errorItem.vehicle_model"
					></span>
					<input
						type="text"
						name="vehicle_model"
						:class="
							errorItem.vehicle_model != '' ? 'error-field' : ''
						"
						v-model="editItem.vehicle_model"
						placeholder="vehicle name"
						@keyup="errorItem.vehicle_model = ''"
						class="form-control"
					/>
				</div>
				<div class="col-12 form-group">
					<label>Year Model <span class="text-danger">*</span> </label
					><span
						class="error-label"
						v-text="errorItem.vehicle_model_year"
					></span>
					<input
						type="text"
						name="vehicle_model_year"
						:class="
							errorItem.vehicle_model_year != ''
								? 'error-field'
								: ''
						"
						v-model="editItem.vehicle_model_year"
						placeholder="eg . 0000"
						@keyup="errorItem.vehicle_model_year = ''"
						class="form-control"
					/>
				</div>
				<div class="col-12 form-group">
					<label
						>Insurance Date
						<span class="text-danger">*</span> </label
					><span
						class="error-label"
						v-text="errorItem.vehicle_insurance_date"
					></span>
					<input
						type="date"
						:class="
							errorItem.vehicle_insurance_date != ''
								? 'error-field'
								: ''
						"
						v-model="editItem.vehicle_insurance_date"
						placeholder="Insurance"
						@click="errorItem.vehicle_insurance_date = ''"
						class="form-control"
					/>
				</div>
				<div class="col-12 form-group">
					<label>PUC Date <span class="text-danger">*</span></label
					><span
                        type="date"
						class="error-label"
						v-text="errorItem.vehicle_puc_date"
					></span>
					<input
						type="date"
						:class="
							errorItem.vehicle_puc_date != ''
								? 'error-field'
								: ''
						"
						v-model="editItem.vehicle_puc_date"
						@click="errorItem.vehicle_puc_date = ''"
						class="form-control"
					/>
				</div>
				<div class="col-12 form-group">
					<label
						>Service Date <span class="text-danger">*</span></label
					><span
						class="error-label"
						v-text="errorItem.vehicle_service_date"
					></span>
					<input
						type="date"
						:class="
							errorItem.vehicle_service_date != ''
								? 'error-field'
								: ''
						"
						@click="errorItem.vehicle_service_date = ''"
						v-model="editItem.vehicle_service_date"
						class="form-control"
					/>
				</div>
				<div class="col-12 form-group">
					<label>Note </label>
					<textarea
						:class="
							errorItem.vehicle_note != '' ? 'error-field' : ''
						"
						v-model="editItem.vehicle_note"
						rows="3"
						@keyup="errorItem.vehicle_note = ''"
						class="form-control"
					></textarea>
				</div>
				<div class="col-12 form-group">
                    <button @click.prevent="submitForm()" class="
							btn-lg btn btn-gradient-yellow btn-hover-bluedark
							text-white
						">
                        {{ formBtn }}
                    </button>
                    <button type="reset" class="
							btn-lg btn
							bg-blue-dark
							btn-hover-yellow
							text-white
						">
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
	props: ["itemCategories"],
	data() {
		return {
			editedIndex: -1,
			editItem: {},
			errorItem: {
				vehicle_no: "",
				vehicle_registration_no: "",
				vehicle_model: "",
				vehicle_model_year: "",
				vehicle_insurance_date: "",
				vehicle_puc_date: "",
				vehicle_service_date: "",
				vehicle_note: "",
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
		},
		resetForm() {
			this.editItem = {};
			this.editedIndex = -1;
		},
		edit(item) {
			this.editItem = item;
			this.editedIndex = item.vehicle_id;
		},
		validItemForm() {
			this.isFormValid = true;
			if (
				this.editItem.vehicle_no == null ||
				this.editItem.vehicle_no == ""
			) {
				this.errorItem.vehicle_no = "Vehicle Number is required";
				this.isFormValid = false;
			} else {
				this.errorItem.vehicle_no = "";
			}
			if (
				this.editItem.vehicle_registration_no == null ||
				this.editItem.vehicle_registration_no == ""
			) {
				this.errorItem.vehicle_registration_no =
					"Registration Number is required";
				this.isFormValid = false;
			} else {
				this.errorItem.vehicle_registration_no = "";
			}

			if (
				this.editItem.vehicle_model == null ||
				this.editItem.vehicle_model == ""
			) {
				this.errorItem.vehicle_model = "Vehicle Model is required";
				this.isFormValid = false;
			} else {
				this.errorItem.vehicle_model = "";
			}

			if (
				this.editItem.vehicle_model_year == null ||
				this.editItem.vehicle_model_year == ""
			) {
				this.errorItem.vehicle_model_year = "Year Model is required";
				this.isFormValid = false;
			} else {
				this.errorItem.vehicle_model_year = "";
			}

			if (
				this.editItem.vehicle_insurance_date == null ||
				this.editItem.vehicle_insurance_date == ""
			) {
				this.errorItem.vehicle_insurance_date =
					"Insurance Number is required";
				this.isFormValid = false;
			} else {
				this.errorItem.vehicle_insurance_date = "";
			}

			if (
				this.editItem.vehicle_puc_date == null ||
				this.editItem.vehicle_puc_date == ""
			) {
				this.errorItem.vehicle_puc_date = "PUC Date is required";
				this.isFormValid = false;
			} else {
				this.errorItem.vehicle_puc_date = "";
			}

			if (
				this.editItem.vehicle_service_date == null ||
				this.editItem.vehicle_service_date == ""
			) {
				this.errorItem.vehicle_service_date =
					"Service Date No is required";
				this.isFormValid = false;
			} else {
				this.errorItem.vehicle_service_date = "";
			}
			return this.isFormValid;
		},
	},
};
</script>


<style scoped>
</style>


