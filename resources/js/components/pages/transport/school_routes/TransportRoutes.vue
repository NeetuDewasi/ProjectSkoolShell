<template>
    <div>
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start -->
            <Breadcrumb pageTitle="Add Transport" :breadcrumbList="breadcrumbList" />
            <!-- End Breadcubs Area -->
            <!-- Add Income Area Start Here -->
            <div class="row gutters-20">
                <div class="col-5">
                    <div class="card height-auto">
                        <div class="card-header ">
                            <div class="item-title">
                                <h3>Add Transport Routes </h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="mg-b-20">
                                <div class="col-12">
                                    <AddTransportRoutes ref="TransporTroutesList" :itemCategories="itemCategories" />
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="col-7">
                    <div class="card height-auto">
                        <div class="card-header ">
                            <div class="item-title">
                                <h3>Transport Route Information</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div>
                                <div class="table table-responsive" v-show="!noData">
                                    <Table ref="table" :tableData="tableData" :tableHead="tableHead" />
                                </div>
                                <NoData v-show="noData" />
                            </div>
                            <!-- All Transport List Area End Here -->
                        </div>
                        <!-- All Subjects Area End Here -->
                    </div>
                </div> <!-- All Transport List Area End Here -->
            </div>
            <!-- All Subjects Area End Here -->
            <Footer />
        </div>
    </div>
</template>
<script>
var toast;
import AddTransportRoutes from "./AddTransportRoutes.vue";
export default {
    components: {
        AddTransportRoutes,
    },
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "school.dashboard" },
                    name: "Home",
                },
                {
                    name: "TransportRoutes",
                },
            ],
            TransporTroutesList: [],
            initItemList: [],
            tableHead: {
                items: {
                    item1: { label: "Sr.No." },
                    item2: { label: "Route Name" },
                },
                actions: true,
            },
            tableData: [],
            isLoaded: true,
            noData: false,
            itemCategories: [],
            editIndex: -1,
        };
    },
    mounted() {
        this.$parent.loadOtherScript();
    },
    created() {
        toast = Toast.fire({
            icon: "warning",
            title: "Loading Data..",
            timer: 0,
        });
        this.showData();
    },
    methods: {
        async showData() {
            const res = await this.callApi(
                "get",
                `/api/school/transport/AddTransportRoutes`,
                null
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.initItemList = JSON.parse(
                        JSON.stringify(data.route_name)
                    );
                    this.TransporTroutesList = data.route_name;
                    this.initTable();
                } else {
                    toast = Toast.fire({
                        icon: "error",
                        title: "Something went wrong",
                        timer: 2500,
                    });
                    this.noData = true;
                }
            }
            this.$refs.table.loadTable();
            this.isLoaded = false;
            toast.close();
        },
        initTable() {
            this.tableData = [];
            this.TransporTroutesList.forEach((element) => {
                this.tableData.push({
                    item: element,
                    data: {
                        item1: element.id,
                        item2: element.route_name,
                    },
                    action: {
                        edit: true,
                        delete: true,
                    },
                });
            });
        },
        async submitForm(item, itemId) {
            this.editItem = item;
            this.editedIndex = itemId;
            var formData = new FormData();
            formData.append("route_name", this.editItem.route_name);
            let $url = "";
            if (this.editedIndex !== -1) {
                $url = `/api/school/transport/AddTransportRoutes/update/${this.editedIndex}`;
            } else {
                $url = `/api/school/transport/AddTransportRoutes/save`;
            }

            const res = await this.callApi("post", $url, formData);

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    if (this.noData) {
                        this.noData = false;
                    }
                    this.editItem = {};
                    if (this.editedIndex !== -1) {
                        if (this.editIndex !== -1) {
                            this.initTable();
                        }
                    } else {
                        this.TransporTroutesList.unshift(data.route_name);
                        var element = data.route_name;
                        this.tableData.unshift({
                            item: element,
                            data: {
                                item1: element.id,
                                item2: element.route_name,
                            },
                            action: {
                                edit: true,
                                delete: true,
                            },
                        });
                    }
                }
                toast = Toast.fire({
                    icon: data.status,
                    title: data.message,
                    timer: 2500,
                });
            } else {
                toast = Toast.fire({
                    icon: "error",
                    title: "Something went wrong",
                    timer: 2500,
                });
            }
            this.editedIndex = -1;
        },

        edit(item, index) {
            this.$refs.TransporTroutesList.edit(item, index);
            this.editedIndex = item.id;
            this.editIndex = index;
        },
        async deleteData(item, index) {
            var formData = new FormData();
            formData.append("status", "deleted");
            const res = await this.callApi(
                "post",
                `/api/school/transport/AddTransportRoutes/delete/${item.route_id}`,
                formData
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.TransporTroutesList.splice(index, 1);
                    this.tableData.splice(index, 1);
                    if (!this.tableData.length) {
                        this.noData = true;
                    }
                    SwalCustomBtn.fire("Deleted!", data.message, "success");
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
                    title: "Something Went Wrong, Not able to delete",
                    timer: 2500,
                });
            }
        },
    },
};
</script>


<style scoped>
</style>
