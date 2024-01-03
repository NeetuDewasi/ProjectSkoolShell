<template>
        <form class="new-added-form">
            <div class="row">
                <div class="col-12 form-group">
                    <label>Item Category Name &nbsp;<strong class="text-danger bolder">*</strong></label>
                    <input type="text" placeholder="" class="form-control" v-model="editItem.item_category"
                        :class="errorItem.item_category != '' ? 'error-field' : ''" @keyup="
                            editItem.item_category != ''
                                ? (errorItem.item_category = '')
                                : ''
                        " />
                    <span class="error-label" v-if="errorItem.item_category != ''" v-text="errorItem.item_category">
                    </span>
                </div>
                <div class="col-12 form-group">
                    <label>Description </label>
                    <textarea class="textarea form-control" name="message" v-model="editItem.description"
                        id="form-message" cols="10" rows="6"></textarea>

                </div>
                <div class="col-12 form-group">
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
                item_category: "",
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
            this.editedIndex = item.item_id;
        },
        validItemForm() {
            this.isFormValid = true;
            if (
                this.editItem.item_category == null ||
                this.editItem.item_category == ""
            ) {
                this.errorItem.item_category = "item category  is required";
                this.isFormValid = false;
            } else {
                this.errorItem.item_category = "";
            }

            return this.isFormValid;
        },
    },
};
</script>


<style scoped>
</style>


