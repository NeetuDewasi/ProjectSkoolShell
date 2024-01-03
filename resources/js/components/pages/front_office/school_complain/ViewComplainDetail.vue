<template>
  <div>
    <div class="dashboard-content-one">
      <!-- Breadcubs Area Start -->
      <Breadcrumb
        pageTitle="Complain View Details"
        :breadcrumbList="breadcrumbList"
      >
        <template v-slot:button>
          <button
            type="submit"
            class="btn btn-primary btn-sm text-white"
            @click="$router.push({ name: 'school.front_office.complain' })"
          >
            <i class="fa fa-arrow-left"></i> Back Complain List
          </button>
        </template>
      </Breadcrumb>
      <!-- End Breadcubs Area -->
      <div class="row gutters-20">
        <!-- Fees Statement List Area Start Here -->
        <div class="col-12">
          <div class="card height-auto shadow">
            <div class="card-header">
              <h2>Complain Information</h2>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-5 rounded border card shadow text-center">
                  <img
                    :src="
                      complain.complain_document &&
                      complain.complain_document != null
                        ? complain.complain_document
                        : srcImageFile
                    "
                    class="mt-3"
                    width="100%"
                  />
                </div>
                <div class="col-7 card border border-rounded">
                  <div class="item-content mt-3">
                    <div class="header-inline item-header pt-3 card-header">
                      <h3 class="text-dark-medium font-medium">
                        {{ complain.complain_person }}
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
                            <td><strong>Complain Type: </strong></td>
                            <td>
                              {{
                                complain.complain_type_id != null
                                  ? complain.complain_type_id.name != null
                                    ? complain.complain_type_id.name
                                    : ""
                                  : ""
                              }}
                            </td>
                            <td><strong>Source:</strong></td>
                            <td>
                              {{
                                complain.complain_source_id != null
                                  ? complain.complain_source_id.name != null
                                    ? complain.complain_source_id.name
                                    : ""
                                  : ""
                              }}
                            </td>
                          </tr>
                          <tr>
                            <td><strong>Date: </strong></td>
                            <td>
                              {{ complain.complain_date }}
                            </td>
                            <td>
                              <strong> Number:</strong>
                            </td>
                            <td>
                              {{ complain.complain_phone }}
                            </td>
                          </tr>
                          <tr>
                            <td><strong>Assigned: </strong></td>
                            <td>
                              {{
                                complain.complain_assigned != null
                                  ? complain.complain_assigned
                                  : ""
                              }}
                            </td>
                            <td><strong>Action Taken:</strong></td>
                            <td>
                              {{
                                complain.complain_action_by != null
                                ? complain.complain_action_by : ""
                              }}
                            </td>
                          </tr>
                          <tr>
                            <td><strong>Description:</strong></td>
                            <td colspan="4">
                              {{
                                complain.complain_description != null
                                ? complain.complain_description : ""
                              }}
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
          name: "complain Detail",
        },
      ],
      complain: {},
      complain_id: -1,
      srcImageFile: "/assets/img/no_img.jpg",
    };
  },
  created() {
    toast = Toast.fire({
      icon: "warning",
      title: "Loading data..",
      timer: 0,
    });
  },
  computed: {},
  mounted() {
    this.$parent.loadOtherScript();
    if (this.$route.params.complain_id) {
      this.complain_id = this.$route.params.complain_id;
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
        `/api/school/front_office/complain/complain_view/${this.complain_id}`,
        null
      );
      // console.log("SHOW_DATA>>>>", res);
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.complain = data.complain;
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
