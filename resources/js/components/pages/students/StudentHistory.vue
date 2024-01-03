        <template>
  <div>
    <div class="dashboard-content-one">
      <Breadcrumb pageTitle=" Student History" :breadcrumbList="breadcrumbList" />
      <div class="row gutters-20">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>Select Criteria</h3>
                </div>
              </div>

              <form class="new-added-form">
                <div class="row">
                  <div class="col-xl-3 col-lg-12 form-group">
                    <label>Select Class</label>
                    <select class="select2">
                      <option value>Select</option>
                      <option value="1">Nursery</option>
                      <option value="2">Play</option>
                      <option value="3">One</option>
                      <option value="4">Two</option>
                      <option value="5">Three</option>
                    </select>
                  </div>
                  <div class="col-xl-3 col-lg-12 form-group">
                    <label>Select Section</label>
                    <select class="select2">
                      <option value="0">Select</option>
                      <option value="1">A</option>
                      <option value="2">B</option>
                      <option value="3">C</option>
                      <option value="4">D</option>
                    </select>
                  </div>
                  <div class="col-xl-3 col-lg-12 form-group">
                    <label>Select Student</label>
                    <select class="select2">
                      <option value="0">Select</option>
                      <option value="1">Priya</option>
                      <option value="2">John</option>
                      <option value="3">Herry</option>
                    </select>
                  </div>
                  <div class="col-xl-3 col-lg-12 form-group">
                    <label>Admission Year</label>
                    <select class="select2">
                      <option value>Select</option>
                      <option
                        :value="year - (index-1)"
                        v-for="index in 100"
                        :key="index"
                      >{{year - (index-1)}}</option>
                    </select>
                  </div>

                </div>
                <div class="d-flex justify-content-end">
                  <button type="submit" class="btn btn-warning btn-lg">
                    <i class="fa fa-search"></i> Search
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>Student History</h3>
                </div>
              </div>
              <div class="table-responsive mt-5">
                <table class="table display data-table text-nowrap">
                  <thead>
                    <tr>
                      <th>Admission Number</th>
                      <th>Admission Date</th>
                      <th>Class(Start-End)</th>
                      <th>Session(Start-End)</th>
                      <th>Years</th>
                      <th>Student Name</th>
                      <th>Mobile Number</th>
                      <th>Father Name</th>
                      <th>Father Phone</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <HistoryTableRow
                      :student_history="student_history"
                      v-for="(student_history,index) in historyList"
                      :key="index"
                    />
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <Footer />
    </div>
  </div>
</template>



<script>
import HistoryTableRow from './HistoryTableRow.vue';
export default {
    components:{HistoryTableRow},
  data() {
    return {
      breadcrumbList: [
        {
          to: { name: "admin.dashboard" },
          name: "Home",
        },
        {
          name: " History ",
        },
      ],
      historyList:[
               {
                    admission_no:'2',
                    admission_date:'22/04/2022',
                    student_class:'3',
                    student_session:'2021-2022',
                    years:'1',
                    student_name:'Shaily',
                    mobile_no:'9874563009',
                    father_name:'Rahul Sharma',
                    father_phone:'9876890987',
               }
      ],
      year: 2022,
    };
  },
  mounted(){
      this.$parent.loadOtherScript()
      this.year = new Date().getFullYear().toString();
  },
};
</script>

