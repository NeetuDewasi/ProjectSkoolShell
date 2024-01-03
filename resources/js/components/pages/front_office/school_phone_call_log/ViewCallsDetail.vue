<template>
  <div>
    <div class="dashboard-content-one">
      <!-- Breadcubs Area Start -->
      <Breadcrumb
        pageTitle="call View Details"
        :breadcrumbList="breadcrumbList"
      >
        <template v-slot:button>
          <button
            type="submit"
            class="btn btn-primary btn-sm text-white"
            @click="$router.push({ name: 'school.front_office.phone_log' })"
          >
            <i class="fa fa-arrow-left"></i> Back Phone Call Log List
          </button>
        </template>
      </Breadcrumb>
      <!-- End Breadcubs Area -->
      <div class="row gutters-20">
        <!-- Fees Statement List Area Start Here -->
        <div class="col-12">
          <div class="card height-auto shadow">
            <div class="card-header">
              <h2>Phone Call Log Information</h2>
            </div>
            <div class="card-body">
              <div class="row">
                <!-- <div class="col-12 card border border-rounded"> -->
                  <div class="col-12 item-content mt-3">
                    <div class="table table-responsive card-body">
                      <table class="table text-nowrap mt-5">
                        <tbody>
                          <tr>
                            <td><strong>Name: </strong></td>
                            <td>
                              {{ call.phone_name }}
                            </td>
                            <td><strong>Phone Number: </strong></td>
                            <td>
                              {{ call.phone_phone }}
                            </td>
                          </tr>
                          <tr>
                            <td><strong>Date</strong></td>
                            <td>
                              {{ call.phone_date }}
                            </td>
                            <td><strong>Next Date:</strong></td>
                            <td>
                              {{
                                call.phone_next_date != null
                                  ? call.phone_next_date
                                  : ""
                              }}
                            </td>
                          </tr>
                          <tr>
                            <td><strong>Call Duration: </strong></td>
                            <td>
                              {{ call.phone_call_duration_minute }}
                              {{ call.phone_call_duration_seconds }}
                            </td>
                            <td><strong>Call Type:</strong></td>
                            <td>
                              {{ call.phone_call_type }}
                            </td>
                          </tr>
                          <tr>
                            <td class="font-weight-bold">Description</td>
                            <td colspan="4">
                              {{ call.phone_description }}
                            </td>
                          </tr>
                          <tr>
                            <td class="font-weight-bold">Note</td>
                            <td colspan="4">
                              {{ call.phone_note }}
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                <!-- </div> -->
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
          name: "call Detail",
        },
      ],
      call: {},
      phone_id: -1,

    };
  },
  created() {
    toast = Toast.fire({
      icon: "warning",
      title: "Loading data..",
      timer: 0,
    });
  },
  mounted() {
    this.$parent.loadOtherScript();
    if (this.$route.params.phone_id) {
      this.phone_id = this.$route.params.phone_id;
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
        `/api/school/front_office/phone_call/phone_call_view/${this.phone_id}`,
        null
      );
      // console.log("SHOW_DATA>>>>", res);
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.call = data.call;
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
