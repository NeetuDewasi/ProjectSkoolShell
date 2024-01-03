<template>
  <div>
    <div class="dashboard-content-one">
      <Breadcrumb pageTitle="Download Center" :breadcrumbList="breadcrumbList" />
      <div class>
        <div
          class="btn btn-gradient-yellow btn-hover-bluedark mx-3 text-white"
          @click="
						$router.push({
							name: 'school.download_center.add_uploads',
						})
					"
        >Add Content</div>
      </div>
      <div class="row gutters-20">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>Content List</h3>
                </div>
              </div>
              <div class="table-responsive" v-if="contentList.length">
                <table class="table display text-nowrap">
                  <thead>
                    <tr>
                      <th>Sr.No.</th>
                      <th>User Id</th>
                      <th>School Class</th>
                      <th>School Section</th>
                      <th>Content Title</th>
                      <th>Type</th>
                      <th>Date</th>
                      <th>description</th>
                      <th>documents</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <UploadTable
                      :uploadContent="uploadContent"
                      :index="index"
                      v-for="(
												uploadContent, index
											) in contentList"
                      :key="index"
                    />
                  </tbody>
                </table>
              </div>
              <div v-else>No Data Found</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

var toast;
import Select2 from "../../common/Select2.vue";
var headers = {
	"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
};
export default {
	components: {
		UploadTable,
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
			classess: [],
			sections: [],
			isShow: false,
		};
	},
	mounted() {
		this.$parent.loadOtherScript();
		toast = Toast.fire({
			icon: "warning",
			title: "Loading Data..",
			timer: 0,
		});
		this.showData();
	},
	methods: {
		isShowClassSection() {
			if ($("#is-show-check-box").is(":checked")) {
				this.isShow = true;
			} else {
				this.isShow = false;
			}
		},

		async showData() {
			this.isLoaded = false;
			const res = await this.callApi(
				"get",
				`/api/school/download_center/upload_content`,
				null,
				headers
			);
			toast.close();

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.contentList = data.upload_contents;
				} else if (data.status_code == 300) {
					toast = Toast.fire({
						icon: data.status,
						title: data.message,
						timer: 2500,
					});
					this.noData = true;
				}
			}
			this.isLoaded = true;
		},
		submitData() {
			if (this.$route.params.edit_id) {
				this.updateData();
			} else {
				this.saveData();
			}
		},
		// async saveData() {
		// 	var data = new FormData();
		//     data.append("content_type", this.editItem.content_type);
		//     data.append("title", this.editItem.title);
		//     data.append("content_for", this.editItem.content_for);
		//     data.append("published_at", this.editItem.published_at);
		//     data.append("description", this.editItem.description);
		//     data.append("documents", this.editItem.documents);
		// 	const res = await this.callApi(
		// 		"post",
		// 		`/api/school/download_center/upload_content/save`,
		// 		data,
		// 		headers
		// 	);
		//
		// 	if (res.status == 200) {
		// 		var data = res.data;
		//         this.$router.push('/admin/download_center/uploads');
		//         // show  toast success message
		// 	}
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


