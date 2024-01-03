<template>
    <div>
        <form class="new-added-form">
            <div class="row">
                <div class="col-12 form-group">
                    <label>Item Category *</label>
                    <Select2 ref="itemCategoriesList_select2" :class="errorItem.category != '' ? 'error-field' : ''"
                        :items="itemCategoriesList" @change="getItems" />
                    <span class="error-label" v-if="errorItem.category != ''" v-text="errorItem.category"></span>
                </div>
                <div class="col-12 form-group">
                    <label>Item *</label>
                    <Select2 ref="item_name_select2" :class="errorItem.item_name != '' ? 'error-field' : ''"
                        :items="itemsName" @change="getItemStocks" />
                    <span class="error-label" v-if="errorItem.item_name != ''" v-text="errorItem.item_name"></span>
                </div>
                <div class="col-12 form-group">
                    <label>Department *</label>
                    <Select2 ref="departmentList_select2" :class="errorItem.department != '' ? 'error-field' : ''"
                        :items="departmentList" @change="getEmployees" />
                    <span class="error-label" v-if="errorItem.department != ''" v-text="errorItem.department"></span>
                </div>
                <div class="col-12 form-group">
                    <label>Assign To *</label>
                    <Select2 ref="employeeList_select2" :class="errorItem.employee != '' ? 'error-field' : ''"
                        :items="employeeList" @change="getEmployeesDepartments" />
                    <span class="error-label" v-if="errorItem.employee != ''" v-text="errorItem.employee"></span>
                </div>
                <div class="col-12 form-group">
                    <label>Quantity </label>
                    <input type="number" placeholder="" v-model="editItem.quantity"  :max='editItem.quantity' min=0
                        class="form-control" :class="errorItem.quantity != '' ? 'error-field' : ''" @keypress="
                            editItem.quantity != ''
                                ? (errorItem.quantity = '')
                                : ''
                        " />
                    <span class="error-label" v-if="errorItem.quantity != ''" v-text="errorItem.quantity"></span>
                </div>
                <div class="col-12 form-group">
                    <label>Return Date*</label>
                    <input type="date" ref="date" placeholder="dd/mm/yyyy" class="form-control air-"
                        v-model="editItem.return_date" :class="
                            errorItem.return_date != '' ? 'error-field' : ''
                        " @click="
    editItem.return_date != ''
        ? (errorItem.return_date = '')
        : ''
