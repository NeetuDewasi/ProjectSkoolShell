<template>
  <div>
    <div class="dashboard-content-one">
      <!-- Breadcubs Area Start -->
      <Breadcrumb pageTitle="Add Hostel" :breadcrumbList="breadcrumbList">
        <template v-slot:button>
          <button
            type="submit"
            class="btn btn-primary btn-sm text-white"
            @click="$router.push({ name: 'school.hostel' })"
          >
            <i class="fa fa-eye"></i> All View Hostel
          </button>
        </template>
      </Breadcrumb>
      <div class="row gutters-20">
        <div class="col-12">
          <div class="card height-auto">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>Add Hostel Form</h3>
                </div>
              </div>
              <form class="new-added-form">
                <div class="row">
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label
                      >Hostel Name
                      <span class="text-danger bold">*</span></label
                    >
                    <input
                      type="text"
                      placeholder="Enter Hostel Name"
                      class="form-control"
                      v-model="editItem.hostel_name"
                      :class="errorItem.hostel_name != '' ? 'error-field' : ''"
                      @keyup="
                        editItem.hostel_name != ''
                          ? (errorItem.hostel_name = '')
                          : ''
                      "
                    />
                    <span
                      class="error-label"
                      v-if="errorItem.hostel_name != ''"
                      v-text="errorItem.hostel_name"
                    >
                    </span>
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label
                      >Hostel Type
                      <span class="text-danger bolder">*</span></label
                    >
                    <select
                      class="form-control"
                      placeholder="--SELECT HOSTEL TYPE--"
                      v-model="editItem.hostel_type"
                      :class="errorItem.hostel_type != '' ? 'error-field' : ''"
                      @change="
                        editItem.hostel_type != ''
                          ? (errorItem.hostel_type = '')
                          : ''
                      "
                    >
                      <option value="" selected disabled>
                        Select Hostel Type
                      </option>
                      <option value="boys">Boys</option>
                      <option value="girls">Girls</option>
                      <option value="combine">Combine</option>
                    </select>
                    <span
                      class="error-label"
                      v-if="errorItem.hostel_type != ''"
                      v-text="errorItem.hostel_type"
                    ></span>
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label
                      >Intake <span class="text-danger bold">*</span></label
                    >
                    <input
                      type="text"
                      placeholder="Enter Hostel Name"
                      class="form-control"
                      v-model="editItem.hostel_intake"
                      :class="
                        errorItem.hostel_intake != '' ? 'error-field' : ''
                      "
                      @keyup="
                        editItem.hostel_intake != ''
                          ? (errorItem.hostel_intake = '')
                          : ''
                      "
                    />
                    <span
                      class="error-label"
                      v-if="errorItem.hostel_intake != ''"
                      v-text="errorItem.hostel_intake"
                    >
                    </span>
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label
                      >Warden Name
                      <span class="text-danger bold">*</span></label
                    >
                    <input
                      type="text"
                      placeholder="Enter Warden Name"
                      class="form-control"
                      v-model="editItem.hostel_person"
                      :class="
                        errorItem.hostel_person != '' ? 'error-field' : ''
                      "
                      @keyup="
                        editItem.hostel_person != ''
                          ? (errorItem.hostel_person = '')
                          : ''
                      "
                    />
                    <span
                      class="error-label"
                      v-if="errorItem.hostel_person != ''"
                      v-text="errorItem.hostel_person"
                    >
                    </span>
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label
                      >Contact Number
                      <span class="text-danger bold">*</span>
                    </label>
                    <input
                      type="text"
                      placeholder="Enter Contact Number"
                      class="form-control"
                      v-model="editItem.hostel_number"
                      :class="
                        errorItem.hostel_number != '' ? 'error-field' : ''
                      "
                    />
                    <span
                      class="error-label"
                      v-if="errorItem.hostel_number != ''"
                      v-text="errorItem.hostel_number"
                    >
                    </span>
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Alternate Contact Number </label>
                    <input
                      type="text"
                      placeholder="Enter Hostel Name"
                      class="form-control"
                      v-model="editItem.hostel_alt_number"
                    />
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label
                      >Email Address
                      <span class="text-danger bold">*</span></label
                    >
                    <input
                      type="text"
                      placeholder="Enter Email Address"
                      class="form-control"
                      v-model="editItem.hostel_email"
                      :class="errorItem.hostel_email != '' ? 'error-field' : ''"
                    />
                    <span
                      class="error-label"
                      v-if="errorItem.hostel_email != ''"
                      v-text="errorItem.hostel_email"
                    >
                    </span>
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label
                      >Address Line 1
                      <span class="text-danger bold">*</span></label
                    >
                    <textarea
                      class="form-control"
                      id="address_line_1"
                      name="address_line_1"
                      rows=""
                      v-model="editItem.hostel_address_line1"
                      :class="
                        errorItem.hostel_address_line1 != ''
                          ? 'error-field'
                          : ''
                      "
                      @keyup="
                        editItem.hostel_address_line1 != ''
                          ? (errorItem.hostel_address_line1 = '')
                          : ''
                      "
                    ></textarea>
                    <span
                      class="error-label"
                      v-if="errorItem.hostel_address_line1 != ''"
                      v-text="errorItem.hostel_address_line1"
                    >
                    </span>
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Address Line 2</label>
                    <textarea
                      class="form-control"
                      id="address_line_1"
                      name="address_line_2"
                      rows=""
                      v-model="editItem.hostel_address_line2"
                    ></textarea>
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Area <span class="text-danger bold">*</span></label>
                    <input
                      type="text"
                      placeholder="Enter Your area"
                      class="form-control"
                      v-model="editItem.hostel_area"
                      :class="errorItem.hostel_area != '' ? 'error-field' : ''"
                      @keyup="
                        editItem.hostel_area != ''
                          ? (errorItem.hostel_area = '')
                          : ''
                      "
                    />
                    <span
                      class="error-label"
                      v-if="errorItem.hostel_area != ''"
                      v-text="errorItem.hostel_area"
                    >
                    </span>
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Land Mark</label>
                    <input
                      type="text"
                      placeholder="Enter your Land Mark"
                      class="form-control"
                      v-model="editItem.hostel_landmark"
                    />
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label
                      >Pin Code <span class="text-danger bold">*</span></label
                    >
                    <input
                      type="text"
                      placeholder="Enter Your Pin Code"
                      class="form-control"
                      v-model="editItem.hostel_pincode"
                      :class="
                        errorItem.hostel_pincode != '' ? 'error-field' : ''
                      "
                      @keyup="
                        editItem.hostel_pincode != ''
                          ? (errorItem.hostel_pincode = '')
                          : ''
                      "
                    />
                    <span
                      class="error-label"
                      v-if="errorItem.hostel_pincode != ''"
                      v-text="errorItem.hostel_pincode"
                    >
                    </span>
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>City <span class="text-danger bold">*</span></label>
                    <input
                      type="text"
                      placeholder="Enter Your City"
                      class="form-control"
                      v-model="editItem.hostel_city"
                      :class="errorItem.hostel_city != '' ? 'error-field' : ''"
                      @keyup="
                        editItem.hostel_city != ''
                          ? (errorItem.hostel_city = '')
                          : ''
                      "
                    />
                    <span
                      class="error-label"
                      v-if="errorItem.hostel_city != ''"
                      v-text="errorItem.hostel_city"
                    >
                    </span>
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>State <span class="text-danger bold">*</span></label>
                    <input
                      type="text"
                      placeholder="Enter Your State"
                      class="form-control"
                      v-model="editItem.hostel_state"
                      :class="errorItem.hostel_state != '' ? 'error-field' : ''"
                      @keyup="
                        editItem.hostel_state != ''
                          ? (errorItem.hostel_state = '')
                          : ''
                      "
                    />
                    <span
                      class="error-label"
                      v-if="errorItem.hostel_state != ''"
                      v-text="errorItem.hostel_state"
                    >
                    </span>
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label
                      >country <span class="text-danger bold">*</span></label
                    >
                    <input
                      type="text"
                      placeholder="Enter Your Countery"
                      class="form-control"
                      v-model="editItem.hostel_country"
                      :class="
                        errorItem.hostel_country != '' ? 'error-field' : ''
                      "
                      @keyup="
                        editItem.hostel_country != ''
                          ? (errorItem.hostel_country = '')
                          : ''
                      "
                    />
                    <span
                      class="error-label"
                      v-if="errorItem.hostel_country != ''"
                      v-text="errorItem.hostel_country"
                    >
                    </span>
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Descrpition</label>
                    <textarea
                      class="textarea form-control"
                      id="form-message"
                      cols=""
                      rows=""
                      v-model="editItem.hostel_description"
                    ></textarea>
                  </div>
                </div>
                <div class="d-flex justify-content-end mt-5">
                  <button
                    type="submit"
                    class="
                      btn-fill-lg
                      text-light
                      shadow-dodger-blue
                      bg-dodger-blue
                    "
                    @click.prevent="submitForm()"
                  >
                    {{ formBtn }}
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- Add Hostel End Here -->
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
          to: { name: "admin.dashboard" },
          name: "Home",
        },
        {
          name: "Add Hostel",
        },
      ],
      editItem: {
        // hostel_type:"-1",
        hostel_type: "",
      },
      errorItem: {
        hostel_name: "",
        hostel_type: "",
        hostel_intake: "",
        hostel_email: "",
        hostel_address_line1: "",
        hostel_area: "",
        hostel_person: "",
        hostel_pincode: "",
        hostel_city: "",
        hostel_state: "",
        hostel_country: "",
        hostel_number: "",
      },
      emailRegex: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/,
      mobileRegex: /^[5-9][0-9]{9}$/,
    };
  },
  watch: {
    "editItem.hostel_number": function (val) {
      this.errorItem.hostel_number = "";
      if (val == null || val == "") {
        this.errorItem.hostel_number = "Mobile No. is required";
      }
      if (val && !this.mobileRegex.test(val)) {
        this.errorItem.hostel_number = "Enter Valid 10 Digit Mobile id";
      }
    },
    "editItem.hostel_email": function (val) {
      this.errorItem.hostel_email = "";
      if (val == null || val == "") {
        this.errorItem.hostel_email = "Email is required";
      }
      if (val && !this.emailRegex.test(val)) {
        this.errorItem.hostel_email = "Enter Valid Email id";
      }
    },
  },
  computed: {
    formBtn: function () {
      return this.$route.params.edit_id ? "update" : "save";
    },
  },
  mounted() {
    this.$parent.loadOtherScript();
    if (this.$route.params.edit_id) {
      this.getEditData();
    }
  },
  methods: {
    async getEditData() {
      const res = await this.callApi(
        "get",
        `/api/school/hostel/hostel/edit/${this.$route.params.edit_id}`,
        null
      );
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.editItem = data.hostel;
        }
      }
    },
    resetForm() {
      this.editItem = {
        // hostel_type = "",
      };
    },
    async submitForm() {
      var isVaild = await this.validHostelForm();
      if (!isVaild) {
        return;
      }
      if (this.$route.params.edit_id) {
        toast = Toast.fire({
          icon: "warning",
          title: "Please Wait!! Updating Hostel",
          timer: 0,
        });
      } else {
        toast = Toast.fire({
          icon: "warning",
          title: "Please Wait!! Creating New Hostel",
          timer: 0,
        });
      }
      var data = new FormData();
      data.append(
        "hostel_name",
        this.editItem.hostel_name ? this.editItem.hostel_name : ""
      );
      data.append(
        "hostel_type",
        this.editItem.hostel_type ? this.editItem.hostel_type : ""
      );
      data.append(
        "hostel_intake",
        this.editItem.hostel_intake ? this.editItem.hostel_intake : ""
      );
      data.append(
        "hostel_person",
        this.editItem.hostel_person ? this.editItem.hostel_person : ""
      );
      data.append(
        "hostel_number",
        this.editItem.hostel_number ? this.editItem.hostel_number : ""
      );
      data.append(
        "hostel_alt_number",
        this.editItem.hostel_alt_number ? this.editItem.hostel_alt_number : ""
      );
      data.append(
        "hostel_email",
        this.editItem.hostel_email ? this.editItem.hostel_email : ""
      );
      data.append(
        "admission_enquiry_address_line2",
        this.editItem.admission_enquiry_address_line2
          ? this.editItem.admission_enquiry_address_line2
          : ""
      );
      data.append(
        "hostel_address_line1",
        this.editItem.hostel_address_line1
          ? this.editItem.hostel_address_line1
          : ""
      );
      data.append(
        "hostel_address_line2",
        this.editItem.hostel_address_line2
          ? this.editItem.hostel_address_line2
          : ""
      );
      data.append(
        "hostel_area",
        this.editItem.hostel_area ? this.editItem.hostel_area : ""
      );
      data.append(
        "hostel_landmark",
        this.editItem.hostel_landmark ? this.editItem.hostel_landmark : ""
      );
      data.append(
        "hostel_city",
        this.editItem.hostel_city ? this.editItem.hostel_city : ""
      );
      data.append(
        "hostel_state",
        this.editItem.hostel_state ? this.editItem.hostel_state : ""
      );
      data.append(
        "hostel_country",
        this.editItem.hostel_country ? this.editItem.hostel_country : ""
      );
      data.append(
        "hostel_pincode",
        this.editItem.hostel_pincode ? this.editItem.hostel_pincode : ""
      );
      data.append(
        "hostel_description",
        this.editItem.hostel_description ? this.editItem.hostel_description : ""
      );
      let $url = "";
      if (this.$route.params.edit_id) {
        $url = `/api/school/hostel/hostel/update/${this.$route.params.edit_id}`;
      } else {
        $url = `/api/school/hostel/hostel/save`;
      }
      const res = await this.callApi("post", $url, data);

      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.resetForm();
          if (this.$route.params.edit_id) {
            toast = Toast.fire({
              icon: data.status,
              title: data.message,
              timer: 2500,
            });
            setTimeout(() => {
              this.$router.push("/school/hostel");
            }, 2500);
          }
          toast = Toast.fire({
            icon: data.status,
            title: data.message,
            timer: 2500,
          });
        } else {
          toast = Toast.fire({
            icon: "error",
            title: "Something went wrong",
            timer: 0,
          });
        }
      }
    },
    validHostelForm() {
      let isFormValid = true;

      if (
        this.editItem.hostel_name == null ||
        this.editItem.hostel_name == ""
      ) {
        this.errorItem.hostel_name = "Hostel Name is required";
        isFormValid = false;
      } else {
        this.errorItem.hostel_name = "";
      }
      if (
        this.editItem.hostel_type == null ||
        this.editItem.hostel_type == ""
      ) {
        this.errorItem.hostel_type = "Hostel Type is required";
        isFormValid = false;
      } else {
        this.errorItem.hostel_type = "";
      }
      if (
        this.editItem.hostel_intake == null ||
        this.editItem.hostel_intake == ""
      ) {
        this.errorItem.hostel_intake = "Hostel Capacity is required";
        isFormValid = false;
      } else {
        this.errorItem.hostel_intake = "";
      }
      if (
        this.editItem.hostel_email == null ||
        this.editItem.hostel_email == ""
      ) {
        this.errorItem.hostel_email = "Email is required";
        isFormValid = false;
      } else {
        if (!this.emailRegex.test(this.editItem.hostel_email)) {
          this.errorItem.hostel_email = "Enter valid email";
          isFormValid = false;
        } else {
          this.errorItem.hostel_email = "";
        }
      }
      if (
        this.editItem.hostel_address_line1 == null ||
        this.editItem.hostel_address_line1 == ""
      ) {
        this.errorItem.hostel_address_line1 = "Address Line 1 is required";
        isFormValid = false;
      } else {
        this.errorItem.hostel_address_line1 = "";
      }
      if (
        this.editItem.hostel_area == null ||
        this.editItem.hostel_area == ""
      ) {
        this.errorItem.hostel_area = "Area is required";
        isFormValid = false;
      } else {
        this.errorItem.hostel_area = "";
      }
      if (
        this.editItem.hostel_area == null ||
        this.editItem.hostel_area == ""
      ) {
        this.errorItem.hostel_area = "Area is required";
        isFormValid = false;
      } else {
        this.errorItem.hostel_area = "";
      }
      if (
        this.editItem.hostel_person == null ||
        this.editItem.hostel_person == ""
      ) {
        this.errorItem.hostel_person = "Warden Name is required";
        isFormValid = false;
      } else {
        this.errorItem.hostel_person = "";
      }
      if (
        this.editItem.hostel_number == null ||
        this.editItem.hostel_number == ""
      ) {
        this.errorItem.hostel_number = "Contact Number is required";
        isFormValid = false;
      } else {
        if (!this.mobileRegex.test(this.editItem.hostel_number)) {
          this.errorItem.hostel_number = "Enter valid mobile number";
          isFormValid = false;
        }
        this.errorItem.hostel_number = "";
      }
      if (
        this.editItem.hostel_pincode == null ||
        this.editItem.hostel_pincode == ""
      ) {
        this.errorItem.hostel_pincode = "Pincode is required";
        isFormValid = false;
      } else {
        this.errorItem.hostel_pincode = "";
      }
      if (
        this.editItem.hostel_city == null ||
        this.editItem.hostel_city == ""
      ) {
        this.errorItem.hostel_city = "City Name is required";
        isFormValid = false;
      } else {
        this.errorItem.hostel_city = "";
      }
      if (
        this.editItem.hostel_state == null ||
        this.editItem.hostel_state == ""
      ) {
        this.errorItem.hostel_state = "Pincode is required";
        isFormValid = false;
      } else {
        this.errorItem.hostel_state = "";
      }
      if (
        this.editItem.hostel_country == null ||
        this.editItem.hostel_country == ""
      ) {
        this.errorItem.hostel_country = "Country Name is required";
        isFormValid = false;
      } else {
        this.errorItem.hostel_country = "";
      }
      return isFormValid;
    },
  },
};
</script>


<style scoped>
</style>
