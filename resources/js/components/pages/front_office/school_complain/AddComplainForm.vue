
<template>
  <div class="card">
    <div class="card-body">
      <div class="heading-layout1">
        <div class="item-title">
          <h3>Add Complain Form</h3>
        </div>
      </div>
      <form class="new-added-form" enctype="multipart/form-data">
        <div class="row">
          <div class="col-lg-6 col-12 form-group">
            <label
              >Complain Type <span class="text-danger bolder">*</span></label
            >
            <Select2
              ref="complain_type_list"
              placeholder=" --SELECT COMPLAIN TYPE-- "
              :items="complain_type_list"
              :selectedId="selectedComplainType"
              @change="selectComplainType"
              :class="errorItem.complain_type_list != '' ? 'error-field' : ''"
            />
            <span
              class="error-label"
              v-if="errorItem.complain_type_list != ''"
              v-text="errorItem.complain_type_list"
            >
            </span>
          </div>
          <div class="col-lg-6 col-12 form-group">
            <label>Source <span class="text-danger bolder">*</span></label>
            <Select2
              ref="source_list"
              placeholder="--SELECT SOURCE--"
              :items="source_list"
              :selectedId="selectedSource"
              @change="selectSource"
              :class="errorItem.source_list != '' ? 'error-field' : ''"
            />
            <span
              class="error-label"
              v-if="errorItem.source_list != ''"
              v-text="errorItem.source_list"
            >
            </span>
          </div>
          <div class="col-lg-6 col-12 form-group">
            <label>Complain By <span class="text-danger bolder">*</span></label>
            <input
              type="text"
              placeholder="Enter Your Name"
              class="form-control"
              v-model="editItem.complain_person"
              :class="errorItem.complain_person != '' ? 'error-field' : ''"
              @keyup="
                editItem.complain_person != ''
                  ? (errorItem.complain_person = '')
                  : ''
              "
            />
            <span
              class="error-label"
              v-if="errorItem.complain_person != ''"
              v-text="errorItem.complain_person"
            >
            </span>
          </div>
          <div class="col-lg-6 col-12 form-group">
            <label>Phone <span class="text-danger bolder">*</span></label>
            <input
              type="phone"
              placeholder="Enter Your Phone Number"
              class="form-control"
              v-model="editItem.complain_phone"
              :class="errorItem.complain_phone != '' ? 'error-field' : ''"
            />
            <span
              class="error-label"
              v-if="errorItem.complain_phone != ''"
              v-text="errorItem.complain_phone"
            >
            </span>
          </div>
          <div class="col-lg-6 col-12 form-group">
            <label
              >Select Date
              <span class="text-danger bolder">*</span>
            </label>
            <DatePicker
              format="DD-MM-YYYY"
              value-type="format"
              type="date"
              placeholder="Select a date"
              v-model="displayDate"
              :default-value="new Date()"
              :disabled-date="disabledAfterToday"
              class="form-control vue-datepicker my-0"
            />
            <span
              class="error-label"
              v-if="errorItem.complain_date != ''"
              v-text="errorItem.complain_date"
            >
            </span>
          </div>
          <div class="col-lg-6 col-12 form-group">
            <label>Action Taken</label>
            <input
              type="text"
              placeholder=""
              class="form-control"
              v-model="editItem.complain_action_by"
            />
          </div>
          <div class="col-lg-6 col-12 form-group">
            <label>Assigned</label>
            <input
              type="text"
              placeholder=""
              class="form-control"
              v-model="editItem.complain_assigned"
            />
          </div>
          <div class="col-12 form-group">
            <label>Descrpition</label>
            <textarea
              class="textarea form-control"
              name="descrpition"
              id="form-message"
              cols=""
              rows=""
              v-model="editItem.complain_description"
            ></textarea>
          </div>
          <div class="col-12 form-group">
            <label>Attach Document</label>
            <span
              class="error-label"
              v-if="errorItem.imageFilePath != ''"
              v-text="errorItem.imageFilePath"
            ></span>
            <div class="imageContainer">
              <img :src="selectedImage" height="100" alt="" />
              <input type="file" @change="imageFileSelect" />
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
              complain_date: "",
      },
      complain_type_list: [],
      source_list: [],
      errorItem: {
        complain_type_list: "",
        complain_phone: "",
        source_list: "",
        complain_person: "",
        complain_date: "",
      },
      selectedSource: -1,
      selectedComplainType: -1,
      imageFilePath: null,
      srcImageFile: null,
      mobileRegex: /^[5-9][0-9]{9}$/,
      displayDate: "",
      complain_date: moment(new Date()).format("YYYY-MM-DD"),
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
  mounted() {
    this.displayDate = moment(new Date()).format("DD-MMM-YYYY");
    this.getComplainTypeData();
    this.getSourceData();
  },
  watch: {
    displayDate: function (val) {
      this.displayDate = val;
      this.complain_date = moment(new Date(val)).format("YYYY-MM-DD");
      this.errorItem.complain_date = "";
      if (val == null || val == "")
        this.errorItem.complain_date = "Date is required";
    },
    "editItem.complain_phone": function (val) {
      this.errorItem.complain_phone = "";
      if (val == null || val == "") {
        this.errorItem.complain_phone = "Mobile No. is required";
      }
      if (val && !this.mobileRegex.test(val)) {
        this.errorItem.complain_phone = "Enter Valid 10 Digit Mobile id";
      }
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
      this.errorItem.imageFilePath = "";
    },
    async getComplainTypeData() {
      const res = await this.callApi(
        "get",
        `/api/school/front_office/complain/complain_type_list`,
        null
      );

      if (res.status == 200) {
        var data = res.data;
        this.complain_type_list = data.complain_type_list;
        this.$refs.complain_type_list.updateList(data.complain_type_list);
        this.$refs.complain_type_list.setSelected(this.selectedComplainType);
      }
    },

    async getSourceData() {
      const res = await this.callApi(
        "get",
        `/api/school/front_office/complain/source_list`,
        null
      );

      if (res.status == 200) {
        var data = res.data;
        this.source_list = data.source_list;
        this.$refs.source_list.updateList(data.source_list);
        this.$refs.source_list.setSelected(this.selectedSource);
      }
    },
    selectSource(val) {
      this.editItem.selectedSource = val;
      this.errorItem.source_list = "";
    },
    selectComplainType(val) {
      this.editItem.selectedComplainType = val;
      this.errorItem.complain_type_list = "";
    },
    resetForm() {
      this.editItem = {};
      this.$refs.complain_type_list.setSelected("-1");
      this.$refs.source_list.setSelected("-1");
      this.srcImageFile = null;
      this.imageFilePath = null;
      this.displayDate = null;
      this.editedIndex = -1;
    },
    async submitForm() {
      var data = new FormData();
      var isVaild = await this.validComplainForm();
      if (!isVaild) {
        return;
      }
      if (this.editedIndex === -1) {
        toast = Toast.fire({
          icon: "warning",
          title: "Please Wait!! Creating New Complain",
          timer: 0,
        });
      } else {
        toast = Toast.fire({
          icon: "warning",
          title: "Please Wait!! Updating Complain",
          timer: 0,
        });
      }
      this.editItem.complain_date = this.complain_date;
      this.editItem.imageFilePath = this.imageFilePath;
      this.$parent.submitForm(this.editItem, this.editedIndex);
      this.resetForm();
    },
    edit(item) {
      this.selectComplainType(item.complain_type_id.value);
      this.selectSource(item.complain_source_id.value);
      this.editItem = item;
      this.editedIndex = item.complain_id;
      this.editItem.selectedComplainType = item.complain_type_id.value;
      this.$refs.complain_type_list.setSelected(item.complain_type_id.value);
      this.editItem.selectedSource = item.complain_source_id.value;
      this.$refs.source_list.setSelected(item.complain_source_id.value);
      this.srcImageFile =
        item.complain_document != "" && item.complain_document != null
          ? item.complain_document
          : null;
      this.displayDate = moment(String(item.complain_date)).format(
        "DD-MMM-YYYY"
      );
      this.complain_date = moment(String(item.complain_date)).format(
        "YYYY-MM-DD"
      );
    },
    validComplainForm() {
      let isFormValid = true;
      if (this.editItem.selectedComplainType == -1) {
        this.errorItem.complain_type_list = "Complain Type is required";
        isFormValid = false;
      } else {
        this.errorItem.complain_type_list = "";
      }
      if (this.editItem.selectedSource == -1) {
        this.errorItem.source_list = "Source is required";
        isFormValid = false;
      } else {
        this.errorItem.source_list = "";
      }
      if (
        this.editItem.complain_person == null ||
        this.editItem.complain_person == ""
      ) {
        this.errorItem.complain_person = "Complain Person Name is required";
        isFormValid = false;
      } else {
        this.errorItem.complain_person = "";
      }
      if (this.complain_date == null || this.complain_date == "") {
        this.errorItem.complain_date = "Date is required";
        isFormValid = false;
      } else {
        this.errorItem.complain_date = "";
      }
      if (
        this.editItem.complain_phone == null ||
        this.editItem.complain_phone == ""
      ) {
        this.errorItem.complain_phone = "Phone is required";
        isFormValid = false;
      } else {
        if (!this.mobileRegex.test(this.editItem.complain_phone)) {
          this.errorItem.complain_phone = "Enter valid mobile number";
          isFormValid = false;
        }
        this.errorItem.complain_phone = "";
      }
      return isFormValid;
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



