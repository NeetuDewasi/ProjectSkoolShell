<template>
  <div>
    <div class="dashboard-content-one">
      <!-- Breadcubs Area Start -->
      <Breadcrumb pageTitle="Student Hostel Report" :breadcrumbList="breadcrumbList" />
      <!-- End Breadcubs Area -->
      <div class="row gutters-20">
        <!-- All Transport List Area Start Here -->
        <div class="col-12">
          <div class="card height-auto">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>Student Hostel Details</h3>
                </div>
              </div>
              <form class="mg-b-20">
                <div class="row gutters-8">
                  <div class="col-xl-4 col-lg-6col-12 form-group">
                     <Select2
                                            :item="[{value: 0, name: 'Select'}, {value: 1, name: '1'}, {value: 2, name: '2'}]"
                                        />
                  </div>
                  <div class="col-xl-4 col-lg-6 col-12 form-group">
                    <select class="select2">
                      <option value="Search by Section  ...">Search by Section ...*</option>
                      <option value="A">A</option>
                      <option value="B">B</option>
                      <option value="C">C</option>
                      <option value="D">D</option>
                    </select>
                  </div>
                  <div class="col-xl-4 col-lg-6 col-12 form-group">
                    <select class="select2">
                      <option value="Search by Route Title...">Search by Hostel Name..*</option>
                      <option value="ST">Veer Teja Hostel</option>
                      <option value="SC">Karni Hostel</option>
                      <option value="General">Shree Ram Hostel</option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-2 col-12 form-group">
                  <br />
                  <button type="submit" class="btn btn-warning btn-lg">
                    <i class="fa fa-search"></i> Search
                  </button>
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
                          aria-label="Route Name"
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
                          aria-label="Admission Number : activate to sort column ascending"
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
                        >Mobile No</th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Mobile Number  : activate to sort column ascending"
                          style="width: 136.484px"
                        >Guardian No</th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Date Of Birth   : activate to sort column ascending"
                          style="width: 136.484px"
                        >Hostel name</th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Gender   : activate to sort column ascending"
                          style="width: 136.484px"
                        >Room Numebr /Name</th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Category   : activate to sort column ascending"
                          style="width: 136.484px"
                        >Room Type</th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="National Identification Number : activate to sort column ascending"
                          style="width: 136.484px"
                        >Cost Per Bed ($)</th>
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
                      <StudentHostelReportList
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
	import StudentHostelReportList from "./StudentHostelReportList.vue";
	export default {
		components: {
			StudentHostelReportList,
		},
		data() {
			return {
				breadcrumbList: [
					{
						to: { name: "admin.dashboard" },
						name: "Home",
					},
					{
						name: "StudentHostelFullReport",
					},
				],
				streports: [
					{
						ClassSection: "B",
						AdmissionNumber: "A10112",
						StudentName: "Rajkumar Sharma",
						MobileNumber: "9895578654",
						GuardianNo: "4789748994 ",
						HostelName: "Shree Veer Teja Hostel ",
						RoomNumebrName: "B1",
						RoomType: "Normal",
						Costperbed: "General",
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
