<template>
    <div>
        <div class="card">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3> New Exam Type</h3>
                    </div>
                </div>
                <form class="new-added-form">
                    <div class="col-md-12 flex-grow-1 mr-5 form-group">
                        <label>Exam Type</label>
                        <input class="form-control" v-model="editItem.exam_type" placeholder="Enter Type Of the Exam"
                         @keypress="errorItem.exam_type = ''" :class="
                                errorItem.exam_type != ''
                                    ? 'error-field'
                                    : ''
                            "  />
                        <span class="error-label" v-if="errorItem.exam_type != ''" v-text="errorItem.exam_type"></span>
                    </div>
                    <div class="col-md-12 flex-grow-1 mr-5 form-group">
                        <label>Description</label>
                        <input class="form-control" v-model="editItem.exam_description">
                    </div>
                    <div class="form-group">
                        <button type="button" class="
								btn-fill-lg
								text-light
								shadow-dodger-blue
								bg-dodger-blue"
                                @click.prevent="submitData()">
                            {{ frmBtn }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
var toast;
export default {
    data() {
        return {
            editItem: {
                exam_type: '',
            },
            errorItem:{
                exam_type:'',
            },
            editedIndex: -1,
        };
    },
    computed: {
        frmBtn: function () {
            return this.editedIndex !== -1 ? 'Update' : 'Save';
        },
    },
    methods: {
        async submitData() {
            var isVaild = await this.validExamForm();
            if (!isVaild) {
                return;
            }
            toast = Toast.fire({
                icon: "warning",
                title: "Please Wait!! Creating new Exam Type",
                timer: 0,
            });
            var data = new FormData;
            data.append('exam_type', this.editItem.exam_type ? this.editItem.exam_type : '');
            data.append('description', this.editItem.exam_description ? this.editItem.exam_description : '');
            let url = "";
            if (this.editedIndex != -1) {
                url = `/api/school/examinations/exam_type/update/${this.editedIndex}`;
            } else {
                url = `/api/school/examinations/exam_type/save`;
            }
            const res = await this.callApi("post", url, data);
            this.log('REQUEST', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.$parent.showData();
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
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
        edit(item,index){
			this.editItem = item;
			this.editedIndex = item.exam_type_id;
		},

        validExamForm() {
            this.isFormValid = true;
            if (
                this.editItem.exam_type == null ||
                this.editItem.exam_type == ""
            ) {
                this.errorItem.exam_type =
                    "Exam Type is required";
                this.isFormValid = false;
            } else {
                this.errorItem.exam_type = "";
            }
            return this.isFormValid;
        }
    },
};
</script>
