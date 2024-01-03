<template>
    <div>
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start -->
            <Breadcrumb pageTitle="Item Issueing Information " :breadcrumbList="breadcrumbList" />
            <!-- End Breadcubs Area -->
            <!-- Add Item Store Start Here -->
            <div class="row gutters-20">
                <div class="col-5">
                    <div class="card height-auto">
                        <div>
                            <div class="card-header ">
                                <div class="item-title">
                                    <h3>Add Issue Item  </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <form class="mg-b-20">
                                    <div class="col-12">
                                         <AddIssueItem ref="IssueItemLists" :itemCategories="itemCategories" />
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
                                <h3>Issue Items Information</h3>
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
import AddIssueItem from "./AddIssueItem.vue";
export default {
    components: {
        AddIssueItem,
    },
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "admin.dashboard" },
                    name: "Home",
                },
                {
                    name: "IssueItem",
                },
            ],
            IssueItemLists: [],
            initItemList: [],
            itemCategoriesList: [],
            itemsName: [],
            departmentList: [],
            employeeList: [],
            editIndex: -1,
            selectedQty: 0,
            tableHead: {
                items: {
                    item1: { label: "Sr.No." },
                    item2: { label: "Department " },
                    item3: { label: "Assign To" },
                    item4: { label: "Item Category" },
                    item5: { label: "Item Name" },
                    item6: { label: "Item Quantity" },
                    item7: { label: "Return Date" },
                    item8: { label: "Description" },
                },
                actions: true,
            },
            tableData: [],
            isLoaded: true,
            noData: false,
            editIndex: -1,
            itemCategories: [],
            itemsName: [],
            selectedQty: 0,
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
                `/api/school/inventory/AddIssueItem/IssueItem`,
                null,
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.IssueItemLists = data.issue_items;
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
            this.IssueItemLists.forEach((element) => {
                this.tableData.push({
                    item: element,
                    data: {
                        item1: element.inventory_issueItem_id,
                        item2: element.inventory_department_info_id != null ? element.inventory_department_info_id.name : "",
                        item3: element.inventory_employee_id != null ? element.inventory_employee_id.name : "",
                        item4: element.inventory_item_category_id != null ? element.inventory_item_category_id.name : "",
                        item5: element.inventory_add_item_id != null ? element.inventory_add_item_id.name : "",
                        item6: element.quantity != null ? element.quantity : "",
                        item7: element.return_date != null ? element.return_date : "",
                        item8: element.description != null || element.description != undefined ? element.description : ""
                    },
                    action: {
                        edit: true,
                        delete: true,
                    },
                });
            });
        },
        async submitForm(item, itemId) {
            this.editedIndex = itemId;
            var formData = new FormData();
            this.log('sfsdf',item);
            formData.append("inventory_item_category_id", item.categoryId);
            formData.append("inventory_add_item_id", item.inventoryItemId);
            formData.append("inventory_item_department_id", item.inventoryDepartmentId);
            formData.append("inventory_item_employee_id", item.inventoryEmployeeId);
            formData.append("quantity", item.quantity);
            formData.append("return_date", item.return_date);
            formData.append("description", item.description);
            let $url = '';
            if (this.editedIndex !== -1) {
                $url = `/api/school/inventory/AddIssueItem/update/${this.editedIndex}`;
            } else {
                $url = `/api/school/inventory/AddIssueItem/save`;
            }

            const res = await this.callApi(
                "post",
                $url,
                formData,
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == 'success') {
                    if (this.noData) {
                        this.noData = false;
                    }
                    if (this.editedIndex !== -1) {
                        if (this.editIndex !== -1) {
                            this.initTable();
                        }
                    } else {
                        this.IssueItemLists.unshift(data.issue_items);
                        var element = data.issue_items;
                        this.tableData.unshift({
                            item: element,
                            data: {
                                item1: element.stock_id,
                                item2: element.inventory_item_department_id != null ? element.inventory_item_department_id.name : "",
                                item3: element.inventory_item_employee_id != null ? element.inventory_item_employee_id.name : "",
                                item4: element.inventory_item_category_id != null ? element.inventory_item_category_id.name : "",
                                item5: element.inventory_add_item_id != null ? element.inventory_add_item_id.name : "",
                                item6: element.quantity != null ? element.quantity : "",
                                item7: element.return_date,
                                item8: element.description
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
            this.$refs.IssueItemLists.edit(item, index);
            this.editedIndex = item.itemId;
            this.editIndex = index;
        },
        async deleteData(item, index) {
            const res = await this.callApi(
                "get",
                `/api/school/inventory/AddIssueItem/delete/${item.stock_id}`,
                null,
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == 'success') {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                    this.IssueItemLists.splice(this.IssueItemLists.indexOf(index), 1)
                    this.tableData.splice(this.IssueItemLists.indexOf(index), 1)
                    SwalCustomBtn.fire('Deleted!', data.message, 'success');
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
