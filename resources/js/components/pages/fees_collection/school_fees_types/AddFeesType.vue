<template>
  <div class="card">
    <div class="card-body">
      <div class="heading-layout1">
        <div class="item-title">
          <h3>Add Fees Type Form</h3>
        </div>
      </div>
      <form class="new-added-form">
        <div class="row gutters-20">
          <div class="col-12 form-group">
            <label>Name <span class="text-danger bolder">*</span></label>
            <input
              type="text"
              placeholder="Enter Fees Type Name"
              class="form-control"
              v-model="editItem.fees_type_name"
              :class="errorItem.fees_type_name != '' ? 'error-field' : ''"
              @keyup="
                editItem.fees_type_name != ''
                  ? (errorItem.fees_type_name = '')
                  : ''
              "
            />
            <span
              class="error-label"
              v-if="errorItem.fees_type_name != ''"
              v-text="errorItem.fees_type_name"
            >
            </span>
          </div>
          <div class="col-12 form-group">
            <label>Fees Code <span class="text-danger bolder">*</span></label>
            <input
              type="text"
              placeholder=""
              class="form-control"
              v-model="editItem.fees_type_fees_code"
              :class="errorItem.fees_type_fees_code != '' ? 'error-field' : ''"
              @keyup="
                editItem.fees_type_fees_code != ''
                  ? (errorItem.fees_type_fees_code = '')
                  : ''
              "
            />
            <span
              class="error-label"
              v-if="errorItem.fees_type_fees_code != ''"
              v-text="errorItem.fees_type_fees_code">
            </span>
          </div>
          <div class="col-12 form-group">
            <label>Description</label>
            <textarea
              class="textarea form-control"
              name="message"
              id="form-message"
              cols=""
              rows=""
              v-model="editItem.fees_type_description"
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
                btn btn-fill-sm rounded mg-t-30
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
        fees_type_name: "",
        fees_type_fees_code: "",
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
      var isVaild = await this.validFeesTypeForm();
      if (!isVaild) {
        return;
      }
      if(this.editedIndex === -1){
        toast = Toast.fire({
          icon: "warning",
          title: "Please Wait!! Creating new Fees Type",
          timer: 0,
        });
      } else {
        toast = Toast.fire({
        icon: "warning",
        title: "Please Wait!! Updating Fees Type",
        timer: 0,
      });
      }
      this.$parent.submitForm(this.editItem,this.editedIndex);
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
      this.editedIndex = item.fees_type_id;
    },
    validFeesTypeForm() {
      this.isFormValid = true;
      if (
        this.editItem.fees_type_name == null ||
        this.editItem.fees_type_name == ""
      ) {
        this.errorItem.fees_type_name = "Fees Type is required";
        this.isFormValid = false;
      } else {
        this.errorItem.fees_type_name = "";
      }
      if (
        this.editItem.fees_type_fees_code == null ||
        this.editItem.fees_type_fees_code == ""
      ) {
        this.errorItem.fees_type_fees_code = "Fees Code is required";
        this.isFormValid = false;
      } else {
        this.errorItem.fees_type_fees_code = "";
      }
      return this.isFormValid;
    },
  },
};
</script>


<style scoped>
</style>
