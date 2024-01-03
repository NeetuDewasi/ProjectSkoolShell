<template>
    <div>
        <Breadcrumb pageTitle="Menus" :breadcrumbList="breadcrumbList" />
        <div class="card">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Add Component</h3>
                    </div>
                </div>

                <div class="new-added-form">
                    <div class="row">
                        <div class="col-lg-3 col-sm-12 mt-5 form-group">
                            <label>
                                Select Category
                                <strong class="text-danger">*</strong>
                            </label>
                            <Select2
                            placeholder="--SELECT A MENU--"
                            ref="menu_list_select2"
                                :items="menus"
                                @change="selectMenuID"
                            />
                        </div>
                        <div class="col-lg-3 col-sm-12 mt-5 form-group">
                            <label>
                                Component Name
                                <strong class="text-danger">*</strong>
                            </label>
                            <input
                                class="form-control"
                                v-model="editItem.component_name"
                                placeholder="Enter Name"
                                @keypress="errorItem.component_name = ''"
                                :class="errorItem.component_name != ''
                                        ? 'error-field'
                                        : ''
                                    "
                            />
                            <span
                                class="error-label"
                                v-if="errorItem.component_name != ''"
                                v-text="errorItem.component_name"
                            ></span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-12 mt-5 form-group">
                                <label>
                                    Path Name
                                    <strong class="text-danger">*</strong>
                                </label>
                                <input
                                    class="form-control"
                                    v-model="editItem.path_name"
                                    placeholder="Enter Path Name"
                                    @keypress="errorItem.path_name = ''"
                                    :class="errorItem.path_name != ''
                                            ? 'error-field'
                                            : ''
                                        "
                                />
                                <span
                                    class="error-label"
                                    v-if="errorItem.path_name != ''"
                                    v-text="errorItem.path_name"
                                ></span>

                            </div>
                    </div>
                    <div class="row form-group">
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
                            <h3>Component List</h3>
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
                    name: "Components",
                },
            ],
            editItem: {},
            editedIndex: -1,
            errorItem: {
                component_name: "",
                path_name:"",
            },
            isFormValid: false,
            tableHead: {
                items: {
                    item1: { label: "Sr.No." },
                    item2: { label: "Module" },
                    item3: { label: "Component"},
                    item4: { label: "path"}
                },
                actions: true,
            },
            tableData: [],
            isLoaded: false,
            noData: false,
            menus: [],
            components: [],
            editedIndex: -1,
            menu_component_id: -1,
            menu_list_select2:[]
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
        this.getCategories();
        this.showData();

    },
    methods: {
        submitData(){
            if(this.editedIndex != -1){
                this.updateData();
            }else{
                this.saveData();
            }
        },
         async getCategories() {
            this.isLoaded = false;
            const res = await this.callApi("get", `/api/admin/component/menu_list`, null);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.menus = data.menus;
                    this.$refs.menu_list_select2.updateList(data.menus);
                    this.$refs.menu_list_select2.setSelected(data.menus[0].value);
                    this.selectMenuID(data.menus[0].value);
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
        },

        selectMenuID(menu_id){
            this.menu_id = menu_id;
        },
        async showData() {
            this.isLoaded = false;
            const res = await this.callApi("get", `/api/admin/component/component_list`, null);
            this.log('compnent paths',res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.components = data.components;
                    console.log("catteee", this.menus);
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
            this.components.forEach((element) => {
                this.tableData.push({
                    item: element,
                    data: {
                        item1: element.component_id,
                        item2: `${element.category ? (element.category.menu_name ? element.category.menu_name : '') : ''}`,
                        item3: element.component_name,
                        item4: element.path_name,
                    },
                    action: {
                        edit: true,
                        delete: true,
                    },
                });
            });
        },
        async saveData() {
            this.log('edit',this.editedIndex);
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

            console.log('category_id', this.menu_id ? this.menu_id : '');
            data.append('category_id',this.menu_id ? this.menu_id : '');
            data.append(
                "comp_name",
                this.editItem.component_name ? this.editItem.component_name : ""
            );
            data.append(
                "path_name",
                this.editItem.path_name ? this.editItem.path_name : ""
            );
            let url = "";
            if (this.editedIndex ==  -1) {
                url = `/api/admin/component/save`;
            }
            const res = await this.callApi("post", url, data);
            this.log('updated data', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.resetForm();
                    if (this.noData) {
                        this.noData = false;
                    }

                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                    this.showData();
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
        resetForm(){
            this.editItem = {};
            this.menu_id = -1;
            this.$refs.menu_list_select2.setSelected('');
            this.editedIndex = -1;
            this.menus = [];
        },
        validCategoryForm() {
            this.isFormValid = true;
            if (
                this.editItem.component_name == null ||
                this.editItem.component_name == ""
            ) {
                this.errorItem.component_name = "Component Name is required";
                this.isFormValid = false;
            } else {
                this.errorItem.component_name = "";
            }
            if (
                this.editItem.path_name == null ||
                this.editItem.path_name == ""
            ) {
                this.errorItem.path_name = "Path Name is required";
                this.isFormValid = false;
            } else {
                this.errorItem.path_name = "";
            }
            return this.isFormValid;
        },
        edit(item){
            this.editedIndex = item.component_id;
            this.editItem = item;
            this.$refs.menu_list_select2.setSelected(item.category_id);
            this.selectMenuID(item.category_id);
        },
        async updateData(){
            var data = new FormData();
            data.append('category_id', this.menu_id ? this.menu_id : '');
            data.append(
                "comp_name",
                this.editItem.component_name ? this.editItem.component_name : ""
            );
            data.append(
                "path_name",
                this.editItem.path_name ? this.editItem.path_name : ""
            );
            let url = "";
            if (this.editedIndex != -1) {
                url = `/api/admin/component/comp_update/${this.editedIndex}`;
            }
            const res = await this.callApi("post", url, data);
            this.log('updated data', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.resetForm();
                    if (this.noData) {
                        this.noData = false;
                    }

                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                    this.showData();
                    // this.menus.unshift(data.menu_item);
                    // this.tableData.unshift({
                    //     item: data.menu_item,
                    //     data: {
                    //         item1: data.menu_id,
                    //         item2: data.component_name,
                    //     },
                    //     action: {
                    //         delete: true,
                    //     },
                    // });
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

        async deleteData(item, index) {
            console.log('delete id',item.component_id);
           const res = await this.callApi("get",`/api/admin/component/delete_menu_component/${item.component_id}`);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    SwalCustomBtn.fire("Deleted!", data.message, "success");
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                    this.components.splice(index, 1);
                    this.tableData.splice(index, 1);
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
