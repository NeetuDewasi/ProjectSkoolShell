<template>
    <div>
        <form class="new-added-form">
            <div class="row">
                <!-- <div class="col-12 form-group">
                    <label>Income Head <span class="error-s">*</span> </label>
                    <Select2 ref="itemCategoriesList_select2" :class="errorItem.category != '' ? 'error-field' : ''"
                        :items="itemCategoriesList" @change='getItems' />
                    <span class="error-label" v-if="errorItem.category != ''" v-text="errorItem.category"></span>
                </div> -->
                <div class="col-12 form-group">
                    <label>Income Head <strong class="text-danger bolder">*</strong></label>
                    <Select2 ref="income_head_list_select2" :items="income_head_list" @change="selectIncomeHead"
                        :selectedId="selectedIncomeHead" :class="
                            errorItem.income_head_list != '' ? 'error-field' : ''
                        " />
                    <span class="error-label" v-if="errorItem.income_head_list != ''"
                        v-text="errorItem.income_head_list">
                    </span>
                </div>
                <div class="col-12 form-group">
                    <label>Item Name <span class="error-s">*</span></label>
                    <Select2 ref="item_name_select2" :items="income_item_list" @change="selectIncomeItem"
                        :selectedId="selectIncomeItem" :class="
                            errorItem.income_item_list != '' ? 'error-field' : ''
                        " />
                    <span class="error-label" v-if="errorItem.income_item_list != ''"
                        v-text="errorItem.income_item_list">
                    </span>
                </div>

                <div class="col-12 form-group">
                    <label>Invoice Number &nbsp; <strong class="text-danger bolder">*</strong></label>
                    <input type="text" name="invoice_number" v-model="editItem.invoice_number" placeholder=""
                        class="form-control" :class="
                            errorItem.invoice_number != '' ? 'error-field' : ''
                        " @keyup="
    editItem.invoice_number != ''
        ? (errorItem.invoice_number = '')
        : ''
" />
                    <span class="error-label" v-if="errorItem.invoice_number != ''" v-text="errorItem.invoice_number">
                    </span>
                </div>
                <div class="col-12 form-group">
                    <label>Income Date &nbsp; <strong class="text-danger bolder">*</strong></label>
                    <input type="date" ref="date" placeholder="dd/mm/yyyy" class="form-control air-"
                        v-model="editItem.income_date" :class="
                            errorItem.income_date != '' ? 'error-field' : ''
                        " @click="
    editItem.income_date != ''
        ? (errorItem.income_date = '')
        : ''
" />
                    <span class="error-label" v-if="errorItem.income_date != ''" v-text="errorItem.income_date"></span>
                </div>
                <div class="col-12 form-group">
                    <label>Income Amount &nbsp; <strong class="text-danger bolder">*</strong></label>
                    <input type="text" name="amount" v-model="editItem.amount" placeholder="" class="form-control"
                        :class="errorItem.amount != '' ? 'error-field' : ''" @keyup="
                            editItem.amount != '' ? (errorItem.amount = '') : ''
                        " />
                    <span class="error-label" v-if="errorItem.amount != ''" v-text="errorItem.amount">
                    </span>
                </div>
                <div class="col-12 form-group">
                    <label class="text-dark-medium">Atteched Document &nbsp; <strong
                            class="text-danger bolder">*</strong></label>
                    <div class="imageContainer">
                        <img :src="selectedImage" alt />
                        <input type="file" accept="image/*" name="document" :class="
                            errorItem.imageFilePath != '' ? 'error-field' : ''
                        " class="form-control-file" @change="getImage" />
                        <span class="error-label" v-if="errorItem.imageFilePath != ''"
                            v-text="errorItem.imageFilePath"></span>
                        <!-- <div class="my-3 ml-3" v-if="srcImageFile != null" style="margin-buttom: 100px">
                            <img :src="selectedImage" height="150" width="150" />
                        </div> -->
                    </div>
                </div>
                <div class="col-12 form-group">
                    <label>Description &nbsp; </label>
                    <textarea class="textarea form-control" v-model="editItem.description" name="message"
                        id="form-message" cols="10" rows="6" />
                </div>
                <div class="col-12 form-group">
                    <button @click.prevent="submitForm()" class="
							btn-lg btn btn-gradient-yellow btn-hover-bluedark
							text-white
						">
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
        </form>
    </div>
