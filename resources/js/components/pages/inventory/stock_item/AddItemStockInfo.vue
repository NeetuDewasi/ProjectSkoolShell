<template>
    <div>
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start -->
            <Breadcrumb pageTitle="Add Item Stock Info" :breadcrumbList="breadcrumbList" />
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card height-auto">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Add Item Stock Info</h3>
                                </div>
                            </div>
                            <form class="new-added-form">
                                <div class="row">
                                    <div class="col-lg-12 col-12 form-group">
                                        <label>Item Category <span class="error-s">*</span> </label>
                                        <Select2 ref="itemCategoriesList_select2"
                                            :class="errorItem.category != '' ? 'error-field' : ''"
                                            :items="itemCategoriesList" @change="getItems" />
                                        <span class="error-label" v-if="errorItem.category != ''"
                                            v-text="errorItem.category"></span>
                                    </div>
                                    <div class="col-lg-12 col-12 form-group">
                                        <label>Item Name <span class="error-s">*</span></label>
                                        <Select2 ref="item_name_select2"
                                            :class="errorItem.item_name != '' ? 'error-field' : ''" :items="item_name_select2"
                                            @change="getSuppliers" v-model="editItem.inventoryItemId"/>
                                        <span class="error-label" v-if="errorItem.item_name != ''"
                                            v-text="errorItem.item_name"></span>
                                    </div>
                                    <div class="col-lg-12 col-12 form-group">
                                        <label>Supplier <span class="error-s">*</span></label>
                                        <Select2 ref="supplier_select2"
                                            :class="errorItem.supplier != '' ? 'error-field' : ''" :items="itemSuppliers"
                                            @change="getSupplierId" />
                                        <span class="error-label" v-if="errorItem.supplier != ''"
                                            v-text="errorItem.supplier"></span>
                                    </div>
                                    <div class="col-lg-12 col-12 form-group">
                                        <label>Store <span class="error-s">*</span></label>
                                        <Select2 ref="item_store_select2"
                                            :class="errorItem.item_store != '' ? 'error-field' : ''" :items="itemStores"
                                            @change="selectedStore" />
                                        <span class="error-label" v-if="errorItem.item_store != ''"
                                            v-text="errorItem.item_store"></span>
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>Quantity <span class="error-s">*</span></label>
                                        <input type="text" placeholder="" v-model="editItem.quantity" class="form-control"
                                            :class="errorItem.quantity != '' ? 'error-field' : ''" @keyup="
                                                editItem.quantity != ''
                                                    ? (errorItem.quantity = '')
                                                    : ''
                                                " />
                                        <span class="error-label" v-if="errorItem.quantity != ''"
                                            v-text="errorItem.quantity">
                                        </span>
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>Date </label>
                                        <input type="date" ref="date" placeholder="dd/mm/yyyy" class="form-control air-"
                                            v-model="editItem.income_date" :class="errorItem.income_date != '' ? 'error-field' : ''
                                                " @click="
        editItem.income_date != ''
            ? (errorItem.income_date = '')
            : ''
        " />
                                        <span class="error-label" v-if="errorItem.income_date != ''"
                                            v-text="errorItem.income_date"></span>
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>Description </label>
                                        <textarea class="textarea form-control" v-model="editItem.description"
                                            name="message" id="form-message" cols="10" rows="6" />

                                    </div>
                                    <div class="col-12 form-group">
                                        <label class="text-dark-medium">Atteched Document &nbsp; <strong
                                                class="text-danger bolder">*</strong></label>
                                        <div class="imageContainer">
                                            <img :src="selectedImage" alt />
                                            <input type="file" accept="image/jpeg, image/jpg, image/png" name="document" :class="errorItem.imageFilePath != '' ? 'error-field' : ''
                                                " class="form-control-file" @change="getImage" />
                                            <span class="error-label" v-if="errorItem.imageFilePath != ''"
                                                v-text="errorItem.imageFilePath"></span>
                                            <!-- <div class="my-3 ml-3" v-if="srcImageFile != null" style="margin-buttom: 100px">
                            <img :src="selectedImage" height="150" width="150" />
                        </div> -->
                                        </div>
                                    </div>
                                    <div class="col-12 form-group">
                                        <div class="justify-content-end">
                                            <button type="submit" class="
							btn-lg btn btn-gradient-yellow btn-hover-bluedark
							text-white
						" @click.prevent="submitForm">
                                                {{ formBtn }}
                                            </button>
                                            <button type="reset" class="
							btn-lg btn
							bg-blue-dark
							btn-hover-yellow
							text-white
						">
                                                Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <Footer />
                        <!-- All Subjects Area End Here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
