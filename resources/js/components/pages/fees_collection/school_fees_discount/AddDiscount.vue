
<template>
  <div class="card">
    <div class="card-body">
      <div class="heading-layout1">
        <div class="item-title">
          <h3>Add Fees Discount</h3>
        </div>
      </div>
      <form class="new-added-form" enctype="multipart/form-data">
        <div class="row gutters-20">
          <div class="col-12 form-group">
            <label>Name <strong class="text-danger bolder">*</strong></label>
            <input
              type="text"
              placeholder=""
              class="form-control"
              v-model="editItem.fees_discount_name"
              :class="errorItem.fees_discount_name != '' ? 'error-field' : ''"
              @keyup="
                editItem.fees_discount_name != ''
                  ? (errorItem.fees_discount_name = '')
                  : ''
              "
            />
            <span
              class="error-label"
              v-if="errorItem.fees_discount_name != ''"
              v-text="errorItem.fees_discount_name"
            ></span>
          </div>
          <div class="col-12 form-group">
            <label
              >Discount Code
              <strong class="text-danger bolder">*</strong></label
            >
            <input
              type="text"
              placeholder=""
              class="form-control"
              v-model="editItem.fees_discount_code"
              :class="errorItem.fees_discount_code != '' ? 'error-field' : ''"
              @keyup="
                editItem.fees_discount_code != ''
                  ? (errorItem.fees_discount_code = '')
                  : ''
              "
            />
            <span
              class="error-label"
              v-if="errorItem.fees_discount_code != ''"
              v-text="errorItem.fees_discount_code"
            ></span>
          </div>
          <div class="col-12 form-group">
            <label>Amount <strong class="text-danger bolder">*</strong></label>
            <input
              type="text"
              placeholder=""
              class="form-control"
              v-model="editItem.fees_discount_amount"
              :class="errorItem.fees_discount_amount != '' ? 'error-field' : ''"
              @keyup="
                editItem.fees_discount_amount != ''
                  ? (errorItem.fees_discount_amount = '')
                  : ''
              "
            />
            <span
              class="error-label"
              v-if="errorItem.fees_discount_amount != ''"
              v-text="errorItem.fees_discount_amount"
            ></span>
          </div>
          <div class="col-12 form-group">
            <label>Description</label>
            <textarea
              class="textarea form-control"
              name="message"
              id="form-message"
              cols=""
              rows=""
              v-model="editItem.fees_discount_description"
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
      editedIndex: -1,
      editItem: {},
      errorItem: {
        fees_discount_name: "",
        fees_discount_code: "",
        fees_discount_amount: "",
      },
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
  methods: {
    resetForm(){
        this.editItem = {};
		this.editedIndex = -1;
    },
    async submitForm() {
      var isVaild = await this.validDiscountForm();
      if (!isVaild) {
        return;
      }
      toast = Toast.fire({
        icon: "warning",
        title: "Please Wait!! Creating new Discount",
        timer: 0,
      });
      this.$parent.submitForm(this.editItem,this.editedIndex);
      this.resetForm();

    },
    edit(item) {
      this.editItem = item;
      this.editedIndex = item.fees_discount_id;
    },
    validDiscountForm() {
      this.isFormValid = true;
      if (
        this.editItem.fees_discount_name == null ||
        this.editItem.fees_discount_name == ""
      ) {
        this.errorItem.fees_discount_name = "Fees Discount Name is required";
        this.isFormValid = false;
      } else {
        this.errorItem.fees_discount_name = "";
      }
      if (
        this.editItem.fees_discount_code == null ||
        this.editItem.fees_discount_code == ""
      ) {
        this.errorItem.fees_discount_code = "Fees Discount Code is required";
        this.isFormValid = false;
      } else {
        this.errorItem.fees_discount_code = "";
      }
      if (
        this.editItem.fees_discount_amount == null ||
        this.editItem.fees_discount_amount == ""
      ) {
        this.errorItem.fees_discount_amount =
          "Fees Discount Amount is required";
        this.isFormValid = false;
      } else {
        this.errorItem.fees_discount_amount = "";
      }

      return this.isFormValid;
    },
  },
};
</script>


<style scoped>
</style>
