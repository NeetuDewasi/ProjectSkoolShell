<template>
    <div>
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start -->
            <Breadcrumb pageTitle="Add Item Stock" :breadcrumbList="breadcrumbList" />
            <!-- End Breadcubs Area -->
            <!-- Add Item Stock< Start Here -->
            <div class="row gutters-20">
                 <div class="col-5">
                    <div class="card height-auto">
                        <div>
                            <div class="card-header ">
                                <div class="item-title">
                                    <h3>Add Stock Item Information</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <form class="mg-b-20">
                                    <div class="col-12">
                                     <AddItemStockInfo ref="ItemStockLists"
                                                    :itemCategories="itemCategories" />
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
                                <h3>Stock Item Information</h3>
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
import AddItemStockInfo from "./AddItemStockInfo.vue";
export default {
    components: {
        AddItemStockInfo,
    },
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "admin.dashboard" },
                    name: "Home",
                },
                {
                    name: "AddItemStock",
                },
            ],
            ItemStockLists: [],
            initItemList: [],
            editItem: {},
            editIndex: -1,
            categoryId: -1,
            inventoryItemId: -1,
            inventorySupplierId: -1,
            inventory_item_store_id: -1,
            tableHead: {
                items: {
                    item1: { label: "Sr.No." },
                    item2: { label: "Item Category" },
                    item3: { label: "Item name" },
                    item4: { label: "Supplier" },
                    item5: { label: "store" },
                    item6: { label: "Quantity" },
                    item7: { label: "Date" },
                    item8: { label: "Document" },
                    item9: { label: "Description" },
                },
                actions: true,
            },
            tableData: [],
            isLoaded: true,
            noData: false,
            editIndex: -1,
            itemCategories: [],
            itemsName: [],
            itemSuppliers: [],
            categoryId: -1,
            editItem: {},
            inventoryItemId: -1,
            inventorySupplierId: -1,
            inventory_item_store_id: -1,

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
                `/api/school/inventory/AddItemStockInfo/AddItemStock`,
                null
            );
            this.log('table',res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.ItemStockLists = data.stock_items;
                    if (!this.ItemStockLists.length) {
                        this.noData = true;
                    }
                    this.itemCategories = data.item_categories;
                    this.$refs.ItemStockLists.DropDownUpdateList(
                        data.item_categories
                    );
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
            this.ItemStockLists.forEach((element) => {
                this.tableData.push({
                    item: element,
                    data: {
                        item1: element.stock_id,
                        item2: element.inventory_item_category_id != null ? element.inventory_item_category_id.name : "",
                        item3: element.inventory_add_item_id != null ? element.inventory_add_item_id.name : "",
                        item4: element.inventory_supplier_info_id != null ? element.inventory_supplier_info_id.name : "",
                        item5: element.inventory_item_store_id != null ? element.inventory_item_store_id.name : "",
                        item6: element.quantity ? element.quantity :'',
                        item7: element.income_date ? element.income_date : '',
                        item8: {
                            type: 'file',
                            path: element.document ? element.document : '',
                        },
                        item9: element.description != null ? element.description : '',
                    },
                    action: {
                        edit: true,
                        delete: true,
                    },
                });
            });
        },

        async submitForm(item, stock_id) {
            this.editItem = item;
            this.editedIndex = stock_id;
            var formData = new FormData();
            formData.append(
                "inventory_item_category_id",
                this.editItem.categoryId
            );
            formData.append(
                "inventory_add_item_id",
                this.editItem.inventoryItemId
            );
            formData.append(
                "inventory_supplier_info_id",
                this.editItem.inventorySupplierId
            );
            formData.append(
                "inventory_item_store_id",
                this.editItem.inventory_item_store_id
            );
            formData.append("quantity", this.editItem.quantity ? this.editItem.quantity : '');
            formData.append("income_date", this.editItem.income_date ? this.editItem.income_date : '');
            formData.append("description", this.editItem.description ? this.editItem.description : '');
            formData.append("image", this.editItem.imageFilePath ? this.editItem.imageFilePath : '');
            let $url = "";
            if (this.editedIndex !== -1) {
                $url = `/api/school/inventory/AddItemStockInfo/update/${this.editedIndex}`;
            } else {
                $url = `/api/school/inventory/AddItemStockInfo/save`;
            }

            const res = await this.callApi(
                "post",
                $url,
                formData,
            );
            this.log('res item',res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.$refs.ItemStockLists.resetForm();
                     toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                    this.showData();
                    if (this.noData) {
                        this.noData = false;
                    }
                    if (this.editedIndex !== -1) {
                        if (this.editIndex !== -1) {
                            // this.initTable();
                        }
                    } else {
                        this.ItemStockLists.unshift(data.stock_items);
                        var element = data.stock_items;
                        this.tableData.unshift({
                            item: element,
                            data: {
                                item1: element.stock_id,
                                item2: element.inventory_item_category_id != null ? element.inventory_item_category_id.name : "",
                                item3: element.inventory_add_item_id != null ? element.inventory_add_item_id.name : "",
                                item4: element.inventory_supplier_info_id != null ? element.inventory_supplier_info_id.name : "",
                                item5: element.inventory_item_store_id != null ? element.inventory_item_store_id.name : "",
                                item6: element.quantity,
                                item7: element.income_date,
                                item8: {
                                    type: 'file',
                                    path: element.document,
                                },
                                item9: element.description,
                            },
                            action: {
                                edit: true,
                                delete: true,
                            },
                        });
                    }
                }

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
            this.$refs.ItemStockLists.edit(item, index);
            this.editedIndex = item.stock_id;
            this.editIndex = index;
        },

        async deleteData(item, index) {
            let inventory_add_item_stock = item.stock_id;
            this.log('stock id', inventory_add_item_stock);
            const res = await this.callApi(
                "get",
                `/api/school/inventory/AddItemStockInfo/stock/${inventory_add_item_stock}`,
                null
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == 'success') {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                    this.ItemStockLists.splice(index, 1);
                    this.tableData.splice(index, 1);
                    SwalCustomBtn.fire("Deleted!", data.message, "success");
                } else {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 0,
                    });
                }
            }
        }
    },
};
</script>

<style scoped>
</style>






