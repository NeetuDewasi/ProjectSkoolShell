<template>
  <div>
    <div class="dashboard-content-one">
      <!-- Breadcubs Area Start -->
      <Breadcrumb pageTitle="Fees Master" :breadcrumbList="breadcrumbList" />

      <div class="row gutters-20">
        <div class="col-5">
          <AddFeesMasterForm ref="fees_masters" />
        </div>
        <div class="col-7">
          <div class="card height-auto">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>Fees Master</h3>
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
        <!-- Fees Master List Area End Here -->
      </div>
      <Footer />
    </div>
  </div>
</template>

<script>
var toast;
import AddFeesMasterForm from "./AddFeesMasterForm.vue";
export default {
  components: {
    AddFeesMasterForm,
  },
  data() {
    return {
      breadcrumbList: [
        {
          to: { name: "admin.dashboard" },
          name: "Home",
        },
        {
          name: "Fees Master",
        },
      ],
      fees_masters: [],
      initFeesMasters :[],
      tableHead: {
        items: {
          item1: { label: "Sr.No." },
          item2: { label: "Class" },
          item3: { label: "Fees Group" },
          item4: { label: "Fees Type" },
          item5: { label: "Due Date" },
          item6: { label: "Amount" },
          item7: { label: "Fine Type" },
          item8: { label: "Fine Amount" },
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
  created() {
    toast = Toast.fire({
      icon: "warning",
      title: "Loading Data..",
      timer: 0,
    });
    this.showData();
  },
  mounted() {
    this.$parent.loadOtherScript();
  },
  methods: {
    async showData() {
      this.isLoaded = false;
      const res = await this.callApi(
        "get",
        `/api/school/fees_collection/fees_master`,
        null
      );
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.initFeesMasters = JSON.parse(JSON.stringify(data.fees_masters));
          this.fees_masters = data.fees_masters;
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
      this.fees_masters.forEach((element) => {
        this.tableData.push({
          item: element,
          data: {
            item1: element.fees_master_id,
            item2:
              element.fees_master_class != null
                ? element.fees_master_class.name
                : "",
            item3:
              element.fees_master_fees_group != null
                ? element.fees_master_fees_group.name
                : "",
            item4:
              element.fees_master_fees_type != null
                ? element.fees_master_fees_type.name
                : "",
            item5: Vue.filter("formatDate")(element.fees_master_due_date),
            item6: `${this.rupeesIcon} ${element.fees_master_amount}`,
            item7: element.fees_master_fine_type,
            item8: element.fees_master_fine_amount,
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
      data.append("fees_master_class", this.editItem.selectedClass);
      data.append("fees_master_fees_group", this.editItem.selectedFeesGroup);
      data.append("fees_master_fees_type", this.editItem.selectedFeesTypes);
      data.append(
        "fees_master_due_date",
        this.editItem.fees_master_due_date ? this.editItem.fees_master_due_date : ""
      );
      data.append(
        "fees_master_amount",
        this.editItem.fees_master_amount ? this.editItem.fees_master_amount : ""
      );
      data.append(
        "fees_master_fine_type",
        this.editItem.fees_master_fine_type
          ? this.editItem.fees_master_fine_type
          : ""
      );
      data.append(
        "fees_master_fine_amount",
        this.editItem.fees_master_fine_type != "none"
          ? this.editItem.fees_master_fine_amount
          : 0
      );
      let $url = "";
      if (this.editedIndex !== -1) {
        $url = `/api/school/fees_collection/fees_master/update/${this.editedIndex}`;
      } else {
        $url = `/api/school/fees_collection/fees_master/save`;
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
            this.fees_masters[this.editIndex] = data.fees_master;
            this.tableData[this.editIndex] = data.fees_master;
            this.initTable();
          } else {
            this.fees_masters.unshift(data.fees_master);
            var element = data.fees_master;
            this.tableData.unshift({
              item: element,
              data: {
                item1: element.fees_master_id,
            item2:
              element.fees_master_class != null
                ? element.fees_master_class.name
                : "",
            item3:
              element.fees_master_fees_group != null
                ? element.fees_master_fees_group.name
                : "",
            item4:
              element.fees_master_fees_type != null
                ? element.fees_master_fees_type.name
                : "",
            item5: Vue.filter("formatDate")(element.fees_master_due_date),
            item6: `${this.rupeesIcon} ${element.fees_master_amount}`,
            item7: element.fees_master_fine_type,
            item8: element.fees_master_fine_amount,
              },
              action: {
                edit: true,
                delete: true,
              },
            });
          }
          this.$refs.fees_masters.resetForm();
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
      this.$refs.fees_masters.edit(item);
      this.editIndex = index;
    },
    async deleteData(item, index) {
      var data = new FormData();
      data.append("fees_master_status", "deleted");
      const res = await this.callApi(
        "post",
        `/api/school/fees_collection/fees_master/delete/${item.fees_master_id}`,
        data
      );

      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.fees_masters.splice(index, 1);
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
          timer: 0,
        });
      }
    },
  },
};
</script>


<style scoped>
</style>