" />
                    <span class="error-label" v-if="errorItem.return_date != ''" v-text="errorItem.return_date"></span>
                </div>
                <div class="col-12 form-group">
                    <label>Note</label>
                    <textarea class="textarea form-control" v-model="editItem.description" name="message"
                        id="form-message" cols="10" rows="6" />
                </div>
                <div class="form-group mg-t-8">
                    <div class="justify-content-end">
                        <button type="submit" class="
								btn-lg
								btn
								btn-gradient-yellow
								btn-hover-bluedark
								text-white
							" @click.prevent="submitForm">
                            {{ formBtn }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
var toast;
export default {
    data() {

        return {
            editedIndex: -1,
            editItem: {
                categoryId: -1,
                inventoryItemId: -1,
                inventoryDepartmentId: -1,
                inventoryEmployeeId: -1,
                quantity: 0,
            },
            errorItem: {
                category: "",
                item_name: "",
                itemsStock: "",
                department: "",
                employee: "",
                return_date: "",
                quantity: "",

            },
            itemCategoriesList: [],
            itemsName: [],
            itemsStock: [],
            ItemAvailStock: [],
            departmentList: [],
            employeeList: [],
        };
    },
    created() {
        this.getDropDown();
    },
    mounted() {
         this.itemCategoriesList = this.itemCategories;
     },
    computed: {
        formBtn: function () {
            return this.editedIndex !== -1 ? "update" : "save";
        },
    },
    methods: {
        async getItems(val) {
            this.editItem.categoryId = val;
            this.log('Item_id',this.editItem.categoryId);
            if (this.editItem.categoryId != -1) {
                const res = await this.callApi(
                    "get",
                    `/api/school/inventory/AddIssueItem/items/${this.editItem.categoryId}`,
                    null
                );
                if (res.status == 200) {
                    var resData = res.data;
                    if (resData.status == "success") {
                        this.itemsName = resData.itemsName;
                        this.$refs.item_name_select2.updateList(
                            resData.itemsName);
                    }
                    else {
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
        async getItemStocks(val) {
            this.editItem.inventoryItemId = val;
            let selectedQty = 0;
            this.itemsName.forEach(element => {
                if (element.value == val) {
                    selectedQty = element.quantity
                    this.editItem.selectedQtty = element.quantity;
                }
            });
            if (selectedQty == 0) {
                SwalCustomBtn.fire({
                    title: "Out of Stock",
                    text: "This item is out of stock. Add this item in stock before issue",
                    icon: "error",
                    showCancelButton: false,
                    confirmButtonText: "ok",
                }).then((result) => {
                    this.$refs.item_name_select2.setSelected("-1");
                    this.editItem.inventoryItemId = -1;
                    this.editItem.quantity = 0;
                });

            } else {
                this.editItem.quantity = selectedQty;


            }

        },
        async getDropDown() {
            const res = await this.callApi(
                "get",
                `/api/school/inventory/AddIssueItem/AddIssueItem/dropdowndata`,
                null
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.itemCategories = data.item_categories;
                    this.$refs.itemCategoriesList_select2.updateList(
                        data.item_categories
                    );
                    this.departmentList = data.departments;
                    this.$refs.departmentList_select2.updateList(
                        this.departmentList
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
            toast = Toast.fire({
                icon: "warning",
                title: "Please Wait!! Creating new Item",
                timer: 0,
            });
            if( this.editItem.quantity <= this.editItem.selectedQtty){
                this.$parent.submitForm(this.editItem, this.editedIndex);
            }else{
                 SwalCustomBtn.fire({
                    title: "Out of Stock",
                    text: "Please enter item quantity is less than or equal of in stock quantity. Add this item in stock before issue",
                    icon: "error",
                    showCancelButton: false,
                    confirmButtonText: "ok",
                }).then((result) => {
                    this.$refs.item_name_select2.setSelected("-1");
                    this.editItem.inventoryItemId = -1;
                    this.editItem.quantity = 0;
                });
            }
        },
        resetForm() {
            this.editItem = {};
            this.editItem = {
                categoryId: -1,
                inventoryItemId: -1,
                inventoryDepartmentId: -1,
                inventoryEmployeeId: -1,
                quantity: 0,
            },
            this.editedIndex = -1;
            this.$refs.itemCategoriesList_select2.setSelected(-1);
            this.$refs.item_name_select2.setSelected(-1);
            this.$refs.departmentList_select2.setSelected(-1);
            this.$refs.employeeList_select2.setSelected(-1);
        },
        edit(item) {
            this.editItem = item;
            this.editedIndex = item.inventory_issueItem_id;
            this.$refs.itemCategoriesList_select2.setSelected(
                item.inventory_item_category_id.value
            );
            this.editItem.categoryId = item.inventory_item_category_id.value;

            this.getItems(item.inventory_item_category_id.value);
            this.$refs.item_name_select2.setSelected(
                item.inventory_add_item_id.value
            );
            this.editItem.inventoryItemId =
                item.inventory_add_item_id.value;

            // this.getDepartments(item.inventory_department_info_id.value);
            this.$refs.departmentList_select2.setSelected(
                item.inventory_department_info_id.value
            );
            this.editItem.inventoryDepartmentId =
                item.inventory_department_info_id.value;
            this.getEmployees(item.inventory_department_info_id.value);
            this.$refs.employeeList_select2.setSelected(
                item.inventory_employee_id.value
            );
            this.editItem.inventoryEmployeeId =
                item.inventory_employee_id.value;
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
            if (this.editItem.inventoryItemId == -1 || this.editItem.quantity ==0 ) {
                this.errorItem.quantity = "Select Item Stock Quantity  is required";
                this.isFormValid = false;
            } else {
                this.errorItem.quantity = "";
                this.isFormValid = true;
            }
            if (this.editItem.inventoryDepartmentId == -1) {
                this.errorItem.department = "Select Department  is required";
                this.isFormValid = false;
            } else {
                this.errorItem.department = "";
                this.isFormValid = true;
            }
            if (this.editItem.inventoryEmployeeId == -1) {
                this.errorItem.employee = "Select Employee is required";
                this.isFormValid = false;
            } else {
                this.errorItem.employee = "";
                this.isFormValid = true;
            }
            if (
                this.editItem.return_date == null ||
                this.editItem.return_date == ""
            ) {
                this.errorItem.return_date = "Income Date is required";
                this.isFormValid = false;
            } else {
                this.errorItem.return_date = "";
                this.isFormValid = true;
            }

            return this.isFormValid;
        },

        async getDepartments(val) {
            this.editItem.inventoryItemId = val;
        },

        async getEmployees(val) {
            this.log('depart id', this.editItem.inventoryDepartmentId);
            this.editItem.inventoryDepartmentId = val;
            if (this.editItem.inventoryDepartmentId != -1) {
                const res = await this.callApi(
                    "get",
                    `/api/school/inventory/AddIssueItem/items/employees/${this.editItem.inventoryDepartmentId}`,
                    null
                );
                console.log('employees',res);
                if (res.status == 200) {
                    var resData = res.data;
                    if (resData.status == "success") {
                        this.employeeList = resData.employeeList;
                        this.$refs.employeeList_select2.updateList(
                            resData.employeeList
                        );
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
        async getEmployeesDepartments(val) {
            this.editItem.inventoryEmployeeId = val;
        },

    },

};

</script>

<style scoped>
.error-s {
    color: red;
}
</style>


