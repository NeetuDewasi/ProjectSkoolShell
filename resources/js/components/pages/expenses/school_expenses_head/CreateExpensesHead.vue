<template>
  <div class="card">
    <div class="card-body">
      <div class="heading-layout1">
        <div class="item-title">
          <h3>Add Expenses Head</h3>
        </div>
      </div>
      <form class="new-added-form">
        <div class="row gutters-20">
          <div class=" col-12 form-group">
            <label
              >Expenses Head Name
              <span class="text-danger bolder">*</span></label
            >
            <input
              type="text"
              placeholder="Enter Expense Head Name"
              class="form-control"
              v-model="editItem.expense_head_name"
               :class="errorItem.expense_head_name != '' ? 'error-field' : ''" @keyup="
                editItem.expense_head_name != ''
                    ? (errorItem.expense_head_name = '')
                    : ''
            "
            />
           <span
                class="error-label"
                v-if="errorItem.expense_head_name != ''"
                v-text="errorItem.expense_head_name"
            ></span>
          </div>
          <div class=" col-12 mx-auto form-group">
            <label>Description</label>
            <textarea
              class="textarea form-control"
              id="form-message"
              cols=""
              rows=""
              v-model="editItem.expense_head_description"
            ></textarea>
          </div>
        </div>
        <div class="d-flex justify-content-end mg-t-30">
          <button
            type="submit"
            class="btn btn-fill-sm rounded mg-t-30 text-light shadow-dodger-blue bg-dodger-blue"
            @click.prevent="submitForm()"
          >
            {{ formBtn }}
          </button>
          <button
            type="button"
            class="
                ml-3
                btn btn-fill-sm rounded
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
  <!-- Add Expenses Head End Here -->
</template>

<script>
var toast;
export default {
  data() {
    return {
      editedIndex: -1,
      editItem: {},
      errorItem: {
        expense_head_name: "",
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
    async submitForm() {
      var isVaild = await this.validExpenseHeadForm();
      if (!isVaild) {
        return;
      }
      if(this.editedIndex === -1){
        toast = Toast.fire({
        icon: "warning",
        title: "Please Wait!! Updating Expense Head",
        timer: 0,
        });
      } else {
        toast = Toast.fire({
        icon: "warning",
        title: "Please Wait!! Creating new Expense Head",
        timer: 0,
        });
      }
      this.$parent.submitForm(this.editItem);
      this.resetForm();
    //   this.editItem = {};
    //   this.editedIndex = -1;
    },
    resetForm(){
        this.editItem = {};
		this.editedIndex = -1;
    },
    edit(item) {
      this.editItem = item;
      this.editedIndex = item.expense_head_id;
    },
    validExpenseHeadForm() {
      this.isFormValid = true;
      if (this.editItem.expense_head_name == null || this.editItem.expense_head_name == "") {
        this.errorItem.expense_head_name = "Expenses Name  is required";
        this.isFormValid = false;
      } else {
        this.errorItem.expense_head_name = "";
      }
      return this.isFormValid;
    },
  },
};
</script>


<style scoped>
</style>
