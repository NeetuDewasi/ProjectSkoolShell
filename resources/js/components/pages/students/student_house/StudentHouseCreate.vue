<template>
    <div>
   
            <Breadcrumb pageTitle="Student House" :breadcrumbList="breadcrumbList" />
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Add School House</h3>
                                </div>
                            </div>

                            <form class="new-added-form">

                                <div class="flex-grow-1 mr-5 col-12 form-group">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input class="form-control" v-model="editItem.house_name" placeholder="Enter House name"
                                        @keypress="errorItem.house_name = ''" :class="
                                            errorItem.house_name != ''
                                                ? 'error-field'
                                                : ''
                                        " />
                                    <span class="error-label" v-if="errorItem.house_name != ''"
                                        v-text="errorItem.house_name"></span>
                                </div>
                                <div class="flex-grow-1 col-12 mr-5 form-group">
                                    <label>Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control" type="text-area" v-model="editItem.description"
                                        placeholder="Enter House description" @keypress="errorItem.description = ''" :class="
                                            errorItem.description != ''
                                                ? 'error-field'
                                                : ''
                                        " />
                                    <span class="error-label" v-if="errorItem.description != ''"
                                        v-text="errorItem.description"></span>
                                </div>
                                <div class="row ml-3">
                                    <div class="col-12 form-group mb-5 ">
                                        <button type="button"
                                            class="btn-fill-md text-light shadow-dodger-blue bg-dodger-blue"
                                            @click.prevent="submitData()">{{ formBtn }}</button>

                                        <button type="button" class="
    									btn-fill-md
    									text-light
    									shadow-dodger-blue
    									btn-gradient-yellow
    								" @click.prevent="resetForm()">
                                            {{ resetButton }}
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
       
    </div>
</template>

<script>
export default {
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "admin.dashboard" },
                    name: "Home",
                },
                {
                    name: "Student House",
                },
            ],
            editItem: {},
            editedIndex: -1,
            errorItem: {
                house_name: "",
                description: "",
            },
            isFormValid: false,
        };

    },
    computed: {
        formBtn: function () {
            return this.editedIndex !== -1 ? 'Update' : 'Save';
        },
        resetButton: function () {
            return this.editedIndex === -1 ? "Reset" : "Cancel";
        },
    },
    methods: {

        async submitData() {
            var isVaild = await this.validHouseForm();
            if (!isVaild) {
                return;
            }
            if (this.editedIndex === -1) {
                this.$parent.saveData(this.editItem);
            } else {
                this.$parent.updateData(this.editItem, this.editedIndex);
            }
            this.editItem = {};
            this.editedIndex = -1;
        },
        resetForm() {
            this.editItem = {};
            this.editedIndex = -1;
        },
        validHouseForm() {
            this.isFormValid = true;
            if (
                this.editItem.house_name == null ||
                this.editItem.house_name == ""
            ) {
                this.errorItem.house_name = "House Name is required";
                this.isFormValid = false;
            } else {
                this.errorItem.house_name = "";
            }
            if (
                this.editItem.description == null ||
                this.editItem.description == ""
            ) {
                this.errorItem.description = "Description is required";
                this.isFormValid = false;
            } else {
                this.errorItem.description = "";
            }
            return this.isFormValid;
        },
        edit(item) {
            this.editItem = item;
            this.editedIndex = item.house_id;
        },
    },
};
</script>
