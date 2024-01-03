<template>
  <div>
    <div class="dashboard-content-one">
      <Breadcrumb pageTitle="Expenses Head " :breadcrumbList="breadcrumbList" />
      <div class="row gutters-20">
        <div class="col-5">
          <CreateExpensesHead ref="expenseHead" />
        </div>
        <div class="col-7">
          <div class="card">
            <div class="card-body">
              <div class="item-title">
                <h3>Expenses Heads</h3>
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
      <!-- Expense Head List Area End Here -->
      <Footer />
    </div>
  </div>
</template>

<script>
var toast;
import CreateExpensesHead from "./CreateExpensesHead.vue";
export default {
  components: {
    CreateExpensesHead,
  },
  data() {
    return {
      breadcrumbList: [
        {
          to: { name: "school.dashboard" },
          name: "Home",
        },
        {
          name: "Expenses Head",
        },
      ],
      expensesHead: [],
      initExpensesHeadList: [],
      tableHead: {
        items: {
          item1: { label: "Sr.No." },
          item2: { label: "Expense Head Name" },
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
        `/api/school/expenses/expense_heads`,
        null
      );

      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.initExpensesHeadList = JSON.parse(
            JSON.stringify(data.expense_heads)
          );
          this.expensesHead = data.expense_heads;
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
      this.expensesHead.forEach((element) => {
        this.tableData.push({
          item: element,
          data: {
            item1: element.expense_head_id,
            item2: element.expense_head_name,
          },
          action: {
            edit: true,
            delete: true,
          },
        });
      });
    },
    async submitForm(item) {
      this.editItem = item;
      var data = new FormData();
      data.append(
        "expense_head_name",
        this.editItem.expense_head_name ? this.editItem.expense_head_name : ""
      );
      data.append(
        "expense_head_description",
        this.editItem.expense_head_description
          ? this.editItem.expense_head_description
          : ""
      );
      let $url = "";
      if (this.editedIndex !== -1) {
        $url = `/api/school/expenses/expense_heads/update/${this.editItem.expense_head_id}`;
      } else {
        $url = `/api/school/expenses/expense_heads/save`;
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
            this.expensesHead[this.editIndex] = data.expense_head;
            this.tableData[this.editIndex] = data.expense_head;
            this.initTable();
          } else {
            this.expensesHead.unshift(data.expense_head);
            var element = data.expense_head;
            this.tableData.unshift({
              item: element,
              data: {
                item1: element.expense_head_id,
                item2: element.expense_head_name,
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
      this.$refs.expenseHead.edit(item);
      this.editedIndex = item.expense_head_id;
    },
    async deleteData(item) {
      var data = new FormData();
      data.append("expense_head_status", "deleted");
      const res = await this.callApi(
        "post",
        `/api/school/expenses/expense_heads/delete/${item.expense_head_id}`,
        data
      );
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.expensesHead.splice(this.expensesHead.indexOf(item), 1);
          this.initTable();
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