var toast;
export default {
    props: ["itemCategories"],
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "admin.dashboard" },
                    name: "Home",
                },
                {
                    name: "AddItemStockInfo",
                },
            ],
            editedIndex: -1,
            itemStores: [],
            editItem: {
                categoryId: -1,
                inventoryItemId: -1,
                inventorySupplierId: -1,
                inventory_item_store_id: -1,
            },
            errorItem: {
                category: "",
                item_name: "",
                supplier: "",
                item_store: "",
                income_date: "",
                quantity: "",
                description: "",
                imageFilePath: "",
            },
            itemCategoriesList: [],
            item_name_select2: [],
            itemSuppliers: [],
            categoryId: -1,
            inventoryItemId: -1,
            inventorySupplierId: -1,
            inventory_item_store_id: -1,
            srcImageFile: null,
            imageFilePath: null,
        };
    },
    computed: {
        formBtn: function () {
            return this.editedIndex !== -1 ? "update" : "save";
        },
        selectedImage: function () {
            return this.srcImageFile != null
                ? this.srcImageFile
                : "/assets/img/nb.png";
        },
    },
    created() {
        this.getDropDown();
    },
    mounted() {
        this.editItem.itemCategoriesList = this.itemCategories;
        this.log('categoruies', this.itemCategories);
        this.$refs.itemCategoriesList_select2.updateList(this.itemCategories);
    },

    methods: {
        getSupplierId(val) {
            this.editItem.inventorySupplierId = val;
        },
        getImage(e) {
            const file = e.target.files[0];
            if (file) {
                this.srcImageFile = URL.createObjectURL(file);
                URL.revokeObjectURL(file);
                this.imageFilePath = file;
                this.errorItem.imageFilePath = "";
                this.isFormValid = true;
            } else {
                this.srcImageFile = null;
                this.imageFilePath = null;
            }

        },
        async getItems(val) {
            this.editItem.categoryId = val;
            this.log('Category id', this.editItem.categoryId);
            if (this.editItem.categoryId != -1) {
                const res = await this.callApi(
                    "get",
                    `/api/school/inventory/AddItemStockInfo/items/${this.editItem.categoryId}`,
                    null
                );
                console.log('hhhf',res);
                if (res.status == 200) {
                    var resData = res.data;
                    if (resData.status == "success") {
                        this.item_name_select2 = resData.itemsName;
                        this.log('item name select2', this.item_name_select2);
                        this.$refs.item_name_select2.updateList(
                            resData.itemsName
                        );
                        this.$nextTick(() => {
                            this.$refs.item_name_select2.setSelected(this.editItem.inventoryItemId);
                        });
                    } else {
                        toast = Toast.fire({
                            icon: resData.status,
                            title: resData.message,
                            timer: 2500,
                        });
                    }
                } else {
                    toast = Toast.fire({
                        icon: resData.status,
                        title: resData.message,
                        timer: 2500,
                    });
                }
            }
        },
        async getDropDown() {
            const res = await this.callApi(
                "get",
                `/api/school/inventory/AddItemStockInfo/AddItemStock/dropdowndata`,
                null
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.itemSuppliers = data.itemSuppliers;
                    this.$refs.supplier_select2.updateList(
                        data.itemSuppliers
                    );
                    this.itemStores = data.itemStores;
                    this.$refs.item_store_select2.updateList(
                        data.itemStores
                    );
                } else {
                    toast = Toast.fire({
                        icon: "error",
                        title: "Something went wrong",
                        timer: 2500,
                    });
                    this.noData = true;
                }
            }

        },
        DropDownUpdateList(item) {
            this.itemCategoriesList = item;
            this.$refs.itemCategoriesList_select2.updateList(item);
        },
        async submitForm() {
            var isVaild = await this.validItemForm();
            if (!isVaild) {
                return;
            }
            this.editItem.imageFilePath = this.imageFilePath;
            toast = Toast.fire({
                icon: "warning",
                title: "Please Wait!! Creating new Item",
                timer: 0,
            });
            this.$parent.submitForm(this.editItem, this.editedIndex);
            this.editItem = {};
            this.editedIndex = -1;

        },
        resetForm() {
            this.editItem = {};
            this.editedIndex = -1;
            this.$refs.itemCategoriesList_select2.setSelected('');
            this.$refs.item_name_select2.setSelected('');
            this.$refs.supplier_select2.setSelected('');
            this.$refs.item_store_select2.setSelected('');
            this.imageFilePath = '';
            this.srcImageFile = '';
        },
        // edit(item) {
        //     this.editedIndex = item.stock_id;
        //     this.srcImageFile = item.document;
        //     this.inventory_item_category_id != null ? item.inventory_item_category_id.value : -1;
        //     this.$refs.itemCategoriesList_select2.setSelected(this.inventory_item_category_id);
        //     this.inventory_add_item_id != null ? item.inventory_add_item_id.value : -1;
        //     this.$refs.item_name_select2.setSelected(this.inventory_add_item_id);
        //     this.inventory_supplier_info_id != null ? item.inventory_supplier_info_id.value : -1;
        //     this.$refs.supplier_select2.setSelected(this.inventory_supplier_info_id);
        //     this.inventory_item_store_id != null ? item.inventory_item_store_id.value : -1;
        //     this.$refs.item_store_select2.setSelected(this.inventory_item_store_id);
        // },
        edit(item) {
            this.log(item);
            this.editItem = item;
            this.editedIndex = item.stock_id;
            this.$refs.itemCategoriesList_select2.setSelected(
                item.inventory_item_category_id.value
            );
            this.editItem.categoryId = item.inventory_item_category_id.value;

            this.getItems(item.inventory_item_category_id.value);
            this.log('item name id', this.$refs.item_name_select2.setSelected(
                item.inventory_add_item_id.value
            ));

            this.editItem.inventoryItemId =
                item.inventory_add_item_id.value;

            this.getSupplierId(item.inventory_supplier_info_id.value);
            this.$refs.supplier_select2.setSelected(
                item.inventory_supplier_info_id.value
            );
            this.editItem.inventorySupplierId =
                item.inventory_supplier_info_id.value;

            this.selectedStore(item.inventory_item_storeId.value);
            this.$refs.item_store_select2.setSelected(
                item.inventory_item_storeId.value
            );
            this.editItem.inventory_item_store_id =
                item.inventory_item_storeId.value;
                this.srcImageFile = item.document;
                this.imageFilePath = item.document;
                this.log('image',this.imageFilePath);
                if(this.srcImageFile !== null || this.imageFilePath !== null){
                    this.errorItem.imageFilePath = '';
                    this.isFormValid = true;
                }
        },

        validItemForm() {
            this.isFormValid = true;
            if (this.editItem.categoryId == -1) {
                this.errorItem.category = "Select Item category is required";
                this.isFormValid = false;
            } else {
                this.errorItem.category = "";
                this.isFormValid = true;
            }
            if (this.editItem.inventoryItemId == -1) {
                this.errorItem.item_name = "Select Item Name  is required";
                this.isFormValid = false;
            } else {
                this.errorItem.item_name = "";
                this.isFormValid = true;
            }
            if (this.editItem.inventorySupplierId == -1) {
                this.errorItem.supplier = "Select Item Supplier  is required";
                this.isFormValid = false;
            } else {
                this.errorItem.supplier = "";
                this.isFormValid = true;
            }
            if (this.editItem.inventory_item_store_id == -1) {
                this.errorItem.item_store = "Select Item Store is required";
                this.isFormValid = false;
            } else {
                this.errorItem.item_store = "";
                this.isFormValid = true;
            }
            if (
                this.editItem.quantity == null ||
                this.editItem.quantity == ""
            ) {
                this.errorItem.quantity = "Item Quantity is required";
                this.isFormValid = false;
            } else {
                this.errorItem.quantity = "";
                this.isFormValid = true;
            }
            if (
                this.editItem.item_stock == null ||
                this.editItem.item_stock == ""
            ) {
                this.errorItem.item_stock = "item stock required";
                this.isFormValid = false;
            } else {
                this.errorItem.item_stock = "";
                this.isFormValid = true;
            }
            if (
                this.editItem.income_date == null ||
                this.editItem.income_date == ""
            ) {
                this.errorItem.income_date = "Expense Date is required";
                this.isFormValid = false;
            } else {
                this.errorItem.income_date = "";
                this.isFormValid = true;
            }

            if (this.imageFilePath == null || this.srcImageFile == null) {
                this.errorItem.imageFilePath = "image is required";
                this.isFormValid = false;
            } else {
                this.errorItem.imageFilePath = "";
                this.isFormValid = true;
            }
            return this.isFormValid;
        },

        async getSuppliers(val) {
            this.editItem.inventoryItemId = val;
        },
        selectedStore(val) {
            this.editItem.inventory_item_store_id = val;
        },
    },
};
</script>
<style scoped>
.error-s {
    color: red;
}
</style>
<style scoped>
.imageContainer {
    width: 100%;
    height: 150px;
    border: grey dashed 2px;
    border-radius: 10px;
    position: relative;
    background: #ffffff;
    text-align: center;
    padding: 10px;
    margin: auto;
    margin-bottom: 40px;
    cursor: pointer;
}

.imageContainer img {
    /* width: 100%; */
    height: 100%;
}

.imageContainer input {
    width: 100%;
    height: 100%;
    opacity: 0;
    position: absolute;
    top: 0;
    left: 0;
}
</style>

