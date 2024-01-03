<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb pageTitle="Supplier Information" :breadcrumbList="breadcrumbList" />
            <div class="row gutters-20">
                <div class="col-5">
                    <div class="card height-auto">
                            <div>
                                <div class="card-header ">
                                    <div class="item-title">
                                        <h3>Add Supplier Information </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                <form class="mg-b-20">
                                    <div class="col-12">
                                        <ItemSupplierForm ref="stockitemreports" :itemCategories="itemCategories" />
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
                                <h3>Supplier Information</h3>
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
import ItemSupplierForm from "./ItemSupplierForm.vue";

export default {
    components: {
        ItemSupplierForm,
    },
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "admin.dashboard" },
                    name: "Home",
                },
                {
                    name: "ItemSupplier",
                },
            ],
            stockitemreports: [],
            initItemList: [],
            tableHead: {
                items: {
                    item1: { label: "Sr.No." },
                    item2: { label: "Supplier Name" },
                    item3: { label: "Emai" },
                    item4: { label: "Address" },
                    item5: { label: "phone" },
                    item6: { label: "Contact Person" },
                    item7: { label: "Contact Number" },
                    item8: { label: "Contact Email" },
                    item9: { label: "Description" },
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
                `/api/school/inventory/ItemSupplier`,
                null
            );
            console.log('hdfdshg', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.stockitemreports = data.supplier_name;
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
                        item1: element.id,
                        item2: element.supplier_name,
                        item3: element.email,
                        item4: element.address,
                        item5: element.phone,
                        item6: element.contact_person_name,
                        item7: element.contact_person_phone,
                        item8: element.contact_person_email,
                        item9: element.description,
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
            formData.append("supplier_name", this.editItem.supplier_name);
            formData.append("email", this.editItem.email);
            formData.append("address", this.editItem.address);
            formData.append("phone", this.editItem.phone);
            formData.append(
                "contact_person_name",
                this.editItem.contact_person_name
            );
            formData.append(
                "contact_person_phone",
                this.editItem.contact_person_phone
            );
            formData.append(
                "contact_person_email",
                this.editItem.contact_person_email
            );
            formData.append("description", this.editItem.description);
            let $url = "";
            if (this.editedIndex !== -1) {
                $url = `/api/school/inventory/ItemSupplierForm/update/${this.editedIndex}`;
            } else {
                $url = `/api/school/inventory/ItemSupplierForm/save`;
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
                        this.stockitemreports.unshift(data.supplier_name);
                        var element = data.supplier_name;
                        this.tableData.unshift({
                            item: element,
                            data: {
                                item1: element.id,
                                item2: element.supplier_name,
                                item3: element.email,
                                item4: element.address,
                                item5: element.phone,
                                item6: element.contact_person_name,
                                item7: element.contact_person_phone,
                                item8: element.contact_person_email,
                                item9: element.description,
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
            this.editedIndex = item.id;
            this.editIndex = index;
        },
        async deleteData(item, index) {
            const res = await this.callApi(
                "get",
                `/api/school/inventory/ItemSupplierForm/delete/${item.id}`,
                null
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
