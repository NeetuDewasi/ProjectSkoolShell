
<template>
  <div>
    <div class="dashboard-content-one">
      <!-- Breadcubs Area Start -->
      <Breadcrumb pageTitle="Purpose" :breadcrumbList="breadcrumbList" />
      <!-- End Breadcubs Area -->
      <!-- Purpose List Area Start -->
      <div class="row gutters-20">
        <div class="col-5">
          <AddPurposeForm ref="purposes" />
        </div>
        <div class="col-7">
          <div class="card height-auto">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>All Purpose</h3>
                </div>
              </div>
              <div class="table" v-show="!noData">
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
      <!-- Purpose List Area End Here -->
      <Footer />
    </div>
  </div>
</template>

<script>
var toast;
import AddPurposeForm from "./AddPurposeForm.vue";
export default {
  components: {
    AddPurposeForm,
  },
  data() {
    return {
      breadcrumbList: [
        {
          to: { name: "school.dashboard" },
          name: "Home",
        },
        {
          name: "Purpose",
        },
      ],
      purposes: [],
      initPurposeList: [],
      tableHead: {
        items: {
          item1: { label: "Sr.No." },
          item2: { label: "Purpose Name" },
        },
        actions: true,
      },
      tableData: [],
      isLoaded: false,
      noData: false,
      editItem: {},
      editedIndex: -1,
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
        `/api/school/front_office/purpose`,
        null
      );

      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.initPurposeList = JSON.parse(JSON.stringify(data.purposes));
          this.purposes = data.purposes;
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
      this.purposes.forEach((element) => {
        this.tableData.push({
          item: element,
          data: {
            item1: element.purpose_id,
            item2: element.purpose_name,
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
        "purpose_name",
        this.editItem.purpose_name ? this.editItem.purpose_name : ""
      );
      data.append(
        "purpose_description",
        this.editItem.purpose_description
          ? this.editItem.purpose_description
          : ""
      );
      let $url = "";
      if (this.editedIndex !== -1) {
        $url = `/api/school/front_office/purpose/update/${this.editItem.purpose_id}`;
      } else {
        $url = `/api/school/front_office/purpose/save`;
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
            this.purposes[this.editIndex] = data.purpose;
            this.tableData[this.editIndex] = data.purpose;
            this.initTable();
          } else {
            this.purposes.unshift(data.purpose);
            var element = data.purpose;
            this.tableData.unshift({
              item: element,
              data: {
                item1: element.purpose_id,
                item2: element.purpose_name,
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
    edit(item) {
      this.$refs.purposes.edit(item);
      this.editedIndex = item.purpose_id;
    },
    async deleteData(item, index) {
      var data = new FormData();
      data.append("purpose_status", "deleted");
      const res = await this.callApi(
        "post",
        `/api/school/front_office/purpose/delete/${item.purpose_id}`,
        data
      );

      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.purposes.splice(index, 1);
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
