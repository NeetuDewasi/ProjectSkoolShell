<template>
    <div>
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start -->
            <Breadcrumb pageTitle="Add New Item" :breadcrumbList="breadcrumbList" />
            <!-- End Breadcubs Area -->
            <!-- Add New Item Start Here -->
            <div class="row gutters-20">
                <div class="col-5">
                    <div class="card height-auto">
                        <div>
                            <div class="card-header ">
                                <div class="item-title">
                                    <h3>Add Item </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <form class="mg-b-20">
                                    <div class="col-12">
                                        <AddItemForm ref="itemreports" :itemCategories="itemCategories" />
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
                                <h3>Items Information</h3>
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
import AddItemForm from "./AddItemForm.vue";

export default {
    components: {
        AddItemForm,
    },
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "school.dashboard" },
                    name: "Home",
                },
                {
                    name: "AddItem",
                },
            ],
            itemreports: [],
            initItemList: [],
            tableHead: {
                items: {
                    item1: { label: "Sr.No." },
                    item2: { label: "Item Category" },
                    item3: { label: "Item Name" },
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
                `/api/school/inventory/AddItem`,
                null
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.initItemList = JSON.parse(
                        JSON.stringify(data.item_category)
                    );
                    this.itemreports = data.item_category;
                    this.itemCategories = data.item_categories;
                    this.$refs.itemreports.updateList(data.item_categories);

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
            this.itemreports.forEach((element) => {
                this.tableData.push({
                    item: element,
                    data: {
                        item1: element.item_id,
                        item2:
                            element.category != null
                                ? element.category.name
                                : "",
                        item3: element.item_name,
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
            formData.append("item_name", this.editItem.item_name);
            formData.append("item_category", this.editItem.categoryId);
            let $url = "";
            if (this.editedIndex !== -1) {
                $url = `/api/school/inventory/AddItemForm/update/${this.editedIndex}`;
            } else {
                $url = `/api/school/inventory/AddItemForm/save`;
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
                        this.itemreports.unshift(data.item_category);
                        var element = data.item_category;
                        this.tableData.unshift({
                            item: element,
                            data: {
                                item1: element.item_id,
                                item2: element.item_name,
                                item3:
                                    element.category != null
                                        ? element.category.name
                                        : "",
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
            this.$refs.itemreports.edit(item, index);
            this.editedIndex = item.item_id;
            this.editIndex = index;
        },
        async deleteData(item, index) {
            const res = await this.callApi(
                "get",
                `/api/school/inventory/AddItemForm/delete/${item.item_id}`,
                null
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.itemreports.splice(index, 1);
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


