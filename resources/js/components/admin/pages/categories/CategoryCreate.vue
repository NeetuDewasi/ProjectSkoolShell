<template>
    <div>
        <Breadcrumb pageTitle="Menus" :breadcrumbList="breadcrumbList" />
        <div class="card">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Add Menu</h3>
                    </div>
                </div>

                <div class="row new-added-form">
                    <div class="flex-grow-1 form-group pr-4">
                        <input
                            class="form-control"
                            v-model="editItem.menu_name"
                            placeholder="Enter Name"
                            @keypress="errorItem.menu_name = ''"
                            :class="
                                errorItem.menu_name != '' ? 'error-field' : ''
                            "
                        />
                        <span
                            class="error-label"
                            v-if="errorItem.menu_name != ''"
                            v-text="errorItem.menu_name"
                        ></span>
                    </div>
                    <div class="form-group">
                        <button
                            type="button"
                            class="btn-fill-lg text-light shadow-dodger-blue bg-dodger-blue"
                            @click.prevent="submitData()"
                        >
                            {{ formBtn }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gutters-20">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="item-title">
                            <h3>Menu List</h3>
                        </div>
                        <div class="table table-responsive" v-show="!noData">
                            <Table
                                ref="table"
                                :tableData="tableData"
                                :tableHead="tableHead"
                            />
                        </div>
                        <NoData v-show="noData" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
var toast;
export default {
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "admin.dashboard" },
                    name: "Home",
                },
                {
                    name: "Menus",
                },
            ],
            editItem: {},
            editedIndex: -1,
            errorItem: {
                menu_name: "",
            },
            isFormValid: false,
            tableHead: {
                items: {
                    item1: { label: "Sr.No." },
                    item2: { label: "Name" },
                },
                actions: true,
            },
            tableData: [],
            isLoaded: false,
            noData: false,
            menus: [],
        };
    },
    computed: {
        formBtn: function () {
            return this.editedIndex === -1 ? "Save" : "Update";
        },
        resetButton: function () {
            return this.editedIndex === -1 ? "Reset" : "Cancel";
        },
    },
    mounted() {
        this.showData();
    },
    methods: {
        async showData() {
            this.isLoaded = false;
            const res = await this.callApi("get", `/api/admin/menus`, null);

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.menus = data.menus;
                    this.initTable();
                } else {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                    this.noData = true;
                }
            } else {
                toast = Toast.fire({
                    icon: data.status,
                    title: data.message,
                    timer: 2500,
                });
            }
            this.$refs.table.loadTable();
            this.isLoaded = true;
        },
        initTable() {
            this.tableData = [];
            this.menus.forEach((element) => {
                this.tableData.push({
                    item: element,
                    data: {
                        item1: element.menu_id,
                        item2: element.menu_name,
                    },
                    action: {
                        delete: true,
                    },
                });
            });
        },
        async submitData() {
            var isVaild = await this.validCategoryForm();
            if (!isVaild) {
                return;
            }
            toast = Toast.fire({
                icon: "warning",
                title: "Please Wait!! Creating new Group",
                timer: 0,
            });
            var data = new FormData();
            data.append(
                "menu_name",
                this.editItem.menu_name ? this.editItem.menu_name : ""
            );
            let url = "";
            if (this.editedIndex == -1) {
                url = `/api/admin/menus/save`;
            } else {
                url = `/api/admin/menus/update/${this.editedIndex}`;
            }
            const res = await this.callApi("post", url, data);
            this.log("added dataa>>>", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    if (this.noData) {
                        this.noData = false;
                    }
                    this.log("iitteemmss", data.menu_item);
                    this.menus.unshift(data.menu_item);
                    this.tableData.unshift({
                        item: data.menu_item,
                        data: {
                            item1: data.menu_item.menu_id,
                            item2: data.menu_item.menu_name,
                        },
                        action: {
                            delete: true,
                        },
                    });
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                    this.editItem = {};
                }
                toast = Toast.fire({
                    icon: data.status,
                    title: data.message,
                    timer: 2500,
                });
            } else {
                toast = Toast.fire({
                    icon: data.status,
                    title: data.message,
                    timer: 2500,
                });
            }
        },
        validCategoryForm() {
            this.isFormValid = true;
            if (
                this.editItem.menu_name == null ||
                this.editItem.menu_name == ""
            ) {
                this.errorItem.menu_name = "Category Name is required";
                this.isFormValid = false;
            } else {
                this.errorItem.menu_name = "";
            }
            return this.isFormValid;
        },

        async deleteData(item, index) {
            var data = new FormData();
            data.append("status", "deleted");
            const res = await this.callApi(
                "post",
                `/api/admin/menus/delete/${item.menu_id}`,
                data
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.menus.splice(index, 1);
                    this.tableData.splice(index, 1);
                    SwalCustomBtn.fire("Deleted!", data.message, "success");
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                } else {
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
