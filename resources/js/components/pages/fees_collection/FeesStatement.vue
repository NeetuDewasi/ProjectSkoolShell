<template>
  <div>
    <div class="dashboard-content-one">
      <!-- Breadcubs Area Start -->
      <Breadcrumb pageTitle="Fees statement" :breadcrumbList="breadcrumbList" />
      <!-- End Breadcubs Area -->
      <div class="row gutters-20">
        <!-- Fees Statement List Area Start Here -->
        <div class="col-12">
          <div class="card height-auto">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>Student Fees Statement</h3>
                </div>
              </div>
              <div class="card col-12 rounded-2 m-3">
                <div class="mt-5 row">
                  <div class="col-md-2">
                    <img
                      class="student-avatar"
                      :src="student.student_photo"
                    />
                  </div>
                  <div class="col-md-5 col-12">
                    <div class="row">
                      <div class="col-6">Name Of The Student</div>
                      <div class="col-6 text-dark font-bold">
                        {{ student.first_name }}
                        {{ student.last_name }}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">Father's Name</div>
                      <div class="col-6 text-dark font-bold">
                        {{
                        student.student_guardian != null
                          ? student.student_guardian.father.first_name != null
                            ? student.student_guardian.father.first_name
                            : ""
                          : ""
                      }}
                      {{
                        student.student_guardian != null
                          ? student.student_guardian.father.middle_name != null
                            ? student.student_guardian.father.middle_name
                            : ""
                          : ""
                      }}
                      {{
                        student.student_guardian != null
                          ? student.student_guardian.father.last_name != null
                            ? student.student_guardian.father.last_name
                            : ""
                          : ""
                      }}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">Mother's Name</div>
                      <div class="col-6 text-dark font-bold">
                        {{
                        student.student_guardian != null
                          ? student.student_guardian.mother.first_name != null
                            ? student.student_guardian.mother.first_name
                            : ""
                          : ""
                      }}
                      {{
                        student.student_guardian != null
                          ? student.student_guardian.mother.middle_name != null
                            ? student.student_guardian.mother.middle_name
                            : ""
                          : ""
                      }}
                      {{
                        student.student_guardian != null
                          ? student.student_guardian.mother.last_name != null
                            ? student.student_guardian.mother.last_name
                            : ""
                          : ""
                      }}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">Phone Number</div>
                      <div class="col-6 text-dark font-bold">
                        {{ student.mobile }}
                      </div>
                    </div>
                  </div>
                  <div class="col-md-5 col-12">
                    <div class="row">
                      <div class="col-6">Class Section Name</div>
                      <div class="col-6 text-dark font-bold">
                        {{
                        student.school_class != null
                          ? student.school_class.class_name != null
                            ? student.school_class.class_name
                            : ""
                          : ""
                      }}
                      {{
                        student.school_section != null
                          ? student.school_section.section_name != null
                            ? student.school_section.section_name
                            : ""
                          : ""
                      }}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">Admission Number</div>
                      <div class="col-6 text-dark font-bold">
                        {{ student.admission_number }}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">Student Category</div>
                      <div class="col-6 text-dark font-bold">
                       {{
                        student.student_category != null
                          ? student.student_category.category_name != null
                            ? student.student_category.category_name
                            : ""
                          : ""
                      }}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">Gender</div>
                      <div class="col-6 text-dark font-bold">
                        {{ student.gender }}
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
      student: {},
      class_list: [],
      section_list: [],
      selectedClass: -1,
      selectedClassName: "",
      student_admission_id: -1,
       tableHead: {
        items: {
          item1: { label: "Sr.No." },
          item2: { label: "Fees Group" },
          item3: { label: "Fees Code" },
          item4: { label: "Due Date" },
          item5: { label: "Status" },
          item6: { label: "Amount"},
        //   item7: { label: "Payment ID" },
          item7: { label: "Payment Mode" },
          item8: { label: "Date" },
          item9: { label: "Discount" },
          item10: { label: "Fine Amount" },
          item11: { label: "Paid" },
          item12: { label: "Balance" },
          item13: { label: "View"},
          item14: { label: "Action"},
        },
        actions: false,
      },
      studentFees:[],
      addFees:[],
      tableData: [],
      isLoaded: false,
      noData: false,
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
    if (this.$route.params.student_id) {
      this.student_admission_id = this.$route.params.student_id;
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
        `/api/school/fees_collection/collect_fees/student_fees/${this.student_admission_id}`,
        null
      );
      console.log('fees statement',res);
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.student = data.student_admission;
          this.studentFees = data.student_fees;
          this.addFees = data.add_fees;
          this.log(this.student);
          this.initTable();
        }
      }
      this.isLoaded = true;
      this.$refs.table.loadTable();
      toast.close();
    },
    initTable() {
      this.tableData = [];
      this.studentFees.forEach((element) => {
        this.tableData.push({
          item: element,
          data: {
            item1: element.fees_master_id,
            item2:
              element.fees_master_fees_group != null
                ? element.fees_master_fees_group.name
                : "",
            item3:
              element.fees_master_fees_type != null
                ?  element.fees_master_fees_type.code
                : "",
            item4: element.fees_master_due_date != null ?element.fees_master_due_date:'',
            item5:  {
              type: "label",
              options: {
                label: element.fees_status,
                style: "",
                class: this.getStatusClass(element.fees_status),
                icon: '',
              },
            },
            item6: element.fees_master_amount != null ? element.fees_master_amount : '',
            item7: element.fees_id !=null ? element.fees_id:'',
            item8: element.fees_payment_mode != null ? element.fees_payment_mode : "",
            item9: element.fees_date !=null ? Vue.filter('formatDate')(element.fees_date) : '',
            item10: element.fees_discount_amount,
            item11: element.fees_fine_amount,
            item12: element.fees_amount,
            item13: element.fees_balance,
            item14: !element.fees_payment_mode   ? '' : {
              type: "action",
              options: {
                label: "",
                style: "",
                class: "btn btn-primary",
                icon: '<i class="fas fa-eye"></i>',
                method: this.viewDetail
              },
            },
            item15: element.fees_balance == 0 ? '' : {
              type: "action",
              options: {
                label: "Add Fee",
                style: "",
                class: "btn btn-info",
                icon: '<i class="fas fa-plus"></i>',
                method: this.addFeesPay
              },
            },
          },
          action: {},
        });
      });
    },
    viewDetail(item, index) {
      this.$router.push(`/school/fees/fees_payment/${this.student_admission_id}/${item.fees_master_id}`);
    },
    addFeesPay(item, index) {
      this.$router.push(`/school/fees/add_fees/${this.student_admission_id}/${item.fees_master_id}`);
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
