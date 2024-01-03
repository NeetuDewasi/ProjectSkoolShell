<template>
	<div>
		<div class="dashboard-content-one">
			<Breadcrumb
				pageTitle="Assignments"
				:breadcrumbList="breadcrumbList"
			/>

      <div class="row gutters-20">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="item-title text-center bg-danger">
                <h3>Assignment List</h3>
              </div>
              <!-- <div class="table" v-show="!noData">
                <Table ref="table" :tableData="filterData" :tableHead="tableHead" />
              </div>
              <NoData v-show="noData" />-->
							<div class="row">
								<div class="col-12">
									<label>Content Title :</label>
									{{ content.upload_title }}
								</div>
								<div class="col-12">
									<label>Class :</label>
									{{ content.upload_school_class }}
								</div>
								<div class="col-12">
									<label>Section :</label>
									{{ content.upload_school_section }}
								</div>
								<div class="col-12">
									<label>Content type :</label>
									{{ content.upload_content_type }}
								</div>
								<div class="col-12">
									<label>Upload Date :</label>
									{{ content.upload_published_at }}
								</div>
								<div class="col-12">
									<label>Description :</label>
									{{ content.upload_description }}
								</div>
								<div class="col-12">
									<label>Uploaded Document :</label>

									<img :src="content.upload_documents" />
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<Footer />
	</div>
</template>

<script>
// var toast;
export default {
	data() {
		return {
			breadcrumbList: [
				{
					to: { name: "admin.dashboard" },
					name: "Home",
				},
				{
					name: "Assignment",
				},
			],
			content_list: [],
			tableHead: {
				items: {
					item1: { label: "Sr.No." },
					item2: { label: "Class" },
					item3: { label: "Title" },
					item4: { label: "Content For" },
					item5: { label: "Published At" },
					item7: { label: "" },
				},
				actions: true,
			},
			// tableData: [],
			// isLoaded: false,
			// noData: false,
			// editedIndex: -1,
			content: [],
			class_list: [],
			selectedClass: -1,
			selectedClassName: "",
			section_list: [],
			// selectedSection: -1,
			// selectedSectionName: '',
			upload_content_id: -1,
		};
	},
	created() {
		this.upload_content_id = this.$route.params.upload_content_id;
		this.showData();
		this.$parent.loadOtherScript();
	},
	methods: {
		async showData() {
			this.isLoaded = false;
			const res = await this.callApi(
				"get",
				`/api/school/download_center/upload_content/${this.upload_content_id}`,
				null
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.content = data.content;
				}
			}
			this.isLoaded = true;
		},
		// getExtension(item) {
		//     if (
		//         item.split(".")[1] == "png" ||
		//         item.split(".")[1] == "jpg" ||
		//         item.split(".")[1] == "jpeg"
		//     ) {
		//         return 'image'
		//     } else if (
		//         item.split(".")[1] == "doc" ||
		//         item.split(".")[1] == "docx"
		//     ) {
		//         return "doc";
		//     } else if (
		//         item.split(".")[1] == "xls" ||
		//         item.split(".")[1] == "xlsx"
		//     ) {
		//         return "excel";
		//     } else if (item.split(".")[1] == "pdf") {
		//         return "pdf";
		//     }
		// }
	},
};
</script>

