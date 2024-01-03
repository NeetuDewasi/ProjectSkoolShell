<template>
	<div class="card">
		<div class="card-body">
			<div class="heading-layout1">
				<div class="item-title">
					<h3>Add Class</h3>
				</div>
			</div>

			<div class="new-added-form">
					<div class="flex-grow-1 mr-5 form-group">
						<span
							class="error-label"
							v-if="errorItem.class_number != ''"
							v-text="errorItem.class_number"
						></span>
						<select
							class="form-control"
							v-model="editItem.class_number"
							@change="errorItem.class_number = ''"
							:class="
								errorItem.class_number != ''
									? 'error-field'
									: ''
							"
						>
							<option v-for="num in 12" :key="num" :value="num">
								Class {{ num }}
							</option>
						</select>
					</div>
					<div class="form-group">
						<button
							type="button"
							class="btn btn-fill-sm mr-1 rounded text-light shadow-dodger-blue bg-dodger-blue"
							@click.prevent="saveData()"
						>
							SAVE
						</button>
					</div>
			</div>
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
				class_number: "",
			},
			isFormValid: false,
		};
	},
	methods: {
		async saveData() {
			var isVaild = await this.validClassForm();
			if (!isVaild) {
				return;
			}
			this.$parent.saveData(this.editItem);
		},
		validClassForm() {
			this.isFormValid = true;
			if (
				this.editItem.class_number == null ||
				this.editItem.class_number == ""
			) {
				this.errorItem.class_number = "Class Name is required";
				this.isFormValid = false;
			} else {
				this.errorItem.class_number = "";
			}
			return this.isFormValid;
		},
	},
};
</script>
