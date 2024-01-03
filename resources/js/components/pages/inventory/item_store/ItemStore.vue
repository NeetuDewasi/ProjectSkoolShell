<template>
    <div>
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start -->
            <Breadcrumb pageTitle="Item Store" :breadcrumbList="breadcrumbList" />
            <!-- End Breadcubs Area -->
            <!-- Add Item Store Start Here -->
            <div class="row gutters-20">
                <div class="col-5">
                    <div class="card height-auto">
                        <div>
                            <div class="card-header ">
                                <div class="item-title">
                                    <h3>Add Store Information </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <form class="mg-b-20">
                                    <div class="col-12">
                                        <AddItemStore ref="ItemStoreLists" :itemCategories="itemCategories" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-7">
                    <div class="card height-auto">
                        <div class="card-header ">
                            <div class="item-title">
                                <h3>Stores Information</h3>
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
                </div>
                <!-- All Transport List Area End Here -->
            </div>
            <!-- All Subjects Area End Here -->
        </div>
        <Footer />
    </div>
</template>

<script>
var toast;
// import { defineComponent } from '@vue/composition-api'
import AddItemStore from "./AddItemStore.vue";

export default {
    components: {
        AddItemStore,
    },
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "admin.dashboard" },
                    name: "Home",
                },
                {
                    name: "ItemStore",
                },
            ],
            ItemStoreLists: [],
            initItemList: [],
            tableHead: {
                items: {
                    item1: { label: "Sr.No." },
                    item2: { label: "Item Store" },
                    item3: { label: "Item Stock" },
                    item4: { label: "Description" },
                },
                actions: true,
            },
            tableData: [],
            isLoaded: true,
            noData: false,
            editIndex: -1,
            itemCategories: [],
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
                `/api/school/inventory/itemstore`,
                null
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.ItemStoreLists = data.item_stores;
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
            this.ItemStoreLists.forEach((element) => {
                this.tableData.push({
                    item: element,
                    data: {
                        item1: element.store_id,
                        item2: element.item_store,
                        item3: element.item_stock,
                        item4: element.description,
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
            formData.append("item_store", this.editItem.item_store);
            formData.append("item_stock", this.editItem.item_stock);
            formData.append("description", this.editItem.description);
            let $url = "";
            if (this.editedIndex !== -1) {
                $url = `/api/school/inventory/AddItemStore/update/${this.editedIndex}`;
            } else {
                $url = `/api/school/inventory/AddItemStore/save`;
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
                        this.ItemStoreLists.unshift(data.item_stores);
                        var element = data.item_stores;
                        this.tableData.unshift({
                            item: element,
                            data: {
                                item1: element.store_id,
                                item2: element.item_store,
                                item3: element.item_stock,
                                item4: element.description,
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
            this.$refs.ItemStoreLists.edit(item, index);
            this.editedIndex = item.store_id;
            this.editIndex = index;
        },
        async deleteData(item, index) {
            const res = await this.callApi(
                "get",
                `/api/school/inventory/AddItemStore/delete/${item.store_id}`,
                null
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                    this.ItemStoreLists.splice(
                        this.ItemStoreLists.indexOf(index),
                        1
                    );
                    this.tableData.splice(
                        this.ItemStoreLists.indexOf(index),
                        1
                    );
                } else {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 0,
                    });
                }
            }
        },
    },
};
</script>
<style scoped>
</style>
