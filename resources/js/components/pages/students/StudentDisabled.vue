<template>
  <div>
    <div class="dashboard-content-one">
      <Breadcrumb pageTitle="Disabled Student" :breadcrumbList="breadcrumbList" />
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
                <div class="col-12 form-group mg-t-8">
            <button
              type="submit"
               class="btn-lg btn btn-gradient-yellow btn-hover-bluedark text-white"
            >
              Save
            </button>
            <button
              type="reset"
              class="btn-lg btn bg-blue-dark btn-hover-yellow text-white"
            >
              Reset
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
                  <h3>Disabled Student List</h3>
                </div>
              </div>
              <div class="table-responsive mt-5">
                <table class="table display data-table text-nowrap">
                  <thead>
                    <tr>
                      <th>#</th>

                      <th>Admission Number</th>
                      <th>Student Name</th>
                      <th>Class(Section)</th>
                      <th>Father Name</th>
                      <th>Mother Name</th>
                      <th>Mobile Number</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
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
						name: "Disabled Students",
					},
				],
			};
		},
		mounted() {
			this.$parent.loadOtherScript();
		},
	};
</script>



