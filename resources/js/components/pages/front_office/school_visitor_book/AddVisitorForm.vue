<template>
  <div class="card">
    <div class="card-body">
      <div class="heading-layout1">
        <div class="item-title">
          <h3>Add Visitor</h3>
        </div>
      </div>
      <form class="new-added-form" enctype="multipart/form-data">
        <div class="row">
          <div class="col-12 form-group">
            <label>Purpose <span class="text-danger bold">*</span></label>
            <Select2
              ref="purpose_list"
              :items="purpose_list"
              placeholder="--SELECT PURPOSE--"
              @change="selectPurpose"
              :selectedId="selectedPurpose"
              :class="errorItem.purpose_list != '' ? 'error-field' : ''"
            />
            <span
              class="error-label"
              v-if="errorItem.purpose_list != ''"
              v-text="errorItem.purpose_list"
            >
            </span>
          </div>
          <div class="col-12 form-group">
            <label>Name <span class="text-danger bold">*</span></label>
            <input
              type="text"
              placeholder="Please Enter Your Name"
              class="form-control"
              v-model="editItem.visitor_name"
              :class="errorItem.visitor_name != '' ? 'error-field' : ''"
              @keyup="
                editItem.visitor_name != '' ? (errorItem.visitor_name = '') : ''
              "
            />
            <span
              class="error-label"
              v-if="errorItem.visitor_name != ''"
              v-text="errorItem.visitor_name"
            >
            </span>
          </div>
          <div class="col-12 form-group">
            <label>Email</label>
            <input
              type="email"
              placeholder=""
              class="form-control"
              v-model="editItem.visitor_email"
            />
            <span
              class="error-label"
              v-if="errorItem.visitor_email != ''"
              v-text="errorItem.visitor_email"
            ></span>
          </div>
          <div class="col-12 form-group">
            <label>Phone Number <span class="text-danger bold">*</span></label>
            <input
              type="text"
              placeholder="Enter Mobile Number"
              class="form-control"
              v-model="editItem.visitor_phone"
              :class="errorItem.visitor_phone != '' ? 'error-field' : ''"
            />
            <span
              class="error-label"
              v-if="errorItem.visitor_phone != ''"
              v-text="errorItem.visitor_phone"
            ></span>
          </div>
          <div class="col-12 form-group">
            <label>ID Card <span class="text-danger bold">*</span></label>
            <input
              type="text"
              placeholder="Please Enter Your Id Card Number"
              class="form-control"
              v-model="editItem.visitor_id_card"
              :class="errorItem.visitor_id_card != '' ? 'error-field' : ''"
              @keyup="
                editItem.visitor_id_card != ''
                  ? (errorItem.visitor_id_card = '')
                  : ''
              "
            />
            <span
              class="error-label"
              v-if="errorItem.visitor_id_card != ''"
              v-text="errorItem.visitor_id_card"
            >
            </span>
          </div>
          <div class="col-12 form-group">
            <label
              >Number Of Person<span class="text-danger bold">*</span></label
            >
            <input
              type="text"
              placeholder=""
              class="form-control"
              v-model="editItem.visitor_no_of_person"
              :class="errorItem.visitor_no_of_person != '' ? 'error-field' : ''"
              @keyup="
                editItem.visitor_no_of_person != ''
                  ? (errorItem.visitor_no_of_person = '')
                  : ''
              "
            />
            <span
              class="error-label"
              v-if="errorItem.visitor_no_of_person != ''"
              v-text="errorItem.visitor_no_of_person"
            >
            </span>
          </div>
          <div class="col-12 form-group">
            <label>Select Date</label>
            <DatePicker
              format="DD-MMM-YYYY"
              value-type="format"
              type="date"
              placeholder="Select a date"
              v-model="displayDate"
              :default-value="new Date()"
              :disabled-date="disabledAfterToday"
              class="form-control vue-datepicker my-0"
            />
          </div>
          <div class="col-12 form-group">
            <label>In Time</label>
            <input
              type="time"
              placeholder="Select Time"
              class="form-control timepicker"
              v-model="editItem.visitor_in_time"
            />
          </div>
          <div class="col-12 form-group">
            <label>Out Time</label>
            <input
              type="time"
              placeholder="Slect Time"
              class="form-control timepicker"
              v-model="editItem.visitor_out_time"
            />
          </div>
          <div class="col-12 form-group">
            <label>Note</label>
            <textarea
              class="textarea form-control"
              name="message"
              id="form-message"
              cols="10"
              rows="8"
              v-model="editItem.visitor_note"
            ></textarea>
          </div>
          <div class="col-12 form-group">
            <label>Attach Document</label>
            <div class="imageContainer">
              <img :src="selectedImage" alt />
              <input type="file" accept="image/*" @change="imageFileSelect" />
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-end mg-t-8">
          <button
            type="submit"
            class="
              btn btn-fill-sm
              rounded
              mg-t-30
              text-light
              shadow-dodger-blue
              bg-dodger-blue
            "
            @click.prevent="submitForm()"
          >
            {{ formBtn }}
          </button>
          <button
            type="button"
            class="
              ml-3
              btn btn-fill-sm
              rounded
              mg-t-30
              text-light
              shadow-dodger-blue
              btn-gradient-yellow
            "
            @click="resetForm"
          >
            {{ resetButton }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
var toast;
export default {
  data() {
    return {
      editedIndex: -1,
      editItem: {},
      purpose_list: [],
      errorItem: {
        visitor_name: "",
        visitor_email: "",
        visitor_phone: "",
        // visitor_date: "",
        visitor_id_card: "",
        purpose_list: "",
        visitor_no_of_person: "",
      },
      imageFilePath: null,
      srcImageFile: null,
      selectedPurpose: -1,
      displayDate: "",
      visitor_date: moment(new Date()).format("YYYY-MM-DD"),
      emailRegex: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/,
      mobileRegex: /^[5-9][0-9]{9}$/,
    };
  },
  mounted() {
    this.displayDate = moment(new Date()).format("DD-MMM-YYYY");
    this.getPurposeData();
  },
  watch: {
    displayDate: function (val) {
      this.displayDate = val;
      this.visitor_date = moment(new Date(val)).format("YYYY-MM-DD");
    },
    "editItem.visitor_email": function (val) {
      this.errorItem.visitor_email = "";
      if (val && !this.emailRegex.test(val)) {
        this.errorItem.visitor_email = "Enter Valid Email id";
      }
    },
    "editItem.visitor_phone": function (val) {
      this.errorItem.visitor_phone = "";
      if (val == null || val == "") {
        this.errorItem.visitor_phone = "Mobile is required";
      }
      if (val && !this.mobileRegex.test(val)) {
        this.errorItem.visitor_phone = "Enter Valid 10 Digit Mobile id";
      }
    },
  },
  computed: {
    formBtn: function () {
      return this.editedIndex !== -1 ? "update" : "save";
    },
    resetButton: function () {
      return this.editedIndex === -1 ? "Reset" : "Cancel";
    },
    selectedImage: function () {
      return this.srcImageFile != null
        ? this.srcImageFile
        : "/assets/img/nb.jpg";
    },
  },
  methods: {
    disabledAfterToday(date) {
      const today = new Date();
      today.setHours(0, 0, 0, 0);

      return date > today;
    },
    imageFileSelect(e) {
      const file = e.target.files[0];
      if (file) {
        this.srcImageFile = URL.createObjectURL(file);
        URL.revokeObjectURL(file);
        this.imageFilePath = file;
      } else {
        this.srcImageFile = null;
        this.imageFilePath = null;
      }
    },
    async getPurposeData() {
      const res = await this.callApi(
        "get",
        `/api/school/front_office/visitors/purpose_list`,
        null
      );

      if (res.status == 200) {
        var data = res.data;
        this.purpose_list = data.purpose_list;
        this.$refs.purpose_list.updateList(data.purpose_list);
        this.$refs.purpose_list.setSelected(this.selectedPurpose);
      }
    },
    selectPurpose(val) {
      this.editItem.selectedPurpose = val;
      this.errorItem.purpose_list = "";
    },
    resetForm() {
      this.editItem = {};
      this.srcImageFile = null;
      this.imageFilePath = null;
      this.$refs.purpose_list.setSelected("-1");
      this.displayDate = new Date();
      this.editedIndex = -1;
    },
    async submitForm() {
      var isVaild = await this.validVisitorForm();
      if (!isVaild) {
        return;
      }
      if (this.editedIndex === -1) {
        toast = Toast.fire({
          icon: "warning",
          title: "Please Wait!! Creating New Visitor",
          timer: 0,
        });
      } else {
        toast = Toast.fire({
          icon: "warning",
          title: "Please Wait!! Updating Visitor",
          timer: 0,
        });
      }
      this.editItem.visitor_date = this.visitor_date;
      this.editItem.imageFilePath = this.imageFilePath;
      this.$parent.submitForm(this.editItem, this.editedIndex);
      this.resetForm();
    },
    edit(item) {
      this.selectPurpose(item.visitor_purpose_id.value);
      this.editItem = item;
      this.editedIndex = item.visitor_id;
      this.editItem.selectedPurpose = item.visitor_purpose_id.value;
      this.$refs.purpose_list.setSelected(item.visitor_purpose_id.value);
      this.srcImageFile =
        item.visitor_document != "" &&
        item.visitor_document != null
          ? item.visitor_document
          : null;
      this.displayDate = moment(String(item.visitor_date)).format(
        "DD-MMM-YYYY"
      );
      this.visitor_date = moment(String(item.visitor_date)).format(
        "YYYY-MM-DD"
      );
    },
    validVisitorForm() {
      this.isFormValid = true;
      if (this.editItem.selectedPurpose == -1) {
        this.errorItem.purpose_list = "Purpose is required";
        this.isFormValid = false;
      } else {
        this.errorItem.purpose_list = "";
      }
      if (
        this.editItem.visitor_name == null ||
        this.editItem.visitor_name == ""
      ) {
        this.errorItem.visitor_name = "Visitor Name  is required";
        this.isFormValid = false;
      } else {
        this.errorItem.visitor_name = "";
      }
      if (
        this.editItem.visitor_phone == null ||
        this.editItem.visitor_phone == ""
      ) {
        this.errorItem.visitor_phone = "Phone Number is required";
        this.isFormValid = false;
      } else {
        if (!this.mobileRegex.test(this.editItem.visitor_phone)) {
          this.errorItem.visitor_phone = "Enter valid mobile number";
          isFormValid = false;
        }
        this.errorItem.visitor_phone = "";
      }
        if (!this.emailRegex.test(this.editItem.visitor_email)) {
          this.errorItem.visitor_email = "Enter valid email";
          isFormValid = false;
        } else {
          this.errorItem.visitor_email = "";
        }
      if (
        this.editItem.visitor_id_card == null ||
        this.editItem.visitor_id_card == ""
      ) {
        this.errorItem.visitor_id_card = "Visitor ID Card is required";
        this.isFormValid = false;
      } else {
        this.errorItem.visitor_id_card = "";
      }
      if (
        this.editItem.visitor_no_of_person == null ||
        this.editItem.visitor_no_of_person == ""
      ) {
        this.errorItem.visitor_no_of_person = "Number of Person is required";
        this.isFormValid = false;
      } else {
        this.errorItem.visitor_no_of_person = "";
      }

      return this.isFormValid;
    },
  },
};
</script>

<style scoped>
.imageContainer {
  width: 100%;
  height: 150px;
  border: grey dashed 2px;
  border-radius: 10px;
  position: relative;
  background: #ffffff;
  text-align: center;
  padding: 10px;
  margin: auto;
  margin-bottom: 40px;
  cursor: pointer;
}

.imageContainer img {
  /* width: 100%; */
  height: 100%;
}

.imageContainer input {
  width: 100%;
  height: 100%;
  opacity: 0;
  position: absolute;
  top: 0;
  left: 0;
}
</style>


