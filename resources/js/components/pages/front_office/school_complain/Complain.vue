<template>
  <div>
    <div class="dashboard-content-one">
      <Breadcrumb pageTitle="Complain" :breadcrumbList="breadcrumbList"/>
      <div class="row gutters-20">
        <div class="col-5">
          <AddComplainForm ref="complains" />
        </div>
        <div class="col-7">
          <div class="card height-auto">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>Complain List</h3>
                </div>
              </div>
              <div class="table table-responsive" v-show="!noData">
                <Table
                  ref="table"
                  :tableData="tableData"
				  :responsive= "false"
                  :tableHead="tableHead"
                />
              </div>
              <NoData v-show="noData" />
            </div>
          </div>
        </div>
      </div>
      <!--Complain List End Here -->
      <Footer />
    </div>
  </div>
</template>

<script>
var toast;
import AddComplainForm from "./AddComplainForm.vue";
export default {
  components: {
    AddComplainForm,
  },
  data() {
    return {
      breadcrumbList: [
        {
          to: { name: "school.dashboard" },
          name: "Home",
        },
        {
          name: "Complain",
        },
      ],
      complains: [],
      initComplains:[],
      tableHead: {
        items: {
          item1: { label: "Sr.No." },
          item2: { label: "Complain Type" },
          item3: { label: "Name" },
          item4: { label: "Phone" },
          item5: { label: "Date" },
          item6: { label: "view" },
          item7: { label: "" },
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
        `/api/school/front_office/complain`,
        null
      );
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.initComplains = JSON.parse(JSON.stringify(data.complains));
          this.complains = data.complains;
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
      this.complains.forEach((element) => {
        this.tableData.push({
          item: element,
          data: {
            item1: element.complain_id,
            item2:
              element.complain_type_id != null
                ? element.complain_type_id.name
                : "",
            item3: element.complain_person,
            item4: element.complain_phone,
            item5: Vue.filter("formatDate")(element.complain_date),
            item7: {
              type: "action",
              options: {
                label: "View",
                style: "",
                class: "btn btn-info",
                icon: '<i class="fas fa-eye" ></i>',
                method: this.complainDetail,
              },
            },
            item8: element.complain_document
              ? {
                  type: "action",
                  options: {
                    label: "",
                    style: "",
                    class: "btn",
                    icon: '<i class="fa fa-download"></i>',
                    method: this.download,
                  },
                }
              : "",
          },
          action: {
            edit: true,
            delete: true,
          },
        });
      });
    },
    complainDetail(item) {
      this.$router.push(
        `/school/front_office/complain_view/${item.complain_id}`
      );
    },
    async submitForm(item, itemId) {
      this.editItem = item;
      this.editedIndex = itemId;
      var data = new FormData();
      data.append("complain_type_id", this.editItem.selectedComplainType);
      data.append("complain_source_id", this.editItem.selectedSource);
      data.append(
        "complain_person",
        this.editItem.complain_person ? this.editItem.complain_person : ""
      );
      data.append(
        "complain_phone",
        this.editItem.complain_phone ? this.editItem.complain_phone : ""
      );
      data.append(
        "complain_date",
        this.editItem.complain_date ? this.editItem.complain_date : ""
      );
      data.append(
        "complain_action_by",
        this.editItem.complain_action_by ? this.editItem.complain_action_by : ""
      );
      data.append(
        "complain_assigned",
        this.editItem.complain_assigned ? this.editItem.complain_assigned : ""
      );
      data.append(
        "complain_document",
        this.editItem.complain_document ? this.editItem.complain_document : ""
      );
      data.append("image", this.editItem.imageFilePath ? this.editItem.imageFilePath : "");
      data.append(
        "complain_description",
        this.editItem.complain_description
          ? this.editItem.complain_description
          : ""
      );
      let $url = "";
      if (this.editedIndex !== -1) {
        $url = `/api/school/front_office/complain/update/${this.editedIndex}`;
      } else {
        $url = `/api/school/front_office/complain/save`;
      }
      const res = await this.callApi("post", $url, data,"multipart");
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          if (this.noData) {
            this.noData = false;
          }
          this.editItem = {};
          if (this.editedIndex !== -1) {
            this.complains[this.editIndex] = data.complain;
            this.tableData[this.editIndex] = data.complain;
            this.initTable();
          } else {
            this.complains.unshift(data.complain);
            var element = data.complain;
            this.tableData.unshift({
              item: element,
              data: {
                item1: element.complain_id,
            item2:
              element.complain_type_id != null
                ? element.complain_type_id.name
                : "",
            item3: element.complain_person,
            item4: element.complain_phone,
            item5: Vue.filter("formatDate")(element.complain_date),
            item7: {
              type: "action",
              options: {
                label: "View",
                style: "",
                class: "btn btn-info",
                icon: '<i class="fas fa-eye" ></i>',
                method: this.complainDetail,
              },
            },
            item8: element.complain_document
              ? {
                  type: "action",
                  options: {
                    label: "",
                    style: "",
                    class: "btn",
                    icon: '<i class="fa fa-download"></i>',
                    method: this.download,
                  },
                }
              : "",

              },
              action: {
                edit: true,
                delete: true,
              },
            });
          }
          this.$refs.complains.resetForm();
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
      this.$refs.complains.edit(item);
      this.editIndex = index;
    },
    async deleteData(item, index) {
      var data = new FormData();
      data.append("complain_status", "deleted");
      const res = await this.callApi(
        "post",
        `/api/school/front_office/complain/delete/${item.complain_id}`,
        data
      );

      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.complains.splice(index, 1);
          this.tableData.splice(index, 1);
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
