<template>
	<div>
		<div class="dashboard-content-one">
			<Breadcrumb
				pageTitle="Download Center"
				:breadcrumbList="breadcrumbList"
			/>
			<div class="row gutters-20">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div class="heading-layout1">
								<div class="item-title">
									<h3>Upload Content</h3>
								</div>
							</div>
							<form class="new-added-form">
								<div class="row">
									<div class="col-lg-6 col-12 form-group">
										<label>Title</label>
										<input
											type="text"
											class="form-control mb-4"
											v-model="editItem.title"
										/>
									</div>
									<div
										class="col-lg-6 classSection form-group"
									>
										<div
											class="
												form-check
												available-class-section
											"
										>
											<input
												type="checkbox"
												class="
													form-check-input
													checkAll
												"
												id="is-show-check-box"
												@click="isShowClassSection"
											/>
											<label class="form-check-label"
												>Available For :</label
											>
										</div>
										<div class="row" v-if="isShow">
											<div class="col-3">
												<label>Class</label>
												<Select2 :items="classList" />
											</div>
											<div class="col-3">
												<label>Section</label>
												<Select2
													:items="[
														{
															value: 0,
															name: 'Select',
														},
														{ value: 1, name: 'A' },
														{ value: 2, name: 'B' },
													]"
												/>
											</div>

											<div
												class="
													form-check form-group
													col-6
												"
											>
												<input
													type="checkbox"
													class="
														form-check-input
														checkAll
													"
													v-model="
														editItem.contentFor
													"
												/>
												<label class="form-check-label"
													>Students</label
												>
											</div>
										</div>
									</div>
								</div>

								<div class="col-6">
									<div class="col-lg-6 col-12 form-group">
										<label>Content Type</label>
										<select
											class="select2"
											v-model="editItem.type"
										>
											<option value="0">
												Select Type
											</option>
											<option value="2">B</option>
										</select>
									</div>
								</div>

								<div class="row">
									<div class="col-xl-3 col-lg-12 form-group">
										<label>Upload Date</label>
										<input
											type="date"
											class="form-control mb-4"
											ref="published_at"
											v-model="editItem.published_at"
										/>
									</div>
									<div class="col-lg-6 col-12 form-group">
										<label class="text-dark-medium"
											>Attach Document</label
										>
										<input
											type="file"
											class="form-control-file mt-2"
										/>
									</div>
									<div class="col-xl-6 col-lg-12 form-group">
										<label>Description</label>
										<textarea
											class="textarea form-control"
											name="message"
											id="form-message"
											cols="10"
											rows="4"
											v-model="editItem.description"
										></textarea>
									</div>
								</div>

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
										@click.prevent="submitData()"
									>
										Save
									</button>
									<button
										type="reset"
										class="
											btn
											btn-lg
											btn-gradient-yellow
											btn-hover-bluedark
											mx-3
											text-white
										"
									>
										Reset
									</button>
									<button
										type="reset"
										class="
											btn
											btn-lg
											btn-gradient-yellow
											btn-hover-bluedark
											mx-3
											text-white
										"
										@click="$router.push('uploads')"
									>
										View
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>


<script>
import UploadTable from "./UploadTable.vue";
import Select2 from "../../common/Select2.vue";
var headers = {
	"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
};
export default {
	components: {
		UploadTable,
		Select2,
	},

	data() {
		return {
			breadcrumbList: [
				{
					to: { name: "admin.dashboard" },
					name: "Home",
				},
				{
					name: "Upload Content",
				},
			],
			contentList: [],
			initcontentList: [],
			isLoaded: false,
			noData: false,
			editItem: {},
			editedIndex: -1,
			isShow: false,
			// contentFor:[],
			classList: [],
		};
	},
	computed: {
		formBtn: function () {
			return this.editedIndex !== -1 ? "Update" : "Save";
		},
	},
	mounted() {
		this.$parent.loadOtherScript();

		this.getClassList();
	},

	methods: {
		isShowClassSection() {
			if ($("#is-show-check-box").is(":checked")) {
				this.isShow = true;
			} else {
				this.isShow = false;
			}
		},
		async getClassList() {
			const res = await this.callApi(
				"get",
				`/api/school/general/get_class_list`,
				null,
				headers
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.classList = data.class_list;
				} else {
					this.noData = true;
				}
			}
		},
		getSelectedData(value) {},
		// editData(item){
		//     this.editItem = item;
		//     this.editedIndex = item.content_id;
		// },
		// async updateData() {
		//     var data = new FormData();
		//     data.append("name", this.editItem.category_name);

		//     const res = await this.callApi(
		//         "post",
		//         `/api/school/download_center/upload_contents/update/${this.editedIndex}`,
		//         data,
		//         headers
		//     );
		//
		//     if (res.status == 200) {
		//         var data = res.data;
		//         if(data.status == 'success'){
		//             this.contentList[this.editedIndex].content_type = this.editItem.content_type
		//         }
		//     }
		// },

		submitData() {
			if (this.editedIndex !== -1) {
				// editedIndex = -1
				this.updateData();
			} else {
				this.saveData();
			}
		},
		async saveData() {
			var data = new FormData();
			data.append("user_id", 1);
			data.append("class", 1);
			data.append("section", "A");
			data.append("title", this.editItem.title);
			data.append("content_type", 1);
			// data.append("content_for", this.editItem.content_for);
			data.append("published_at", this.$refs.published_at.value);
			data.append("description", this.editItem.description);
			data.append("documents", null);

			const res = await this.callApi(
				"post",
				`/api/school/download_center/upload_content/save`,
				data,
				headers
			);

			if (res.status == 200) {
				this.editItem = {};
			}
		},
		// async deleteData(item, status) {
		//     var data = new FormData();
		//     data.append("status", status);
		//     const res = await this.callApi(
		//         "post",
		//         `/api/school/download_center/upload_content/delete/${item.content_id}`,
		//         data,
		//         headers
		//     );

		//     if (res.status == 200) {
		//         var data = res.data;
		//         if (data.status == "success") {
		//             this.contentList.splice(this.contentList.indexOf(item), 1)
		//         } else {
		//             // show toast;
		//         }
		//     }
		// },
	},
};
</script>
<style scoped>
/*.classSection{
    background-color: #efececf7 !important;
}  */
.available-class-section {
	margin-top: 15px !important;
}
</style>


