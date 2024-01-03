<template>
  <div class="card">
    <div class="card-body">
      <div class="heading-layout1">
        <div class="item-title">
          <h3>Add Phone Call Log</h3>
        </div>
      </div>
      <form class="new-added-form">
        <div class="row">
          <div class="col-lg-6 col-12 form-group">
            <label>Name <span class="text-danger bolder">*</span></label>
            <input
              type="text"
              placeholder="Please Enter Your Name"
              class="form-control"
              v-model="editItem.phone_name"
              :class="errorItem.phone_name != '' ? 'error-field' : ''"
              @keyup="
                editItem.phone_name != '' ? (errorItem.phone_name = '') : ''
              "
            />
            <span
              class="error-label"
              v-if="errorItem.phone_name != ''"
              v-text="errorItem.phone_name"
            >
            </span>
          </div>
          <div class="col-lg-6 col-12 form-group">
            <label
              >Phone Number <span class="text-danger bolder">*</span></label
            >
            <input
              type="phone"
              placeholder="Please Enter Your Phone Number"
              class="form-control"
              v-model="editItem.phone_phone"
              :class="errorItem.phone_phone != '' ? 'error-field' : ''"
            />
            <span
              class="error-label"
              v-if="errorItem.phone_phone != ''"
              v-text="errorItem.phone_phone"
            >
            </span>
          </div>
          <div class="col-lg-6 col-12 form-group">
            <label>Date <span class="text-danger bolder">*</span></label>
            <DatePicker
              format="DD-MMM-YYYY"
              value-type="format"
              type="date"
              placeholder="Select a date"
              v-model="displayDate1"
              :disabled-date="disabledAfterToday"
              class="form-control vue-datepicker my-0"
              :class="errorItem.phone_date != '' ? 'error-field' : ''"
            />
            <span
              class="error-label"
              v-if="errorItem.phone_date != ''"
              v-text="errorItem.phone_date"
            >
            </span>
          </div>
          <div class="col-lg-6 col-12 form-group">
            <label>Next Follow Up Date</label>
            <DatePicker
              format="DD-MMM-YYYY"
              value-type="format"
              type="date"
              placeholder="Select a date"
              v-model="displayDate2"
              :disabled-date="disabledBeforeDate1"
              class="form-control vue-datepicker my-0"
            />
          </div>
          <div class="col-12 form-group">
   <label>Call Duration</label>
            <div class="row">
              <div class="col-6">
                  <label>Minute</label>
                <input
                  type="text"
                  placeholder="Enter Minute"
                  class="form-control"
                  v-model="editItem.phone_call_duration_minute"
                />
              </div>
              <div class="col-6">
                  <label>Seconds</label>
                <input
                  type="text"
                  placeholder="Enter Seconds"
                  class="form-control"
                  v-model="editItem.phone_call_duration_seconds"
                />
              </div>
            </div>
          </div>
          <div class="col-12 form-group">
            <label>Call Type</label>
            <div class="form-group">
              <input
                type="radio"
                class="form-radio-input"
                value="incoming"
                v-model="editItem.phone_call_type"
              />
              <span for="" class="ml-2">Incoming</span>
              <input
                type="radio"
                class="form-radio-input ml-3"
                value="outgoing"
                v-model="editItem.phone_call_type"
              />
              <span for="" class="ml-1">Outgonig</span>
            </div>
          </div>
          <div class="col-12 form-group">
            <label>Description</label>
            <textarea
              class="textarea form-control"
              name="message"
              id="form-message"
              cols="10"
              rows="8"
              v-model="editItem.phone_description"
            ></textarea>
          </div>
          <div class="col-12 form-group">
            <label>Note</label>
            <textarea
              class="textarea form-control"
              name="message"
              id="form-message"
              cols="10"
              rows="8"
              v-model="editItem.phone_note"
            ></textarea>
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
			breadcrumbList: [
				{
					to: { name: "school.dashboard" },
					name: "Home",
				},
				{
					name: "Add Phone Call Log",
				},
			],
            editedIndex:-1,
			editItem: {},
			errorItem: {
				phone_name: "",
				phone_date: "",
				phone_phone: "",
			},
            mobileRegex: /^[5-9][0-9]{9}$/,
            displayDate1 : "",
            displayDate2: "",
            phone_date: moment(new Date()).format("YYYY-MM-DD"),
            phone_next_date: moment(new Date()).format("YYYY-MM-DD"),
		};
	},
	mounted() {
		// this.$parent.loadOtherScript();
		if (this.$route.params.edit_id) {
			this.getEditData();
		}
	},
  watch: {
    displayDate1: function (val) {
      this.displayDate1 = val;
      this.phone_date = moment(new Date(val)).format("YYYY-MM-DD");
      this.errorItem.phone_date = "";
      if (val == null || val == "")
        this.errorItem.phone_date = "Date is required";
    },
    displayDate2: function (val) {
        if(!this.firstTime){
            this.phone_next_date = moment(new Date(val)).format("YYYY-MM-DD");
        }
      this.displayDate2 = val;
    },
    // "editItem.phone_phone": function (val) {
    //   this.errorItem.phone_phone = "";
    //   if (val == null || val == "") {
    //     this.errorItem.phone_phone = "Mobile No. is required";
    //   }
    //   if (val && !this.mobileRegex.test(val)) {
    //     this.errorItem.phone_phone = "Enter Valid 10 Digit Mobile id";
    //   }
    // },
  },
  computed: {
    formBtn: function () {
      return this.editedIndex !== -1 ? "Update" : "Save";
    },
    resetButton: function () {
      return this.editedIndex === -1 ? "Reset" : "Cancel";
    },
  },
  methods: {
    disabledAfterToday(date) {
      const today = new Date();
      today.setHours(0, 0, 0, 0);

      return date > today;
    },

    disabledBeforeDate1(date) {
      const today = new Date();
      today.setHours(0, 0, 0, 0);

      return date < today;
    },
    resetForm() {
      this.editItem = {
        phone_call_type: "incoming",
      };
      this.editedIndex = -1;
      this.displayDate1 = new Date();
      this.displayDate2 = "";
    },
    async submitForm() {
        // return this.log(this.phone_next_date);
      var isVaild = await this.validPhoneLogForm();
      if (!isVaild) {
        return;
      }
      if (this.editedIndex === -1) {
        toast = Toast.fire({
          icon: "warning",
          title: "Please Wait!! Creating New Phone Call Log",
          timer: 0,
        });
      } else {
        toast = Toast.fire({
          icon: "warning",
          title: "Please Wait!! Updating Phone Call Log",
          timer: 0,
        });
      }

      this.editItem.phone_date = this.phone_date;
      this.editItem.phone_next_date = this.phone_next_date;
      this.$parent.submitForm(this.editItem, this.editedIndex);
      this.resetForm();
    },
    edit(item) {
      this.editItem = item;
      this.editedIndex = item.phone_id;
      this.displayDate1 = moment(String(item.phone_date)).format(
        "DD-MMM-YYYY"
      );
      this.displayDate2 = moment(String(item.phone_next_date)).format(
        "DD-MMM-YYYY"
      );
      this.phone_date = moment(String(item.phone_date)).format(
        "YYYY-MM-DD"
      );
      this.phone_next_date = moment(String(item.phone_next_date)).format(
        "YYYY-MM-DD"
      );
    },
    validPhoneLogForm() {
      let isFormValid = true;
      if (this.editItem.phone_name == null || this.editItem.phone_name == "") {
        this.errorItem.phone_name = "Name is required";
        isFormValid = false;
      } else {
        this.errorItem.phone_name = "";
      }
      if (this.phone_date == null || this.phone_date == "") {
        this.errorItem.phone_date = "Date is required";
        isFormValid = false;
      } else {
        this.errorItem.phone_date = "";
      }
      if (
        this.editItem.phone_phone == null ||
        this.editItem.phone_phone == ""
      ) {
        this.errorItem.phone_phone = "Phone Number is required";
        isFormValid = false;
      } else {
        if (!this.mobileRegex.test(this.editItem.phone_phone)) {
          this.errorItem.phone_phone = "Enter valid mobile number";
          isFormValid = false;
        }
        this.errorItem.phone_phone = "";
      }
      return isFormValid;
    },
  },
};
</script>


<style scoped>
</style>
