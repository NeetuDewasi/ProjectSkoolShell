<template>
  <div>
    <template>
      <div>
        <div class="dashboard-content-one">
          <Breadcrumb pageTitle=" Guardian Report" :breadcrumbList="breadcrumbList" />
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
                      <div class="col-xl-4 col-lg-12 form-group">
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
                      <div class="col-xl-4 col-lg-12 form-group">
                        <label>Select Section</label>
                        <select class="select2">
                          <option value="0">Select</option>
                          <option value="1">A</option>
                          <option value="2">B</option>
                          <option value="3">C</option>
                          <option value="4">D</option>
                        </select>
                      </div>
                      <div class="col-xl-4 col-lg-6 col-12 form-group">
                        <label>Search By Keyword *</label>
                        <input type="text" placeholder class="form-control" />
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
                      <h3>Guardian Report</h3>
                    </div>
                  </div>
                  <div class="table-responsive mt-5">
                    <table class="table display data-table text-nowrap">
                      <thead>
                        <tr>
                          <th>Sr.No.</th>
                          <th>Admission Number</th>
                          <th>Student Name</th>
                          <th>Class(Section)</th>
                          <th>Mobile Number</th>
                          <th>Father Name</th>
                          <th>Father Phone</th>
                          <th>Mother Name</th>
                          <th>Mother Phone</th>
                          <th>Guardian Name</th>
                          <th>Guardian Relation</th>
                          <th>Guardian Phone</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <StudentGuardianReportTable
                          :guardian_report="guardian_report"
                          :index="index"
                          v-for="(guardian_report,index) in guardianReportList"
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
  </div>
</template>

<script>
import StudentGuardianReportTable from './StudentGuardianReportTable.vue';

export default {
    components:{StudentGuardianReportTable},

  data() {
    return {
      breadcrumbList: [
        {
          to: { name: "admin.dashboard" },
          name: "Home",
        },
        {
          name: "Guardian Report ",
        },
      ],
           guardianReportList :[
               {
                   admission_no:'1',
                   student_name:'Shaily',
                   student_class:'3 C',
                   mobile_no:'8754360934',
                   father_name:'Rahul Sharma',
                   father_phone:'8754360934',
                   mother_name:'Deepika',
                   mother_phone:'98764534231',
                   guardian_name:'Pooja',
                   guardian_relation:'Sister',
                    guardian_phone:'9087699008',
               }
           ],
    };
  },mounted(){
      this.$parent.loadOtherScript()

  },
};
</script>
