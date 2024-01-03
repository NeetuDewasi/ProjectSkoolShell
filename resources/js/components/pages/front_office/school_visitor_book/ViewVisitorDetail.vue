<template>
  <div>
    <div class="dashboard-content-one">
      <!-- Breadcubs Area Start -->
      <Breadcrumb
        pageTitle="Visitor View Details"
        :breadcrumbList="breadcrumbList"
      >
        <template v-slot:button>
          <button
            type="submit"
            class="btn btn-primary btn-sm text-white"
            @click="$router.push({ name: 'school.front_office.visitors' })"
          >
            <i class="fa fa-arrow-left"></i> Back Visitor List
          </button>
        </template>
      </Breadcrumb>
      <!-- End Breadcubs Area -->
      <div class="row gutters-20">
        <!-- Fees Statement List Area Start Here -->
        <div class="col-12">
          <div class="card height-auto shadow">
            <div class="card-header">
              <h2>Visitor Information</h2>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-5 rounded border card  shadow text-center">
                  <img
                    :src="visitor.visitor_document && visitor.visitor_document != null  ? visitor.visitor_document : srcImageFile"
                    class="mt-3"
                    width="100%"
                  />
                </div>
                <div class="col-7 card border border-rounded">
                  <div class="item-content mt-3">
                    <div class="header-inline item-header pt-3 card-header">
                      <h3 class="text-dark-medium font-medium">
                        {{ visitor.visitor_name }}
                      </h3>
                      <div class="header-elements d-flex">
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
                            <td width="75"><strong>ID Card : </strong></td>
                            <td width="91">
                              {{
                                visitor.visitor_id_card != null
                                  ? visitor.visitor_id_card
                                  : ""
                              }}
                            </td>
                            <td width="108"><strong>Purpose</strong></td>
                            <td width="107">
                              {{
                                visitor.visitor_purpose_id != null
                                  ? visitor.visitor_purpose_id.name != null
                                    ? visitor.visitor_purpose_id.name
                                    : ""
                                  : ""
                              }}
                            </td>
                          </tr>
                          <tr>
                            <td><strong>Phone:</strong></td>
                            <td>
                              {{ visitor.visitor_phone }}
                            </td>
                            <td><strong>Date: </strong></td>
                            <td>
                              {{ visitor.visitor_date }}
                            </td>
                          </tr>
                          <tr>
                            <td><strong>In Time:</strong></td>
                            <td>
                              {{ visitor.visitor_in_time }}
                            </td>
                            <td><strong>Out Time:</strong></td>
                            <td>
                              {{ visitor.visitor_out_time }}
                            </td>
                          </tr>
                          <tr>
                            <td><strong>Email:</strong></td>
                            <td colspan="4">
                              {{
                                visitor.visitor_email != null
                                  ? visitor.visitor_email
                                  : ""
                              }}
                            </td>
                          </tr>
                          <tr>
                            <td class="font-weight-bold">Description</td>
                            <td
                              colspan="4"
                            >
                              {{ visitor.visitor_note }}
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
          name: "Visitor Detail",
        },
      ],
      visitor: {},
      visitor_id: -1,
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
    if (this.$route.params.visitor_id) {
      this.visitor_id = this.$route.params.visitor_id;
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
        `/api/school/front_office/visitors/visitor_view/${this.visitor_id}`,
        null
      );
      this.log("SHOW_DATA>>>>", res);
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.visitor = data.visitor;
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
