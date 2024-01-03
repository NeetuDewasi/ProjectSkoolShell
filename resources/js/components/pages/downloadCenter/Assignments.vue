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
							<div class="heading-layout1">
								<div class="item-title">
									<h3>Select Criteria</h3>
								</div>
							</div>
							<form class="new-added-form">
								<div class="row">
									<div class="col-xl-6 col-lg-12 form-group">
										<label>Select Class</label>
										<Select2
											ref="class_list"
											placeholder="--SELECT A CLASS--"
											:items="class_list"
											@change="selectClass"
										/>
									</div>
									<div class="col-xl-6 col-lg-12 form-group">
										<label>Select Section</label>
										<Select2
											placeholder="--SELECT A SECTION--"
											ref="section_list"
											:items="section_list"
											@change="selectSection"
										/>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div class="item-title">
								<h3>Assignment List</h3>
							</div>
							<div class="table table-responsive" v-show="!noData">
								<Table
									ref="table"
									:tableData="filterData"
									:tableHead="tableHead"
								/>
							</div>
							<NoData v-show="noData" />
						</div>
					</div>
				</div>
			</div>
		</div>
		<Footer />
	</div>
</template>


<script>
var toast;
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
                    item2: { label: "Title" },
                    item3: { label: "Class" },
                    item4: { label: "Published At" },
                    item5: { label: "Status" },
                    item6: { label: "" },
                },
                actions: true,
            },
            tableData: [],
            isLoaded: false,
            noData: false,
            editedIndex: -1,
            contents: [],
            class_list: [],
            selectedClass: -1,
            selectedClassName: '',
            section_list: [],
            selectedSection: -1,
            selectedSectionName: '',
            upload_contents: -1,
        };
    },
    created() {
       this.getClassList();
    },
    mounted() {
        this.$parent.loadOtherScript();
        toast = Toast.fire({
            icon: "warning",
            title: "Loading Data..",
            timer: 2000,
        });
        this.showData();
    },
    computed: {
        filterData() {
            if (this.selectedClass != -1) {
                if (this.selectedSection != -1) {
                    return this.tableData.filter(item => {
                        return item.data.item3 == (this.selectedClassName + ' ' + this.selectedSectionName);
                    })
                }
                return  this.tableData.filter(item => {
                    return item.data.item3.includes(this.selectedClassName);
                });
            }
            return this.tableData;
        }
    },
    methods: {
        getSelectedClassName() {
            if (this.selectedClass != -1) {
                this.class_list.forEach(element => {
                    if (element.value == this.selectedClass) {
                        this.selectedClassName = element.name;
                    }
                });
            }
        },
        getSelectedSectionName() {
            if (this.selectedSection != -1) {
                this.section_list.forEach(element => {
                    if (element.value == this.selectedSection) {
                        this.selectedSectionName = element.name;
                    }
                });
            }
        },
        async selectClass(val) {
            this.selectedClass = val;
            this.getSelectedClassName();
            if (this.selectedClass == -1) {
        this.section_list = [];
        this.$refs.section_list.updateList([]);
        return;
      }
            const res = await this.callApi(
                "get",
                `/api/school/class/sections/${this.selectedClass}`,
                null,
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.section_list = data.school_class_sections;
                    this.$refs.section_list.updateList(data.school_class_sections);
                }
            }
        },
        async selectSection(val) {
            this.selectedSection = val;
            this.getSelectedSectionName();
        },
        async getClassList() {
            const res = await this.callApi(
                "get",
                `/api/school/general/get_class_list`,
                null,
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.class_list = data.class_list;
                    // console.log("CLASSES_LIST>>>>", this.class_list);
                    this.$refs.class_list.updateList(data.class_list);
                }
            }
        },
        async showData() {
            this.isLoaded = false;
            var formData = new FormData();
            formData.append('content_type', 'assignments');
            const res = await this.callApi(
                "post",
                `/api/school/download_center/contents`,
                formData,
            );
            this.log('showData function',res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.contents = data.contents;
                    this.initTable();
                }
            }
            this.$refs.table.loadTable();
            this.isLoaded = true;
            toast.close();
        },
        initTable() {
			this.tableData = [];
			this.contents.forEach((element) => {
				this.tableData.push({
					item: element,
					data: {
						item1:
							element.upload_content_id != null
								? element.upload_content_id
								: "",
						item2:
							element.upload_title != null
								?  `<span data-html="true" title="${element.upload_description}">${element.upload_title}</span>`: "",
                        item3:
							element.upload_school_class != null
								? element.upload_school_class +
								  (element.upload_school_section != null
										? " " + element.upload_school_section
										: "")
								: "",

						item4:
							element.upload_published_at != null
								? element.upload_published_at
								: "",
						item5: {
                            type: 'action',
                            options: {
                                label: element.upload_status == 'published' ? 'Unpublished' :element.upload_status == 'unpublished' || element.upload_status == 'activated' ? 'Published': '',
                                style: '',
                                class: 'btn btn-light border',
                                method :element.upload_status == 'published' ? this.unpublished :element.upload_status == 'unpublished' || element.upload_status == 'activated' ? this.published: '',
                            }
                        },
                         item6: element.upload_documents != null ?  {
                            type: 'action',
                            options: {
                                style: 'border:none',
                                icon: '<i class="fa fa-download" aria-hidden="true"></i>',
                                method : this.downloadData
                            }
                        } : '',
					},
					action: {
						edit: true,
						delete: true,
					},
				});
			});
		},
        downloadData(item){
            const link = document.createElement('a')
            link.href = item.upload_documents;
            document.body.appendChild(link)
            link.click()
        },
        edit(item, index) {
            this.$router.push({
                path: `/school/download_center/upload_content/add_uploads/${item.upload_content_id}`
            });
        },
        async deleteData(item, index) {
            var data = new FormData();
            data.append("status", "deleted");
            const res = await this.callApi(
                "post",
                `/api/school/download_center/upload_content/delete/${item.upload_content_id}`,
                data
            );
            console.log('Iiiid', item.upload_content_id);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.contents.splice(index, 1);
                    this.tableData.splice(index, 1);
                    SwalCustomBtn.fire("Deleted!", data.message, "success");
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                }
                else {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                }
            }

        },
        async published(item, index) {
            var data = new FormData();
            data.append("status", "published");
            const res = await this.callApi(
                "post",
                `/api/school/download_center/upload_content/delete/${item.upload_content_id}`,
                data
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.contents.splice(index, 1);
                    this.tableData.splice(index, 1);
                    SwalCustomBtn.fire("Published!", data.message, "success");
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                }
                else {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                }
            }

        },
        async unpublished(item, index) {
            var data = new FormData();
            data.append("status", "unpublished");
            const res = await this.callApi(
                "post",
                `/api/school/download_center/upload_content/delete/${item.upload_content_id}`,
                data
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.contents.splice(index, 1);
                    this.tableData.splice(index, 1);
                    SwalCustomBtn.fire("Unpublished!", data.message, "success");
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                }
                else {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                }
            }

        },
    },
};
</script>






