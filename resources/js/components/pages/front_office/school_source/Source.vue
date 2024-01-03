<template>
  <div>
    <div class="dashboard-content-one">
      <Breadcrumb pageTitle="Source" :breadcrumbList="breadcrumbList" />
      <div class="row gutters-20">
        <div class="col-5">
          <AddSourceForm ref="sources" />
        </div>
        <div class="col-7">
          <div class="card height-auto">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>All Source</h3>
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
      <!-- Source List Area End Here -->
      <Footer />
    </div>
  </div>
</template>

<script>
var toast;
import AddSourceForm from "./AddSourceForm.vue";
export default {
  components: {
    AddSourceForm,
  },
  data() {
    return {
      breadcrumbList: [
        {
          to: { name: "admin.dashboard" },
          name: "Home",
        },
        {
          name: "Source",
        },
      ],
      sources: [],
      initSourceList: [],
      tableHead: {
        items: {
          item1: { label: "Sr.No." },
          item2: { label: "Sorce Name" },
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
        `/api/school/front_office/source`,
        null
      );

      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.initSourceList = JSON.parse(JSON.stringify(data.sources));
          this.sources = data.sources;
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
      this.sources.forEach((element) => {
        this.tableData.push({
          item: element,
          data: {
            item1: element.source_id,
            item2: element.source_name,
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
        "source_name",
        this.editItem.source_name ? this.editItem.source_name : ""
      );
      data.append(
        "source_description",
        this.editItem.source_description ? this.editItem.source_description : ""
      );
      let $url = "";
      if (this.editedIndex !== -1) {
        $url = `/api/school/front_office/source/update/${this.editItem.source_id}`;
      } else {
        $url = `/api/school/front_office/source/save`;
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
            this.sources[this.editIndex] = data.source;
            this.tableData[this.editIndex] = data.source;
            this.initTable();
          } else {
            this.sources.unshift(data.source);
            var element = data.source;
            this.tableData.unshift({
              item: element,
              data: {
                item1: element.source_id,
                item2: element.source_name,
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
      this.$refs.sources.edit(item);
      this.editedIndex = item.source_id;
    },
    async deleteData(item, index) {
      var data = new FormData();
      data.append("source_status", "deleted");
      const res = await this.callApi(
        "post",
        `/api/school/front_office/source/delete/${item.source_id}`,
        data
      );
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.sources.splice(index, 1);
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
