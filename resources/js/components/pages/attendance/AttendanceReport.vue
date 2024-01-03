<template>
  <div>
    <div class="dashboard-content-one">
      <Breadcrumb pageTitle="Student Attendance Report" :breadcrumbList="breadcrumbList" />
      <div class="row gutters-20">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <form class="new-added-form">
                <div class="row">
                  <div class="col-6 form-group">
                    <label>Select Class</label>
                    <Select2
                      ref="class_list"
                      :item="class_list"
                      @change="selectClass"
                    />
                  </div>
                  <div class="col-6 form-group">
                    <label>Select Section</label>

                    <Select2
                      :item="[{value: 0, name: 'Select'}, {value: 1, name: '1'}, {value: 2, name: '2'}]"
                    />
                  </div>
                  <div class="col-xl-4 col-lg-3 col-3 form-group">
                    <label>Select Month</label>
                    <select class="select2">
                      <option value>Select</option>
                      <option value="1">January</option>
                      <option value="2">February</option>
                      <option value="3">March</option>
                      <option value="4">April</option>
                      <option value="5">May</option>
                      <option value="6">June</option>
                      <option value="7">July</option>
                      <option value="8">August</option>
                      <option value="9">September</option>
                      <option value="10">October</option>
                      <option value="11">Nevember</option>
                      <option value="12">December</option>
                    </select>
                  </div>

                  <div class="col-xl-4 col-lg-3 col-3 form-group">
                    <label>Select Year</label>
                    <select class="select2">
                      <option value>Select</option>
                      <option
                        :value="year - (index-1)"
                        v-for="index in 100"
                        :key="index"
                      >{{year - (index-1)}}</option>
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
                  <h3>Report</h3>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table display data-table text-nowrap">
                  <thead>
                    <tr>
                      <th>Student Name</th>
                      <th>Present</th>
                      <th>Absent</th>
                      <th>Late</th>
                      <th>Holiday</th>
                      <th>Half Day</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>John Levis</td>
                      <td>0</td>
                      <td>25</td>
                      <td>0</td>
                      <td>5</td>
                      <td>4</td>
                      <td>
                        <button type="submit" class="btn btn-success btn-hover-bluedark mx-2">
                          <i class="fas fa-pen text-white"></i>
                        </button>
                        <button type="submit" class="btn btn-danger btn-hover-bluedark mx-2">
                          <i class="fas fa-trash text-white"></i>
                        </button>
                        <button type="submit" class="btn btn-info btn-hover-bluedark mx-2">
                          <i class="fas fa-eye text-white"></i>
                        </button>
                      </td>
                    </tr>
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
export default {
  data() {
    return {
      breadcrumbList: [
        {
          to: { name: "admin.dashboard" },
          name: "Home",
        },
        {
          name: "Attendance Report",
        },
      ],
        year:'',
        month: '',
        selectedClass: -1,
        selectedSection: -1,
    };
  },

  mounted() {
    this.$parent.loadOtherScript();
    this.year = new Date().getFullYear().toString();

  },
  methods: {
      selectClass(val) {
          this.selectedClass = val;
      }
  }
};
</script>
