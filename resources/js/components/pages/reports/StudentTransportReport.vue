<template>
  <div>
    <div class="dashboard-content-one">
      <!-- Breadcubs Area Start -->
      <Breadcrumb pageTitle="Student Transport Report" :breadcrumbList="breadcrumbList" />
      <!-- End Breadcubs Area -->
      <div class="row gutters-20">
        <!-- All Transport List Area Start Here -->
        <div class="col-12">
          <div class="card height-auto">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>Student Transport Details</h3>
                </div>
              </div>
              <form class="mg-b-20">
                <div class="row gutters-8">
                  <div class="col-xl-2 col-lg-3 col-12 form-group">
                     <Select2
                                            :item="[{value: 0, name: 'Select'}, {value: 1, name: '1'}, {value: 2, name: '2'}]"
                                        />
                  </div>
                  <div class="col-xl-2 col-lg-3 col-12 form-group">
                    <Select2
                                            :item="[{value: 0, name: 'Select'}, {value: 1, name: '1'}, {value: 2, name: '2'}]"
                                        />
                  </div>
                  <div class="col-xl-3 col-lg-3 col-12 form-group">
                     <Select2
                                            :item="[{value: 0, name: 'Select'}, {value: 1, name: '1'}, {value: 2, name: '2'}]"
                                        />
                  </div>
                  <div class="col-xl-3 col-lg-3 col-12 form-group">
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
                          aria-label="Route Name"
                          style="width: 170.484px"
                        >
                          <div class="form-check">
                            <input type="checkbox" class="form-check-input checkAll" />
                            <label class="form-check-label">Vehicle Year Model</label>
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
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Route Title  : activate to sort column ascending"
                          style="width: 136.484px"
                        >Route Title</th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Vehicle No: activate to sort column ascending"
                          style="width: 105.406px"
                        >Vehicle No</th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Driver Name: activate to sort column ascending"
                          style="width: 144.828px"
                        >Driver Name</th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Driver Contect Number : activate to sort column ascending"
                          style="width: 136.484px"
                        >Driver Contect No</th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Fare: activate to sort column ascending"
                          style="width: 156.562px"
                        >Fare</th>
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
                      <FullStreportListItem
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
	import FullStreportListItem from "./FullStreportListItem.vue";
	export default {
		components: {
			FullStreportListItem,
		},
		data() {
			return {
				breadcrumbList: [
					{
						to: { name: "admin.dashboard" },
						name: "Home",
					},
					{
						name: "StudentTransportReport",
					},
				],
				streports: [
					{
						ClassSection: "B",
						AdmissionNumber: "Sardarpura to Bsani",
						StudentName: "Rajkumar Sharma",
						MobileNumber: "989564485",
						FatherName: "Narendra Sharma ",
						FatherPhone: "985454845",
						MotherName: "Sashikala Sharma ",
						MotherPhone: "9987141518",
						RouteTitle: "Sardarpura to Bsani",
						VehicleNo: "Rj19-CD_1233",
						DriverName: "Mohan Ram",
						DriverContectNumber: "998545489",
						Fare: "1000",
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
