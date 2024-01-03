<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb pageTitle="Examinations" :breadcrumbList="breadcrumbList" />

            <div class="row gutters-20">
                <div class="col-12">
                    <div class="row">
                        <div class="col-5">
                            <DesignMarksheetCreate ref="designMarksheetCreate" />
                        </div>
                        <div class="col-7">
                            <div class="card">
                                <div class="card-body">
                                    <div class="heading-layout1">
                                        <div class="item-title">
                                            <h3>Marksheet List</h3>
                                        </div>
                                    </div>
                                    <div class="table table-responsive" v-show="!noData">
                                        <Table ref="table" :tableData="tableData" :tableHead="tableHead" />
                                    </div>
                                    <NoData v-show="noData" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <Footer />
        </div>
    </div>
</template>

<script>
var toast;
import DesignMarksheetCreate from "./DesignMarksheetCreate.vue";
export default {
    components: {
        DesignMarksheetCreate,
    },
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "school.dashboard" },
                    name: "Home",
                },
                {
                    name: "Design Marksheet",
                },
            ],
            tableData: [],
            isLoaded: false,
            noData: false,
            editedIndex: -1,
            classId: -1,
            sectionId: -1,
            showMarksheetList: [],
            tableHead: {
                items: {
                    item1: { label: "Sr.No." },
                    item2: { label: "Title" },
                    item3: { label: "Background Image" },
                },
                actions: true,
            },

        };
    },
    mounted() {
        this.$parent.loadOtherScript();
        this.showData();
    },
    methods: {
        async showData() {
            this.isLoaded = false;
            const res = await this.callApi(
                "get",
                `/api/school/examinations/design_marksheet/get`,
                null
            );
            this.log("DATAA", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.showMarksheetList = data.design_marksheet_list;
                    this.initTable();
                }
            }
            this.$refs.table.loadTable();
            this.isLoaded = true;
        },
        initTable() {
            this.tableData = [];
            this.showMarksheetList.forEach((element) => {
                this.tableData.push({
                    item: element,
                    data: {
                        item1: element.marksheet_id,
                        item2: element.marksheet_title
                            ? element.marksheet_title
                            : "",
                        item3: element.marksheet_background_image
                            ? {
                                type: "file",
                                path: element.marksheet_background_image,
                                height: 70,
                            }
                            : "",

                    },
                    action: {
                        edit: true,
                        delete: true,
                    },
                });
            });
        },

        edit(item, index) {
            this.$refs.designMarksheetCreate.edit(item, index);
            this.editedIndex = item.marksheet_id;
        },
        async deleteData(item, index) {
            var data = new FormData();
            data.append("status", "deleted");
            const res = await this.callApi(
                "post",
                `/api/school/examinations/design_marksheet/delete/${item.marksheet_id}`,
                data
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.showMarksheetList.splice(index, 1);
                    this.tableData.splice(index, 1);
                    if (!this.tableData.length) {
                        this.noData = true;
                    }
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
