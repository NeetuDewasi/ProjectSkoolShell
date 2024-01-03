<template>
  <div>
    <div class="dashboard-content-one">
      <Breadcrumb pageTitle="Fees Group" :breadcrumbList="breadcrumbList" />
      <div class="row gutters-20">
        <div class="col-5">
          <AddFeesGroup ref="fees_groups" />
        </div>
        <div class="col-7">
          <div class="card height-auto">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>Fees Groups</h3>
                </div>
              </div>
              <div class="table table-responsive" v-show="!noData">
                <Table
                  :key="tableKey"
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
      <!-- Fees Group List Area End Here -->
      <Footer />
    </div>
  </div>
</template>

<script>
var toast;
import AddFeesGroup from "./AddFeesGroup.vue";
export default {
  components: {
    AddFeesGroup,
  },
  data() {
    return {
      breadcrumbList: [
        {
          to: { name: "school.dashboard" },
          name: "Home",
        },
        {
          name: "Fees Group",
        },
      ],
      fees_groups: [],
      initFeesGroup: [],
      tableHead: {
        items: {
          item1: { label: "Sr.No." },
          item2: { label: "Class Name" },
          item3: { label: "Fees Group Name" },
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
        `/api/school/fees_collection/fees_groups`,
        null
      );
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.initFeesGroup = JSON.parse(JSON.stringify(data.fees_groups));
          this.fees_groups = data.fees_groups;
          this.initTable();
        } else {
          toast = Toast.fire({
            icon: "error",
            title: "Something went wrong",
            timer: 2500,
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
      this.fees_groups.forEach((element) => {
        this.tableData.push({
          item: element,
          data: {
            item1: element.fees_group_id,
            item2:
              element.fees_class_id != null ? element.fees_class_id.name : "",
            item3: element.fees_group_name,
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
        "fees_class_id",
        item.selectedClass ? item.selectedClass : ""
      );
      data.append(
        "fees_group_name",
        this.editItem.fees_group_name ? this.editItem.fees_group_name : ""
      );
      data.append(
        "fees_group_description",
        this.editItem.fees_group_description
          ? this.editItem.fees_group_description
          : ""
      );
      let url = "";

      if (this.editedIndex !== -1) {
        url = `/api/school/fees_collection/fees_groups/update/${this.editedIndex}`;
      } else {
        url = `/api/school/fees_collection/fees_groups/save`;
      }
      const res = await this.callApi("post", url, data);

      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          if (this.noData) {
            this.noData = false;
          }
          this.editItem = {};
          if (this.editedIndex !== -1) {
            this.fees_groups[this.editIndex] = data.fees_group;
            this.tableData[this.editIndex] = data.fees_group;
            this.initTable();
          } else {
            this.fees_groups.unshift(data.fees_group);
            var element = data.fees_group;
            this.tableData.unshift({
              item: element,
              data: {
                item1: element.fees_group_id,
                item2:
                  element.fees_class_id != null
                    ? element.fees_class_id.name
                    : "",
                item3: element.fees_group_name,
              },
              action: {
                edit: true,
                delete: true,
              },
            });
          }
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
      this.$refs.fees_groups.edit(item);
      this.editIndex = index;
    },
    async deleteData(item, index) {
      var data = new FormData();
      data.append("fees_group_status", "deleted");
      const res = await this.callApi(
        "post",
        `/api/school/fees_collection/fees_groups/delete/${item.fees_group_id}`,
        data
      );
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.fees_groups.splice(index, 1);
          this.tableData.splice(index, 1);
          SwalCustomBtn.fire("Deleted!", data.message, "success");
        } else {
          toast = Toast.fire({
            icon: data.status,
            title: data.message,
            timer: 2500,
          });
        }
      } else {
        toast = Toast.fire({
          icon: "error",
          title: "Something Went Wrong, Not able to delete",
          timer: 2500,
        });
      }
    },
  },
};
</script>


<style scoped>
</style>
