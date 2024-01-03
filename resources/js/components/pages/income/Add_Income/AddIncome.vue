<template>
    <div>
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start -->
            <Breadcrumb pageTitle="Add Income" :breadcrumbList="breadcrumbList" />
            <!-- End Breadcubs Area -->
            <!-- Add Income Area Start Here -->
            <div class="row gutters-20">
                <div class="col-5">
                    <div class="card height-auto">
                        <div>
                            <div class="card-header ">
                                <div class="item-title">
                                    <h3>Add Income </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <form class="mg-b-20">
                                    <div class="col-12">
                                        <AddIncomeForm ref="Incomereports" :itemCategories="
                                            itemCategories
                                        " />
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
                                <h3>Add Income Information</h3>
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
// import { defineComponent } from '@vue/composition-api'
import AddIncomeForm from "./AddIncomeForm.vue";
export default {
    components: {
        AddIncomeForm,
    },
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "admin.dashboard" },
                    name: "Home",
                },
                {
                    name: "AddIncome",
                },
            ],
            Incomereports: [],
            initItemList: [],
            // income_head_list: [],
            tableHead: {
                items: {
                    item1: { label: "Sr.No." },
                    item2: { label: "Income Head" },
                    item3: { label: "Income Name" },
                    item4: { label: "Invoice Number" },
                    item5: { label: "Income Date" },
                    item6: { label: "Amount" },
                    item7: { label: "Document" },
                    item8: { label: "Description" },
                },
                actions: true,
            },
            tableData: [],
            isLoaded: true,
            noData: false,
            editIndex: -1,
            itemCategories: [],
            income_head_list: [],
            selectedIncomeHead: -1,
            income_item_list: [],
            selectedIncomeItem: -1,
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
                `/api/school/income/AddIncome`,
                null
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.Incomereports = data.incomes;
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
            this.Incomereports.forEach((element) => {
                this.tableData.push({
                    item: element,
                    data: {
                        item1: element.id,
                        item2: element.income_head != null ? element.income_head.name : "",
                        item3: element.item_name != null ? element.item_name.name : "",
                        item4: element.invoice_number,
                        item5: element.income_date != null ? element.income_date : "",
                        item6: element.amount,
                        item7: {
                            type: 'file',
                            path: element.document,
                        },
                        item8: element.description,
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
            formData.append("income_head", this.editItem.incomeHeadId);
            formData.append("item_name", this.editItem.incomeItemId);
            formData.append("invoice_number", this.editItem.invoice_number);
            formData.append("income_date", this.editItem.income_date);
            formData.append("amount", this.editItem.amount);
            formData.append("image", this.editItem.imageFilePath);
            formData.append('description', this.editItem.description);
            let $url = "";
            if (this.editedIndex !== -1) {
                $url = `/api/school/income/AddIncome/update/${this.editedIndex}`;
            } else {
                $url = `/api/school/income/AddIncome/save`;
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
                        this.Incomereports.unshift(data.incomes);
                        var element = data.incomes;
                        this.tableData.unshift({
                            item: element,
                            data: {
                                item1: element.id,
                                item2: element.income_head != null ? element.income_head.name : "",
                                item3: element.item_name != null ? element.item_name.name : "",
                                item4: element.invoice_number,
                                item5: element.income_date != null ? element.income_date : "",
                                item6: element.amount,
                                item7: {
                                    type: 'file',
                                    path: element.document,
                                },
                                item8: element.description,
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
            this.$refs.Incomereports.edit(item, index);
            this.editedIndex = item.id;
            this.editIndex = index;
        },
        async deleteData(item, index) {
            const res = await this.callApi(
                "get",
                `/api/school/income/AddIncome/delete/${item.id}`,
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
                    this.Incomereports.splice(
                        this.Incomereports.indexOf(index),
                        1
                    );
                    this.tableData.splice(this.Incomereports.indexOf(index), 1);
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
