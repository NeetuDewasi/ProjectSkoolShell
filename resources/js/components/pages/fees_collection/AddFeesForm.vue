    <template>
	<div>
		<div class="dashboard-content-one">
			<!-- Breadcubs Area Start -->
			<Breadcrumb pageTitle="Add Fees" :breadcrumbList="breadcrumbList" />
			<!-- End Breadcubs Area -->
			<!-- Add Fees Area Start Here -->
			<div class="row gutters-20">
				<div class="col-12">
					<div class="card height-auto">
						<div class="card-body">
							<div class="heading-layout1">
								<div class="item-title">
									<h3>Add Fees</h3>
								</div>
							</div>
							<form class="new-added-form">
								<div class="row gutters-8">
									<div
										class="
											col-xl-4 col-lg-6 col-12
											form-group
										"
									>
										<label>
											Date
											<span class="text-danger bolder"
												>*</span
											></label
										>
										<DatePicker
											format="DD-MMM-YYYY"
											value-type="format"
											type="date"
											placeholder="Select a date"
											v-model="displayDate"
											:default-value="new Date()"
											:disabled-date="disabledAfterToday"
											class="
												form-control
												vue-datepicker
												my-0
												w-100
											"
											:class="
												errorItem.fees_date != ''
													? 'error-field'
													: ''
											"
										/>
										<span
											class="error-label"
											v-if="errorItem.fees_date != ''"
											v-text="errorItem.fees_date"
										>
										</span>
									</div>
									<div
										class="
											col-xl-4 col-lg-6 col-12
											form-group
										"
									>
										<label
											>Amount
											<span class="text-danger bolder"
												>*</span
											></label
										>
										<input
											type="text"
											placeholder=""
											class="form-control"
											v-model="editItem.fees_amount"
											:class="
												errorItem.fees_amount != ''
													? 'error-field'
													: ''
											"
											@keyup="
												editItem.fees_amount != ''
													? (errorItem.fees_amount =
															'')
													: ''
											"
										/>
										<span
											class="error-label"
											v-if="errorItem.fees_amount != ''"
											v-text="errorItem.fees_amount"
										>
										</span>
									</div>
									<div
										class="
											col-xl-4 col-lg-6 col-12
											form-group
										"
									>
										<label>Discount Group</label>
										<Select2
											ref="fees_discount_list"
											:items="fees_discount_list"
											:selectedId="selectedFeesDiscount"
											@change="selectFeesDiscount"
										/>
									</div>
									<div
										class="
											col-xl-6 col-lg-6 col-12
											form-group
										"
									>
										<label>Discount Amount </label>
										<input
											type="phone"
											placeholder=""
											class="form-control"
											v-model="
												editItem.fees_discount_amount
											"
											readonly
										/>
									</div>
									<div
										class="
											col-xl-6 col-lg-6 col-12
											form-group
										"
									>
										<label>Fine</label>
										<input
											type="text"
											placeholder=""
											class="form-control"
											v-model="editItem.fees_fine_amount"
											readonly
										/>
									</div>
									<div
										class="
											col-xl-6 col-lg-6 col-12
											form-group
										"
									>
										<label>Description</label>
										<textarea
											class="textarea form-control"
											name="message"
											id="form-message"
											cols=""
											rows=""
											v-model="editItem.fees_description"
										></textarea>
									</div>
									<div
										class="
											col-xl-6 col-lg-6 col-12
											form-group
										"
									>
										<label
											>Payment Mode
											<span class="text-danger bolder"
												>*</span
											>
										</label>
										<div class="form-group mt-3 ms-2">
											<input
												type="radio"
												class="form-radio-input"
												value="cash"
												v-model="
													editItem.fees_payment_mode
												"
											/>
											<span for="" class="ml-2"
												>Cash</span
											>
											<input
												type="radio"
												class="form-radio-input ml-3"
												value="cheque"
												v-model="
													editItem.fees_payment_mode
												"
											/>
											<span for="" class="ml-1"
												>Cheque</span
											>
											<input
												type="radio"
												class="form-radio-input"
												value="dd"
												v-model="
													editItem.fees_payment_mode
												"
											/>
											<span for="" class="ml-2">DD</span>
											<input
												type="radio"
												class="form-radio-input ml-3"
												value="bank"
												v-model="
													editItem.fees_payment_mode
												"
											/>
											<span for="" class="ml-1"
												>Bank Transfer</span
											>
											<input
												type="radio"
												class="form-radio-input"
												value="upi"
												v-model="
													editItem.fees_payment_mode
												"
											/>
											<span for="" class="ml-2">UPI</span>
											<input
												type="radio"
												class="form-radio-input ml-3"
												value="card"
												v-model="
													editItem.fees_payment_mode
												"
											/>
											<span for="" class="ml-1"
												>Card</span
											>
										</div>
									</div>
								</div>
								<div class="d-flex justify-content-end mg-t-8">
									<button
										type="submit"
										class="
											btn-fill-lg
											text-light
											shadow-dodger-blue
											bg-dodger-blue
										"
										@click.prevent="submitForm()"
									>
										{{ formBtn }}
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- Add Fees Area End Here -->
			<Footer />
		</div>
	</div>
</template>

