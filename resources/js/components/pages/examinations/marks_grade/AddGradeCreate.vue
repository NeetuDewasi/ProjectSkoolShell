<template>
  <div>
    <div class="row gutters-20">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="heading-layout1">
              <div class="item-title">
                <h3>Add Marks Grade</h3>
              </div>
            </div>
            <form class="new-added-form">
              <div class="row">
                <div class="col-lg-12 col-12 form-group">
                  <label>Exam Type *</label>

                  <Select2
                    ref="exam_type"
                    :items="exam_type"
                    @change="selectExamType"
                  />
                </div>
                <div class="col-lg-12 col-12 form-group">
                  <label>Grade Name</label>
                  <input type="text" class="form-control" v-model="editItem.grade"
                   :class="errorItem.grade != '' ? 'error-field' : ''"
                    @keyup="editItem.grade != '' ? (errorItem.grade = '') : ''" />
                    <span class="error-label" v-if="errorItem.grade != ''"
                    v-text="errorItem.grade"></span>
                </div>
                <div class="col-lg-12 col-12 form-group">
                  <label>Percent Upto</label>
                  <input type="text" class="form-control" v-model="editItem.percent_upto"
                  :class="errorItem.percent_upto != '' ? 'error-field' : ''"
                    @keyup="editItem.percent_upto != '' ? (errorItem.percent_upto = '') : ''" />
                    <span class="error-label" v-if="errorItem.percent_upto != ''"
                    v-text="errorItem.percent_upto"></span>
                </div>
                <div class="col-lg-12 col-12 form-group">
                  <label>Grade From</label>
                  <input type="text" class="form-control" v-model="editItem.percent_from"
                  :class="errorItem.percent_from != '' ? 'error-field' : ''"
                    @keyup="editItem.percent_from != '' ? (errorItem.percent_from = '') : ''" />
                    <span class="error-label" v-if="errorItem.percent_from != ''"
                    v-text="errorItem.percent_from"></span>
                </div>
                <div class="col-lg-12 col-12 form-group">
                  <label>Grade Point</label>
                  <input type="text" class="form-control" v-model="editItem.grade_point" />
                </div>

                <div class="col-xl-12 col-lg-12 form-group mg-t-8">
                  <button
                    type="submit"
                    class="btn btn-lg btn-gradient-yellow btn-hover-bluedark mx-3 text-white"
                    @click.prevent="submitData()"
                  >{{ formBtn }}</button>
                  <button
                    type="reset"
                    class="btn btn-lg btn-gradient-yellow btn-hover-bluedark mx-3 text-white"
                  >Reset</button>
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
var toast;
export default {
    data() {
        return {
            editItem:{},
            exam_type:[],
            editedIndex:-1,
            errorItem:{
                grade:'',
                percent_from:'',
                percent_upto:'',
            },
        };
    },
     computed: {
        formBtn: function () {
            return this.editedIndex != -1 ? "Update" : "Save";
        },
    },
    mounted(){
        this.getExamType();
    },
    methods:{
         async getExamType() {
            const res = await this.callApi(
                "get",
                `/api/school/examinations/marks_grade/exam_type_list`,
                null,
            );
            this.log('Dropdown', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.exam_type = data.exam_type_list;
                    this.$refs.exam_type.updateList(data.exam_type_list);
                }
            }
        },
        selectExamType(exam_type_id){
            this.exam_type_id = exam_type_id;
        },
        async submitData() {
            var isVaild = await this.validGradeForm();
            if (!isVaild) {
                return;
            }
            toast = Toast.fire({
                icon: "warning",
                title: "Please wait! Creating new Id Card"
            });
            var data = new FormData();
            data.append('exam_type_id', this.exam_type_id ? this.exam_type_id : "");
            data.append('grade_name', this.editItem.grade ? this.editItem.grade : "");
            data.append('percent_upto', this.editItem.percent_upto ? this.editItem.percent_upto : "");
            data.append('percent_from', this.editItem.percent_from ? this.editItem.percent_from : "");
            data.append('grade_point', this.editItem.grade_point ? this.editItem.grade_point : "");
            let url = "";
            if (this.editedIndex != -1) {
                url = `/api/school/examinations/marks_grade/update/${this.editedIndex}`;
            } else {
                url = `/api/school/examinations/marks_grade/save`;
            }
            const res = await this.callApi("post", url, data, "multipart");
            this.log('DAATAA', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == 'success') {
                    this.resetForm();
                    this.$parent.showData();
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                }
                else {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                }
            }
        },
        resetForm(){
            this.exam_type_id = -1,
            this.editItem = {},
            this.$refs.exam_type.setSelected(-1)
        },
        edit(item,index){
            this.editItem = item;
            this.editedIndex = item.grade_id;
            this.$refs.exam_type.setSelected(item.exam_type_id);
            this.selectExamType(item.exam_type_id);
        },
        validGradeForm() {
            this.isFormValid = true;
            if (
                this.editItem.grade == null ||
                this.editItem.grade == ""
            ) {
                this.errorItem.grade = "Grade Name is required";
                this.isFormValid = false;
            } else {
                this.errorItem.grade = "";
            }

            if (
                this.editItem.percent_upto == null ||
                this.editItem.percent_upto == ""
            ) {
                this.errorItem.percent_upto = "Percent Upto is required";
                this.isFormValid = false;
            } else {
                this.errorItem.percent_upto = "";
            }

            if (
                this.editItem.percent_from == null ||
                this.editItem.percent_from == ""
            ) {
                this.errorItem.percent_from = "Percent From is required";
                this.isFormValid = false;
            } else {
                this.errorItem.percent_from = "";
            }
            return this.isFormValid;
        }
    },
};
</script>
