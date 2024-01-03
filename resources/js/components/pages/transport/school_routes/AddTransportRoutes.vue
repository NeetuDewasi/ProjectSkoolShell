<template>
    <div>
        <div class="card height-auto">
            <div class="row">
                <div class="col-12 form-group">
                    <label>Route Name
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="route_name" v-model="editItem.route_name" :class="
                        errorItem.route_name != ''
                            ? 'error-field'
                            : ''
                    " @keydown="errorItem.route_name = ''" placeholder="Enter Route Name *" class="form-control" />
                    <span v-if="errorItem.route_name != ''" v-text="errorItem.route_name" class="error-label"></span>
                </div><br>
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
        </div>
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
                route_name: "",
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
            return this.editedIndex !== -1 ? "update" : "save";
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
            this.editedIndex = item.route_id;
        },
        validItemForm() {
            this.isFormValid = true;
            if (
                this.editItem.route_name == null ||
                this.editItem.route_name == ""
            ) {
                this.errorItem.route_name = "Route Name is required";
                this.isFormValid = false;
            } else {
                this.errorItem.route_name = "";
            }
            return this.isFormValid;
        },
    },
};
</script>


<style scoped>
</style>


