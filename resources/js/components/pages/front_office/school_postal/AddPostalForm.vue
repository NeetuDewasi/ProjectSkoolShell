<template>
  <div class="card">
    <div class="card-body">
        <div class="heading-layout1">
        <div class="item-title">
            <h3>Add Postel</h3>
        </div>
        </div>
        <form class="new-added-form" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-6 col-12 form-group">
            <label
                >From Title
                <span class="text-danger bolder">*</span></label
            >
            <input
                type="text"
                placeholder="From Title.."
                class="form-control"
                v-model="editItem.postal_from_title"
                :class="
                errorItem.postal_from_title != '' ? 'error-field' : ''
                "
                @keyup="
                editItem.postal_from_title != ''
                    ? (errorItem.postal_from_title = '')
                    : ''
                "
            />
            <span
                class="error-label"
                v-if="errorItem.postal_from_title != ''"
                v-text="errorItem.postal_from_title"
            >
            </span>
            </div>
            <div class="col-lg-6 col-12 form-group">
            <label
                >To Title <span class="text-danger bolder">*</span></label
            >
            <input
                type="text"
                placeholder="To Tile.."
                class="form-control"
                v-model="editItem.postal_to_title"
                :class="
                errorItem.postal_to_title != '' ? 'error-field' : ''
                "
                @keyup="
                editItem.postal_to_title != ''
                    ? (errorItem.postal_to_title = '')
                    : ''
                "
            />
            <span
                class="error-label"
                v-if="errorItem.postal_to_title != ''"
                v-text="errorItem.postal_to_title"
            >
            </span>
            </div>
            <div class="col-lg-6 col-12 form-group">
            <label>Reference No<span class="text-danger bolder">*</span></label>
            <input
                type="text"
                placeholder="Enter Reference Number"
                class="form-control"
                v-model="editItem.postal_ref_no"
                :class="
                errorItem.postal_ref_no != '' ? 'error-field' : ''
                "
                @keyup="
                editItem.postal_ref_no != ''
                    ? (errorItem.postal_ref_no = '')
                    : ''
                "
            />
            <span
                class="error-label"
                v-if="errorItem.postal_ref_no != ''"
                v-text="errorItem.postal_ref_no"
            >
            </span>
            </div>
            <div class="col-lg-6 col-12 form-group">
            <label
                >Postel Type
                <span class="text-danger bolder">*</span></label
            >
            <select
                class="form-control"
                placeholder="--SELECT POSTAL TYPE--"
                v-model="editItem.postal_type"
                :class="errorItem.postal_type != '' ? 'error-field' : ''"
                @change="
                editItem.postal_type != ''
                    ? (errorItem.postal_type = '')
                    : ''
                "
            >
                <option selected disabled>PLEASE SELECT</option>
                <option value="receive">Receive</option>
                <option value="dispatch">Dispatch</option>
            </select>
            <span
                class="error-label"
                v-if="errorItem.postal_type != ''"
                v-text="errorItem.postal_type"
            ></span>
            </div>
            <div class="col-lg-6 col-12 form-group">
            <label
                >Select Date
                <span class="text-danger bolder">*</span></label
            >
            <DatePicker
                format="DD-MMM-YYYY"
                value-type="format"
                type="date"
                placeholder="Select a date"
                v-model="displayDate1"
                :default-value="new Date()"
                :disabled-date="disabledAfterToday"
                class="form-control vue-datepicker my-0"
                :class="errorItem.postal_date != '' ? 'error-field' : ''"
            />
            <span
                class="error-label"
                v-if="errorItem.postal_date != ''"
                v-text="errorItem.postal_date"
            >
            </span>
            </div>
            <div class="col-lg-6 col-12 form-group">
            <label
                >Address <span class="text-danger bolder">*</span></label
            >
            <textarea
                class="textarea form-control"
                name="address"
                id="form-message"
                cols=""
                rows=""
                v-model="editItem.postal_address"
                :class="
                errorItem.postal_address != '' ? 'error-field' : ''
                "
                @keyup="
                editItem.postal_address != ''
                    ? (errorItem.postal_address = '')
                    : ''
                "
            ></textarea>
            <span
                class="error-label"
                v-if="errorItem.postal_address != ''"
                v-text="errorItem.postal_address"
            >
            </span>
            </div>
            <div class="col-12 form-group">
            <label>Note</label>
            <textarea
                class="textarea form-control"
                name="message"
                id="form-message"
                cols=""
                rows=""
                v-model="editItem.postal_note"
            ></textarea>
            </div>
            <div class="col-12 form-group">
            <label>Attach Document</label>
            <div class="imageContainer">
                <img :src="selectedImage" alt />
                <input
                type="file"
                accept="image/*"
                @change="imageFileSelect"
                />
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
      editItem: {
        postal_type: "-1",
        postal_date: "",
      },
      errorItem: {
        postal_from_title: "",
        postal_to_title: "",
        postal_type: "",
        postal_date: "",
        postal_address: "",
        postal_ref_no: "",
      },
      imageFilePath: null,
      srcImageFile: null,
      displayDate1: "",
      postal_date: moment(new Date()).format("YYYY-MM-DD"),
    };
  },
  computed: {
    formBtn: function () {
      return this.editedIndex !== -1 ? "Update" : "Save";
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
  watch: {
    displayDate1: function (val) {
      this.displayDate1 = val;
      this.postal_date = moment(new Date(val)).format("YYYY-MM-DD");
      this.errorItem.postal_date = "";
      if (val == null || val == "")
        this.errorItem.postal_date = "Date is required";
    },
  },
  mounted() {
    this.displayDate1 = moment(new Date()).format("DD-MMM-YYYY");
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
    resetForm() {
      this.editItem = {};
      this.srcImageFile = null;
      this.imageFilePath = null;
      this.displayDate1 = new Date();
      this.editedIndex = -1;
    },
    async submitForm() {
      var isVaild = await this.validPostalForm();
      if (!isVaild) {
        return;
      }
      if (this.editedIndex === -1) {
        toast = Toast.fire({
          icon: "warning",
          title: "Please Wait!! Creating New Postal",
          timer: 0,
        });
      } else {
        toast = Toast.fire({
          icon: "warning",
          title: "Please Wait!! Updating Postal",
          timer: 0,
        });
      }
      this.editItem.postal_date = this.postal_date;
      this.editItem.imageFilePath = this.imageFilePath;
      this.$parent.submitForm(this.editItem, this.editedIndex);
      this.resetForm();
    },
    edit(item) {
      this.editItem = item;
      this.editedIndex = item.postal_id;
      this.srcImageFile =
        item.postal_document != "" &&
        item.postal_document != null
          ? item.postal_document
          : null;
      this.displayDate = moment(String(item.postal_date)).format(
        "DD-MMM-YYYY"
      );
      this.postal_date = moment(String(item.postal_date)).format(
        "YYYY-MM-DD"
      );
    },
    validPostalForm() {
      let isFormValid = true;
      if (
        this.editItem.postal_from_title == null ||
        this.editItem.postal_from_title == ""
      ) {
        this.errorItem.postal_from_title = "Postal From Title is required";
        isFormValid = false;
      } else {
        this.errorItem.postal_from_title = "";
      }
      if (
        this.editItem.postal_to_title == null ||
        this.editItem.postal_to_title == ""
      ) {
        this.errorItem.postal_to_title = "Postal To Title is required";
        isFormValid = false;
      } else {
        this.errorItem.postal_to_title = "";
      }
      if (this.postal_date == null || this.postal_date == "") {
        this.errorItem.postal_date = "Postal Date is required";
        isFormValid = false;
      } else {
        this.errorItem.postal_date = "";
      }
      if (
        this.editItem.postal_type == null ||
        this.editItem.postal_type == ""
      ) {
        this.errorItem.postal_type = "Postal Type is required";
        isFormValid = false;
      } else {
        this.errorItem.postal_type = "";
      }
      if (
        this.editItem.postal_address == null ||
        this.editItem.postal_address == ""
      ) {
        this.errorItem.postal_address = "Postal Address is required";
        isFormValid = false;
      } else {
        this.errorItem.postal_address = "";
      }
      if (
        this.editItem.postal_ref_no == null ||
        this.editItem.postal_ref_no == ""
      ) {
        this.errorItem.postal_ref_no = "Reference Number is required";
        isFormValid = false;
      } else {
        this.errorItem.postal_ref_no = "";
      }
      return isFormValid;
    },
  },
};
</script>


<style >
.imageContainer {
  width: 80%;
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
