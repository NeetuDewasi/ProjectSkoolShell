<template>
  <div>
    <div class="dashboard-content-one">
      <Breadcrumb pageTitle="Hostel Rooms" :breadcrumbList="breadcrumbList" />
      <div class="row gutters-20">
        <div class="col-5">
          <AddHostelRoom ref="hostel_rooms" />
        </div>
        <div class="col-7">
          <div class="card">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>Hostel Rooms</h3>
                </div>
              </div>
              <div class="table table-responsive" v-show="!noData">
                <Table
                  ref="table"
                  :tableData="tableData"
                  :tableHead="tableHead"
                />
              </div>
              <NoData v-show="noData" />
            </div>
          </div>
        </div>
      </div>
      <Footer />
    </div>
  </div>
</template>

<script>
var toast;
import AddHostelRoom from "./AddHostelRoom.vue";
export default {
  components: {
    AddHostelRoom,
  },
  data() {
    return {
      breadcrumbList: [
        {
          to: { name: "school.dashboard" },
          name: "Home",
        },
        {
          name: "Hostel Rooms",
        },
      ],
      hostel_rooms: [],
      initHostelRooms: [],
      tableHead: {
        items: {
          item1: { label: "Sr.No." },
          item2: { label: "Room Name/Number" },
          item3: { label: "Hostel Type" },
          item4: { label: "Room Type" },
          item5: { label: "Number Of Bed" },
          item6: { label: "Cost Per Bed" },
        },
        actions: true,
      },
      tableKey: 0,
      tableData: [],
      isLoaded: false,
      noData: false,
      editItem: {},
      editedIndex: -1,
      editIndex: -1,
      rupeesIcon:'₹'
    };
  },
  mounted() {
    this.$parent.loadOtherScript();
  },
  created() {
    toast = Toast.fire({
      icon: "warning",
      title: "Loading Data..",
      timer: 0,
    });
    this.showData();
  },
  methods: {
    async showData() {
      this.isLoaded = false;
      const res = await this.callApi(
        "get",
        `/api/school/hostel/hostel_room`,
        null
      );
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.initHostelRooms = JSON.parse(JSON.stringify(data.hostel_rooms));
          this.hostel_rooms = data.hostel_rooms;
          this.initTable();
        } else {
          toast = Toast.fire({
            icon: "error",
            title: "Something went wrong",
            timer: 0,
          });
          this.noData = true;
        }
      }
      this.$refs.table.loadTable();
      this.isLoaded = true;
      toast.close();
    },
    initTable() {
      this.tableData = [];
      this.hostel_rooms.forEach((element) => {
        this.tableData.push({
          item: element,
          data: {
            item1: element.hostel_room_id,
            item2: element.hostel_room_name,
            item3:
              element.hostel_room_hostel != null
                ? element.hostel_room_hostel.name
                : "",
            item4:
              element.hostel_room_type != null
                ? element.hostel_room_type.name
                : "",

            item5: element.hostel_room_no_of_bed,
            item6: `${this.rupeesIcon} ${element.hostel_room_cost}`,
          },
          action: {
            edit: true,
            delete: true,
          },
        });
      });
    },
    async submitForm(item, itemId) {
      this.editItem = item;
      this.editedIndex = itemId;
      var data = new FormData();
      data.append("hostel_room_hostel", this.editItem.selectedHostel);
      data.append("hostel_room_type", this.editItem.selectedRoomType);
      data.append(
        "hostel_room_name",
        this.editItem.hostel_room_name ? this.editItem.hostel_room_name : ""
      );
      data.append(
        "hostel_room_no_of_bed",
        this.editItem.hostel_room_no_of_bed
          ? this.editItem.hostel_room_no_of_bed
          : ""
      );
      data.append(
        "hostel_room_id_card",
        this.editItem.hostel_room_id_card
          ? this.editItem.hostel_room_id_card
          : ""
      );
      data.append(
        "hostel_room_cost",
        this.editItem.hostel_room_cost ? this.editItem.hostel_room_cost : ""
      );
      data.append(
        "hostel_room_description",
        this.editItem.hostel_room_description
          ? this.editItem.hostel_room_description
          : ""
      );
      data.append(
        "hostel_room_in_time",
        this.editItem.hostel_room_in_time
          ? this.editItem.hostel_room_in_time
          : ""
      );
      data.append(
        "hostel_room_out_time",
        this.editItem.hostel_room_out_time
          ? this.editItem.hostel_room_out_time
          : ""
      );
      let $url = "";
      if (this.editedIndex !== -1) {
        $url = `/api/school/hostel/hostel_room/update/${this.editedIndex}`;
      } else {
        $url = `/api/school/hostel/hostel_room/save`;
      }
      const res = await this.callApi("post", $url, data);
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          if (this.noData) {
            this.noData = false;
          }
          this.editItem = {};
          if (this.editedIndex !== -1) {
            this.hostel_rooms[this.editIndex] = data.hostel_room;
            this.tableData[this.editIndex] = data.hostel_room;
            this.initTable();
          } else {
            this.hostel_rooms.unshift(data.hostel_room);
            var element = data.hostel_room;
            this.tableData.unshift({
              item: element,
              data: {
                item1: element.hostel_room_id,
                item2: element.hostel_room_name,
                item3:
                  element.hostel_room_hostel != null
                    ? element.hostel_room_hostel.name
                    : "",
                item4:
                  element.hostel_room_type != null
                    ? element.hostel_room_type.name
                    : "",

                item5: element.hostel_room_no_of_bed,
                item6: `${this.rupeesIcon} ${element.hostel_room_cost}`,
              },
              action: {
                edit: true,
                delete: true,
              },
            });
          }
          this.$refs.hostel_rooms.resetForm();
        }
        toast = Toast.fire({
          icon: data.status,
          title: data.message,
          timer: 2500,
        });
      } else {
        toast = Toast.fire({
          icon: "error",
          title: "Something went wrong",
          timer: 2500,
        });
      }
      this.editedIndex = -1;
    },
    edit(item, index) {
      this.$refs.hostel_rooms.edit(item);
      this.editIndex = index;
    },
    async deleteData(item, index) {
      var data = new FormData();
      data.append("hostel_room_status", "deleted");
      const res = await this.callApi(
        "post",
        `/api/school/hostel/hostel_room/delete/${item.hostel_room_id}`,
        data
      );

      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.hostel_rooms.splice(index, 1);
          this.tableData.splice(index, 1);
          if (!this.tableData.length) this.noData = true;
          SwalCustomBtn.fire("Deleted!", data.message, "success");
        } else {
          toast = Toast.fire({
            icon: data.status,
            title: data.message,
            timer: 0,
          });
        }
      } else {
        toast = Toast.fire({
          icon: "error",
          title: "Something Went Wrong, Not able to delete",
          timer: 0,
        });
      }
    },
  },
};
</script>


<style scoped>
</style>
