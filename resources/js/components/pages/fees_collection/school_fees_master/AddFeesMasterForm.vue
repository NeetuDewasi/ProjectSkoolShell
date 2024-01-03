<template>
  <div class="card">
    <div class="card-body">
      <div class="heading-layout1">
        <div class="item-title">
          <h3>Add Fees Master Form</h3>
        </div>
      </div>
      <form class="new-added-form">
        <div class="row gutters-8">
          <div class="col-12 form-group">
            <label>Class <span class="text-danger bolder">*</span></label>
            <Select2
              ref="class_list"
              placeholder="--SELECT A CLASS--"
              :items="class_list"
              @change="selectClass"
              :selectedId="selectedClass"
              :class="errorItem.class_list != '' ? 'error-field' : ''"
            />
            <span
              class="error-label"
              v-if="errorItem.class_list != ''"
              v-text="errorItem.class_list"
            >
            </span>
          </div>
          <div class="col-12 form-group">
            <label>Fees Group <span class="text-danger bolder">*</span></label>
            <Select2
              ref="fees_group_list"
              placeholder="--SELECT FEES GROUP--"
              :items="fees_group_list"
              :selectedId="selectedFeesGroup"
              @change="selectFeesGroup"
              :class="errorItem.fees_group_list != '' ? 'error-field' : ''"
            />
            <span
              class="error-label"
              v-if="errorItem.fees_group_list != ''"
              v-text="errorItem.fees_group_list"
            >
            </span>
          </div>
          <div class="col-12 form-group">
            <label>Fees Type <span class="text-danger bolder">*</span></label>
            <Select2
              ref="fees_type_list"
              placeholder=" -- SELECT FEES TYPE"
              :items="fees_type_list"
              :selectedId="selectedFeesTypes"
              @change="selectFeesType"
              :class="errorItem.fees_type_list != '' ? 'error-field' : ''"
            />
            <span
              class="error-label"
              v-if="errorItem.fees_type_list != ''"
              v-text="errorItem.fees_type_list"
            >
            </span>
          </div>
          <div class="col-12 form-group">
            <label>Due Date<span class="text-danger">*</span></label>
            <DatePicker
              format="DD-MMM-YYYY"
              value-type="format"
              type="date"
              placeholder="Select a date"
              v-model="displayDate1"
              :disabled-date="disabledBeforeToday"
              class="form-control vue-datepicker my-0"
              :class="errorItem.fees_master_due_date != '' ? 'error-field' : ''"
            />
            <span
              class="error-label"
              v-if="errorItem.fees_master_due_date != ''"
              v-text="errorItem.fees_master_due_date"
            >
            </span>
          </div>
          <div class="col-12 form-group">
            <label>Amount <span class="text-danger bolder">*</span></label>
            <input
              type="text"
              placeholder="Enter Amont"
              class="form-control"
              v-model="editItem.fees_master_amount"
              :class="errorItem.fees_master_amount != '' ? 'error-field' : ''"
              @keyup="
                editItem.fees_master_amount != ''
                  ? (errorItem.fees_master_amount = '')
                  : ''
              "
            />
            <span
              class="error-label"
              v-if="errorItem.fees_master_amount != ''"
              v-text="errorItem.fees_master_amount"
            >
            </span>
          </div>
          <div class="col-12 form-group">
            <label>Fine Type<span class="text-danger bolder">*</span></label>
            <div class="form-group mt-3">
              <input
                type="radio"
                class="form-radio-input"
                value="none"
                name="fine_type"
                v-model="editItem.fees_master_fine_type"
              />
              <span for="" class="ml-2">None</span>
              <input
                type="radio"
                class="form-radio-input ml-3"
                value="percantage"
                name="fine_type"
                v-model="editItem.fees_master_fine_type"
              />
              <span for="" class="ml-1">Percentage</span>
              <input
                type="radio"
                class="form-radio-input ml-3"
                value="fixed-amount"
                name="fine_type"
                v-model="editItem.fees_master_fine_type"
              />
              <span for="" class="ml-1">Fix Amount</span>
            </div>
          </div>
          <div
            class="col-12 form-group"
            v-if="editItem.fees_master_fine_type != 'none'"
          >
            <label>Fine Value</label>
            <input
              type="text"
              placeholder="Enter Fine Amount"
              class="form-control"
              v-model="editItem.fees_master_fine_amount"
              :class="
                errorItem.fees_master_fine_amount != '' ? 'error-field' : ''
              "
              @keyup="
                editItem.fees_master_fine_amount != ''
                  ? (errorItem.fees_master_fine_amount = '')
                  : ''
              "
            />
            <span
              class="error-label"
              v-if="errorItem.fees_master_fine_amount != ''"
              v-text="errorItem.fees_master_fine_amount"
            >
            </span>
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
        fees_master_fine_type: "none",
      },
      fees_group_list: [],
      fees_type_list: [],
      class_list: [],
      errorItem: {
        fees_master_fine_type: "",
        fees_master_amount: "",
        fees_master_fine_amount: "",
        fees_group_list: "",
        fees_type_list: "",
        class_list: "",
        fees_master_due_date: "",
      },
      selectedFeesGroup: -1,
      selectedFeesTypes: -1,
      selectedClass: -1,
      selectedFeesGroupName: "",
      selectedClassName: "",
      displayDate1: "",
      fees_master_due_date: moment(new Date()).format("YYYY-MM-DD"),
    };
  },
  computed: {
    formBtn: function () {
      return this.editedIndex !== -1 ? "Update" : "Save";
    },
    resetButton: function () {
      return this.editedIndex === -1 ? "Reset" : "Cancel";
    },
  },
  mounted() {
    this.getClassFeesTypeData();
  },
  watch: {
    displayDate1: function (val) {
      this.displayDate1 = val;
      this.fees_master_due_date = moment(new Date(val)).format("YYYY-MM-DD");
    },
    "editItem.fees_master_fine_type": function (val) {
      this.log(val);
    },
  },
  methods: {
    disabledBeforeToday(date) {
      const today = new Date();
      today.setHours(0, 0, 0, 0);

      return date < today;
    },
    getSelectedClassName() {
      this.class_list.forEach((e) => {
        if (e.value == this.selectedClass) {
          this.selectedClassName = e.name;
        }
      });
    },
    getSelectedFeesGroupName() {
      this.room_type_list.forEach((e) => {
        if (e.value == this.selectFeesGroup) {
          this.selectedFeesGroupName = e.name;
        }
      });
    },
    // async getEditData() {
    //   const res = await this.callApi(
    //     "get",
    //     `/api/school/fees_collection/fees_master/edit/${this.$route.params.edit_id}`,
    //     null
    //   );
    //   if (res.status == 200) {
    //     var data = res.data;
    //     if (data.status == "success") {
    //       this.editItem = data.fees_master;
    //       this.selectClass(data.fees_master.fees_master_class.value);
    //       this.selectedFeesGroup =
    //         data.fees_master.fees_master_fees_group.value;
    //       this.selectedFeesTypes = data.fees_master.fees_master_fees_type.value;
    //       this.$refs.fees_group_list.setSelected(
    //         data.fees_master.fees_master_fees_group.value
    //       );
    //       this.displayDate1 = moment(
    //         String(data.fees_master.fees_master_due_date)
    //       ).format("DD-MMM-YYYY");
    //       this.fees_master_due_date = moment(
    //         String(data.fees_master.fees_master_due_date)
    //       ).format("YYYY-MM-DD");
    //     }
    //   }
    // },
    async getClassData() {
      const res = await this.callApi(
        "get",
        `/api/school/fees_collection/fees_master/class_list`,
        null
      );

      if (res.status == 200) {
        var data = res.data;
        this.class_list = data.class_list;
        this.$refs.class_list.updateList(data.class_list);
      }
    },
    async selectClass(val) {
      this.editItem.selectedClass = val;
      this.errorItem.class_list = "";
      this.fees_group_list = [];
      this.$refs.fees_group_list.updateList([]);
      if (this.editItem.selectedClass != -1) {
        var formData = new FormData();
        formData.append("class_id", this.editItem.selectedClass);
        const res = await this.callApi(
          "post",
          `/api/school/fees_collection/fees_master/fees_group_list`,
          formData
        );

        if (res.status == 200) {
          var data = res.data;
          if (data.status == "success") {
            this.fees_group_list = data.fees_group_list;
            this.$refs.fees_group_list.updateList(data.fees_group_list);
            this.$refs.fees_group_list.setSelected(this.selectedFeesGroup);
          }
        }
      }
    },
    selectFeesGroup(val) {
      this.editItem.selectedFeesGroup = val;
      this.errorItem.fees_group_list = "";
    },
    selectFeesType(val) {
      this.editItem.selectedFeesTypes = val;
      this.errorItem.fees_type_list = "";
    },
    async getClassFeesTypeData() {
      const res = await this.callApi(
        "get",
        `/api/school/fees_collection/fees_master/data_list`,
        null
      );

      if (res.status == 200) {
        var data = res.data;
        this.fees_type_list = data.fees_type_list;
        this.class_list = data.class_list;
        this.$refs.class_list.updateList(data.class_list);
        this.$refs.class_list.setSelected(this.selectedClass);

        this.$refs.fees_type_list.updateList(data.fees_type_list);
        this.$refs.fees_type_list.setSelected(this.selectedFeesTypes);
      }
    },
    resetForm() {
      this.editItem = {
        fees_master_fine_type: "none",
      };
      this.displayDate1 = "";
      this.$refs.fees_group_list.setSelected("-1");
      this.$refs.class_list.setSelected("-1");
      this.$refs.fees_type_list.setSelected("-1");
      this.editedIndex = -1;
    },
    async submitForm() {
      var isVaild = await this.validFeesMasterForm();
      if (!isVaild) {
        return;
      }
      if (this.editedIndex === -1) {
        toast = Toast.fire({
          icon: "warning",
          title: "Please Wait!! Creating New Fees Master",
          timer: 0,
        });
      } else {
        toast = Toast.fire({
          icon: "warning",
          title: "Please Wait!! Updating Fees Master",
          timer: 0,
        });
      }
      this.editItem.fees_master_due_date = this.fees_master_due_date;
      this.$parent.submitForm(this.editItem, this.editedIndex);
      this.resetForm();
    },
    edit(item) {
      this.selectClass(item.fees_master_class.value);
      this.selectFeesType(item.fees_master_fees_type.value);
      this.editItem = item;
      this.editedIndex = item.fees_master_id;
      this.editItem.selectedClass = item.fees_master_class.value;
      this.editItem.selectedFeesTypes = item.fees_master_fees_type.value;
      this.$refs.class_list.setSelected(item.fees_master_class.value);
      this.$refs.fees_type_list.setSelected(item.fees_master_fees_type.value);
      this.editItem.selectedFeesGroup = item.fees_master_fees_group.value;
      setTimeout(() => {
          this.$refs.fees_group_list.setSelected(item.fees_master_fees_group.value);
      }, 500);
      this.displayDate1 = moment(String(item.fees_master_due_date)).format(
        "DD-MMM-YYYY"
      );
      this.fees_master_due_date = moment(String(item.fees_master_due_date)).format(
        "YYYY-MM-DD"
      );
    },

    validFeesMasterForm() {
      let isFormValid = true;
      if (this.editItem.selectedClass == -1) {
        this.errorItem.class_list = "Class is required";
        isFormValid = false;
      } else {
        this.errorItem.class_list = "";
      }
      if (this.editItem.selectedFeesGroup == -1) {
        this.errorItem.fees_group_list = "Fees Group is required";
        isFormValid = false;
      } else {
        this.errorItem.fees_group_list = "";
      }
      if (this.editItem.selectedFeesTypes == -1) {
        this.errorItem.fees_type_list = "Fees Type is required";
        this.isFormValid = false;
      } else {
        this.errorItem.fees_type_list = "";
      }
      if (
        this.editItem.fees_master_amount == null ||
        this.editItem.fees_master_amount == ""
      ) {
        this.errorItem.fees_master_amount = "Fine Amount is required";
        isFormValid = false;
      } else {
        this.errorItem.fees_master_amount = "";
      }
      if (this.displayDate1 == null || this.displayDate1 == "") {
        this.errorItem.fees_master_due_date = "Due Date is required";
        isFormValid = false;
      } else {
        this.errorItem.fees_master_due_date = "";
      }
      return isFormValid;
    },
  },
};
</script>


<style scoped>
</style>
