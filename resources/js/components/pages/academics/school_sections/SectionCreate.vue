<template>
    <div class="card">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Add Section</h3>
                </div>
            </div>

            <div class="new-added-form">
                <div class="flex-grow-1 mr-5 form-group">
                    <input class="form-control" v-model="editItem.section_name" placeholder="Enter Section name"
                        @keypress="errorItem.section_name = ''" :class="errorItem.section_name != ''
                                ? 'error-field'
                                : ''
                            " />
                    <span class="error-label" v-if="errorItem.section_name != ''" v-text="errorItem.section_name"></span>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-fill-sm mr-1 rounded text-light shadow-dodger-blue bg-dodger-blue" @click.prevent="submitData()">
                        SAVE
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            editItem: {},
            editedIndex: -1,
            errorItem: {
                section_name: "",
            },
            isFormValid: false,
        };
    },
    computed: {
        formButton: function () {
            return this.editedIndex === -1 ? "Save" : "Update";
        },
        resetButton: function () {
            return this.editedIndex === -1 ? "Reset" : "Cancel";
        },
    },
    methods: {
        async submitData() {
            var isVaild = await this.validSectionForm();
            if (!isVaild) {
                return;
            }
            if (this.editedIndex === -1) {
                this.$parent.saveData(this.editItem);
            } else {
                this.$parent.updateData(this.editItem, this.editedIndex);
            }
        },
        resetForm() {
            this.editItem = {};
            this.editedIndex = -1;
        },
        validSectionForm() {
            this.isFormValid = true;
            if (
                this.editItem.section_name == null ||
                this.editItem.section_name == ""
            ) {
                this.errorItem.section_name = "Section Name is required";
                this.isFormValid = false;
            } else {
                this.errorItem.section_name = "";
            }
            return this.isFormValid;
        },
        edit(item) {
            this.editItem = item;
            this.editedIndex = item.section_id;
        },
    },
};
</script>
