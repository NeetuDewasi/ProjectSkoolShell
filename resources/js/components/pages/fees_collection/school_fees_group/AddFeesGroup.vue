
<template>
  <div class="card">
    <div class="card-body">
      <div class="heading-layout1">
        <div class="item-title">
          <h3>Add Fees Group Form</h3>
        </div>
      </div>
      <form class="new-added-form">
        <div class="row gutters-20">
          <div class="col-12 form-group">
            <label>Class<span class="text-danger bolder">*</span></label>
            <Select2
                ref="class_list"
                placeholder=" --SELECT A CLASS-- "
                :items="class_list"
                :selectedId="selectedClass"
                @change="selectClass"
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
            <label> Name <span class="text-danger bolder">*</span></label>
            <input
              type="text"
              placeholder=""
              class="form-control"
              v-model="editItem.fees_group_name"
              :class="errorItem.fees_group_name != '' ? 'error-field' : ''"
              @keyup="
                editItem.fees_group_name != ''
                  ? (errorItem.fees_group_name = '')
                  : ''
              "
            />
            <span
                class="error-label"
                v-if="errorItem.fees_group_name != ''"
                v-text="errorItem.fees_group_name">
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
              v-model="editItem.fees_group_description"
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
      class_list:[],
      errorItem: {
        class_list:"",
        fees_group_name: "",
      },
      selectedClass: -1,
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
  mounted(){
    this.getClassData();
  },
  methods: {
    async getClassData(){
        const res = await this.callApi(
        "get",
        `/api/school/general/get_class_list`,
        null
      );

      if (res.status == 200) {
        var data = res.data;
        this.class_list = data.class_list;
        this.$refs.class_list.updateList(data.class_list);
        this.$refs.class_list.setSelected(this.editItem.selectedClass);
      }
    },
    selectClass(val){
        this.editItem.selectedClass = val;
        this.errorItem.class_list = "";
    },
    resetForm(){
        this.editItem = {};
        this.$refs.class_list.setSelected('-1');
    },
    async submitForm() {
      var isVaild = await this.validFeesGroupForm();
      if (!isVaild) {
        return;
      }
      if(this.editedIndex === -1){
        toast = Toast.fire({
          icon: "warning",
          title: "Please Wait!! Creating new Fees Group",
          timer: 0,
        });
      } else {
        toast = Toast.fire({
        icon: "warning",
        title: "Please Wait!! Updating Fees Group",
        timer: 0,
      });
      }
      this.$parent.submitForm(this.editItem,this.editedIndex);
      // this.editItem = {};
      // this.editedIndex = -1;
      this.resetForm();
    },
    edit(item,index) {
      this.editItem = item;
      this.editedIndex = item.fees_group_id;
      this.editItem.selectedClass = item.fees_class_id.value;
      this.$refs.class_list.setSelected(item.fees_class_id.value);
    },
    validFeesGroupForm() {
      this.isFormValid = true;

      if (this.editItem.selectedClass == null || this.editItem.selectedClass == -1) {
        this.errorItem.class_list = "Classn Name is required";
        this.isFormValid = false;
      } else {
        this.errorItem.class_list = "";
      }
      if (
        this.editItem.fees_group_name == null ||
        this.editItem.fees_group_name == ""
      ) {
        this.errorItem.fees_group_name = "Fees Group Name  is required";
        this.isFormValid = false;
      } else {
        this.errorItem.fees_group_name = "";
      }
      return this.isFormValid;
    },
  },
};
</script>


<style scoped>
</style>
