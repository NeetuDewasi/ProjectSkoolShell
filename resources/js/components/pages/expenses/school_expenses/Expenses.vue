<template>
  <div>
    <div class="dashboard-content-one">
      <Breadcrumb pageTitle="Expenses " :breadcrumbList="breadcrumbList" />
      <div class="row gutters-20">
        <div class="col-5">
          <ExpensesCreate ref="expenses" />
        </div>
        <div class="col-7">
          <div class="card">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>All Expenses</h3>
                </div>
              </div>
              <div class="row gutters-20">
                <div class="col-xl-12 col-lg-12 col-12 form-group">
                  <select
                    class="form-control"
                    v-model="filterDate"
                    @change="selectedDate()"
                  >
                    <option value="today">Today's</option>
                    <option value="yesterday">Yesterday's</option>
                    <option value="this_week">This Week's</option>
                    <option value="last_week">Last Week's</option>
                    <option value="this_month">This Month's</option>
                    <option value="last_three_months">Last 3 Months</option>
                    <option value="last_six_months">Last 6 Months</option>
                    <option value="this_year">
                      This Year (From
                      {{ thisYearStartDate | formatDate }})
                    </option>
                    <option value="last_year">
                      Last Year From
                      {{ lastYearStartDate | formatDate }}
                      to
                      {{ lastYearEndDate | formatDate }}
                    </option>
                    <option value="life_time">Life time</option>
                    <option value="custom_date">Custom Date</option>
                  </select>
                </div>
              </div>
              <div class="col-12 mt-2" v-if="isCustomDate">
                <div class="row form-group">
                  <div class="col-6">
                    <input
                      type="date"
                      class="form-control"
                      v-model="filterDateTo"
                      @change="startDate = filterDateTo"
                    />
                  </div>
                  <div class="col-6">
                    <input
                      type="date"
                      class="form-control"
                      v-model="filterDateFrom"
                      :min="startDate"
                      :max="endDate"
                      @change="endDate = filterDateFrom"
                    />
                  </div>
                </div>
              </div>
              <div class="table table-responsive" v-show="!noData">
                <Table
                  ref="table"
                  :responsive="false"
                  :tableData="filterData"
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
import ExpensesCreate from "./ExpensesCreate.vue";
export default {
  components: {
    ExpensesCreate,
  },
  data() {
    return {
      breadcrumbList: [
        {
          to: { name: "school.dashboard" },
          name: "Home",
        },
        {
          name: "Expenses",
        },
      ],
      expenses: [],
      initExpenses: [],
      tableHead: {
        items: {
          item1: { label: "Sr.No." },
          item2: { label: "Expense Head" },
          item3: { label: "Name" },
          item4: { label: "Invoice number" },
          item5: { label: "Date" },
          item6: { label: "Amount" },
          item7: { label: "" },
        },
        actions: true,
      },
      tableKey: 0,
      tableData: [],
      isLoaded: false,
      noData: false,
      filterType: "all",
      filterDateTo: moment(new Date()).format("YYYY-MM-DD"),
      filterDateFrom: moment(new Date()).format("YYYY-MM-DD"),
      subscribePanel: false,
      filterDate: "today",
      isCustomDate: false,
      startDate: moment(new Date()).format("YYYY-MM-DD"),
      endDate: moment(new Date()).format("YYYY-MM-DD"),
      thisYearStartDate: moment(new Date()).format("YYYY-MM-DD"),
      lastYearStartDate: moment(new Date()).format("YYYY-MM-DD"),
      lastYearEndDate: moment(new Date()).format("YYYY-MM-DD"),
      editItem: {},
      editedIndex: -1,
      editIndex: -1,
      rupeesIcon: "₹",
    };
  },
  created() {
    toast = Toast.fire({
      icon: "warning",
      title: "Loading Data..",
      timer: 0,
    });
    const today = new Date();
    var currentMonth = today.getMonth();

    var year = today.getFullYear();
    if (currentMonth <= 2) {
      year -= 1;
    }

    this.thisYearStartDate = moment(new Date(year, 3, 1)).format("YYYY-MM-DD");

    var lastYear = today.getFullYear();
    if (currentMonth <= 2) {
      lastYear -= 1;
    }

    this.lastYearStartDate = moment(new Date(lastYear - 1, 3, 1)).format(
      "YYYY-MM-DD"
    );
    this.lastYearEndDate = moment(new Date(lastYear, 2, 31)).format(
      "YYYY-MM-DD"
    );
    this.showData();
  },
  mounted() {
    this.$parent.loadOtherScript();
  },
  computed: {
    filterData: function () {
      return this.tableData.filter((item) => {
        if (
          item.data.item5 >= this.startDate &&
          item.data.item5 <= this.endDate
        ) {
          return item;
        }
      });
    },
  },
  methods: {
    async showData() {
      this.isLoaded = false;
      const res = await this.callApi(
        "get",
        `/api/school/expenses/expenses`,
        null
      );

      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.initExpenses = JSON.parse(JSON.stringify(data.expenses));
          this.expenses = data.expenses;
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
      this.expenses.forEach((element) => {
        this.tableData.push({
          item: element,
          data: {
            item1: element.expense_id,
            item2:
              element.expense_head != null ? element.expense_head.name : "",
            item3: element.expense_name,
            item4: element.expense_invoice_number,
            item5: element.expense_date,
            item6: `${this.rupeesIcon} ${element.expense_amount}`,
            // item7: {
            //   type: "file",
            //   path: element.expense_documents,
            //   height: "120px",
            // },
            item7: element.expense_documents
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
    async submitForm(item, itemId) {
      this.editItem = item;
      this.log(this.editItem.imageFilePath);
      this.editedIndex = itemId;
      var data = new FormData();
      data.append(
        "expense_name",
        this.editItem.expense_name ? this.editItem.expense_name : ""
      );
      data.append(
        "expense_head",
        this.editItem.selectedExpenseHead
          ? this.editItem.selectedExpenseHead
          : ""
      );
      data.append(
        "expense_invoice_number",
        this.editItem.expense_invoice_number
          ? this.editItem.expense_invoice_number
          : ""
      );
      data.append(
        "expense_amount",
        this.editItem.expense_amount ? this.editItem.expense_amount : ""
      );
      data.append(
        "image",
        this.editItem.imageFilePath ? this.editItem.imageFilePath : ""
      );

      data.append(
        "expense_date",
        this.editItem.expense_date ? this.editItem.expense_date : ""
      );
      data.append(
        "expense_description",
        this.editItem.expense_description
          ? this.editItem.expense_description
          : ""
      );
      let $url = "";
      if (this.editedIndex !== -1) {
        $url = `/api/school/expenses/expenses/update/${this.editedIndex}`;
      } else {
        $url = `/api/school/expenses/expenses/save`;
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
            this.expenses[this.editIndex] = data.expenses;
            this.tableData[this.editIndex] = data.expenses;
            this.initTable();
          } else {
            this.expenses.unshift(data.expenses);
            var element = data.expenses;
            this.tableData.unshift({
              item: element,
              data: {
                item1: element.expense_id,
                item2:
                  element.expense_head != null ? element.expense_head.name : "",
                item3: element.expense_name,
                item4: element.expense_invoice_number,
                item5: element.expense_date,
                item6: `${this.rupeesIcon} ${element.expense_amount}`,
                // item7: {
                //   type: "file",
                //   path: element.expense_documents,
                //   height: "120px",
                // },
                item7: element.expense_documents
                  ? {
                      type: "action",
                      options: {
                        label: "",
                        style: "",
                        class: "",
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
          this.$refs.expenses.resetForm();
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
      this.$refs.expenses.edit(item);
      this.editIndex = index;
    },
    async deleteData(item, index) {
      var data = new FormData();
      data.append("expense_status", "deleted");
      const res = await this.callApi(
        "post",
        `/api/school/expenses/expenses/delete/${item.expense_id}`,
        data
      );

      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.expenses.splice(index, 1);
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
    getToDate(e) {},
    selectedDate() {
      if (this.filterDate == "today") {
        this.startDate = moment(new Date()).format("YYYY-MM-DD");
        this.endDate = moment(new Date()).format("YYYY-MM-DD");
        this.isCustomDate = false;
        return;
      }

      if (this.filterDate == "yesterday") {
        const today = new Date();
        const yesterday = new Date(today);

        yesterday.setDate(yesterday.getDate() - 1);

        this.startDate = moment(yesterday).format("YYYY-MM-DD");
        this.endDate = moment(yesterday).format("YYYY-MM-DD");
        this.isCustomDate = false;
        return;
      }

      if (this.filterDate == "this_week") {
        const firstDay = new Date();
        const first = firstDay.getDate() - firstDay.getDay(); // First day is the day of the month - the day of the week
        const firstday = new Date(firstDay.setDate(first));

        this.startDate = moment(firstday).format("YYYY-MM-DD");
        this.endDate = moment(new Date()).format("YYYY-MM-DD");
        this.isCustomDate = false;
        return;
      }

      if (this.filterDate == "last_week") {
        const today = new Date();
        const firstThisWeek = today.getDate() - today.getDay(); // First day is the day of the month - the day of the week
        const firstdayThisWeek = new Date(today.setDate(firstThisWeek));
        const lastdate = new Date(firstdayThisWeek);
        lastdate.setDate(lastdate.getDate() - 1);

        const firstDay = new Date(lastdate);
        const first = firstDay.getDate() - firstDay.getDay(); // First day is the day of the month - the day of the week
        const firstday = new Date(firstDay.setDate(first));

        this.startDate = moment(firstday).format("YYYY-MM-DD");
        this.endDate = moment(lastdate).format("YYYY-MM-DD");
        this.isCustomDate = false;
        return;
      }

      if (this.filterDate == "this_month") {
        const today = new Date();
        const firstDate = new Date(today.getFullYear(), today.getMonth(), 1);

        this.startDate = moment(firstDate).format("YYYY-MM-DD");
        this.endDate = moment(new Date()).format("YYYY-MM-DD");
        this.isCustomDate = false;
        return;
      }

      if (this.filterDate == "last_three_months") {
        const today = new Date();

        var currentMonth = today.getMonth();
        var year = today.getFullYear();
        if (currentMonth <= 2) {
          year -= 1;
        }
        const firstDate = new Date(year, today.getMonth() - 2, 1);

        this.startDate = moment(firstDate).format("YYYY-MM-DD");
        this.endDate = moment(new Date()).format("YYYY-MM-DD");
        this.isCustomDate = false;
        return;
      }

      if (this.filterDate == "last_six_months") {
        const today = new Date();

        var currentMonth = today.getMonth();
        var year = today.getFullYear();
        if (currentMonth <= 2) {
          year -= 1;
        }
        const firstDate = new Date(year, today.getMonth() - 5, 1);

        this.startDate = moment(firstDate).format("YYYY-MM-DD");
        this.endDate = moment(new Date()).format("YYYY-MM-DD");
        this.isCustomDate = false;
        return;
      }

      if (this.filterDate == "last_six_months") {
        const today = new Date();

        var currentMonth = today.getMonth();
        var year = today.getFullYear();
        if (currentMonth <= 2) {
          year -= 1;
        }
        const firstDate = new Date(year, today.getMonth() - 5, 1);

        this.startDate = moment(firstDate).format("YYYY-MM-DD");
        this.endDate = moment(new Date()).format("YYYY-MM-DD");
        this.isCustomDate = false;
        return;
      }
      if (this.filterDate == "this_year") {
        this.startDate = moment(this.thisYearStartDate).format("YYYY-MM-DD");
        this.endDate = moment(new Date()).format("YYYY-MM-DD");
        this.isCustomDate = false;
        return;
      }

      if (this.filterDate == "last_year") {
        this.startDate = moment(this.lastYearStartDate).format("YYYY-MM-DD");
        this.endDate = moment(this.lastYearEndDate).format("YYYY-MM-DD");
        this.isCustomDate = false;
        return;
      }

      if (this.filterDate == "life_time") {
        this.startDate = moment(new Date(2020, 3, 1)).format("YYYY-MM-DD");
        this.endDate = moment(new Date()).format("YYYY-MM-DD");
        return;
      }

      this.isCustomDate = this.filterDate == "custom_date";
    },
  },
};
</script>


<style scoped>
</style>
