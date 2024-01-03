<template>
  <div>
    <div class="dashboard-content-one">
      <Breadcrumb pageTitle="Student Promotion" :breadcrumbList="breadcrumbList" />
      <div class="row gutters-20">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>Search Student Promotion</h3>
                </div>
              </div>

              <form class="new-added-form">
                <div class="row">
                  <div class="col-6 form-group">
                    <label>Current Session</label>
                   <Select2
                          :item="[{value: 0, name: 'Select'}, {value: 1, name: '1'}, {value: 2, name: '2'}]"
                        />
                  </div>
                  <div class="col-6 form-group">
                    <label>Promote Session</label>
                   <Select2
                          :item="[{value: 0, name: 'Select'}, {value: 1, name: '1'}, {value: 2, name: '2'}]"
                        />
                  </div>

                  <div class="col-6 form-group">
                    <label>Promotion from Class</label>
                   <Select2
                          :item="[{value: 0, name: 'Select'}, {value: 1, name: '1'}, {value: 2, name: '2'}]"
                        />
                  </div>
                  <div class="col-6 form-group">
                    <label>Promotion To Class</label>
                   <Select2
                          :item="[{value: 0, name: 'Select'}, {value: 1, name: '1'}, {value: 2, name: '2'}]"
                        />
                  </div>
                </div>

                <div class="d-flex justify-content-end">
                  <button type="submit" class="btn btn-warning btn-lg">
                    <i class="fa fa-search"></i> Search
                  </button>
                </div>

                <div class="col-lg-12 col-12 form-group mg-t-8">
                  <button
                    type="submit"
                    class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark"
                  >Add</button>
                  <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Reset</button>
                </div>
              </form>
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
          name: "Student Promotion",
        },
      ],
      isStudentPhoto: false,
    };
  },

  mounted() {
    this.$parent.loadOtherScript();
  },
};
</script>

