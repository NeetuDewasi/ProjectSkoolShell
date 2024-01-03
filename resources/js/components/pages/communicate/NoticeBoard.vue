<template>
  <div>
    <div class="dashboard-content-one">
      <div class="d-flex justify-content-between">
        <Breadcrumb pageTitle="Notice Board" :breadcrumbList="breadcrumbList" />
        <button type="button" class="text-white new-message btn btn-secondary">+ Post New Message</button>
      </div>
      <div class="row gutters-20">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <form class="new-added-form">
                <div class="row">
                  <div class="col-lg-9 col-12 form-group">
                    <div class="heading-layout1">
                      <div class="item-title">
                        <h3>Generate Notice Board</h3>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-12 col-12 text-primary mt-5 p-5">No Record Found</div>
                </div>
                <div class="col-xl-12 col-lg-12 form-group mg-t-8">
                  <button
                    type="submit"
                    class="btn btn-lg btn-gradient-yellow btn-hover-bluedark mx-3 text-white"
                  >Generate</button>
                  <button
                    type="reset"
                    class="btn btn-lg btn-gradient-yellow btn-hover-bluedark mx-3 text-white"
                  >Reset</button>
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
          name: "Notice Board",
        },
      ],
    };
  }, mounted() {
    this.$parent.loadOtherScript();
  },
};
</script>
<style scoped>

.text-primary{
    background-color: #b6ced5!important;
    border: 1px ;

   border-color:#b6ced5!important;
}
button.new-message{
    font-size: 14px !important;
    padding: 5px 10px  !important;
    display: inline-block;
    align-self: center;
}
</style>



