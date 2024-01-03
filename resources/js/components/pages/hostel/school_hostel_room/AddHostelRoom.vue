<template>
  <div class="card">
    <div class="card-body">
      <div class="heading-layout1">
        <div class="item-title">
          <h3>Add Hostel Room</h3>
        </div>
      </div>
      <form class="new-added-form" enctype="multipart/form-data">
        <div class="row gutters-20">
          <div class="col-12 form-group">
            <label>Hostel Type<span class="text-danger bold">*</span></label>
            <Select2
              ref="hostel_list"
              :items="hostel_list"
              placeholder="--SELECT HOSTEL TYPE--"
              :selectedId="selectedHostel"
              @change="selectHostel"
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
            <label>Room Type <span class="text-danger bold">*</span></label>
            <Select2
              ref="room_type_list"
              :items="room_type_list"
              placeholder="--SELECT ROOM TYPE--"
              :selectedId="selectedRoomType"
              @change="selectRoomType"
              :class="errorItem.room_type_list != '' ? 'error-field' : ''"
            />
            <span
              class="error-label"
              v-if="errorItem.room_type_list != ''"
              v-text="errorItem.room_type_list"
            >
            </span>
          </div>
          <div class="col-12 form-group">
            <label
              >Room Number/Name <span class="text-danger bold">*</span></label
            >
            <input
              type="text"
              placeholder="Enter Room Name/Number"
              class="form-control"
              v-model="editItem.hostel_room_name"
              :class="errorItem.hostel_room_name != '' ? 'error-field' : ''"
              @keyup="
                editItem.hostel_room_name != ''
                  ? (errorItem.hostel_room_name = '')
                  : ''
              "
            />
            <span
              class="error-label"
              v-if="errorItem.hostel_room_name != ''"
              v-text="errorItem.hostel_room_name"
            >
            </span>
          </div>
          <div class="col-12 form-group">
            <label>Number Of Bed <span class="text-danger bold">*</span></label>
            <input
              type="text"
              placeholder="Please Enter No Of Bed"
              class="form-control"
              v-model="editItem.hostel_room_no_of_bed"
              :class="
                errorItem.hostel_room_no_of_bed != '' ? 'error-field' : ''
              "
              @keyup="
                editItem.hostel_room_no_of_bed != ''
                  ? (errorItem.hostel_room_no_of_bed = '')
                  : ''
              "
            />
            <span
              class="error-label"
              v-if="errorItem.hostel_room_no_of_bed != ''"
              v-text="errorItem.hostel_room_no_of_bed"
            >
            </span>
          </div>
          <div class="col-12 form-group">
            <label>Cost Per Bed <span class="text-danger bold">*</span></label>
            <input
              type="text"
              placeholder="Please Enter Room Cost"
              class="form-control"
              v-model="editItem.hostel_room_cost"
              :class="errorItem.hostel_room_cost != '' ? 'error-field' : ''"
              @keyup="
                editItem.hostel_room_cost != ''
                  ? (errorItem.hostel_room_cost = '')
                  : ''
              "
            />
            <span
              class="error-label"
              v-if="errorItem.hostel_room_cost != ''"
              v-text="errorItem.hostel_room_cost"
            >
            </span>
          </div>
          <div class="col-12 form-group">
            <label>Description</label>
            <textarea
              class="textarea form-control"
              name="desc"
              id="form-desc"
              rows=""
              cols=""
              v-model="editItem.hostel_room_description"
            ></textarea>
          </div>
        </div>
        <div class="d-flex justify-content-end mt-5">
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
      room_type_list: [],
      errorItem: {
        hostel_room_name: "",
        hostel_room_no_of_bed: "",
        hostel_room_cost: "",
        hostel_list: "",
        room_type_list: "",
      },
      selectedHostel: -1,
      selectedRoomType: -1,
      selectedHostelName: "",
      selectedRoomTypeName: "",
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
    this.getHostelRoomTypeData();
  },
  methods: {
    getSelectedHostelName() {
      this.hostel_list.forEach((e) => {
        if (e.value == this.editItem.selectedHostel) {
          this.selectedHostelName = e.name;
        }
      });
    },
    getSelectedRoomTypeName() {
      this.room_type_list.forEach((e) => {
        if (e.value == this.editItem.selectedRoomType) {
          this.selectedRoomTypeName = e.name;
        }
      });
    },
    async selectHostel(val) {
      this.editItem.selectedHostel = val;
      this.errorItem.hostel_list = "";
      this.getSelectedHostelName();
      if (this.editItem.selectedHostel == -1) {
        this.room_type_list = [];
        this.$refs.room_type_list.updateList([]);
        return;
      }
      const res = await this.callApi(
        "get",
        `/api/school/hostel/room_type/${this.editItem.selectedHostel}`,
        null
      );

      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.room_type_list = data.hostel_room_types;
          this.$refs.room_type_list.updateList(data.hostel_room_types);
          this.$refs.room_type_list.setSelected(this.selectedRoomType);
        }
      }
    },
    async getHostelRoomTypeData() {
      const res = await this.callApi(
        "get",
        `/api/school/hostel/hostel_room/data_list`,
        null
      );
        console.log('room types',res);
      if (res.status == 200) {
        var data = res.data;
        this.hostel_list = data.hostel_list;
        this.room_type_list = data.room_type_list;
        this.$refs.hostel_list.updateList(data.hostel_list);
        this.$refs.hostel_list.setSelected(this.selectedHostel);
        this.$refs.room_type_list.updateList([]);
        this.$refs.room_type_list.setSelected(this.selectedRoomType);
      }
    },
    selectRoomType(val) {
      this.editItem.selectedRoomType = val;
      this.errorItem.room_type_list = "";
    },
    resetForm() {
      this.editItem = {};
      this.$refs.hostel_list.setSelected("-1");
      this.$refs.room_type_list.setSelected("-1");
      this.editedIndex = -1;
    },
    async submitForm() {
      var isVaild = await this.validHostelRoomForm();
      if (!isVaild) {
        return;
      }
      if (this.editedIndex === -1) {
        toast = Toast.fire({
          icon: "warning",
          title: "Please Wait!! Creating New Hostel Room",
          timer: 0,
        });
      } else {
        toast = Toast.fire({
          icon: "warning",
          title: "Please Wait!! Updating Hostel Room",
          timer: 0,
        });
      }
      this.$parent.submitForm(this.editItem, this.editedIndex);
      this.resetForm();
    },
    edit(item) {
      this.selectHostel(item.hostel_room_hostel.value);
      this.editItem = item;
      this.editedIndex = item.hostel_room_id;
      this.editItem.selectedHostel = item.hostel_room_hostel.value;
      this.$refs.hostel_list.setSelected(item.hostel_room_hostel.value);
      this.editItem.selectedRoomType = item.hostel_room_type.value;
      setTimeout(() => {
          this.$refs.room_type_list.setSelected(item.hostel_room_type.value);
      }, 500);

    },
    validHostelRoomForm() {
      this.isFormValid = true;
      if (this.editItem.selectedHostel == null || this.editItem.selectedHostel == -1) {
        this.errorItem.hostel_list = "Hostel Type is required";
        this.isFormValid = false;
      } else {
        this.errorItem.hostel_list = "";
      }
      if (this.editItem.selectedRoomType == null || this.editItem.selectedRoomType == -1) {
        this.errorItem.room_type_list = "Room Type is required";
        this.isFormValid = false;
      } else {
        this.errorItem.room_type_list = "";
      }
      if (
        this.editItem.hostel_room_name == null ||
        this.editItem.hostel_room_name == ""
      ) {
        this.errorItem.hostel_room_name = "Hostel Room Name  is required";
        this.isFormValid = false;
      } else {
        this.errorItem.hostel_room_name = "";
      }
      if (
        this.editItem.hostel_room_no_of_bed == null ||
        this.editItem.hostel_room_no_of_bed == ""
      ) {
        this.errorItem.hostel_room_no_of_bed = "No Of Bed is required";
        this.isFormValid = false;
      } else {
        this.errorItem.hostel_room_no_of_bed = "";
      }
      if (
        this.editItem.hostel_room_cost == null ||
        this.editItem.hostel_room_cost == ""
      ) {
        this.errorItem.hostel_room_cost = "NHostel Room Cost is required";
        this.isFormValid = false;
      } else {
        this.errorItem.hostel_room_cost = "";
      }

      return this.isFormValid;
    },
  },
};
</script>


<style scoped>
</style>
