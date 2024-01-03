<template>
  <div>
    <div class="dashboard-content-one">
      <!-- Breadcubs Area Start -->
      <Breadcrumb pageTitle="Payroll Report" :breadcrumbList="breadcrumbList" />
      <!-- End Breadcubs Area -->
      <div class="row gutters-20">
        <!-- All Transport List Area Start Here -->
        <div class="col-12">
          <div class="card height-auto">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>Search Payroll Details</h3>
                </div>
              </div>
              <form class="mg-b-20">
                <div class="row gutters-8 new-added-form">
                  <div class="col-xl-3 col-lg-3 col-12 form-group">
                    <label>Select Role... *</label>
                     <Select2
                                            :item="[{value: 0, name: 'Select'}, {value: 1, name: '1'}, {value: 2, name: '2'}]"
                                        />
                  </div>
                  <div class="col-xl-3 col-lg-4 col-12 form-group">
                    <label>Date From *</label>
                    <input type="Date" placeholder class="form-control" />
                  </div>
                  <div class="col-xl-3 col-lg-4 col-12 form-group">
                    <label>Date To *</label>
                    <input type="Date" placeholder class="form-control" />
                  </div>
                  <div class="col-lg-2 col-12 form-group">
                    <label></label>
                    <br />
                    <button type="submit" class="btn btn-warning btn-lg">
                      <i class="fa fa-search"></i> Search
                    </button>
                  </div>
                </div>
              </form>
              <div class="table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                  <table
                    class="table display data-table text-nowrap dataTable no-footer"
                    id="DataTables_Table_0"
                    role="grid"
                  >
                    <thead>
                      <tr role="row">
                        <th
                          class="sorting_asc"
                          rowspan="1"
                          colspan="1"
                          aria-label="Guardian Name"
                          style="width: 170.484px"
                        >
                          <div class="form-check">
                            <input type="checkbox" class="form-check-input checkAll" />
                            <label class="form-check-label"></label>
                          </div>
                        </th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Name : activate to sort column ascending"
                          style="width: 136.484px"
                        >Name</th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Role : activate to sort column ascending"
                          style="width: 136.484px"
                        >Role</th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Designation   : activate to sort column ascending"
                          style="width: 136.484px"
                        >Designation</th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Month-Year  : activate to sort column ascending"
                          style="width: 136.484px"
                        >Month-Year</th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Payslip  : activate to sort column ascending"
                          style="width: 136.484px"
                        >Payslip</th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Erning  : activate to sort column ascending"
                          style="width: 136.484px"
                        >Erning</th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Deducatione   : activate to sort column ascending"
                          style="width: 136.484px"
                        >Deducatione</th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Gross Salary : activate to sort column ascending"
                          style="width: 136.484px"
                        >Gross Salary</th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Tax   : activate to sort column ascending"
                          style="width: 136.484px"
                        >Tax</th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Net Salary  : activate to sort column ascending"
                          style="width: 136.484px"
                        >Net Salary</th>
                        <th
                          class="sorting_disabled"
                          rowspan="1"
                          colspan="1"
                          aria-label
                          style="width: 68.2344px"
                        ></th>
                      </tr>
                    </thead>
                    <tbody>
                      <PayrollReportList
                        :streport="streportItem"
                        v-for="(streportItem, index) in streports"
                        :key="index"
                      />
                    </tbody>
                  </table>
                  <div
                    class="dataTables_paginate paging_simple_numbers"
                    id="DataTables_Table_0_paginate"
                  ></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- All Transport List Area End Here -->
      </div>
      <!-- All Subjects Area End Here -->
      <Footer />
    </div>
  </div>
</template>
<script>
	// import { defineComponent } from '@vue/composition-api'
	import PayrollReportList from "./PayrollReportList.vue";
	export default {
		components: {
			PayrollReportList,
		},
		data() {
			return {
				breadcrumbList: [
					{
						to: { name: "admin.dashboard" },
						name: "Home",
					},
					{
						name: "PayrollReport",
					},
				],
				streports: [
					{
						Name: "Ram Kishor Sherma",
						Role: "Admin",
						Designation: "Managment",
						MonthYear: "12/2022",
						Payslip: "555555 ",
						BasicSalary: "150000",
						Erning: "3200",
						GrossSalary: "163500",
						Tax: "1800",
						NetSalary: "165000",
					},
				],
			};
		},
		mounted() {
			this.$parent.loadOtherScript();
		},
	};
</script>




</style>
