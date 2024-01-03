<template>
  <div>
    <div class="dashboard-content-one">
      <Breadcrumb pageTitle="Reference" :breadcrumbList="breadcrumbList" />
      <div class="row gutters-20">
        <div class="col-5">
          <AddReferenceForm ref="references" />
        </div>
        <div class="col-7">
          <div class="card height-auto">
            <div class="card-body">
              <div class="item-title">
                <h3>All Reference</h3>
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
      <Footer />
    </div>
  </div>
</template>

<script>
var toast;
import AddReferenceForm from "./AddReferenceForm.vue";
export default {
  components: {
    AddReferenceForm,
  },
  data() {
    return {
      breadcrumbList: [
        {
          to: { name: "admin.dashboard" },
          name: "Home",
        },
        {
          name: "Reference",
        },
      ],
      references: [],
      initReference: [],
      tableHead: {
        items: {
          item1: { label: "Sr.No." },
          item2: { label: "Reference Name" },
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
        `/api/school/front_office/reference`,
        null
      );

      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.initReference = JSON.parse(JSON.stringify(data.references));
          this.references = data.references;
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
      this.references.forEach((element) => {
        this.tableData.push({
          item: element,
          data: {
            item1: element.reference_id,
            item2: element.reference_name,
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
        "reference_name",
        this.editItem.reference_name ? this.editItem.reference_name : ""
      );
      data.append(
        "reference_description",
        this.editItem.reference_description
          ? this.editItem.reference_description
          : ""
      );
      let $url = "";
      if (this.editedIndex !== -1) {
        $url = `/api/school/front_office/reference/update/${this.editItem.reference_id}`;
      } else {
        $url = `/api/school/front_office/reference/save`;
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
            this.references[this.editIndex] = data.reference;
            this.tableData[this.editIndex] = data.reference;
            this.initTable();
          } else {
            this.references.unshift(data.reference);
            var element = data.reference;
            this.tableData.unshift({
              item: element,
              data: {
                item1: element.reference_id,
                item2: element.reference_name,
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
          timer: 0,
        });
      }
      this.editedIndex = -1;
    },
    edit(item) {
      this.$refs.references.edit(item);
      this.editedIndex = item.reference_id;
    },
    async deleteData(item, index) {
      var data = new FormData();
      data.append("reference_status", "deleted");
      const res = await this.callApi(
        "post",
        `/api/school/front_office/reference/delete/${item.reference_id}`,
        data
      );
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.references.splice(index, 1);
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
