<template>
    <div>
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start -->
            <Breadcrumb pageTitle="Item Category" :breadcrumbList="breadcrumbList" />
            <!-- End Breadcubs Area -->
            <!-- Add Item Category Start Here -->
            <div class="row gutters-20">
                <div class="col-5">
                    <div class="card height-auto">
                        <div>
                            <div class="card-header ">
                                <div class="item-title">
                                    <h3>Add Item Category </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <form class="mg-b-20">
                                    <div class="col-12">
                                        <ItemCategoryForm ref="stockitemreports" :itemCategories="itemCategories" />
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
                                <h3>Item Category Information</h3>
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
            </div>
        </div>
        <Footer />
    </div>
</template>
<script>
var toast;
//import { defineComponent } from '@vue/composition-api'
import ItemCategoryForm from "./ItemCategoryForm.vue";
export default {
    components: {
        ItemCategoryForm,
    },
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "school.dashboard" },
                    name: "Home",
                },
                {
                    name: "ItemCategory",
                },
            ],
            stockitemreports: [],
            initItemList: [],
            tableHead: {
                items: {
                    item1: { label: "Sr.No." },
                    item2: { label: "Item Category Name" },
                    item3: { label: "Description" },
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
        this.ShowData();
    },
    methods: {
        async ShowData() {
            const res = await this.callApi(
                "get",
                `/api/school/inventory/ItemCategory`,
                null
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.stockitemreports = data.item_categorys;
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
            this.stockitemreports.forEach((element) => {
                this.tableData.push({
                    item: element,
                    data: {
                        item1: element.item_id,
                        item2: element.item_category,
                        item3: element.description,
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
            formData.append("item_category", this.editItem.item_category);
            formData.append("description", this.editItem.description);
            let $url = "";
            if (this.editedIndex !== -1) {
                $url = `/api/school/inventory/ItemCategoryForm/update/${this.editedIndex}`;
            } else {
                $url = `/api/school/inventory/ItemCategoryForm/save`;
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
                        this.stockitemreports.unshift(data.item_category);
                        var element = data.item_category;
                        this.tableData.unshift({
                            item: element,
                            data: {
                                item1: element.item_id,
                                item2: element.item_category,
                                item3: element.description,
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
            this.$refs.stockitemreports.edit(item, index);
            this.editedIndex = item.item_id;
            this.editIndex = index;
        },

        async deleteData(item, index) {
            const res = await this.callApi(
                "get",
                `/api/school/inventory/ItemCategoryForm/delete/${item.item_id}`
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.stockitemreports.splice(index, 1);
                    this.tableData.splice(index, 1);
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
