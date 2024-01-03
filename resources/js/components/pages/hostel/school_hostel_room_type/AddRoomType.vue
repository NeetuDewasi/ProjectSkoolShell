<template>
  <div class="card">
    <div class="card-body">
      <div class="heading-layout1">
        <div class="item-title">
          <h3>Add Room Type</h3>
        </div>
      </div>
      <form class="new-added-form" enctype="multipart/form-data">
        <div class="row gutters-20">
          <div class="col-12 form-group">
            <label>Hostel <strong class="text-danger bolder">*</strong></label>
            <Select2
              ref="hostel_list"
              placeholder=" --SELECT HOSTEL--"
              :items="hostel_list"
              @change="selectHostel"
              :selectedId="selectedHostel"
              :class="errorItem.hostel_list != '' ? 'error-field' : ''"
            />
            <span
              class="error-label"
              v-if="errorItem.hostel_list != ''"
              v-text="errorItem.hostel_list"
            >
            </span>
          </div>
          <div class="col-12 form-group">
            <label
              >Room Type<strong class="text-danger bolder">*</strong></label
            >
            <input
              type="text"
              placeholder="Enter Room Type Name"
              class="form-control"
              v-model="editItem.room_type_name"
              :class="errorItem.room_type_name != '' ? 'error-field' : ''"
              @keyup="
                editItem.room_type_name != ''
                  ? (errorItem.room_type_name = '')
                  : ''
              "
            />
            <span
              class="error-label"
              v-if="errorItem.room_type_name != ''"
              v-text="errorItem.room_type_name"
            ></span>
          </div>
          <div class="col-12 form-group">
            <label>Description</label>
            <textarea
              class="textarea form-control"
              v-model="editItem.room_type_description"
              id="form-message"
              cols=""
              rows=""
            ></textarea>
          </div>
        </div>
        <div class="d-flex justify-content-end mg-t-30">
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
      hostel_list: [],
      errorItem: {
        room_type_name: "",
        hostel_list: "",
      },
      selectedHostel: -1,
      //   isFormValid:true
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
    this.getHostelData();
  },
  methods: {
    async getHostelData() {
      const res = await this.callApi(
        "get",
        `/api/school/hostel/room_type/hostel_list`,
        null
      );

      if (res.status == 200) {
        var data = res.data;
        this.hostel_list = data.hostel_list;
        this.$refs.hostel_list.updateList(data.hostel_list);
        this.$refs.hostel_list.setSelected(this.selectedHostel);
      }
    },
    selectHostel(val) {
      this.editItem.selectedHostel = val;
      this.errorItem.hostel_list = "";
    },
    resetForm() {
      this.editItem = {};
      this.$refs.hostel_list.setSelected("-1");
      this.editedIndex = -1;
    },
    async submitForm() {
      var isVaild = await this.validRoomTypeForm();
      if (!isVaild) {
        return;
      }
      if (this.editedIndex === -1) {
        toast = Toast.fire({
          icon: "warning",
          title: "Please Wait!! Creating Room Type",
          timer: 0,
        });
      } else {
        toast = Toast.fire({
          icon: "warning",
          title: "Please Wait!! Updating new Room Type",
          timer: 0,
        });
      }
      this.$parent.submitForm(this.editItem, this.editedIndex);
      this.resetForm();
    },
    edit(item) {
      this.editItem = item;
      this.editedIndex = item.room_type_id;
      this.editItem.selectedHostel = item.room_hostel_id;
      this.$refs.hostel_list.setSelected(item.room_hostel_id);
            this.selectHostel(item.room_hostel_id);
    },
    validRoomTypeForm() {
      this.isFormValid = true;
      if (
        this.editItem.selectedHostel == null ||
        this.editItem.selectedHostel == -1
      ) {
        this.errorItem.hostel_list = "Hostel is required";
        this.isFormValid = false;
      } else {
        this.errorItem.hostel_list = "";
      }
      if (
        this.editItem.room_type_name == null ||
        this.editItem.room_type_name == ""
      ) {
        this.errorItem.room_type_name = "Room Type Name  is required";
        this.isFormValid = false;
      } else {
        this.errorItem.room_type_name = "";
      }
      return this.isFormValid;
    },
  },
};
</script>


<style scoped>
</style>
