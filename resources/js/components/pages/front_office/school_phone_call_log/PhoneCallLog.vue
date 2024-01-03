<template>
  <div>
    <div class="dashboard-content-one">
      <Breadcrumb pageTitle="Phone Call Log" :breadcrumbList="breadcrumbList"/>
      <div class="row gutters-20">
        <div class="col-5">
          <AddPhoneCallLogForm ref="calls" />
        </div>
        <div class="col-7">
          <div class="card height-auto">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>Phone Call Logs</h3>
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
      <!-- Phone Call Log Area End Here -->
      <Footer />
    </div>
  </div>
</template>

<script>
var toast;
import AddPhoneCallLogForm from "./AddPhoneCallLogForm.vue";
export default {
  components: {
    AddPhoneCallLogForm,
  },
  data() {
    return {
      breadcrumbList: [
        {
          to: { name: "school.dashboard" },
          name: "Home",
        },
        {
          name: "Phone Call Log",
        },
      ],
      calls: [],
      initCalls: [],
      tableHead: {
        items: {
          item1: { label: "Sr.No." },
          item2: { label: "Name" },
          item3: { label: "Number" },
          item4: { label: "Date" },
          item5: { label: "Call Type" },
        //   item6: {
        //     label: "Duration<div style='font-size: 10px'>(MM:SS)</div>",
        //   },
          item6: { label: "Next Follow" },
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
        `/api/school/front_office/phone_call`,
        null
      );
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.initCalls = JSON.parse(JSON.stringify(data.calls));
          this.calls = data.calls;
          this.initTable();
        } else {
          this.noData = true;
        }
      }
      this.$refs.table.loadTable();
      this.isLoaded = true;
      toast.close();
    },
    initTable() {
      this.tableData = [];
      this.calls.forEach((element) => {
        this.tableData.push({
          item: element,
          data: {
            item1: element.phone_id,
            item2: element.phone_name != null ? element.phone_name : "",
            item3: element.phone_phone != null ? element.phone_phone : "",
            item4:
              element.phone_date != null
                ? {
                    type: "filter",
                    value: element.phone_date,
                    options: {
                      filter: "formatDate",
                    },
                  }
                : "",
            item5:
              element.phone_call_type != null ? element.phone_call_type : "",
            // item6: `${
            //   element.phone_call_duration_minute != null
            //     ? Vue.filter("leadingZero")(element.phone_call_duration_minute)
            //     : "00"
            // }:${
            //   element.phone_call_duration_seconds != null
            //     ? Vue.filter("leadingZero")(element.phone_call_duration_seconds)
            //     : "00"
            // }`,
            item6:
              element.phone_next_date != null
                ? Vue.filter("formatDate")(element.phone_next_date)
                : "",
            item7: {
              type: "action",
              options: {
                label: "",
                style: "background: none;",
                class: "btn",
                icon: '<i class="fas fa-bars" ></i>',
                method: this.callLogDetail,
              },
            },
          },
          action: {
            edit: true,
            delete: true,
          },
        });
      });
    },
    callLogDetail(item) {
      this.$router.push(
        `/school/front_office/phone_call_view/${item.phone_id}`
      );
    this.log(hello);
    },
    async submitForm(item, itemId) {
      this.editItem = item;
      this.editedIndex = itemId;
      var data = new FormData();
      data.append(
        "phone_name",
        this.editItem.phone_name ? this.editItem.phone_name : ""
      );
      data.append(
        "phone_phone",
        this.editItem.phone_phone ? this.editItem.phone_phone : ""
      );
      data.append("phone_date", this.editItem.phone_date ? this.editItem.phone_date : "");
      data.append(
        "phone_next_date",
        this.editItem.phone_next_date ? this.editItem.phone_next_date : ""
      );
      data.append(
        "phone_call_type",
        this.editItem.phone_call_type ? this.editItem.phone_call_type : ""
      );
      data.append(
        "phone_call_duration_minute",
        this.editItem.phone_call_duration_minute
          ? this.editItem.phone_call_duration_minute
          : ""
      );
      data.append(
        "phone_call_duration_seconds",
        this.editItem.phone_call_duration_seconds
          ? this.editItem.phone_call_duration_seconds
          : ""
      );
      data.append(
        "phone_description",
        this.editItem.phone_description ? this.editItem.phone_description : ""
      );
      data.append(
        "phone_note",
        this.editItem.phone_note ? this.editItem.phone_note : ""
      );
      let $url = "";
      if (this.editedIndex !== -1) {
        $url = `/api/school/front_office/phone_call/update/${this.editedIndex}`;
      } else {
        $url = `/api/school/front_office/phone_call/save`;
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
            this.calls[this.editIndex] = data.call;
            this.tableData[this.editIndex] = data.call;
            this.initTable();
          } else {
            this.calls.unshift(data.call);
            var element = data.call;
            this.tableData.unshift({
              item: element,
              data: {
                item1: element.phone_id,
            item2: element.phone_name != null ? element.phone_name : "",
            item3: element.phone_phone != null ? element.phone_phone : "",
            item4:
              element.phone_date != null
                ? {
                    type: "filter",
                    value: element.phone_date,
                    options: {
                      filter: "formatDate",
                    },
                  }
                : "",
            item5:
              element.phone_call_type != null ? element.phone_call_type : "",
            // item6: `${
            //   element.phone_call_duration_minute != null
            //     ? Vue.filter("leadingZero")(element.phone_call_duration_minute)
            //     : "00"
            // }:${
            //   element.phone_call_duration_seconds != null
            //     ? Vue.filter("leadingZero")(element.phone_call_duration_seconds)
            //     : "00"
            // }`,
            item6:
              element.phone_next_date != null
                ? Vue.filter("formatDate")(element.phone_next_date)
                : "",
            item7: {
              type: "action",
              options: {
                label: "",
                style: "",
                class: "btn btn-info",
                icon: '<i class="fas fa-eye" ></i>',
                method: this.callLogDetail,
              },
            },
              },
              action: {
                edit: true,
                delete: true,
              },
            });
          }
          this.$refs.calls.resetForm();
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
      this.$refs.calls.edit(item);
      this.editIndex = index;
    },
    async deleteData(item, index) {
      var data = new FormData();
      data.append("phone_status", "deleted");
      const res = await this.callApi(
        "post",
        `/api/school/front_office/phone_call/delete/${item.phone_id}`,
        data
      );

      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.calls.splice(index, 1);
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
