<template>
  <div>
    <div class="dashboard-content-one">
      <!-- Breadcubs Area Start -->
      <Breadcrumb pageTitle="Add Book" :breadcrumbList="breadcrumbList" />
      <!-- End Breadcubs Area -->
      <!-- Add Book Start Here -->
      <div class="row gutters-20">
        <div class="col-12">
          <div class="card height-auto">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>Add Book</h3>
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
                      ><i class="fas fa-times text-orange-red"></i>Close</a
                    >
                    <a class="dropdown-item" href="#"
                      ><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a
                    >
                    <a class="dropdown-item" href="#"
                      ><i class="fas fa-redo-alt text-orange-peel"></i
                      >Refresh</a
                    >
                  </div>
                </div>
              </div>
              <form class="new-added-form">
                <div class="row">
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Book Title *</label>
                    <input type="text" placeholder="" class="form-control" />
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Book Number *</label>
                    <input type="text" placeholder="" class="form-control" />
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>ISBN Number *</label>
                    <input type="text" placeholder="" class="form-control" />
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Publisher *</label>
                    <input type="text" placeholder="" class="form-control" />
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Author *</label>
                    <input type="text" placeholder="" class="form-control" />
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Subject *</label>
                    <input type="text" placeholder="" class="form-control" />
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Rock Number *</label>
                    <input type="text" placeholder="" class="form-control" />
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Quantity *</label>
                    <input type="text" placeholder="" class="form-control" />
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Quantity *</label>
                    <input type="text" placeholder="" class="form-control" />
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Book Price *</label>
                    <input type="text" placeholder="" class="form-control" />
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Post Date *</label>
                    <input type="Date" placeholder="" class="form-control" />
                  </div>
                  <div class="col-lg-6 col-12 form-group">
                    <label>Description</label>
                    <textarea
                      class="textarea form-control"
                      name="message"
                      id="form-message"
                      cols="10"
                      rows="6"
                    ></textarea>
                  </div>
                  <div class="col-12 form-group mg-t-8">
                    <button
                      type="submit"
                      class="
                        btn-lg btn btn-gradient-yellow btn-hover-bluedark
                        text-white
                      "
                    >
                      Save
                    </button>
                    <button
                      type="reset"
                      class="
                        btn-lg btn
                        bg-blue-dark
                        btn-hover-yellow
                        text-white
                      "
                    >
                      Reset
                    </button>
                  </div>
                </div>
              </form>
              <div class="col-8-xxxl col-12">
                <div class="card height-auto">
                  <div class="card-body">
                    <div class="heading-layout1">
                      <div class="item-title">
                        <h3>Book Lists</h3>
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
                        <div class="col-xl-4 col-lg-6 col-12 form-group">
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
                                Book Title
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
                                Book Number
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
                                ISBN Number
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
                                Publisher
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
                                Rack Number
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
                                Quantity
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
                                Price
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
                                PostDate
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
                            <BookListReport
                              :BookReport="BookReports"
                              v-for="(BookReports, index) in BookReports"
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
          </div>
        </div>
      </div>
    </div>
    <Footer />
  </div>
</template>
<script>
	// import { defineComponent } from '@vue/composition-api'
	import BookListReport from "./BookListReport";
	export default {
		components: {
			BookListReport,
		},
		data() {
			return {
				breadcrumbList: [
					{
						to: { name: "admin.dashboard" },
						name: "Home",
					},
					{
						name: "BookList",
					},
				],

				BookReports: [
					{
						BookTile: "JESA DESH WESA VESH ",
						BookNumber: "B101",
						ISBNNumber: "214564564",
						Publisher: "Rohit Sharma",
						RackNumber: "1986",
						Quantity: "3",
						Price: "2500",
						PostDate: "20-04-2022",
					},
				],
			};
		},
		mounted() {
			this.$parent.loadOtherScript();
		},
	};
</script>


<style scoped>
</style>
