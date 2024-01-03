<template>
    <div>
        <!-- <div class="dashboard-content-one">
			<Breadcrumb
				pageTitle="Download Center"
				:breadcrumbList="breadcrumbList"
			/>
			<div class>
				<div
					class="
						btn btn-gradient-yellow btn-hover-bluedark
						mx-3
						text-white
					"
					@click="
						$router.push({
							name: 'school.download_center.add_uploads',
						})
					"
				>
					Add Content
				</div>
			</div> -->

        <div class="card">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Content List</h3>
                    </div>
                </div>
                <div class="table table-responsive" v-show="!noData">
                    <Table ref="table" :tableData="tableData" :tableHead="tableHead" />
                </div>
                <NoData v-show="noData" />
            </div>
        </div>
    </div>
</template>

<script>

var toast;
export default {
    data() {
        return {
            tableHead: {
                items: {
                    item1: { label: "Sr.No." },
                    item2: { label: "Title" },
                    item3: { label: "Content Type" },
                    item4: { label: "Available For" },
                    item5: { label: "Published At" },
                    item6: { label: "Status" },
                },
                actions: true,
            },
            tableData: [],
            isLoaded: false,
            noData: false,
            editedIndex: -1,
            classId: -1,
            sectionId: -1,
            content_list: [],
            contents: [],
        };
    },
    created() {
        toast = Toast.fire({
            icon: "warning",
            title: "Loading data..",
            timer: 0,
        });
        this.showData();
    },

    mounted() {
        // this.$parent.loadOtherScript();
    },
    methods: {
        async showData() {
            this.isLoaded = false;
            let formData = new FormData();
            // formData.append('content_type', 'assignments');
            const res = await this.callApi(
                "post",
                `/api/school/download_center/contents`,
                null
            );
            this.log('Content daaataaa', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.content_list = data.contents;
                    this.initTable();
                }
            }
            this.$refs.table.loadTable();
            this.isLoaded = true;
            toast.close();
        },
        initTable() {
            this.tableData = [];
            this.content_list.forEach((element) => {
                this.tableData.push({
                    item: element,
                    data: {
                        item1:
                            element.upload_content_id != null
                                ? element.upload_content_id
                                : "",
                        item2:
                            element.upload_title != null
                                ? `<span data-html="true" title="${element.upload_description}"> ${element.upload_title}</span>`
                                : "",
                        item3: element.upload_content_type != null
                            ? element.upload_content_type
                            : "",

                        item4: element.upload_school_class != null ? (element.upload_school_class + (element.upload_school_section != null ? (' ' + element.upload_school_section) : '')) : '',

                        item5:
                            element.upload_published_at != null
                                ? element.upload_published_at
                                : "",
                        item6: {
                            type: 'action',
                            options: {
                                label: element.upload_status == 'published' ? 'Unpublished' : element.upload_status == 'unpublished' || element.upload_status == 'activated' ? 'Published' : '',
                                style: '',
                                class: 'btn btn-light border',
                                method: element.upload_status == 'published' ? this.unpublished : element.upload_status == 'unpublished' || element.upload_status == 'activated' ? this.published : '',
                            }
                        },
                        item7: {
                            type: 'action',
                            options: {
                                style: 'border:none',
                                icon: '<i class="fa fa-eye" aria-hidden="true"></i>',
                            }
                        },
                        item8: {
                            type: 'action',
                            options: {
                                style: 'border:none',
                                icon: '<i class="fa fa-download" aria-hidden="true"></i>',
                                method: this.downloadFile
                            }
                        },
                    },
                    action: {
                        edit: true,
                        delete: true,
                    },
                });
            });
        },

        downloadFile(item) {
            // const url = window.URL.createObjectURL(new Blob([this.content_list]))
            const link = document.createElement('a')
            link.href = item.upload_documents;
            document.body.appendChild(link)
            link.click()
        },

        edit(item, index) {
            this.$parent.edit(item, index);
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
    },
};
</script>
<style scoped>
able-class-section {
    margin-top: 15px !important;
}
</style>


