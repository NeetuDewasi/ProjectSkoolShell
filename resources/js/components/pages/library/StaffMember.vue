<template>
  <div>
    <div class="dashboard-content-one">
      <!-- Breadcubs Area Start -->
      <Breadcrumb
        pageTitle="Staff Memebr Details"
        :breadcrumbList="breadcrumbList"
      />
      <!-- End Breadcubs Area -->
      <!-- Staff Memebr Details Start Here -->
      <div class="row gutters-20">
        <div class="col-12">
          <div class="card height-auto">
            <div class="card-body">
              <div class="col-8-xxxl col-12">
                <div class="card height-auto">
                  <div class="card-body">
                    <div class="heading-layout1">
                      <div class="item-title">
                        <h3>Staff Memebr Details</h3>
                      </div>
                      <div class="dropdown">
                        <a
                          class="dropdown-toggle"
                          href="#"
                          role="button"
                          data-toggle="dropdown"
                          aria-expanded="false"
                          >...</a
                        >

                        <div class="dropdown-menu dropdown-menu-right">
                          <a class="dropdown-item" href="#"
                            ><i class="fas fa-times text-orange-red"></i
                            >Close</a
                          >
                          <a class="dropdown-item" href="#"
                            ><i class="fas fa-cogs text-dark-pastel-green"></i
                            >Edit</a
                          >
                          <a class="dropdown-item" href="#"
                            ><i class="fas fa-redo-alt text-orange-peel"></i
                            >Refresh</a
                          >
                        </div>
                      </div>
                    </div>
                    <form class="mg-b-20">
                      <div class="row gutters-8">
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                          <label>Select Income Head </label>
                          <Select2
                            :item="[
                              { value: 0, name: 'Select' },
                              { value: 1, name: '1' },
                              { value: 2, name: '2' },
                            ]"
                          />
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                          <label>From Date :</label>
                          <input
                            type="Date"
                            placeholder=""
                            class="form-control"
                          />
                        </div>

                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                          <label>To Date :</label>
                          <input
                            type="Date"
                            placeholder=""
                            class="form-control"
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
                      <div
                        id="DataTables_Table_0_wrapper"
                        class="dataTables_wrapper no-footer"
                      >
                        <table
                          class="
                            table
                            display
                            data-table
                            text-nowrap
                            dataTable
                            no-footer
                          "
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
                                  <input
                                    type="checkbox"
                                    class="form-check-input checkAll"
                                  />
                                  <label class="form-check-label"></label>
                                </div>
                              </th>
                              <th
                                class="sorting"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="Member Id: activate to sort column ascending"
                                style="width: 105.406px"
                              >
                                Member Id
                              </th>
                              <th
                                class="sorting"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="libraryCardNumber: activate to sort column ascending"
                                style="width: 144.828px"
                              >
                                libraryCardNumber
                              </th>
                              <th
                                class="sorting"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="Student Name: activate to sort column ascending"
                                style="width: 136.484px"
                              >
                                Student Name
                              </th>
                              <th
                                class="sorting"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="Email: activate to sort column ascending"
                                style="width: 136.484px"
                              >
                                Email
                              </th>
                              <th
                                class="sorting"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="DOB License: activate to sort column ascending"
                                style="width: 136.484px"
                              >
                                DOB
                              </th>
                              <th
                                class="sorting"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="Contact Number: activate to sort column ascending"
                                style="width: 156.562px"
                              >
                                Contact Number
                              </th>
                              <th
                                class="sorting_disabled"
                                rowspan="1"
                                colspan="1"
                                aria-label=""
                                style="width: 68.2344px"
                              ></th>
                            </tr>
                          </thead>
                          <tbody>
                            <StaffMembersList
                              :StaffReport="StudentReports"
                              v-for="(StudentReports, index) in StaffReports"
                              :key="index"
                            />
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- All Transport List Area End Here -->
            </div>
            <!-- All Subjects Area End Here -->
          </div>
        </div>
      </div>
    </div>
    <Footer />
  </div>
</template>
<script>
	// import { defineComponent } from '@vue/composition-api'
	import StaffMembersList from "./StaffMembersList.vue";
	export default {
		components: {
			StaffMembersList,
		},
		data() {
			return {
				breadcrumbList: [
					{
						to: { name: "admin.dashboard" },
						name: "Home",
					},
					{
						name: "StaffMember",
					},
				],

				StaffReports: [
					{
						MemberId: "R101",
						libraryCardNumber: "B101",
						StaffName: "Rohit Sharma",
						EmailId: "Rohit@gmail.com",
						DateOfBirth: "15-06-1986",
						ContectNumber: "8978979879",
					},
				],
			};
		},
		mounted() {
			this.$parent.loadOtherScript();
		},
	};
</script>
