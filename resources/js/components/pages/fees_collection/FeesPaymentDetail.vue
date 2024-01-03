<template>
  <div>
    <div class="dashboard-content-one">
      <!-- Breadcubs Area Start -->
      <Breadcrumb pageTitle="Fees Payment" :breadcrumbList="breadcrumbList" />
      <!-- End Breadcubs Area -->
      <div class="row gutters-20">
        <!-- Fees Statement List Area Start Here -->
        <div class="col-12" v-if="studentFees">
          <div class="card height-auto">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>Student Fees Payment</h3>
                </div>
              </div>
              <div class="card col-12 rounded-2 m-3">
                <div class="mt-5 row">
                    <span v-if="studentFees && studentFees != null">
                  <div class="col-md-2">
                    <img
                      class="student-avatar"
                      :src="studentFees.fees_admission_id.student_student_photo"
                    />
                  </div>
                  <div class="col-md-5 col-12">
                    <div class="row">
                      <div class="col-6">Name Of The Student</div>
                      <div class="col-6 text-dark font-bold">
                        {{ studentFees.fees_admission_id.student_first_name }}
                        {{ studentFees.fees_admission_id.student_last_name }}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">Father's Name</div>
                      <div class="col-6 text-dark font-bold">
                        {{
                        studentFees.fees_admission_id != null ? studentFees.fees_admission_id.student_guardian != null
                          ? studentFees.fees_admission_id.student_guardian.father.first_name != null
                            ? studentFees.fees_admission_id.student_guardian.father.first_name
                            : ""
                          : ""
                          : ""
                      }}
                      {{
                        studentFees.fees_admission_id != null ? studentFees.fees_admission_id.student_guardian != null
                          ? studentFees.fees_admission_id.student_guardian.father.middle_name != null
                            ? studentFees.fees_admission_id.student_guardian.father.middle_name
                            : ""
                          : ""
                          :""
                      }}
                      {{
                        studentFees.fees_admission_id != null ? studentFees.fees_admission_id.student_guardian != null
                          ? studentFees.fees_admission_id.student_guardian.father.last_name != null
                            ? studentFees.fees_admission_id.student_guardian.father.last_name
                            : ""
                          : ""
                          :""
                      }}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">Mother's Name</div>
                      <div class="col-6 text-dark font-bold">
                        {{
                        studentFees.fees_admission_id != null ? studentFees.fees_admission_id.student_guardian != null
                          ? studentFees.fees_admission_id.student_guardian.mother.first_name != null
                            ? studentFees.fees_admission_id.student_guardian.mother.first_name
                            : ""
                          : ""
                           :""
                      }}
                      {{
                        studentFees.fees_admission_id != null ? studentFees.fees_admission_id.student_guardian != null
                          ? studentFees.fees_admission_id.student_guardian.mother.middle_name != null
                            ? studentFees.fees_admission_id.student_guardian.mother.middle_name
                            : ""
                          : ""
                          :""
                      }}
                      {{
                        studentFees.fees_admission_id != null ? studentFees.fees_admission_id.student_guardian != null
                          ? studentFees.fees_admission_id.student_guardian.mother.last_name != null
                            ? studentFees.fees_admission_id.student_guardian.mother.last_name
                            : ""
                          : ""
                          :""
                      }}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">Phone Number</div>
                      <div class="col-6 text-dark font-bold">
                        {{ studentFees.fees_admission_id.student_mobile }}
                      </div>
                    </div>
                  </div>
                  <div class="col-md-5 col-12">
                    <div class="row">
                      <div class="col-6">Class Section Name</div>
                      <div class="col-6 text-dark font-bold">
                        {{
                        studentFees.fees_admission_id.school_class != null
                          ? studentFees.fees_admission_id.school_class.class_name != null
                            ? studentFees.fees_admission_id.school_class.class_name
                            : ""
                          : ""
                      }}
                      {{
                        studentFees.fees_admission_id.school_section != null
                          ? studentFees.fees_admission_id.school_section.section_name != null
                            ? studentFees.fees_admission_id.school_section.section_name
                            : ""
                          : ""
                      }}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">Admission Number</div>
                      <div class="col-6 text-dark font-bold">
                        {{ studentFees.fees_admission_id.student_admission_number }}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">Student Category</div>
                      <div class="col-6 text-dark font-bold">
                       {{
                        studentFees.fees_admission_id.student_category != null
                          ? studentFees.fees_admission_id.student_category.category_name != null
                            ? studentFees.fees_admission_id.student_category.category_name
                            : ""
                          : ""
                      }}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">Gender</div>
                      <div class="col-6 text-dark font-bold">
                        {{ studentFees.fees_admission_id.student_gender }}
                      </div>
                    </div>
                  </div>
                </span>
                </div>
                <div class="row mt-5">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                        <div class="row">
                            <div class="col-xl-3 col-md-3 col-3">Fees Group </div>
                            <div class="col-3 font-bold text-dark">
                                {{
                                    studentFees.fees_master_fees_group != null
                                    ? studentFees.fees_master_fees_group.name != null
                                        ? studentFees.fees_master_fees_group.name
                                        : ""
                                    : ""
                                }}
                            </div>
                            <div class="col-3">Fees Code </div>
                            <div class="col-3 font-bold text-dark">
                                {{
                                   studentFees.fees_master_fees_type != null
                                    ? studentFees.fees_master_fees_type.code != null
                                        ? studentFees.fees_master_fees_type.code
                                        : ""
                                    : ""
                                }}
                            </div>
                            <div class="col-3">Due Date</div>
                            <div class="col-3 font-bold text-dark">
                                {{
                                    studentFees.fees_master_due_date != null
                                        ? studentFees.fees_master_due_date
                                        : ""
                                }}
                            </div>
                            <div class="col-3">Amount</div>
                            <div class="col-3 font-bold text-dark">
                                {{
                                    studentFees.fees_master_amount != null
                                        ? studentFees.fees_master_amount
                                        : ""
                                }}
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="table table-responsive" v-show="!noData">
                <Table
                ref="table"
                  :tableData="tableData"
                  :tableHead="tableHead"
                />
              </div>
              <NoData v-show="noData" />
            </div>
          </div>
        </div>
        <!-- Fees Statement List Area End Here -->
      </div>
      <Footer />
    </div>
  </div>
