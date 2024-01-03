<template>
    <div class="card">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Add Subject</h3>
                </div>
            </div>

            <div class="new-added-form">
                <div class="form-group">
                    <input class="form-control" v-model="editItem.subject_name" placeholder="Enter Subject name *"
                        @keypress="errorItem.subject_name = ''" :class="errorItem.subject_name != ''
                                ? 'error-field'
                                : ''
                            " />
                    <span class="error-label" v-if="errorItem.subject_name != ''" v-text="errorItem.subject_name"></span>
                </div>
                <div class="form-group">
                    <input class="form-control" v-model="editItem.sub_code" placeholder="Enter Subject Code*"
                        @keypress="errorItem.sub_code = ''" :class="errorItem.sub_code != ''
                                ? 'error-field'
                                : ''
                            " />
                    <span class="error-label" v-if="errorItem.sub_code != ''" v-text="errorItem.sub_code"></span>
                </div>
                <div class="row ml-5">
                    <input class="form-radio-input mr-2 mt-2" v-model="subject_type" type="radio" value="theory"
                        id="isTheory" />
                    <span class="mr-5">Theory</span>
                    <input class="form-radio-input mt-2" v-model="subject_type" type="radio" value="practical"
                        id="isPractical" />
                    <span class="ml-3">Practical</span>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-fill-sm mr-1 rounded text-light shadow-dodger-blue bg-dodger-blue"
                        @click.prevent="submitForm()">
                        {{ formBtn }}
                    </button>
                    <button type="button" class="btn btn-fill-sm rounded text-light shadow-dodger-blue btn-gradient-yellow"
                        @click="resetForm">
                        {{ resetButton }}
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
                subject_name: "",
                sub_code: "",

            },
            subject_type: "theory",
            isFormValid: false,
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
    methods: {
        async submitForm() {
            var isVaild = await this.validSubjectForm();
            if (!isVaild) {
                return;
            }
            this.$parent.submitData(this.editItem, this.editedIndex);
            this.editItem = {};
        },
        validSubjectForm() {
            this.isFormValid = true;
            if (
                this.editItem.subject_name == null ||
                this.editItem.subject_name == ""
            ) {
                this.errorItem.subject_name = "Subject Name is required";
                this.isFormValid = false;
            } else {
                this.errorItem.subject_name = "";
            }
            if (
                this.editItem.sub_code == null ||
                this.editItem.sub_code == ""
            ) {
                this.errorItem.sub_code = "Subject Code is required";
                this.isFormValid = false;
            } else {
                this.errorItem.sub_code = "";
            }
            return this.isFormValid;
        },
        edit(item) {
            this.editItem = item;
            this.subject_type = item.subType;
            this.editedIndex = item.subject_id;
        },
        resetForm() {
            this.editItem = {};
            this.subject_type = "",
                this.editedIndex = -1;
        },
    },
};
</script>
