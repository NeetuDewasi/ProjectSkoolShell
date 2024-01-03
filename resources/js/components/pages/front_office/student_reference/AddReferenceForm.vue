<template>
  <div class="card">
    <div class="card-body">
      <div class="heading-layout1">
        <div class="item-title">
          <h3>Add Reference</h3>
        </div>
      </div>
      <form class="new-added-form">
        <div class="row">
          <div class="col-12 form-group">
            <label>Reference <span class="text-danger bolder">*</span></label>
            <input
              type="text"
              placeholder=""
              class="form-control"
              v-model="editItem.reference_name"
              :class="errorItem.reference_name != '' ? 'error-field' : ''"
              @keyup="
                editItem.reference_name != ''
                  ? (errorItem.reference_name = '')
                  : ''
              "
            />
            <span
              class="error-label"
              v-if="errorItem.reference_name != ''"
              v-text="errorItem.reference_name"
            >
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
              v-model="editItem.reference_description"
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
  <!-- Add Reference Area End Here -->
</template>

<script>
var toast;
export default {
  data() {
    return {
      editedIndex: -1,
      editItem: {},
      errorItem: {
        reference_name: "",
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
         var isVaild = await this.validReferenceForm();
      if (!isVaild) {
        return;
      }
      if(this.editedIndex === -1){
        toast = Toast.fire({
            icon: "warning",
            title: "Please Wait!! Creating new Reference",
            timer: 0,
        });
      } else {
        toast = Toast.fire({
            icon: "warning",
            title: "Please Wait!! Updating Reference",
            timer: 0,
        });
      }
      this.$parent.submitForm(this.editItem,this.editedIndex);
      this.resetForm();
    },
     resetForm(){
        this.editItem = {};
		this.editedIndex = -1;
    },
    edit(item) {
      this.editItem = item;
      this.editedIndex = item.reference_id;
    },
     validReferenceForm() {
      this.isFormValid = true;
      if (
        this.editItem.reference_name == null ||
        this.editItem.reference_name == ""
      ) {
        this.errorItem.reference_name = "Reference Name  is required";
        this.isFormValid = false;
      } else {
        this.errorItem.reference_name = "";
      }
      return this.isFormValid;
    },
  },
};
</script>


<style scoped>
</style>
