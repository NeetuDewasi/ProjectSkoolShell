<template>
  <div>
    <div class="dashboard-content-one">
      <Breadcrumb
        pageTitle="Postel Receive/Dispatch"
        :breadcrumbList="breadcrumbList"
      />
      <div class="row gutters-20">
        <div class="col-5">
          <AddPostalForm ref="postals" />
        </div>
        <div class="col-7">
          <div class="card height-auto">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>Postal Receive & Dispatch List</h3>
                </div>
              </div>
              <div class="table table-responsive" v-show="!noData">
                <Table
                  ref="table"
                  :tableData="tableData"
                  :responsive="false"
                  :tableHead="tableHead"
                />
              </div>
              <NoData v-show="noData" />
            </div>
          </div>
        </div>
      </div>
      <!--Postel Receive/DispatchArea End Here -->
      <Footer />
    </div>
  </div>
</template>

<script>
var toast;
import AddPostalForm from "./AddPostalForm.vue";
export default {
  components: {
    AddPostalForm,
  },
  data() {
    return {
      breadcrumbList: [
        {
          to: { name: "admin.dashboard" },
          name: "Home",
        },
        {
          name: "Postel Receive/Dispatch",
        },
      ],
      postals: [],
      initPostals: [],
      tableHead: {
        items: {
          item1: { label: "Sr.No." },
          item2: { label: "To Title" },
          item3: { label: "Reference No" },
          item4: { label: "From Title" },
          item5: { label: "Postel Type" },
          item6: { label: "Date" },
          item7: { label: "View Detail" },
          item8: { label: "" },
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
        `/api/school/front_office/postal`,
        null
      );
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.initPostals = JSON.parse(JSON.stringify(data.postals));
          this.postals = data.postals;
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
      this.postals.forEach((element) => {
        this.tableData.push({
          item: element,
          data: {
            item1: element.postal_id,
            item2: element.postal_to_title,
            item3: element.postal_ref_no,
            item4: element.postal_from_title,
            item5: element.postal_type,
            item6: Vue.filter("formatDate")(element.postal_date),
            // item7: {
            //   type: "file",
            //   path: element.postal_document,
            //   height: "80px",
            // },
            item7: {
              type: "action",
              options: {
                label: "View",
                style: "",
                class: "btn btn-info",
                icon: '<i class="fas fa-eye" ></i>',
                method: this.postalDetail,
              },
            },
            item8: element.postal_document
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
    postalDetail(item) {
      this.$router.push(
        `/school/front_office/postal_view/${item.postal_id}`
      );
    },
    async submitForm(item, itemId) {
      this.editItem = item;
      this.editedIndex = itemId;
      var data = new FormData();
      data.append(
        "postal_from_title",
        this.editItem.postal_from_title ? this.editItem.postal_from_title : ""
      );
      data.append(
        "postal_to_title",
        this.editItem.postal_to_title ? this.editItem.postal_to_title : ""
      );
      data.append("postal_date", this.editItem.postal_date ? this.editItem.postal_date : "");
      data.append(
        "postal_ref_no",
        this.editItem.postal_ref_no ? this.editItem.postal_ref_no : ""
      );
      data.append(
        "postal_type",
        this.editItem.postal_type ? this.editItem.postal_type : ""
      );
      data.append(
        "postal_address",
        this.editItem.postal_address ? this.editItem.postal_address : ""
      );
      data.append(
        "postal_note",
        this.editItem.postal_note ? this.editItem.postal_note : ""
      );
      data.append("image", this.editItem.imageFilePath ? this.editItem.imageFilePath : "");
      let $url = "";
      if (this.editedIndex !== -1) {
        $url = `/api/school/front_office/postal/update/${this.editedIndex}`;
      } else {
        $url = `/api/school/front_office/postal/save`;
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
            this.postals[this.editIndex] = data.postal;
            this.tableData[this.editIndex] = data.postal;
            this.initTable();
          } else {
            this.postals.unshift(data.postal);
            var element = data.postal;
            this.tableData.unshift({
              item: element,
              data: {
                item1: element.postal_id,
                item2: element.postal_to_title,
                item3: element.postal_ref_no,
                item4: element.postal_from_title,
                item5: element.postal_type,
                item6: Vue.filter("formatDate")(element.postal_date),
                // item7: {
                //   type: "file",
                //   path: element.postal_document,
                //   height: "80px",
                // },
                item7: {
                  type: "action",
                  options: {
                    label: "View",
                    style: "",
                    class: "btn btn-info",
                    icon: '<i class="fas fa-eye" ></i>',
                    method: this.postalDetail,
                  },
                },
                item8: element.visitor_document
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
          this.$refs.postals.resetForm();
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
      this.$refs.postals.edit(item);
      this.editIndex = index;
    },
    async deleteData(item, index) {
      var data = new FormData();
      data.append("postal_status", "deleted");
      const res = await this.callApi(
        "post",
        `/api/school/front_office/postal/delete/${item.postal_id}`,
        data
      );

      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.postals.splice(index, 1);
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
