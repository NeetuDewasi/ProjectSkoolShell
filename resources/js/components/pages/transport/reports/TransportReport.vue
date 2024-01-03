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
                  <h3>Vehicles Transport Lists</h3>
                </div>
              </div>
              <form class="mg-b-20">
                <div class="row gutters-20">
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                     <Select2
                                            :item="[{value: 0, name: 'Select'}, {value: 1, name: '1'}, {value: 2, name: '2'}]"
                                        />
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <Select2
                                            :item="[{value: 0, name: 'Select'}, {value: 1, name: '1'}, {value: 2, name: '2'}]"
                                        />
                  </div>

                  <div class="col-xl-3 col-lg-6 col-12 form-group">
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
                          aria-label="Driver License: activate to sort column ascending"
                          style="width: 136.484px"
                        >Driver License</th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="DataTables_Table_0"
                          rowspan="1"
                          colspan="1"
                          aria-label="Contact Number: activate to sort column ascending"
                          style="width: 156.562px"
                        >Contact Number</th>
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
	export default {

		data() {
			return {
				breadcrumbList: [
					{
						to: { name: "admin.dashboard" },
						name: "Home",
					},
					{
						name: "StuentTransportReport",
					},
				],
				streports: [
					{
						VehicleNo: "1221212",
						DriverName: "Mohan Ram",
						DriverLicense: "Rj121525",
						ContactNumber: "91141564646",
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
