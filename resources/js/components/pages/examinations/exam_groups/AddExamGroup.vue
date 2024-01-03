<template>
    <div>
        <form class="new-added-form">
            <div class="row main_row">
                <div class="col-lg-12 col-12 form-group ">
                    <label>Class</label>
                    <Select2 ref="class_list_select2" :items="class_list_select2" @change="getClassId" />
                    <span class="error-label" v-if="errorItem.class_list_select2 != ''"
                        v-text="errorItem.class_list_select2"></span>
                </div>
                <div class="col-lg-12 col-12 form-group">
                    <label>Exam Group</label>
                    <input type="text" class="form-control" placeholder="Exam Group" v-model="editItem.examGroup_name"
                        @keypress="errorItem.examGroup_name = ''" :class="
                        errorItem.examGroup_name != ''
                        ? 'error-field'
                        : ''" />
                    <span class="error-label" v-if="errorItem.examGroup_name != ''"
                        v-text="errorItem.examGroup_name"></span>

                </div>
                <div class="col-lg-12 col-12 form-group">
                    <label>Exam Type *</label>
                    <Select2 ref="exam_type_select2" :items="exam_type_select2" @change="getExamId" />
                    <span class="error-label" v-if="errorItem.exam_type_select2 != ''"
                        v-text="errorItem.exam_type_select2"></span>
                </div>
                <div class="col-lg-12 col-12 form-group">
                    <label for="Description">Description</label>
                    <textarea class="form-control" placeholder="Description"
                        v-model="editItem.examGroup_description"></textarea>
                </div>
            </div>
            <div class="justify-content-end mt-5">
                <button type="submit" class="
											btn-fill-lg
											text-light
											shadow-dodger-blue
											bg-dodger-blue
										" @click.prevent="submitData()">
                    {{frmBtn}}
                </button>
            </div>
        </form>

    </div>
</template>
<script>
var toast;
export default {
    data() {
        return {
            editItem: {},
            examTypes: [],
            class_list_select2: [],
            exam_type_select2: [],
            editedIndex: -1,
            classId: -1,
            examTypeId: -1,
            examGroups: [],
            errorItem: {
                exam_type_select2: '',
                examGroup_name: '',
                class_list_select2: '',
            },
        };
    },
    created() {

    },
    computed: {
        frmBtn: function () {
            return this.editedIndex !== -1 ? 'Update' : 'Save';
        },
    },
    mounted() {
        this.getClassList();
        this.getExamType();
    },
    methods: {
        async getClassList() {
            const res = await this.callApi(
                "get",
                `/api/school/general/get_class_list`,
                null,
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.class_list_select2 = data.class_list;
                    this.$refs.class_list_select2.updateList(data.class_list);
                }
            }
        },
        getClassId(val) {
            this.classId = val;
        },
        getExamId(value) {
            this.examTypeId = value;
        },
        async getExamType() {
            const res = await this.callApi(
                "get",
                `/api/school/examinations/exam_group/exam_type_list`,
                null,
            );
            this.log('Dropdown', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.exam_type_select2 = data.examType_list;
                    this.$refs.exam_type_select2.updateList(this.exam_type_select2);
                }
            }
        },
        async submitData() {
            var isVaild = await this.validExamForm();
            if (!isVaild) {
                return;
            }
            toast = Toast.fire({
                icon: "warning",
                title: "Please Wait!! Creating new Exam",
                timer: 0,
            });
            var data = new FormData();
            this.log('EDITITEM', this.editItem);
            data.append('classId', this.classId ? this.classId : '');
            data.append('group_name', this.editItem.examGroup_name ? this.editItem.examGroup_name : '');
            data.append('exam_type', this.examTypeId ? this.examTypeId : '');
            data.append('exam_description', this.editItem.examGroup_description ? this.editItem.examGroup_description : '');
            let url = "";
            if (this.editedIndex != -1) {
                url = `/api/school/examinations/exam_group/update/${this.editedIndex}`;
            } else {
                url = `/api/school/examinations/exam_group/save`;
            }
            const res = await this.callApi("post", url, data);
            this.log('REQUEST', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.examGroups.push(data.exam_groups);
                    this.$parent.showData();
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    })
                } else {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                }
            } else {
                toast = Toast.fire({
                    icon: data.status,
                    title: data.message,
                    timer: 2500,
                });
            }

        },
        edit(item, index) {
            this.log('item edit data',item);
            this.editItem = item;
            this.editedIndex = item.examGroup_id;
            this.$refs.class_list_select2.setSelected(item.school_class.value);
            this.getClassId(item.school_class.value);
            this.$refs.exam_type_select2.setSelected(item.examGroup_type.id);
            this.getExamId(item.examGroup_type.id);
        },
        validExamForm() {
            this.isFormValid = true;
            if (
                this.editItem.examGroup_name == null ||
                this.editItem.examGroup_name == ""
            ) {
                this.errorItem.examGroup_name =
                    "Exam Group is required";
                this.isFormValid = false;
            } else {
                this.errorItem.examGroup_name = "";
            }
            return this.isFormValid;
        }

    },
};
</script>

<style scoped>
.main_row {
    padding: 0%;
    margin: 0%;
}

.card-main {
    padding: 0;
    margin: 0;
}
</style>