<script>
var toast;
export default {
	data() {
		return {
			breadcrumbList: [
				{
					to: { name: "school.dashboard" },
					name: "Home",
				},
				{
					to: { name: "school.fees.statement" },
					name: "Fees Statement",
				},
				{
					name: "Add Fees",
				},
			],
			editItem: {
				fees_payment_mode: "cash",
			},
			fees_discount_list: [],
			selectedFeesDiscount: -1,
			fees_admission_id: -1,
			fees_master_id: -1,
			displayDate: "",
			errorItem: {
				fees_date: "",
				fees_amount: "",
			},
			fees_date: moment(new Date()).format("YYYY-MM-DD"),
		};
	},
	computed: {
		formBtn: function () {
			return this.$route.params.edit_id  ? "update" : "save";
		},
	},
	watch: {
		displayDate: function (val) {
			this.displayDate = val;
			this.fees_date = moment(new Date(val)).format("YYYY-MM-DD");
			this.errorItem.fees_date = "";
			if (val == null || val == "") {
				this.errorItem.fees_date = "Fees Date is required";
			}
		},
	},
	mounted() {
		this.$parent.loadOtherScript();

		if (this.$route.params.edit_id &&
		this.$route.params.fee_master_id) {
            this.fees_master_id = this.$route.params.fee_master_id;
			 this.getEditData();
		}

		if (
            this.$route.params.student_id &&
			this.$route.params.fees_master_id
		) {
			this.fees_master_id = this.$route.params.fees_master_id;
			this.fees_admission_id = this.$route.params.student_id;

		}
            this.getFeesDiscountData();

		this.displayDate = moment(new Date()).format("DD-MMM-YYYY");
	},
	methods: {
		disabledAfterToday(date) {
			const today = new Date();
			today.setHours(0, 0, 0, 0);

			return date > today;
		},
		async getEditData() {
			const res = await this.callApi(
				"get",
				`/api/school/fees_collection/add_fees/edit/${this.$route.params.edit_id}`,
				null
			);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
				    this.editItem = data.add_fee;
                    this.selectedFeesDiscount = data.add_fee.fees_discount_id.value;
                    this.$refs.fees_discount_list.setSelected(data.add_fee.fees_discount_id.value);
                    this.fees_admission_id = data.add_fee.fees_admission_id.student_admission_id;
                    this.displayDate = moment(String(data.add_fee.fees_date)).format("DD-MMM-YYYY");
                    this.fees_date = moment(String( data.add_fee.fees_date)).format("YYYY-MM-DD");
				}
			}
		},
		async getFeesDiscountData() {
			var data = new FormData();
			data.append("fee_master", this.fees_master_id);
			const res = await this.callApi(
				"post",
				`/api/school/fees_collection/add_fees/fees_discount_list`,
				data
			);
			if (res.status == 200) {
				var data = res.data;
                if(!this.$route.params.edit_id){
                    this.fees_discount_list = data.fees_discount_list;
                    this.editItem.fees_amount = data.amount;
                    this.editItem.fees_fine_amount = data.fine_amount;
                }
				this.$refs.fees_discount_list.updateList(data.fees_discount_list);
			}
		},
		selectFeesDiscount(val) {
			this.selectedFeesDiscount = val;
            this.log(this.selectedFeesDiscount);
			this.fees_discount_list.forEach((element) => {
				if (this.selectedFeesDiscount == element.value) {
					this.editItem.fees_discount_amount = element.amount;
				}
			});
		},
		async submitForm() {
			var isVaild = await this.validAddFeesForm();
			if (!isVaild) {
				return;
			}

			toast = Toast.fire({
				icon: "warning",
				title: "Please Wait!! Creating new Fees Master",
				timer: 0,
			});
			var data = new FormData();

			data.append("fees_admission_id", this.fees_admission_id);
			data.append("fees_master_id", this.fees_master_id);
			data.append("fees_discount_id", this.selectedFeesDiscount);
			data.append("fees_date", this.fees_date ? this.fees_date : "");
			data.append(
				"fees_amount",
				this.editItem.fees_amount ? this.editItem.fees_amount : 0
			);
			data.append(
				"fees_discount_amount",
				this.editItem.fees_discount_amount
					? this.editItem.fees_discount_amount
					: 0
			);
			data.append(
				"fees_fine_amount",
				this.editItem.fees_fine_amount
					? this.editItem.fees_fine_amount
					: 0
			);
			data.append(
				"fees_payment_mode",
				this.editItem.fees_payment_mode
					? this.editItem.fees_payment_mode
					: ""
			);
			data.append(
				"fees_description",
				this.editItem.fees_description
					? this.editItem.fees_description
					: ""
			);
			let $url = "";
			if (this.$route.params.edit_id) {
				$url = `/api/school/fees_collection/add_fees/update/${this.$route.params.edit_id}`;
			} else {
				$url = `/api/school/fees_collection/add_fees/save`;
			}
			const res = await this.callApi("post", $url, data);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.editItem = {};
					if (this.$route.params.edit_id) {
						toast = Toast.fire({
							icon: data.status,
							title: data.message,
							timer: 2500,
						});
                        if(!this.$route.params.edit_id){
                            this.$router.push(
                                `/school/fees/statement/${this.fees_admission_id}`
                            );
                        }else{
                            this.$router.go(-1);
                        }
					}
					toast = Toast.fire({
						icon: data.status,
						title: data.message,
						timer: 2500,
					});

					this.$router.push(
						`/school/fees/statement/${this.fees_admission_id}`
					);
				} else {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                }
			} else {
				toast = Toast.fire({
					icon: "error",
					title: "Something went wrong",
					timer: 2500,
				});
			}
		},
		validAddFeesForm() {
			let isFormValid = true;
			if (this.fees_date == null || this.fees_date == "") {
				this.errorItem.fees_date = "Fees Date is required";
				isFormValid = false;
			} else {
				this.errorItem.fees_date = "";
			}
			if (
				this.editItem.fees_amount == null ||
				this.editItem.fees_amount == ""
			) {
				this.errorItem.fees_amount = "Fees Amount is required";
				isFormValid = false;
			} else {
				this.errorItem.fees_amount = "";
			}
			return isFormValid;
		},
	},
};
</script>


<style scoped>
</style>
