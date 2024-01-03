<template>
  <div>
    <div class="dashboard-content-one">
      <Breadcrumb pageTitle="Room Type" :breadcrumbList="breadcrumbList" />
      <div class="row gutters-20">
        <div class="col-5">
          <AddRoomType ref="room_types" />
        </div>
        <div class="col-7">
          <div class="card height-auto">
            <div class="card-body">
              <div class="heading-layout1 mb-5">
                <div class="item-title">
                  <h3>Room Type List</h3>
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
import AddRoomType from "./AddRoomType.vue";
export default {
  components: {
    AddRoomType,
  },
  data() {
    return {
      breadcrumbList: [
        {
          to: { name: "school.dashboard" },
          name: "Home",
        },
        {
          name: "Room Type",
        },
      ],
      room_types: [],
      initRoomType: [],
      tableHead: {
        items: {
          item1: { label: "Sr.No." },
          item2: { label: "Hostel Name" },
          item3: { label: "Room Type" },
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
        `/api/school/hostel/room_type`,
        null
      );
      if (res.status == 200) {
        var data = res.data;
        this.log("Hostel",res);
        if (data.status == "success") {
          this.initRoomType = JSON.parse(JSON.stringify(data.room_types));
          this.room_types = data.room_types;
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
      this.room_types.forEach((element) => {
        this.tableData.push({
          item: element,
          data: {
            item1: element.room_type_id,
            item2: element.hostel_name != null ? element.hostel_name.name : "",
            item3: element.room_type_name,
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
      data.append(
        "room_type_name",
        this.editItem.room_type_name ? this.editItem.room_type_name : ""
      );
      data.append(
        "room_hostel_id",
        this.editItem.selectedHostel ? this.editItem.selectedHostel : ""
      );
      data.append(
        "room_type_description",
        this.editItem.room_type_description
          ? this.editItem.room_type_description
          : ""
      );
      let $url = "";
      if (this.editedIndex !== -1) {
        $url = `/api/school/hostel/room_type/update/${this.editedIndex}`;
      } else {
        $url = `/api/school/hostel/room_type/save`;
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
            this.room_types[this.editIndex] = data.room_type;
            this.tableData[this.editIndex] = data.room_type;
            this.initTable();
          } else {
            this.room_types.unshift(data.room_type);
            var element = data.room_type;
            this.tableData.unshift({
              item: element,
              data: {
                item1: element.room_type_id,
                item2: element.room_type_name,
                item3:
                  element.room_hostel_id != null
                    ? element.room_hostel_id.name
                    : "",
              },
              action: {
                edit: true,
                delete: true,
              },
            });
          }
          this.$refs.room_types.resetForm();
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
      this.$refs.room_types.edit(item);
      this.editIndex = index;
    },
    async deleteData(item, index) {
      var data = new FormData();
      data.append("room_type_status", "deleted");
      const res = await this.callApi(
        "post",
        `/api/school/hostel/room_type/delete/${item.room_type_id}`,
        data
      );

      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.room_types.splice(index, 1);
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
