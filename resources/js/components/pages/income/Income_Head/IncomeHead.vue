<template>
    <div>
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start -->
            <Breadcrumb pageTitle="Income Head" :breadcrumbList="breadcrumbList" />
            <!-- End Breadcubs Area -->
            <!-- Add Income Area Start Here -->
            <div class="row gutters-20">
                <div class="col-5">
                    <div class="card height-auto">
                        <div>
                            <div class="card-header ">
                                <div class="item-title">
                                    <h3>Add Income Head </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <form class="mg-b-20">
                                    <div class="col-12">
                                        <IncomeHeadForm ref="Incomereports" />
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
                                <h3>Income Head information</h3>
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
import IncomeHeadForm from "./IncomeHeadForm.vue";
export default {
    components: {
        IncomeHeadForm,
    },
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "admin.dashboard" },
                    name: "Home",
                },
                {
                    name: "IncomeHead",
                },
            ],
            Incomereports: [],
            initItemList: [],
            tableHead: {
                items: {
                    item1: { label: "Sr.No." },
                    item2: { label: "Income Head" },
                    item3: { label: "Description" },
                },
                actions: true,
            },
            tableData: [],
            isLoaded: true,
            noData: false,
            editedIndex: -1,
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
                `/api/school/income/IncomeHead`,
                null
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.Incomereports = data.income_heads;
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
                        item2: element.income_head,
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
            formData.append("income_head", this.editItem.income_head);
            formData.append("description", this.editItem.description);
            let $url = "";
            if (this.editedIndex != -1) {
                $url = `/api/school/income/IncomeHead/update/${this.editedIndex}`;
            } else {
                $url = `/api/school/income/IncomeHead/save`;
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
                        if (this.editedIndex !== -1) {
                            this.initTable();
                        }
                    } else {
                        this.Incomereports.unshift(data.income_heads);
                        var element = data.income_heads;
                        this.tableData.unshift({
                            item: element,
                            data: {
                                item1: element.id,
                                item2: element.income_head,
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
            this.$refs.Incomereports.edit(item, index);
            this.editedIndex = item.id;
            this.editIndex = index;
        },
        async deleteData(item, index) {
            const res = await this.callApi(
                "get",
                `/api/school/income/IncomeHead/delete/${item.id}`,
                null
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.Incomereports.splice(index, 1);
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

