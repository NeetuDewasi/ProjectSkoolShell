<template>
  <div>
    <div class="dashboard-content-one">
      <!-- Breadcubs Area Start -->
      <Breadcrumb
        pageTitle="Postal View Details"
        :breadcrumbList="breadcrumbList"
      >
        <template v-slot:button>
          <button
            type="submit"
            class="btn btn-primary btn-sm text-white"
            @click="$router.push({ name: 'school.front_office.postal' })"
          >
            <i class="fa fa-arrow-left"></i> Back Postal List
          </button>
        </template>
      </Breadcrumb>
      <!-- End Breadcubs Area -->
      <div class="row gutters-20">
        <!-- Fees Statement List Area Start Here -->
        <div class="col-12">
          <div class="card height-auto shadow">
            <div class="card-header">
              <h2>Postal Information</h2>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-5 rounded border card  shadow text-center">
                  <img
                    :src="postal.postal_document && postal.postal_document != null  ? postal.postal_document : srcImageFile"
                    class="mt-3"
                    width="100%"
                  />
                </div>
                <div class="col-7 card border border-rounded">
                  <div class="item-content mt-3">
                    <div class="header-inline item-header pt-3 card-header">
                      <h3 class="text-dark-medium font-medium">

                      </h3>
                      <div class="header-elements d-flex justify-content-end">
                        <div class="mr-3">
                          <a href="#"><i class="fas fa-print"></i></a>
                        </div>
                        <div>
                          <a href="#"><i class="fas fa-download"></i></a>
                        </div>
                      </div>
                    </div>
                    <div class="table table-responsive card-body">
                      <table class="table text-nowrap mt-5">
                        <tbody>
                          <tr>
                            <td><strong>To Title: </strong></td>
                            <td>
                              {{ postal.postal_to_title }}
                            </td>
                            <td><strong>From Title:</strong></td>
                            <td>
                              {{ postal.postal_from_title}}
                            </td>
                          </tr>
                          <tr>
                            <td><strong>Date: </strong></td>
                            <td>
                              {{ postal.postal_date }}
                            </td>
                            <td><strong>Reference Number:</strong></td>
                            <td>
                              {{ postal.postal_ref_no }}
                            </td>
                          </tr>
                          <tr>
                            <td><strong>Postal Type:</strong></td>
                            <td colspan="4">
                              {{ postal.postal_type }}
                            </td>
                           </tr>
                           <tr>
                            <td><strong>Address:</strong></td>
                            <td colspan="4">
                              {{
                                postal.postal_address != null
                                  ? postal.postal_address
                                  : ""
                              }}
                            </td>
                          </tr>
                          <tr>
                            <td class="font-weight-bold">Note</td>
                            <td
                              colspan="4"
                            >
                              {{ postal.postal_note }}
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
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
var toast;
export default {
  data() {
    return {
      breadcrumbList: [
        {
          to: { name: "school.dashboard" },
          name: "Home",
        },
        {
          name: "Postal Detail",
        },
      ],
      postal: {},
      postal_id: -1,
      srcImageFile: '/assets/img/no_img.jpg',
    };
  },
  created() {
    toast = Toast.fire({
      icon: "warning",
      title: "Loading data..",
      timer: 0,
    });
  },
  computed: {
  },
  mounted() {
    this.$parent.loadOtherScript();
    if (this.$route.params.postal_id) {
      this.postal_id = this.$route.params.postal_id;
      this.showData();
    } else {
      this.$router.go(-1);
    }
  },
  methods: {
    async showData() {
      this.isLoaded = false;
      const res = await this.callApi(
        "get",
        `/api/school/front_office/postal/postal_view/${this.postal_id}`,
        null
      );
      // console.log("SHOW_DATA>>>>", res);
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.postal = data.postal;
        }
      }
      this.isLoaded = true;
      toast.close();
    },
  },
};
</script>

<style scoped>
</style>
