<template>
	<div>
		<div class="dashboard-content-one">
			<Breadcrumb
				pageTitle="Send Message  "
				:breadcrumbList="breadcrumbList"
			/>
			<div class="row gutters-20">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<form class="new-added-form">
								<div class="row">
									<div class="col-lg-7 col-12 form-group">
										<div class="heading-layout1">
											<div class="item-title">
												<h3>
													<span
														class="
															fas
															fa-envelope-square
														"
													></span>
													Compose New Message
												</h3>
											</div>
										</div>
										<label>Title</label>
										<input
											type="text"
											class="form-control mb-4"
											v-model="editItem.title"
										/>
										<label>Message</label>
										<VueTrix class="h-300" />
									</div>

									<div class="col-lg-5 col-12">
										<div
											class="
												new-added-form
												form-group
												mt-5
											"
										>
											<label>Notice Date</label>
											<input
												type="date"
												class="form-control mb-4"
												v-model="editItem.notice_date"
												placeholder
												:class="
													errorItem.notice_date !== ''
														? 'error-field'
														: ''
												"
												@click="
													editItem.notice_date != ''
														? (errorItem.notice_date =
																'')
														: ''
												"
											/>
											<span
												class="error-label"
												v-if="
													errorItem.notice_date != ''
												"
												v-text="errorItem.notice_date"
											></span>
											/> />
										</div>
										<div class="new-added-form form-group">
											<label>Publish On</label>
											<input
												type="text"
												class="form-control mb-4"
												v-model="publish_date"
												placeholder
												:class="
													errorItem.publish_date !==
													''
														? 'error-field'
														: ''
												"
												@click="
													editItem.publish_date != ''
														? (errorItem.publish_date =
																'')
														: ''
												"
											/>
											<span
												class="error-label"
												v-if="
													errorItem.publish_date != ''
												"
												v-text="errorItem.publish_date"
											></span>
											/>
										</div>
										<label>Message To:</label>
										<div class="form-check">
											<input
												type="checkbox"
												class="
													form-check-input
													checkAll
												"
											/>
											<label class="form-check-label"
												>Teacher</label
											>
										</div>
										<div class="form-check">
											<input
												type="checkbox"
												class="
													form-check-input
													checkAll
												"
											/>
											<label class="form-check-label"
												>Student</label
											>
										</div>
										<div class="form-check">
											<input
												type="checkbox"
												class="
													form-check-input
													checkAll
												"
											/>
											<label class="form-check-label"
												>Guardian</label
											>
										</div>
										<div class="form-check">
											<input
												type="checkbox"
												class="
													form-check-input
													checkAll
												"
											/>
											<label class="form-check-label"
												>Admin</label
											>
										</div>
										<div class="form-check">
											<input
												type="checkbox"
												class="
													form-check-input
													checkAll
												"
											/>
											<label class="form-check-label"
												>Accountant</label
											>
										</div>
										<div class="form-check">
											<input
												type="checkbox"
												class="
													form-check-input
													checkAll
												"
											/>
											<label class="form-check-label"
												>Librarian</label
											>
										</div>
										<div class="form-check">
											<input
												type="checkbox"
												class="
													form-check-input
													checkAll
												"
											/>
											<label class="form-check-label"
												>Receptionist</label
											>
										</div>
										<div class="form-check">
											<input
												type="checkbox"
												class="
													form-check-input
													checkAll
												"
											/>
											<label class="form-check-label"
												>Parent</label
											>
										</div>
										<div class="form-check">
											<input
												type="checkbox"
												class="
													form-check-input
													checkAll
												"
											/>
											<label class="form-check-label"
												>Super Admin</label
											>
										</div>
									</div>
								</div>
								<div class="col-lg-12 col-12 form-group mg-t-8">
									<div
										class="
											col-xl-12 col-lg-12
											form-group
											mg-t-8
										"
									>
										<button
											type="submit"
											class="
												btn
												btn-lg
												btn-gradient-yellow
												btn-hover-bluedark
												mx-3
												text-white
											"
										>
											{{ formBtn }}
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<Footer />
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
					name: "Send Message",
				},
			],
			editItem: {},
			errorItem: {},
		};
	},
	computed: {
		formBtn: function () {
			return this.editedIndex !== -1 ? "Update" : "Save";
		},
	},
	mounted() {
		this.$parent.loadOtherScript();
	},
	methods: {
		async submitData() {
			var isVaild = await this.validContentForm();
			if (!isVaild) {
				return;
			}
			if (this.editedIndex !== -1) {
				this.updateData();
			} else {
				this.saveData();
			}
		},
		async saveData() {
			/*delete this line later */
			toast = Toast.fire({
				icon: "warning",
				title: "Please Wait!! Creating new Content",
				timer: 0,
			});
			var data = new FormData();
			data.append("publish_date", this.editItem.publish_date);
			data.append("notice_date", this.editItem.notice_date);

			const res = await this.callApi(
				"post",
				`/api/school/download_center/upload_content/save`,
				data,
				"multipart"
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.contentList.push(data.upload_content);

					toast = Toast.fire({
						icon: "success",
						title: data.message,
						timer: 2500,
					});
				} else {
					toast = Toast.fire({
						icon: data.status,
						title: data.message,
						timer: 2500,
					});
				}
			} else {
				toast = Toast.fire({
					icon: data.status,
					title: data.message,
					timer: 2500,
				});
			}
		},
		validContentForm() {
			this.isFormValid = true;

			if (
				this.editItem.publish_date == null ||
				this.editItem.publish_date == ""
			) {
				this.errorItem.publish_date = "Publish Date  is required";
				this.isFormValid = false;
			} else {
				this.errorItem.publish_date = "";
			}
			if (
				this.editItem.notice_date == null ||
				this.editItem.notice_date == ""
			) {
				this.errorItem.notice_date = "Notice Date is required";
				this.isFormValid = false;
			} else {
				this.errorItem.notice_date = "";
			}
		},
	},
};
</script>



