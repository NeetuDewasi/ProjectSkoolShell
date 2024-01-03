<template>
    <div>
        <form class="new-added-form">
            <div class="row">
                <div class="col-12 form-group">
                    <label>Item Store &nbsp; <strong class="text-danger bolder">*</strong></label>
                    <input type="text" name="item_store" v-model="editItem.item_store" placeholder=""
                        class="form-control" :class="errorItem.item_store != '' ? 'error-field' : ''" @keyup="
                            editItem.item_store != ''
                                ? (errorItem.item_store = '')
                                : ''
                        " />
                    <span class="error-label" v-if="errorItem.item_store != ''" v-text="errorItem.item_store">
                    </span>
                </div>
                <div class="col-12 form-group">
                    <label>Item Stock Code &nbsp; <strong class="text-danger bolder">*</strong></label>
                    <input type="text" name="item_stock" v-model="editItem.item_stock" placeholder=""
                        class="form-control" :class="errorItem.item_stock != '' ? 'error-field' : ''" @keyup="
                            editItem.item_stock != ''
                                ? (errorItem.item_stock = '')
                                : ''
                        " />
                    <span class="error-label" v-if="errorItem.item_stock != ''" v-text="errorItem.item_stock">
                    </span>
                </div>
                <div class="col-12 form-group">
                    <label>Description </label>
                    <textarea v-model="editItem.description" class="textarea form-control" name="description"
                        id="form-message" cols="10" rows="6" ></textarea>
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
            editItem: {
                categoryId: -1,
            },
            errorItem: {
                item_store: "",
                item_stock: "",
                description: "",
            },
            itemCategoriesList: [],
        };
    },
    created() { },
    mounted() {
        this.itemCategoriesList = this.itemCategories;
    },
    computed: {
        formBtn: function () {
            return this.editedIndex !== -1 ? "Update" : "Save";
        },
    },
    methods: {
        getCategoryId(val) {
            this.editItem.categoryId = val;
            this.errorItem.itemCategoriesList = "";
        },
        updateList(item) {
            this.itemCategoriesList = item;
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
            this.$parent.submitForm(this.editItem, this.editedIndex);
            this.editItem = {};
            this.editedIndex = -1;
        },
        edit(item) {
            this.editItem = item;
            // this.$refs.select2.changeItemId(item.category.value);
            this.editedIndex = item.store_id;
        },
        validItemForm() {
            this.isFormValid = true;
            if (
                this.editItem.item_store == null ||
                this.editItem.item_store == ""
            ) {
                this.errorItem.item_store = "item store is required";
                this.isFormValid = false;
            } else {
                this.errorItem.item_store = "";
            }
            if (
                this.editItem.item_stock == null ||
                this.editItem.item_stock == ""
            ) {
                this.errorItem.item_stock = "item stock required";
                this.isFormValid = false;
            } else {
                this.errorItem.item_stock = "";
            }

            return this.isFormValid;
        },
    },
};
</script>


<style scoped>
</style>

