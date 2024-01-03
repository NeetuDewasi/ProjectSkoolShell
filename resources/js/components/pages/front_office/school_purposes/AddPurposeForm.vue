<template>
  <div class="card">
    <div class="card-body">
      <div class="heading-layout1">
        <div class="item-title">
          <h3>Add Purpose</h3>
        </div>
      </div>
      <form class="new-added-form">
        <div class="row">
          <div class="col-12 form-group">
            <label>Purpose <span class="text-danger bold">*</span></label>
            <input
              type="text"
              placeholder="Enter Purpose Name"
              class="form-control"
              v-model="editItem.purpose_name"
              :class="errorItem.purpose_name != '' ? 'error-field' : ''"
              @keyup="
                editItem.purpose_name != ''
                  ? (errorItem.purpose_name = '')
                  : ''
              "
            />
            <span
              class="error-label"
              v-if="errorItem.purpose_name != ''"
              v-text="errorItem.purpose_name"
            >
            </span>
          </div>
          <div class="col-12 form-group">
            <label>Description</label>
            <textarea
              class="textarea form-control"
              name="message"
              id="form-message"
              cols="0"
              rows="0"
              v-model="editItem.purpose_description"
            ></textarea>
          </div>
        </div>
        <div class="d-flex justify-content-end mg-t-30">
          <button
            type="button"
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
      editItem: {},
      editedIndex: -1,
      errorItem: {
        purpose_name: "",
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
        var isVaild = await this.validPurposeForm();
      if (!isVaild) {
        return;
      }
      toast = Toast.fire({
        icon: "warning",
        title: "Please Wait!! Creating new Purpose",
        timer: 0,
      });
      this.$parent.submitForm(this.editItem,this.editedIndex);
      this.resetForm();
    },
    resetForm(){
        this.editItem = {};
		this.editedIndex = -1;
    },
    edit(item) {
      this.editItem = item;
      this.editedIndex = item.source_id;
    },
    validPurposeForm() {
      this.isFormValid = true;
      if (
        this.editItem.purpose_name == null ||
        this.editItem.purpose_name == ""
      ) {
        this.errorItem.purpose_name = "Purpose Name  is required";
        this.isFormValid = false;
      } else {
        this.errorItem.purpose_name = "";
      }
      return this.isFormValid;
    },
  },
};
</script>


<style scoped>
</style>
