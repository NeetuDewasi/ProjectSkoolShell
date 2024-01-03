<template>
    <div>
    <div class="dashboard-content-one">

            <Breadcrumb pageTitle="Upload Documents " :breadcrumbList="breadcrumbList" />

    <div class="row gutters-20">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title" v-if="schoolDoc">
                            <h3>{{ schoolDoc.school_name }} Documents</h3>
                        </div>
                        <button type="button" class="text-white new-message btn btn-primary" @click="addDocs()">+ Add Documents</button>
                    </div>
                        <div class="row" >
                        <div class="col-lg-12">
                            <div class="white_card card_height_100 mb_30 pt-4">
                                <div class="white_card_body">
                                    <div class="QA_section">
                                        <div class="white_box_tittle list_header mb-0">
                                            <!-- <h4>Assets List</h4> -->
                                        </div>

                                        <div class="QA_table mb_30">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="">
                                                        <div >
                                                            <div v-if="schoolDoc.documents
                                                                ">
                                                                <div v-for="doc,index in schoolDoc.documents" :key="doc.schoolDoc_id
                                                                    " class="p-2 mb-2">
                                                                    <div class="d-flex align-items-center mt-3">
                                                                        <h4>
                                                                            {{
                                                                                doc.fileTitles
                                                                            }}
                                                                        </h4>
                                                                    </div>
                                                                    <div>
                                                                        <div class="row">
                                                                            <div class="col-xl-3"
                                                                               >
                                                                                <div class="text-center card mb-2 pt-3 px-1"
                                                                                   >
                                                                                    <div>
                                                                                        <img :src="doc.files"
                                                                                             width="40" height="40" target="_blank"/>
                                                                                    </div>
                                                                                    <div
                                                                                        class="d-flex align-items-center justify-content-center"
                                                                                        style="
                                                                                        line-height: 16px;
                                                                                        height: 32px;
                                                                                    ">

                                                                                    </div>

                                                                                    <div class="card-footer">
                                                                                        <div
                                                                                            class="d-flex justify-content-between">
                                                                                            <div class="text-center flex-grow-1 asset-menu-item"
                                                                                                @click="
																								editDoc(

																								)
																							">
                                                                                                <i class="fas fa-edit text-primary"></i>
                                                                                                <div class="font-10">
                                                                                                    Edit<br />
                                                                                                </div>
                                                                                            </div>
                                                                                            <div
                                                                                                class="asset-menu-item-separator">
                                                                                            </div>
                                                                                            <div class="text-center flex-grow-1 asset-menu-item"
                                                                                               @click="downloadDocument(doc.schoolDoc_id)">
                                                                                                <!-- @click="customer.user_customer.user_subscription.user_end_date < customer.user_customer.user_subscription.today ? subscriptionPlan():
																								showNominees(
																									category,
																									asset
																								)
																							" -->
                                                                                                <i
                                                                                                    class="fas fa-download text-success"></i>
                                                                                                <div class="font-10">
                                                                                                    Download<br />
                                                                                                </div>
                                                                                            </div>
                                                                                            <div

                                                                                                class="asset-menu-item-separator">
                                                                                            </div>
                                                                                            <div class="text-center flex-grow-1 asset-menu-item"
                                                                                                @click="deleteData(doc,index)"
                                                                                               >
                                                                                                <!-- @click="customer.user_customer.user_subscription.user_end_date < customer.user_customer.user_subscription.today ? subscriptionPlan():
																								showNominees(
																									category,
																									asset
																								)
																							" -->
                                                                                                <i
                                                                                                    class="fas fa-trash text-danger                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         "></i>
                                                                                                <div class="font-10">
                                                                                                    Delete<br />
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div v-else class="text-center">
                                                                <NoData title="No asset added yet" height="150" />
                                                                <div class="mt-6">
                                                                    <!-- <button
                                                                    class="btn btn-info"
                                                                    @click="
                                                                        addAsset()
                                                                    "
                                                                >
                                                                    Add Asset
                                                                </button> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                    to: { name: "admin.dashboard" },
                    name: "Home",
                },
                {
                    name: "School",
                    to: { name: "admin.school.list" },
                },
                {
                    name: "School Documents"
                }
            ],
            files: [],
            selectedFiles: [],
            isLoaded: false,
            noData: false,
            errorItem: {
                title1: "",
                imageFilePath1: "",
            },
            fileTitles: [],
            editItems: [
                { title: "", imageFiles: [], srcImageFiles: [] },
            ],
            editedIds: [],
            documents: [],
            isUpdate: false,
            isShowing: false,
            school_list_id: -1,
            schoolDoc: {},
            download_link: ""
        };
    },
    mounted() {

        if (this.$route.params.school_id) {
            this.school_list_id = this.$route.params.school_id;
            this.showData();
        }
    },
    methods: {
        addDocs() {
            this.$router.push({
                path: `/admin/school/documents/create/${this.school_list_id}`
            });
        },
        async showData() {
            this.log('school id',this.school_list_id);
            // this.isLoaded = false;
            const res = await this.callApi(
                "get",
                `/api/admin/schools/docs/${this.school_list_id}`,
                null,
            );
            console.log('showData function', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.schoolDoc = data.schoolDoc;
                    // this.initTable();
                }
            }
            // this.$refs.table.loadTable();
            // this.isLoaded = true;
            // toast.close();
        },
        editDoc(){
            console.log('DOC ID',this.school_list_id);
            this.$router.push(`/admin/school/documents/${this.school_list_id}/edit`);
        },
       async downloadDocument(docId) {
            try {
                const res = await this.callApi(
                    "get",
                    `/api/admin/schools/download_doc/${docId}`,
                    null
                );

                console.log('Server Response:', res);

                if (res.status === 200) {
                    const data = res.data;

                    if (data && data.status === "success" && data.download_link) {
                        // Create a download link and trigger the download
                        const link = document.createElement('a');
                        link.href = data.download_link;
                        link.target = '_blank'; // Open in a new tab/window
                        link.rel = 'noopener noreferrer'; // Security best practice for target="_blank"
                        link.download = 'downloaded-document.png'; // Set the desired file name
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    } else {
                        console.error('Error downloading document:', data ? data.message : 'Invalid response data');
                    }
                } else {
                    console.error('Error downloading document:', res.statusText);
                }
            } catch (error) {
                console.error('Error downloading document:', error);
            }
        },


        async deleteData(item, index) {
            this.log('delete function');
            // var data = new FormData();
            // data.append("status", "deleted");
            const res = await this.callApi(
                "delete",
                `/api/admin/schools/delete_doc/${item.schoolDoc_id}`,
                data
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.schoolDoc.documents.splice(index, 1);
                    // this.tableData.splice(index, 1);
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
