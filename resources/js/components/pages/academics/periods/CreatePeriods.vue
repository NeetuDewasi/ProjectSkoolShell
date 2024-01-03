<template>
	<div>
		<div class="">
			<div class="form-group">
				<div class="row">
					<div class="col-md-4 col-sm-12">
						<label for="name"
							>Name <span class="text-danger">*</span></label
						>
						<input
							class="form-control"
							type="text"
							placeholder="Enter Periods Name"
							v-model="editItem.period_name"
							:class="
								errorItem.period_name != ''
									? 'error-field '
									: ''
							"
							@keyup="errorItem.period_name = ''"
						/>
						<span
							v-if="errorItem.period_name != ''"
							class="error-label"
							v-text="errorItem.period_name"
						></span>
					</div>
					<div class="col-md-4 col-sm-12">
						<label for="start"
							>Period Start
							<span class="text-danger">*</span></label
						>
						<input
							class="form-control"
							type="time"
							v-model="editItem.period_start"
							:class="
								errorItem.period_start != ''
									? 'error-field'
									: ''
							"
							@click="errorItem.period_start = ''"
						/>
						<span
							v-if="errorItem.period_start != ''"
							class="error-label"
							v-text="errorItem.period_start"
						></span>
					</div>
					<div class="col-md-4 col-sm-12">
						<label for="start">
							Period End
							<span class="text-danger">*</span></label
						>
						<input
							class="form-control"
							type="time"
							v-model="editItem.period_end"
							:class="
								errorItem.period_end != '' ? 'error-field' : ''
							"
							@click="errorItem.period_end = ''"
						/>
						<span
							v-if="errorItem.period_end != ''"
							class="error-label"
							v-text="errorItem.period_end"
						></span>
					</div>
				</div>
			</div>
			<div class="form-group mt-4 float-right">
				<button
					type="button"
					class="
						btn-fill-lg
						text-light
						shadow-dodger-blue
						bg-dodger-blue
					"
					@click.prevent="submitData()"
				>
					{{ submitButton }}
				</button>

				<button
					type="button"
					class="
						ml-3
						btn-fill-lg
						text-light
						shadow-dodger-blue
						btn-gradient-yellow
					"
					@click="resetForm"
				>
					{{ resetButton }}
				</button>
			</div>
		</div>
	</div>
</template>
<script>
export default {
	data() {
		return {
			editItem: {},
			errorItem: {
				period_name: "",
				period_start: "",
				period_end: "",
			},
			editedIndex: -1,
		};
	},
	mounted() {},
	computed: {
		submitButton: function () {
			return this.editedIndex == -1 ? "Save" : "Update";
		},
		resetButton: function () {
			return this.editedIndex == -1 ? "Reset" : "Cancel";
		},
	},
	created() {},
	methods: {
		async submitData() {
			var isValid = await this.formValidation();
			if (!isValid) {
				return;
			}
			this.$parent.submitData(this.editedIndex, this.editItem);
		},
		resetForm() {
			this.editItem = {};
			this.editedIndex = -1;
		},
		formValidation() {
			var isValidForm = false;
			if (
				this.editItem.period_name == null ||
				this.editItem.period_name == ""
			) {
				this.errorItem.period_name = "Name is required";
				isValidForm = false;
			} else {
				this.errorItem.period_name = "";
				isValidForm = true;
			}
			if (
				this.editItem.period_start == null ||
				this.editItem.period_start == ""
			) {
				this.errorItem.period_start = "Start time is required";
				isValidForm = false;
			} else {
				this.errorItem.period_start = "";
				isValidForm = true;
			}
			if (
				this.editItem.period_end == null ||
				this.editItem.period_end == ""
			) {
				this.errorItem.period_end = "end time is required";
				isValidForm = false;
			} else {
				this.errorItem.period_end = "";
				isValidForm = true;
			}
			return isValidForm;
		},
		edit(item) {
			this.editItem = item;
			this.editedIndex = item.period_id;
		},
	},
};
</script>
