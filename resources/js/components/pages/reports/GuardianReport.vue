<template>
  <div>
    <div class="dashboard-content-one">
      <!-- Breadcubs Area Start -->
      <Breadcrumb pageTitle="Guardian Report" :breadcrumbList="breadcrumbList" />
      <!-- End Breadcubs Area -->
      <div class="row gutters-20">
        <!-- All Transport List Area Start Here -->
        <div class="col-12">
          <div class="card height-auto">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>Student Guardian Details</h3>
                </div>
              </div>
              <form class="mg-b-20">
                <div class="row gutters-8">
                  <div class="col-xl-5 col-lg-6 col-12 form-group">
                     <Select2
                            :item="[{value: 0, name: 'Select'}, {value: 1, name: '1'}, {value: 2, name: '2'}]"
                        />
                  </div>
                  <div class="col-xl-5 col-lg-6 col-12 form-group">
                    <Select2
                        :item="[{value: 0, name: 'Select'}, {value: 1, name: '1'}, {value: 2, name: '2'}]"
                    />
                  </div>
                  <div class="col-lg-2 col-12 form-group">
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
                          aria-label="Class Section : activate to sort column ascending"
                          style="width: 136.484px"
                        >Class Section</th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Admission No : activate to sort column ascending"
                          style="width: 136.484px"
                        >Admission No</th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Student Name  : activate to sort column ascending"
                          style="width: 136.484px"
                        >Student Name</th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Mobile Number  : activate to sort column ascending"
                          style="width: 136.484px"
                        >Mobile Number</th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Guardian Phone  : activate to sort column ascending"
                          style="width: 136.484px"
                        >Guardian Phone</th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Guardian Relation  : activate to sort column ascending"
                          style="width: 136.484px"
                        >Guardian Relation</th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Father Name   : activate to sort column ascending"
                          style="width: 136.484px"
                        >Father Name</th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Father Phone : activate to sort column ascending"
                          style="width: 136.484px"
                        >Father Phone</th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Mother Name   : activate to sort column ascending"
                          style="width: 136.484px"
                        >Mother Name</th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Mother Phone  : activate to sort column ascending"
                          style="width: 136.484px"
                        >Mother Phone</th>
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
                      <FullGuardianReportListItem
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
	import FullGuardianReportListItem from "./FullGuardianReportListItem.vue";
	export default {
		components: {
			FullGuardianReportListItem,
		},
		data() {
			return {
				breadcrumbList: [
					{
						to: { name: "admin.dashboard" },
						name: "Home",
					},
					{
						name: "GuardianReport",
					},
				],
				streports: [
					{
						ClassSection: "B",
						AdmissionNumber: "2321323213",
						StudentName: "Rajkumar Sharma",
						MobileNumber: "898897978 ",
						GuardianPhone: "989564485",
						GuardianRelation: "Father",
						FatherName: "Narendra Sharma",
						FatherPhone: "985454845",
						MotherName: "Sashikala Sharma",
						MotherPhone: "9987141518",
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
