<template>
  <div>
    <div class="dashboard-content-one">
      <Breadcrumb pageTitle="Add Admission Enquiry" :breadcrumbList="breadcrumbList">
        <template v-slot:button>
          <button
            type="submit"
            class="btn btn-primary btn-sm text-white"
            @click="$router.push({ name: 'school.front_office.admission' })"
          >
            <i class="fa fa-eye"></i> Back Admission Enquiry List
          </button>
        </template>
      </Breadcrumb>
      <div class="row gutters-20">
        <div class="col-12">
          <div class="card height-auto">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>Add Admission Enquiry</h3>
                </div>
              </div>
              <form class="new-added-form" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Name <span class="text-danger bold">*</span></label>
                    <input
                      type="text"
                      placeholder="Enter Your Name"
                      class="form-control"
                      v-model="editItem.admission_enquiry_name"
                      :class="errorItem.admission_enquiry_name != '' ? 'error-field' : ''"
                      @keyup="
                        editItem.admission_enquiry_name != ''
                          ? (errorItem.admission_enquiry_name = '')
                          : ''
                      "
                    />
                    <span
                      class="error-label"
                      v-if="errorItem.admission_enquiry_name != ''"
                      v-text="errorItem.admission_enquiry_name"
                    >
                    </span>
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Phone <span class="text-danger bold">*</span> </label>
                    <input
                      type="text"
                      placeholder="Please Enter Your Number"
                      class="form-control"
                      v-model="editItem.admission_enquiry_phone"
                      :class="
                        errorItem.admission_enquiry_phone != '' ? 'error-field' : ''
                      "
                    />
                    <span
                      class="error-label"
                      v-if="errorItem.admission_enquiry_phone != ''"
                      v-text="errorItem.admission_enquiry_phone"
                    >
                    </span>
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Email <span class="text-danger bold">*</span></label>
                    <input
                      type="email"
                      placeholder="Enter Your Email"
                      class="form-control"
                      v-model="editItem.admission_enquiry_email"
                      :class="
                        errorItem.admission_enquiry_email != '' ? 'error-field' : ''
                      "
                    />
                    <span
                      class="error-label"
                      v-if="errorItem.admission_enquiry_email != ''"
                      v-text="errorItem.admission_enquiry_email"
                    >
                    </span>
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Address Line 1 <span class="text-danger bold">*</span></label>
                    <textarea
                      class="form-control"
                      id="address_line_1"
                      name="address_line_1"
                      rows=""
                      v-model="editItem.admission_enquiry_address_line1"
                      :class="
                        errorItem.admission_enquiry_address_line1 != ''
                          ? 'error-field'
                          : ''
                      "
                      @keyup="
                        editItem.admission_enquiry_address_line1 != ''
                          ? (errorItem.admission_enquiry_address_line1 = '')
                          : ''
                      "
                    ></textarea>
                    <span
                      class="error-label"
                      v-if="errorItem.admission_enquiry_address_line1 != ''"
                      v-text="errorItem.admission_enquiry_address_line1"
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
                      v-model="editItem.admission_enquiry_address_line2"
                    ></textarea>
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Area <span class="text-danger bold">*</span></label>
                    <input
                      type="text"
                      placeholder="Enter Your area"
                      class="form-control"
                      v-model="editItem.admission_enquiry_area"
                      :class="errorItem.admission_enquiry_area != '' ? 'error-field' : ''"
                      @keyup="
                        editItem.admission_enquiry_area != ''
                          ? (errorItem.admission_enquiry_area = '')
                          : ''
                      "
                    />
                    <span
                      class="error-label"
                      v-if="errorItem.admission_enquiry_area != ''"
                      v-text="errorItem.admission_enquiry_area"
                    >
                    </span>
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Location</label>
                    <input
                      type="text"
                      placeholder="Enter your Location"
                      class="form-control"
                      v-model="editItem.admission_enquiry_location"
                    />
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Land Mark</label>
                    <input
                      type="text"
                      placeholder="Enter your Land Mark"
                      class="form-control"
                      v-model="editItem.admission_enquiry_landmark"
                    />
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Pin Code <span class="text-danger bold">*</span></label>
                    <input
                      type="text"
                      placeholder="Enter Your Pin Code"
                      class="form-control"
                      v-model="editItem.admission_enquiry_pincode"
                      :class="
                        errorItem.admission_enquiry_pincode != '' ? 'error-field' : ''
                      "
                      @keyup="
                        editItem.admission_enquiry_pincode != ''
                          ? (errorItem.admission_enquiry_pincode = '')
                          : ''
                      "
                    />
                    <span
                      class="error-label"
                      v-if="errorItem.admission_enquiry_pincode != ''"
                      v-text="errorItem.admission_enquiry_pincode"
                    >
                    </span>
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>City <span class="text-danger bold">*</span></label>
                    <input
                      type="text"
                      placeholder="Enter Your City"
                      class="form-control"
                      v-model="editItem.admission_enquiry_city"
                      :class="errorItem.admission_enquiry_city != '' ? 'error-field' : ''"
                      @keyup="
                        editItem.admission_enquiry_city != ''
                          ? (errorItem.admission_enquiry_city = '')
                          : ''
                      "
                    />
                    <span
                      class="error-label"
                      v-if="errorItem.admission_enquiry_city != ''"
                      v-text="errorItem.admission_enquiry_city"
                    >
                    </span>
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>State <span class="text-danger bold">*</span></label>
                    <input
                      type="text"
                      placeholder="Enter Your State"
                      class="form-control"
                      v-model="editItem.admission_enquiry_state"
                      :class="
                        errorItem.admission_enquiry_state != '' ? 'error-field' : ''
                      "
                    />
                    <span
                      class="error-label"
                      v-if="errorItem.admission_enquiry_state != ''"
                      v-text="errorItem.admission_enquiry_state"
                    >
                    </span>
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>country <span class="text-danger bold">*</span></label>
                    <input
                      type="text"
                      placeholder="Enter Your Countery"
                      class="form-control"
                      v-model="editItem.admission_enquiry_country"
                      :class="
                        errorItem.admission_enquiry_country != '' ? 'error-field' : ''
                      "
                      @keyup="
                        editItem.admission_enquiry_country != ''
                          ? (errorItem.admission_enquiry_country = '')
                          : ''
                      "
                    />
                    <span
                      class="error-label"
                      v-if="errorItem.admission_enquiry_country != ''"
                      v-text="errorItem.admission_enquiry_country"
                    >
                    </span>
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Note</label>
                    <textarea
                      class="textarea form-control"
                      name="message"
                      id="form-message"
                      cols=""
                      rows=""
                      v-model="editItem.admission_enquiry_note"
                    ></textarea>
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Number Of Child</label>
                    <input
                      type="number"
                      value=""
                      autocomplete="off"
                      :readonly="$route.params.edit_id ? true : false"
                      class="form-control"
                      v-model="editItem.admission_enquiry_no_of_child"
                    />
                  </div>
                </div>
                <div v-if="addStudents > 0">
                  <div v-for="(num, index) in addStudents" :key="index" class="row">
                    <div class="col-xl-3 col-lg-3 col-md-3 col-12 form-group">
                      <label>Class <span class="text-danger bold">*</span></label>
                      <Select2
                        ref="class_list"
                        placeholder=" -- SELECT A CLASS--"
                        :items="class_list"
                        :selectedId="selectedClass"
                        @change="selectClass($event, index)"
                      />
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-12 form-group">
                      <label>Child Name </label>
                      <input
                        type="text"
                        placeholder="Enter Your Child Name"
                        class="form-control"
                        v-model="editItem.enquiry_student_name[index]"
                      />
                    </div>
                  </div>
                </div>
                <div class="row mt-4" id="number_of_child">
                  <!-- <div class="row mt-4" v-model="addStudents.studentInfo" >
                    <div class="number_of_child" ></div>-->
                </div>
                <div class="d-flex justify-content-end mt-5">
                  <button
                    type="submit"
                    class="btn-fill-lg text-light shadow-dodger-blue bg-dodger-blue"
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
      <!-- Add Enquiry Form Area End Here -->
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
          name: "Add Admission Enquiry",
        },
      ],
      editItem: {
        enquiry_student_name: [],
        admission_enquiry_no_of_child: 1,
      },
      addStudents: 1,
      class_list: [],
      errorItem: {
        admission_enquiry_name: "",
        admission_enquiry_phone: "",
        admission_enquiry_email: "",
        admission_enquiry_address_line1: "",
        admission_enquiry_area: "",
        admission_enquiry_pincode: "",
        admission_enquiry_city: "",
        admission_enquiry_state: "",
        admission_enquiry_country: "",
        admission_enquiry_date: "",
        class_list: "",
      },
      selectedClass: [],
      emailRegex: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/,
      mobileRegex: /^[5-9][0-9]{9}$/,
    };
  },
  mounted() {
    this.$parent.loadOtherScript();
    this.getClassData();
    if (this.$route.params.edit_id) {
      this.getEditData();
    }
  },
  watch: {
    "editItem.admission_enquiry_no_of_child": function (val) {
      this.addStudents = parseInt(val ? val : 0);
      setTimeout(() => {
        if (val && val != null && parseInt(val) > 0) {
          if (this.$refs.class_list) {
            this.$refs.class_list.forEach((element, index) => {
              element.updateList(this.class_list);
              element.setSelected(this.selectedClass[index]);
              if (!this.$route.params.edit_id) {
                this.selectedClass[index] = "-1";
              }
            });
          }
        }
      }, 1200);
    },
    // "editItem.admission_enquiry_email": function (val) {
    //   this.errorItem.admission_enquiry_email = "";
    //   if (val == null || val == "") {
    //     this.errorItem.admission_enquiry_email = "Email is required";
    //   }
    //   if (val && !this.emailRegex.test(val)) {
    //     this.errorItem.admission_enquiry_email = "Enter Valid Email id";
    //   }
    // },
    // "editItem.admission_enquiry_phone": function (val) {
    //   this.errorItem.admission_enquiry_phone = "";
    //   if (val == null || val == "") {
    //     this.errorItem.admission_enquiry_phone = "Mobile is required";
    //   }
    //   if (val && !this.mobileRegex.test(val)) {
    //     this.errorItem.admission_enquiry_phone = "Enter Valid 10 Digit Mobile id";
    //   }
    // },
  },
  computed: {
    formBtn: function () {
      return this.$route.params.edit_id ? "Update" : "Save";
    },
  },

  methods: {
    async getEditData() {
      const res = await this.callApi(
        "get",
        `/api/school/front_office/admission_enquiry/edit/${this.$route.params.edit_id}`,
        null
      );
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.editItem = data.admission_enquiry;
          this.editItem.enquiry_student_name = [];
          for (let i = 0; i < data.admission_enquiry.admission_enquiry_no_of_child; i++) {
            this.editItem.enquiry_student_name.push(
              data.admission_enquiry.students[i].enquiry_student_name
            );
            this.selectedClass.push(
              data.admission_enquiry.students[i].enquiry_student_class.value
            );
          }
          this.addStudents = parseInt(
            data.admission_enquiry.admission_enquiry_no_of_child
          );
        }
      }
    },
    async getClassData() {
      const res = await this.callApi(
        "get",
        `/api/school/front_office/admission_enquiry/data_list`,
        null
      );
      if (res.status == 200) {
        var data = res.data;
        this.class_list = data.class_list;
      }
    },
    selectClass(val, index) {
      this.selectedClass[index] = val;
    },
    resetForm() {
      this.editItem = {
        enquiry_student_name: [],
        admission_enquiry_no_of_child: 0,
      };
      this.editItem.admission_enquiry_no_of_child = 0;
    //   this.$refs.class_list.setSelected(-1);
      this.selectedClass[0];
    },
    async submitForm() {
      var isVaild = await this.validAdmissionEnquiryForm();
      if (!isVaild) {
        return;
      }
      if (this.$route.params.edit_id) {
        toast = Toast.fire({
          icon: "warning",
          title: "Please Wait!! Updating Admission Enquiry",
          timer: 0,
        });
      } else {
        toast = Toast.fire({
          icon: "warning",
          title: "Please Wait!! Creating New Admission Enquiry",
          timer: 0,
        });
      }

      var data = new FormData();
      this.editItem.enquiry_student_name.forEach((element, index) => {
        data.append("enquiry_student_class[]", this.selectedClass[index]);
        data.append("enquiry_student_name[]", element);
      });
      data.append(
        "admission_enquiry_name",
        this.editItem.admission_enquiry_name ? this.editItem.admission_enquiry_name : ""
      );
      data.append(
        "admission_enquiry_phone",
        this.editItem.admission_enquiry_phone ? this.editItem.admission_enquiry_phone : ""
      );
      data.append(
        "admission_enquiry_email",
        this.editItem.admission_enquiry_email ? this.editItem.admission_enquiry_email : ""
      );
      data.append(
        "admission_enquiry_address_line1",
        this.editItem.admission_enquiry_address_line1
          ? this.editItem.admission_enquiry_address_line1
          : ""
      );
      data.append(
        "admission_enquiry_address_line2",
        this.editItem.admission_enquiry_address_line2
          ? this.editItem.admission_enquiry_address_line2
          : ""
      );
      data.append(
        "admission_enquiry_area",
        this.editItem.admission_enquiry_area ? this.editItem.admission_enquiry_area : ""
      );
      data.append(
        "admission_enquiry_location",
        this.editItem.admission_enquiry_location
          ? this.editItem.admission_enquiry_location
          : ""
      );
      data.append(
        "admission_enquiry_city",
        this.editItem.admission_enquiry_city ? this.editItem.admission_enquiry_city : ""
      );
      data.append(
        "admission_enquiry_state",
        this.editItem.admission_enquiry_state ? this.editItem.admission_enquiry_state : ""
      );
      data.append(
        "admission_enquiry_country",
        this.editItem.admission_enquiry_country
          ? this.editItem.admission_enquiry_country
          : ""
      );
      data.append(
        "admission_enquiry_pincode",
        this.editItem.admission_enquiry_pincode
          ? this.editItem.admission_enquiry_pincode
          : ""
      );
      data.append(
        "admission_enquiry_description",
        this.editItem.admission_enquiry_description
          ? this.editItem.admission_enquiry_description
          : ""
      );
      data.append(
        "admission_enquiry_note",
        this.editItem.admission_enquiry_note ? this.editItem.admission_enquiry_note : ""
      );
      data.append(
        "admission_enquiry_date",
        this.editItem.admission_enquiry_date ? this.editItem.admission_enquiry_date : ""
      );
      data.append(
        "admission_enquiry_next_date",
        this.editItem.admission_enquiry_next_date
          ? this.editItem.admission_enquiry_next_date
          : ""
      );
      data.append(
        "admission_enquiry_no_of_child",
        this.editItem.admission_enquiry_no_of_child
          ? this.editItem.admission_enquiry_no_of_child
          : ""
      );
      this.log(data);
      let $url = "";
      if (this.$route.params.edit_id) {
        $url = `/api/school/front_office/admission_enquiry/update/${this.$route.params.edit_id}`;
      } else {
        $url = `/api/school/front_office/admission_enquiry/save`;
      }
      const res = await this.callApi("post", $url, data);
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.resetForm();
            console.log("get",this.$route.params.edit_id);
          if (this.$route.params.edit_id) {
            toast = Toast.fire({
              icon: data.status,
              title: data.message,
              timer: 2500,
            });
            setTimeout(() => {
              this.$router.push("/school/front_office/admission");
            }, 2500);
          }
          toast = Toast.fire({
            icon: data.status,
            title: data.message,
            timer: 2500,
          });
        } else {
          toast = Toast.fire({
            icon: data.status,
            title: data.message,
            timer: 2500,
          });
        }
      } else {
        toast = Toast.fire({
          icon: "error",
          title: "Something went wrong",
          timer: 0,
        });
      }
    },
    validAdmissionEnquiryForm() {
      let isFormValid = true;
      if (this.selectedClass == -1) {
        this.errorItem.class_list = "Class is required";
        isFormValid = false;
      } else {
        this.errorItem.class_list = "";
      }
      if (
        this.editItem.admission_enquiry_name == null ||
        this.editItem.admission_enquiry_name == ""
      ) {
        this.errorItem.admission_enquiry_name = "Name is required";
        isFormValid = false;
      } else {
        this.errorItem.admission_enquiry_name = "";
      }
      if (
        this.editItem.admission_enquiry_phone == null ||
        this.editItem.admission_enquiry_phone == ""
      ) {
        this.errorItem.admission_enquiry_phone = "Phone is required";
        isFormValid = false;
      } else {
        if (!this.mobileRegex.test(this.editItem.admission_enquiry_phone)) {
          this.errorItem.admission_enquiry_phone = "Enter valid mobile number";
          isFormValid = false;
        }
        this.errorItem.admission_enquiry_phone = "";
      }
      if (
        this.editItem.admission_enquiry_email == null ||
        this.editItem.admission_enquiry_email == ""
      ) {
        this.errorItem.admission_enquiry_email = "Email is required";
        isFormValid = false;
      } else {
        if (!this.emailRegex.test(this.editItem.admission_enquiry_email)) {
          this.errorItem.admission_enquiry_email = "Enter valid email";
          isFormValid = false;
        } else {
          this.errorItem.admission_enquiry_email = "";
        }
      }
      if (
        this.editItem.admission_enquiry_address_line1 == null ||
        this.editItem.admission_enquiry_address_line1 == ""
      ) {
        this.errorItem.admission_enquiry_address_line1 = "Address Line 1 is required";
        isFormValid = false;
      } else {
        this.errorItem.admission_enquiry_address_line1 = "";
      }
      if (
        this.editItem.admission_enquiry_area == null ||
        this.editItem.admission_enquiry_area == ""
      ) {
        this.errorItem.admission_enquiry_area = "Area is required";
        this.isFormValid = false;
      } else {
        this.errorItem.admission_enquiry_area = "";
      }
      if (
        this.editItem.admission_enquiry_pincode == null ||
        this.editItem.admission_enquiry_pincode == ""
      ) {
        this.errorItem.admission_enquiry_pincode = "Pincode is required";
        this.isFormValid = false;
      } else {
        this.errorItem.admission_enquiry_pincode = "";
      }
      if (
        this.editItem.admission_enquiry_city == null ||
        this.editItem.admission_enquiry_city == ""
      ) {
        this.errorItem.admission_enquiry_city = "City is required";
        isFormValid = false;
      } else {
        this.errorItem.admission_enquiry_city = "";
      }
      if (
        this.editItem.admission_enquiry_state == null ||
        this.editItem.admission_enquiry_state == ""
      ) {
        this.errorItem.admission_enquiry_state = "State is required";
        isFormValid = false;
      } else {
        this.errorItem.admission_enquiry_state = "";
      }
      if (
        this.editItem.admission_enquiry_country == null ||
        this.editItem.admission_enquiry_country == ""
      ) {
        this.errorItem.admission_enquiry_country = "Country is required";
        isFormValid = false;
      } else {
        this.errorItem.admission_enquiry_country = "";
      }
      return isFormValid;
    },
  },
};
</script>

<style scoped></style>
