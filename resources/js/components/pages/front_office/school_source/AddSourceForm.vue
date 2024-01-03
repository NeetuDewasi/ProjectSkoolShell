<template>
  <div class="card">
    <div class="card-body">
      <div class="heading-layout1">
        <div class="item-title">
          <h3>Add Source</h3>
        </div>
      </div>
      <form class="new-added-form">
        <div class="row">
          <div class="col-12 form-group">
            <label>Source <span class="text-danger bold">*</span></label>
            <input
              type="text"
              placeholder=""
              class="form-control"
              v-model="editItem.source_name"
              :class="errorItem.source_name != '' ? 'error-field' : ''"
              @keyup="
                editItem.source_name != ''
                  ? (errorItem.source_name = '')
                  : ''
              "
            />
            <span
              class="error-label"
              v-if="errorItem.source_name != ''"
              v-text="errorItem.source_name"
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
              v-model="editItem.source_description"
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
        source_name: "",
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
        var isVaild = await this.validSourceForm();
      if (!isVaild) {
        return;
      }
      if(this.editedIndex === -1){
        toast = Toast.fire({
            icon: "warning",
            title: "Please Wait!! Creating new Source",
            timer: 0,
        });
      } else {
        toast = Toast.fire({
            icon: "warning",
            title: "Please Wait!! Updating Source",
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
      this.editedIndex = item.source_id;
    },
    validSourceForm() {
      this.isFormValid = true;
      if (
        this.editItem.source_name == null ||
        this.editItem.source_name == ""
      ) {
        this.errorItem.source_name = "Source Name  is required";
        this.isFormValid = false;
      } else {
        this.errorItem.source_name = "";
      }
      return this.isFormValid;
    },
  },
};
</script>


<style scoped>
</style>
