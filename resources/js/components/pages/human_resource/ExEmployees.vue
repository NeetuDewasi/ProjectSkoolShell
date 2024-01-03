<template>
  <div>
    <div class="card-body">
      <div class="heading-layout1">
        <div class="item-title">
          <h3>Add Disabled Staff</h3>
        </div>
      </div>
      <form class="new-added-form">
        <div class="row">
          <div class="col-xl-6 col-lg-9 col-12 form-group">
            <label> Disabled Staff Name *</label>
            <input type="text" placeholder="" class="form-control" />
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
        </div>
      </form>

      <div class="col-8-xxxl col-12">
        <div class="card height-auto">
          <div class="card-body">
            <div class="heading-layout1">
              <div class="item-title">
                <h3>All Disabled Lists</h3>
              </div>
            </div>
            <form class="mg-b-20">
              <div class="row gutters-8">
                <div class="col-xl-6 col-lg-6 col-12 form-group">
               <Select2
                                            :item="[{value: 0, name: 'Select'}, {value: 1, name: '1'}, {value: 2, name: '2'}]"
                                        />
                </div>
                <div class="col-lg-2 col-12 form-group">
                  <button type="submit" class="fw-btn-fill btn-gradient-yellow">
                    SEARCH
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
                    <tr role="row"></tr>
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
                        aria-label="Staff Name: activate to sort column ascending"
                        style="width: 105.406px"
                      >
                        Staff Name
                      </th>
                      <th
                        class="sorting"
                        tabindex="0"
                        aria-controls="DataTables_Table_0"
                        rowspan="1"
                        colspan="1"
                        aria-label="UserRole: activate to sort column ascending"
                        style="width: 105.406px"
                      >
                        User Role
                      </th>
                      <th
                        class="sorting"
                        tabindex="0"
                        aria-controls="DataTables_Table_0"
                        rowspan="1"
                        colspan="1"
                        aria-label="Department: activate to sort column ascending"
                        style="width: 105.406px"
                      >
                        Department
                      </th>
                      <th
                        class="sorting"
                        tabindex="0"
                        aria-controls="DataTables_Table_0"
                        rowspan="1"
                        colspan="1"
                        aria-label="Designation: activate to sort column ascending"
                        style="width: 105.406px"
                      >
                        Designation
                      </th>
                      <th
                        class="sorting"
                        tabindex="0"
                        aria-controls="DataTables_Table_0"
                        rowspan="1"
                        colspan="1"
                        aria-label="MobileNumber: activate to sort column ascending"
                        style="width: 105.406px"
                      >
                        Mobile Number
                      </th>
                      <th
                        class="sorting"
                        tabindex="0"
                        aria-controls="DataTables_Table_0"
                        rowspan="1"
                        colspan="1"
                        aria-label="Action: activate to sort column ascending"
                        style="width: 105.406px"
                      >
                        Action
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
                    <ExEmployeesReport
                      :DisabledReport="DisabledReportList"
                      v-for="(DisabledReportList, index) in DisabledReports"
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
    <Footer />
  </div>
</template>
<script>
// import { defineComponent } from '@vue/composition-api'
import ExEmployeesReport from "./ExEmployeesReport";
export default {
  components: {
    ExEmployeesReport,
  },
  data() {
    return {
      breadcrumbList: [
        {
          to: { name: "admin.dashboard" },
          name: "Home",
        },
        {
          name: "DisabledStaff",
        },
      ],

      DisabledReports: [
        {
          DisabledStaffName: "Rakesh Kumar Sharma ",
          UserRole: "Admin ",
          Department: "IT COMPANY ",
          Designation: "Software Enginer ",
          MobileNumber: "9166683045 ",
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
