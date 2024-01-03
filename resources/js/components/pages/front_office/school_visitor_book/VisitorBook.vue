<template>
  <div>
    <div class="dashboard-content-one">
      <Breadcrumb pageTitle="Visitor book" :breadcrumbList="breadcrumbList" />
      <div class="row gutters-20">
        <div class="col-5">
          <AddVisitorForm ref="visitors" />
        </div>
        <div class="col-7">
          <div class="card height-auto">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>Visitor Books</h3>
                </div>
              </div>
              <div class="table table-responsive" v-show="!noData">
                <Table
                  ref="table"
                  :responsive="false"
                  :tableData="tableData"
                  :tableHead="tableHead"
                />
              </div>
              <NoData v-show="noData" />
            </div>
          </div>
        </div>
      </div>
      <!-- Visitor Book List Area End Here -->
      <Footer />
    </div>
  </div>
</template>

<script>
var toast;
import AddVisitorForm from "./AddVisitorForm.vue";
export default {
  components: {
    AddVisitorForm,
  },
  data() {
    return {
      breadcrumbList: [
        {
          to: { name: "school.dashboard" },
          name: "Home",
        },
        {
          name: "Visitor Book",
        },
      ],
      visitors: [],
      initVisitor: [],
      tableHead: {
        items: {
          item1: { label: "Sr.No." },
          item2: { label: "Purpose" },
          item3: { label: "ID Card" },
          item4: { label: "Name" },
          item5: { label: "Phone Number" },
          item6: { label: "Date" },
          item7: { label: "In Time" },
          item8: { label: "Out Time" },
          item9: { label: "View Detail" },
          item10: { label: "" },
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
        `/api/school/front_office/visitors`,
        null
      );
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.initVisitor = JSON.parse(JSON.stringify(data.visitors));
          this.visitors = data.visitors;
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
      this.visitors.forEach((element) => {
        this.tableData.push({
          item: element,
          data: {
            item1: element.visitor_id,
            item2:
              element.visitor_purpose_id != null
                ? element.visitor_purpose_id.name
                : "",
            item3: element.visitor_id_card,
            item4: element.visitor_name,
            item5: element.visitor_phone,
            item6:
              element.visitor_date != null
                ? Vue.filter("formatDate")(element.visitor_date)
                : "",
            item7:
              element.visitor_in_time != null
                ? Vue.filter("formatTime")(element.visitor_in_time)
                : "",
            item8:
              element.visitor_out_time != null
                ? Vue.filter("formatTime")(element.visitor_out_time)
                : "",
            // item11: {
            //   type: "file",
            //   path: element.visitor_document,
            //   height: "120px",
            // },
            item9: {
              type: "action",
              options: {
                label: "View",
                style: "",
                class: "btn btn-info",
                icon: '<i class="fas fa-eye" ></i>',
                method: this.visitorDetail,
              },
            },
            item10: element.visitor_document
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
    visitorDetail(item) {
      this.$router.push(
        `/school/front_office/visitors_detail/${item.visitor_id}`
      );
    },
    async submitForm(item, itemId) {
      this.editItem = item;
      this.editedIndex = itemId;
      var data = new FormData();
      data.append("visitor_purpose_id", this.editItem.selectedPurpose ? this.editItem.selectedPurpose : "");
      data.append(
        "visitor_name",
        this.editItem.visitor_name ? this.editItem.visitor_name : ""
      );
      data.append("image", this.editItem.imageFilePath ? this.editItem.imageFilePath : "");
      data.append(
        "visitor_email",
        this.editItem.visitor_email ? this.editItem.visitor_email : ""
      );
      data.append(
        "visitor_phone",
        this.editItem.visitor_phone ? this.editItem.visitor_phone : ""
      );
      data.append(
        "visitor_id_card",
        this.editItem.visitor_id_card ? this.editItem.visitor_id_card : ""
      );
      data.append(
        "visitor_no_of_person",
        this.editItem.visitor_no_of_person
          ? this.editItem.visitor_no_of_person
          : ""
      );
      data.append(
        "visitor_date",
        this.editItem.visitor_date ? this.editItem.visitor_date : ""
      );
      data.append(
        "visitor_in_time",
        this.editItem.visitor_in_time ? this.editItem.visitor_in_time : ""
      );
      data.append(
        "visitor_out_time",
        this.editItem.visitor_out_time ? this.editItem.visitor_out_time : ""
      );
      data.append(
        "visitor_note",
        this.editItem.visitor_note ? this.editItem.visitor_note : ""
      );
      let $url = "";
      if (this.editedIndex !== -1) {
        $url = `/api/school/front_office/visitors/update/${this.editedIndex}`;
      } else {
        $url = `/api/school/front_office/visitors/save`;
      }
      const res = await this.callApi("post", $url, data, "multipart");
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          if (this.noData) {
            this.noData = false;
          }
          this.editItem = {};
          if (this.editedIndex !== -1) {
            this.visitors[this.editIndex] = data.visitor;
            this.tableData[this.editIndex] = data.visitor;
            this.initTable();
          } else {
            this.visitors.unshift(data.visitor);
            var element = data.visitor;
            this.tableData.unshift({
              item: element,
              data: {
                item1: element.visitor_id,
            item2:
              element.visitor_purpose_id != null
                ? element.visitor_purpose_id.name
                : "",
            item3: element.visitor_id_card,
            item4: element.visitor_name,
            item5: element.visitor_phone,
            item6:
              element.visitor_date != null
                ? Vue.filter("formatDate")(element.visitor_date)
                : "",
            item7:
              element.visitor_in_time != null
                ? Vue.filter("formatTime")(element.visitor_in_time)
                : "",
            item8:
              element.visitor_out_time != null
                ? Vue.filter("formatTime")(element.visitor_out_time)
                : "",
            // item11: {
            //   type: "file",
            //   path: element.visitor_document,
            //   height: "120px",
            // },
            item9: {
              type: "action",
              options: {
                label: "View",
                style: "",
                class: "btn btn-info",
                icon: '<i class="fas fa-eye" ></i>',
                method: this.visitorDetail,
              },
            },
            item10: element.visitor_document
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
          this.$refs.visitors.resetForm();
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
      this.$refs.visitors.edit(item);
      this.editIndex = index;
    },
    async deleteData(item, index) {
      var data = new FormData();
      data.append("visitor_status", "deleted");
      const res = await this.callApi(
        "post",
        `/api/school/front_office/visitors/delete/${item.visitor_id}`,
        data
      );

      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.visitors.splice(index, 1);
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
