<template>
  <div class="card">
    <div class="card-body">
      <div class="heading-layout1">
        <div class="item-title">
          <h3>Add New Expense</h3>
        </div>
      </div>
      <form class="new-added-form" enctype="multipart/form-data">
        <div class="row">
          <div class="col-lg-6 col-12 form-group">
            <label
              >Expanse Head <strong class="text-danger bolder">*</strong></label
            >
            <Select2
              ref="expense_head_list"
              :items="expense_head_list"
              @change="selectExpenseHead"
              :selectedId="selectedExpenseHead"
              :class="errorItem.expense_head_list != '' ? 'error-field' : ''"
            />
            <span
              class="error-label"
              v-if="errorItem.expense_head_list != ''"
              v-text="errorItem.expense_head_list"
            >
            </span>
          </div>
          <div class="col-lg-6 col-12 form-group">
            <label>Name <strong class="text-danger bolder">*</strong></label>
            <input
              type="text"
              placeholder="Please Enter Expense Name"
              class="form-control"
              v-model="editItem.expense_name"
              :class="errorItem.expense_name != '' ? 'error-field' : ''"
              @keyup="
                editItem.expense_name != '' ? (errorItem.expense_name = '') : ''
              "
            />
            <span
              class="error-label"
              v-if="errorItem.expense_name != ''"
              v-text="errorItem.expense_name"
            ></span>
          </div>
          <div class="col-lg-6 col-12 form-group">
            <label
              >Invoice Number
              <strong class="text-danger bolder">*</strong></label
            >
            <input
              type="text"
              placeholder="Please Enter Invoice Number"
              class="form-control"
              v-model="editItem.expense_invoice_number"
              :class="
                errorItem.expense_invoice_number != '' ? 'error-field' : ''
              "
              @keyup="
                editItem.expense_invoice_number != ''
                  ? (errorItem.expense_invoice_number = '')
                  : ''
              "
            />
            <span
              class="error-label"
              v-if="errorItem.expense_invoice_number != ''"
              v-text="errorItem.expense_invoice_number"
            ></span>
          </div>
          <div class="col-lg-6 col-12 form-group">
            <label>Amount <strong class="text-danger bolder">*</strong></label>
            <input
              type="text"
              placeholder="Please enter Amount"
              class="form-control"
              v-model="editItem.expense_amount"
              :class="errorItem.expense_amount != '' ? 'error-field' : ''"
              @keyup="
                editItem.expense_amount != ''
                  ? (errorItem.expense_amount = '')
                  : ''
              "
            />
            <span
              class="error-label"
              v-if="errorItem.expense_amount != ''"
              v-text="errorItem.expense_amount"
            ></span>
          </div>
          <div class="col-lg-6 col-12 form-group">
            <label
              >Select Date
              <strong class="text-danger bolder">*</strong>
            </label>
            <DatePicker
              format="DD-MMM-YYYY"
              value-type="format"
              type="date"
              placeholder="Select a date"
              v-model="displayDate"
              :default-value="new Date()"
              :disabled-date="disabledAfterToday"
              class="form-control vue-datepicker my-0"
              :class="errorItem.expense_date != '' ? 'error-field' : ''"
            />
            <span
              class="error-label"
              v-if="errorItem.expense_date != ''"
              v-text="errorItem.expense_date"
            ></span>
          </div>
          <div class="col-lg-6 col-12 form-group">
            <label>Description</label>
            <textarea
              class="textarea form-control"
              name="message"
              id="form-message"
              cols=""
              rows=""
              v-model="editItem.expense_description"
            ></textarea>
          </div>
          <div class="col-12 form-group">
            <label class="text-dark-medium">Attach Document</label>
            <div class="imageContainer">
              <img :src="selectedImage" alt />
              <input
                type="file"
                accept="image/*"
                @change="imageFileSelect"
                :class="errorItem.imageFilePath != '' ? 'error-field' : ''"
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
      editItem: {},
      expense_head_list: [],
      errorItem: {
        expense_name: "",
        expense_invoice_number: "",
        expense_amount: "",
        expense_date: "",
        expense_head_list: "",
      },
      imageFilePath: null,
      srcImageFile: null,
      selectedExpenseHead: -1,
      displayDate: "",
      expense_date: moment(new Date()).format("YYYY-MM-DD"),
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
    displayDate: function (val) {
      this.displayDate = val;
      this.expense_date = moment(new Date(val)).format("YYYY-MM-DD");
    },
  },
  mounted() {
    this.displayDate = moment(new Date()).format("DD-MMM-YYYY");
    this.getExpenseHeadData();
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
    async getExpenseHeadData() {
      const res = await this.callApi(
        "get",
        `/api/school/expenses/expenses/expense_head_list`,
        null
      );

      if (res.status == 200) {
        var data = res.data;
        this.expense_head_list = data.expense_head_list;
        this.$refs.expense_head_list.updateList(data.expense_head_list);
        this.$refs.expense_head_list.setSelected(this.selectedExpenseHead);
      }
    },
    selectExpenseHead(val) {
      this.editItem.selectedExpenseHead = val;
      this.errorItem.expense_head_list = "";
    },
    resetForm() {
      this.editItem = {};
      this.srcImageFile = null;
      this.imageFilePath = null;
      this.$refs.expense_head_list.setSelected("-1");
      this.displayDate = null;
      this.editedIndex = -1;
    },
    async submitForm() {
      var isVaild = await this.validExpensesForm();
      if (!isVaild) {
        return;
      }
      if (this.editedIndex === -1) {
        toast = Toast.fire({
          icon: "warning",
          title: "Please Wait!! Creating New Expenses",
          timer: 0,
        });
      } else {
        toast = Toast.fire({
          icon: "warning",
          title: "Please Wait!! Updating Expenses",
          timer: 0,
        });
      }
      this.editItem.expense_date = this.expense_date;
      this.editItem.imageFilePath = this.imageFilePath;
      this.$parent.submitForm(this.editItem, this.editedIndex);
      this.resetForm();
    },
    edit(item) {
      this.selectExpenseHead(item.expense_head.value);
      this.editItem = item;
      this.editedIndex = item.expense_id;
      this.editItem.selectedExpenseHead = item.expense_head.value;
      this.$refs.expense_head_list.setSelected(item.expense_head.value);
      this.srcImageFile =
        item.expense_documents != "" &&
        item.expense_documents != null
          ? item.expense_documents
          : null;
      this.displayDate = moment(String(item.expense_date)).format(
        "DD-MMM-YYYY"
      );
      this.expense_date = moment(String(item.expense_date)).format(
        "YYYY-MM-DD"
      );
    },

    validExpensesForm() {
      let isFormValid = true;
      if (this.editItem.selectedExpenseHead == null || this.editItem.selectedExpenseHead == -1) {
        this.errorItem.expense_head_list = "Expense Head is required";
        isFormValid = false;
      } else {
        this.errorItem.expense_head_list = "";
      }
      if (
        this.editItem.expense_name == null ||
        this.editItem.expense_name == ""
      ) {
        this.errorItem.expense_name = "Expense Name  is required";
        isFormValid = false;
      } else {
        this.errorItem.expense_name = "";
      }
      if (
        this.editItem.expense_invoice_number == null ||
        this.editItem.expense_invoice_number == ""
      ) {
        this.errorItem.expense_invoice_number =
          "Expense Invoice Number is required";
        isFormValid = false;
      } else {
        this.errorItem.expense_invoice_number = "";
      }
      if (
        this.editItem.expense_amount == null ||
        this.editItem.expense_amount == ""
      ) {
        this.errorItem.expense_amount = "Expense Amount is required";
        this.isFormValid = false;
      } else {
        this.errorItem.expense_amount = "";
      }
      if (this.expense_date == null || this.expense_date == "") {
        this.errorItem.expense_date = "Expense Date is required";
        isFormValid = false;
      } else {
        this.errorItem.expense_date = "";
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