</template>

<script>
var toast;
export default {
  data() {
    return {
      breadcrumbList: [
        {
          to: { name: "admin.dashboard" },
          name: "Home",
        },
        {
          name: "Fees Statement",
        },
      ],
      student: [],
      class_list: [],
      section_list: [],
      selectedClass: -1,
      selectedClassName: "",
      fee_master_id: -1,
       tableHead: {
        items: {
          item1: { label: "Sr.No." },
          item2: { label: "Date" },
          item3: { label: "Discount" },
          item4: { label: "Fine Amount" },
          item5: { label: "Amount" },
          item6: { label: "Action"},
          item7: { label: "Receipt"},
        },
        actions: false,
      },
      studentFees:{

      },
      addFees:[],
      tableData: [],
      isLoaded: false,
      noData: false,
      student_id : -1,
      fees:[],
    };
  },
  created() {
    toast = Toast.fire({
      icon: "warning",
      title: "Loading data..",
      timer: 0,
    });
  },
  mounted() {
    this.$parent.loadOtherScript();
    if (this.$route.params.fee_master_id && this.$route.params.admission_id) {
      this.fee_master_id = this.$route.params.fee_master_id;
      this.student_id = this.$route.params.admission_id;
      this.showData();
    } else {
      this.$router.go(-1);
    }
  },
  methods: {
    getStatusClass(status) {
        if(status == 'unpaid') {
            return 'badge badge-danger';
        } else if(status == 'partial') {
            return 'badge badge-warning';
        } else if(status == 'paid') {
            return 'badge badge-success';
        } else if(status == 'advance') {
            return 'badge badge-primary';
        }
    },
    async showData() {
      this.isLoaded = false;
      const res = await this.callApi(
        "get",
        `/api/school/fees_collection/collect_fees/fees_payment/${this.student_id}/${this.fee_master_id}`,
        null
      );
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.studentFees = data.student_fees;
          this.fees = data.fees;
          this.log(this.studentFees);
          this.initTable();
        }
      }
      this.isLoaded = true;
      this.$refs.table.loadTable();
      toast.close();
    },
    initTable() {
      this.tableData = [];
      this.fees.forEach((element) => {
        this.tableData.push({
          item: element,
          data: {
            item1: element.fees_id,
            item2: element.fees_date !=null ? Vue.filter('formatDate')(element.fees_date) : '',
            item3: element.fees_discount_amount,
            item4: element.fees_fine_amount,
            item5: element.fees_amount,
            item6: {
                type: "action",
                options: {
                label: "Edit Fees",
                style: "",
                class: "btn btn-info",
                icon: '<i class="fas fa-plus"></i>',
                method: this.feesPayment
              },
            },
            item7:{
                type: "action",
                options: {
                label: "Print Receipt",
                style: "",
                class: "btn btn-success",
                icon: '<i class="fas fa-print"></i>',
                method: this.receipt
              },
            },
          },
          action: {},
        });
      });
    },
    feesPayment(item) {
      this.$router.push(`/school/fees/edit_fees/${item.fees_id}/${this.fee_master_id}`);
    },
    receipt(item) {
      this.log("********Payment Receipt");
    },
  },
};
</script>

<style scoped>
.student-avatar {
  border-radius: 10%;
  border: black 2px solid;
  width: 100%;
  height: 100px;
}
</style>