</template>
<script>
var toast;
export default {
    props: ["itemCategories"],
    data() {
        return {
            editedIndex: -1,
            editItem: {},
            errorItem: {

                income_head: "",
                income_head_list: "",
                item_name: "",
                income_item_list: "",
                invoice_number: "",
                income_date: "",
                amount: "",
                document: "",

                imageFilePath: "",

            },

            income_head_list: [],
            selectedIncomeHead: -1,
            income_item_list: [],
            selectedIncomeItem: -1,

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
                : "/assets/img/nb.jpg";
        },
    },
    created() { },
    mounted() {
        this.getIncomeHeadData();
        this.getIncomeItemData();
    },
    methods: {
        getImage(e) {
            const file = e.target.files[0];
            if (file) {
                this.srcImageFile = URL.createObjectURL(file);
                URL.revokeObjectURL(file);
                this.imageFilePath = file;
            } else {
                this.srcImageFile = null;
                this.imageFilePath = null;
            }
            this.errorItem.imageFilePath = "";
        },

        async getIncomeHeadData() {
            const res = await this.callApi(
                "get",
                `/api/school/income/AddIncome/income_head_list`,
                null
            );
            this.log(res);
            if (res.status == 200) {
                var data = res.data;
                this.income_head_list = data.income_head_list;
                this.$refs.income_head_list_select2.updateList(data.income_head_list);
            }
        },

        async getIncomeItemData() {
            const res = await this.callApi(
                "get",
                `/api/school/income/AddIncome/income_item_list`,
                null
            );
            this.log(res);
            if (res.status == 200) {
                var data = res.data;
                this.income_item_list = data.income_item_list;
                this.$refs.item_name_select2.updateList(data.income_item_list);
                this.$refs.item_name_select2.setSelected(-1);

            }
        },
        // async getEditData() {
        //     const res = await this.callApi(
        //         "get",
        //         `/api/school/income/AddIncome/edit/${this.$route.params.edit_id}`,
        //         null
        //     );
        //     if (res.status == 200) {
        //         var data = res.data;
        //         if (data.status == "success") {
        //             this.log("data.expenses>>>>>>", data.income_heads);
        //             this.editItem = data.income_heads;
        //             (this.selectedIncomeHead = data.income_heads.income_head.value);
        //             this.$refs.income_head_list_select2.setSelected(data.income_heads.income_head.value);
        //             (this.selectedIncomeItem = data.income_heads.income_item.value);
        //             this.$refs.item_name_select2.setSelected(data.income_heads.income_item.value);
        //         }
        //     }
        // },
        selectIncomeHead(val) {
            this.log("val", val);
            this.selectedIncomeHead = val;
            this.errorItem.income_head_list = "";
        },
        selectIncomeItem(val) {
            this.log("val", val);
            this.selectedIncomeItem = val;
            this.errorItem.income_item_list = "";
        },
        async submitForm() {
            var isVaild = await this.validItemForm();
            if (!isVaild) {
                return;
            }
            this.editItem.incomeHeadId = this.selectedIncomeHead;
            this.editItem.incomeItemId = this.selectedIncomeItem;
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

        edit(item) {
            this.selectedIncomeHead = item.income_head != null ? item.income_head.value : -1;
            this.$refs.income_head_list_select2.setSelected(this.selectedIncomeHead);
            this.selectedIncomeItem = item.item_name != null ? item.item_name.value : -1;
            this.$refs.item_name_select2.setSelected(this.selectedIncomeItem);
            this.editItem = item;
            this.srcImageFile = item.document;
            this.editedIndex = item.id;
        },

        validItemForm() {
            this.isFormValid = true;
            if (this.selectedIncomeHead == -1) {
                this.errorItem.income_head_list = "Income Head is required";
                this.isFormValid = false;
            } else {
                this.errorItem.income_head_list = "";
            }

            if (this.selectedIncomeItem == -1) {
                this.errorItem.income_item_list = "Income Item is required";
                this.isFormValid = false;
            } else {
                this.errorItem.income_item_list = "";
            }

            if (
                this.editItem.invoice_number == null ||
                this.editItem.invoice_number == ""
            ) {
                this.errorItem.invoice_number = "invoice number is required";
                this.isFormValid = false;
            } else {
                this.errorItem.invoice_number = "";
                this.isFormValid = true;
            }

            if (
                this.editItem.income_date == null ||
                this.editItem.income_date == ""
            ) {
                this.errorItem.income_date = "Date is required";
                this.isFormValid = false;
            } else {
                this.errorItem.income_date = "";
                this.isFormValid = true;
            }

            if (this.editItem.amount == null || this.editItem.amount == "") {
                this.errorItem.amount = "Amount is required";
                this.isFormValid = false;
            } else {
                this.errorItem.amount = "";
                this.isFormValid = true;
            }
            if (
                this.editItem.document == null ||
                this.editItem.document == ""
            ) {
                this.errorItem.document = "document is required";
                this.isFormValid = false;
            } else {
                this.errorItem.document = "";
                this.isFormValid = true;
            }
            // if (
            //     this.editItem.description == null ||
            //     this.editItem.description == ""
            // ) {
            //     this.errorItem.description =
            //         "income head Description  is required";
            //     this.isFormValid = false;
            // } else {
            //     this.errorItem.description = "";
            //     this.isFormValid = true;
            // }
            if (this.imageFilePath == null) {
                this.errorItem.imageFilePath = "image is required";
                this.isFormValid = false;
            } else {
                this.errorItem.imageFilePath = "";
                this.isFormValid = true;
            }
            return this.isFormValid;
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
