<template>
  <div>
    <div class="dashboard-content-one">
      <!-- Breadcubs Area Start -->
      <Breadcrumb
        pageTitle="Admission Enquiry View"
        :breadcrumbList="breadcrumbList"
      >
        <template v-slot:button>
          <button
            type="submit"
            class="btn btn-primary btn-sm text-white"
            @click="$router.push({ name: 'school.front_office.admission' })"
          >
            <i class="fa fa-arrow-left"></i> Back Admission Enquiry List
          </button>
        </template>
      </Breadcrumb>
      <!-- End Breadcubs Area -->
      <div class="row gutters-20">
        <!-- Fees Statement List Area Start Here -->
        <div class="col-12">
          <div class="card height-auto shadow">
            <div class="card-header">
              <h2>Admission Enquiry Information</h2>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 card border border-rounded">
                  <div class="item-content mt-3">
                    <div class="header item-header pt-3 card-header d-flex justify-content-between">
                      <div class="">
                        <h3 class="text-dark-medium font-medium">
                          {{
                            enquiry.enquiry_student_name != null
                                ? enquiry.enquiry_student_name
                                : ""
                          }}
                        </h3>
                        <h5 class="text-dark-medium font-medium">
                          {{
                            enquiry.enquiry_student_class != null
                            ? enquiry.enquiry_student_class.name != null
                                ? enquiry.enquiry_student_class.name
                                : ""
                            : ""
                          }}
                        </h5>
                      </div>
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
                            <td><strong>Parent's Name: </strong></td>
                            <td>
                              {{ enquiry.admission_enquiry.admission_enquiry_name }}
                            </td>
                            <td><strong>Phone Number:</strong></td>
                            <td>
                              {{ enquiry.admission_enquiry.admission_enquiry_phone }}
                            </td>
                          </tr>
                          <tr>
                            <td><strong>Email:</strong></td>
                            <td>
                              {{ enquiry.admission_enquiry.admission_enquiry_email }}
                            </td>
                            <td ><strong>Address: </strong></td>
                            <td>
                              {{
                                enquiry.admission_enquiry
                                  .admission_enquiry_address_line1
                              }}
                              {{
                                enquiry.admission_enquiry
                                  .admission_enquiry_address_line2
                              }}
                            </td>
                          </tr>
                          <tr>
                            <td><strong>Area:</strong></td>
                            <td >
                              {{ enquiry.admission_enquiry.admission_enquiry_area }}
                            </td>
                            <td><strong>Location:</strong> </td>
                            <td>
                              {{
                                enquiry.admission_enquiry
                                  .admission_enquiry_location != null
                                  ? enquiry.admission_enquiry
                                      .admission_enquiry_location
                                  : ""
                              }}
                            </td>
                          </tr>
                          <tr>
                            <td><strong>Land Mark:</strong></td>
                            <td >
                              {{
                                enquiry.admission_enquiry
                                  .admission_enquiry_landmark != null
                                  ? enquiry.admission_enquiry
                                      .admission_enquiry_landmark
                                  : ""
                              }}
                            </td>
                            <td><strong>Pin Code:</strong> </td>
                            <td>
                              {{
                                enquiry.admission_enquiry.admission_enquiry_pincode
                              }}
                            </td>
                          </tr>
                          <tr>
                            <td><strong>City Name:</strong></td>
                            <td >
                              {{ enquiry.admission_enquiry.admission_enquiry_city }}
                            </td>
                            <td><strong>State Name:</strong> </td>
                            <td>
                              {{ enquiry.admission_enquiry.admission_enquiry_state }}
                            </td>
                          </tr>
                          <tr>
                            <td><strong>Country:</strong></td>
                            <td colspan="4">
                              {{
                                enquiry.admission_enquiry.admission_enquiry_country
                              }}
                            </td>
                          </tr>
                          <tr>
                            <td><strong>Description</strong></td>
                            <td
                              colspan="4"
                            >
                              {{
                                enquiry.admission_enquiry_note != null
                                  ? enquiry.admission_enquiry_note
                                  : ""
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
          name: "Admission Enquiry View ",
        },
      ],
      enquiry: {
        admission_enquiry: {},
      },
      enquiry_student_id: -1,
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
    if (this.$route.params.enquiry_student_id) {
      this.enquiry_student_id = this.$route.params.enquiry_student_id;
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
        `/api/school/front_office/admission_enquiry/admission_enquiry_view/${this.enquiry_student_id}`,
        null
      );
      this.log("SHOW_DATA>>>>", res);
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.enquiry = data.enquiry_student;
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
