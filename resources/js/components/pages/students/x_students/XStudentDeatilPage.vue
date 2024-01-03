<template>
  <div>
    <div class="row gutters-20">
      <div class="col-12">
        <div class="card">
          <div class="card-body bg-warning">
            <div class="item-title text-center bg-danger">
              <h3>
                <b>Detail Page</b>
              </h3>
            </div>
            <div class="col-12">
              <div class="row ml-5 p-5">
                <div class="col-4">
                  <img :src="detailList.student_student_photo" style="height: 250px; width:300px;" />
                </div>
                <div class="col-8 fw-bold text-dark">
                  <div class="col-12 mt-5 fw-bold">
                    <label>Admission Number :</label>
                    <b>{{ detailList.student_admission_number!= null ? detailList.student_admission_number : "" }}</b>
                  </div>
                  <div class="col-12">
                    <label>Class Name:</label>
                    <b
                      v-if="detailList.school_class && detailList.school_class.class_name!= null"
                    >{{ detailList.school_class.class_name }}</b>
                  </div>
                  <div class="col-12 b-4">
                    <label>Section Name:</label>
                    <b
                      v-if="detailList.school_section && detailList.school_section.section_name != null"
                    >{{ detailList.school_section.section_name }}</b>
                  </div>
                  <div class="col-12">
                    <label>Student First Name :</label>
                    <b>{{ detailList.student_first_name!= null ? detailList.student_first_name : "" }}</b>
                  </div>
                  <div class="col-12">
                    <label>Student Middle Name:</label>
                    <b>{{ detailList.student_middle_name!= null ? detailList.student_middle_name : "" }}</b>
                  </div>
                  <div class="col-12">
                    <label>Student Last Name: :</label>
                    <b>{{ detailList.student_last_name!= null ? detailList.student_last_name : "" }}</b>
                    <div class="col-12">
                      <label>Admission Date:</label>
                      <b>{{ detailList.student_admission_date!= null ? detailList.student_last_name : "" }}</b>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="row mt-4 text-dark" v-if="detailList && detailList != null">
                    <div class="col-6">
                      <label>Blood Group:</label>
                      <b>{{ detailList.student_blood_group!= null ? detailList.student_blood_group : "" }}</b>
                    </div>
                    <div class="col-6">
                      <label>Cast :</label>
                      <b>{{ detailList.student_cast ? detailList.student_cast : "" }}</b>
                    </div>
                    <div class="col-6">
                      <label>Student Category :</label>
                      <b
                        v-if="detailList.student_category && detailList.student_category.category_name != null"
                      >{{ detailList.student_category.category_name }}</b>
                    </div>
                    <div class="col-6">
                      <label>Date of Birth :</label>
                      <b>{{ detailList.student_date_of_birth!= null ? detailList.student_date_of_birth : "" }}</b>
                    </div>
                    <div class="col-6">
                      <label>Email Id :</label>
                      <b>{{ detailList.student_email!=null ? detailList.student_email : "" }}</b>
                    </div>

                    <div class="col-6">
                      <label>Gender: :</label>
                      <b>{{ detailList.student_gender!= null ? detailList.student_gender : "" }}</b>
                    </div>
                  </div>
                  <div class="row text-dark">
                    <div class="col-6">
                      <label>Student Height :</label>
                      <b>{{ detailList.student_height!= null ? detailList.student_height : "" }}</b>
                    </div>
                    <div class="col-6">
                      <label>Student Weight :</label>
                      <b>{{ detailList.student_weight!= null ? detailList.student_weight : "" }}</b>
                    </div>
                    <div class="col-6">
                      <label>Religion :</label>
                      <b>{{ detailList.student_religion!= null ? detailList.student_religion : "" }}</b>
                    </div>
                    <!-- <div class="col-6">
                      <label>Sibling Name :</label>
                      <b>{{ detailList.student_sibling }}</b>
                    </div>
                    <div class="col-6">
                      <label>Sibling Class :</label>
                      <b>{{ detailList.student_sibling_class }}</b>
                    </div>
                    <div class="col-6">
                      <label>Sibling Section :</label>
                      <b>{{ detailList.student_sibling_section }}</b>
                    </div>-->
                  </div>
                </div>
              </div>
            </div>
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

            isShow: false,
            student_admission_id: -1,
            detailList: [],
            school_class:{},
            school_section:{},
            class_id:-1,
            section_id:-1,
        };
    },
    created() {
        this.$parent.loadOtherScript();

    },
    mounted() {
        this.$parent.loadOtherScript();
        toast = Toast.fire({
            icon: "warning",
            title: "Loading Data..",
            timer: 0,
        });
        this.student_admission_id = this.$route.params.student_admission_id;
        this.log('Admission Id', this.student_admission_id);
        this.showData();
    },
    methods: {
        isShowClassSection() {
            if ($("#is-show-check-box").is(":checked")) {
                this.isShow = true;
            } else {
                this.isShow = false;
            }
        },

        async showData() {
            this.isLoaded = false;
            const res = await this.callApi(
                "get",
                `/api/school/students/student_details/${this.student_admission_id}`,
                null,
            );
            this.log(res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.detailList = data.detailList;
                } else if (data.status_code == 300) {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                    this.noData = true;
                }
            }
            this.isLoaded = true;
        },


    },
};
</script>
