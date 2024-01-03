<template>
  <div>
    <div class="dashboard-content-one">
      <Breadcrumb pageTitle="Fees Discount " :breadcrumbList="breadcrumbList" />
      <div class="row gutters-20">
        <div class="col-5">
          <AddDiscount ref="fees_discounts" />
        </div>
        <div class="col-7">
          <div class="card height-auto">
            <div class="card-body">
              <div class="heading-layout1 d-flex justify-content-between">
                <div class="item-title">
                  <h3>All Fees Discount</h3>
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
      </div>
      <!-- Fees Discount List Area End Here -->
      <Footer />
    </div>
  </div>
</template>

<script>
var toast;
import AddDiscount from "./AddDiscount.vue";
export default {
  components: {
    AddDiscount,
  },
  data() {
    return {
      breadcrumbList: [
        {
          to: { name: "school.dashboard" },
          name: "Home",
        },
        {
          name: "Fees Discount",
        },
      ],
      fees_discounts: [],
      initFeesDiscount: [],
      tableHead: {
        items: {
          item1: { label: "Sr.No." },
          item2: { label: "Name" },
          item3: { label: "Fees Discount Code" },
          item4: { label: "Amount" },
        },
        actions: true,
      },
      tableData: [],
      isLoaded: false,
      noData: false,
      editItem: {},
      editedIndex: -1,
      rupeesIcon: "₹",
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
        `/api/school/fees_collection/fees_discount`,
        null
      );
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.initFeesDiscount = JSON.parse(
            JSON.stringify(data.fees_discounts)
          );
          this.fees_discounts = data.fees_discounts;
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
      this.fees_discounts.forEach((element) => {
        this.tableData.push({
          item: element,
          data: {
            item1: element.fees_discount_id,
            item2: element.fees_discount_name,
            item3: element.fees_discount_code,
            item4: `${this.rupeesIcon} ${element.fees_discount_amount}`,
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
        "fees_discount_name",
        this.editItem.fees_discount_name ? this.editItem.fees_discount_name : ""
      );
      data.append(
        "fees_discount_code",
        this.editItem.fees_discount_code ? this.editItem.fees_discount_code : ""
      );
      data.append(
        "fees_discount_amount",
        this.editItem.fees_discount_amount
          ? this.editItem.fees_discount_amount
          : ""
      );
      data.append(
        "fees_discount_description",
        this.editItem.fees_discount_description
          ? this.editItem.fees_discount_description
          : ""
      );
      let $url = "";
      if (this.editedIndex !== -1) {
        $url = `/api/school/fees_collection/fees_discount/update/${this.editedIndex}`;
      } else {
        $url = `/api/school/fees_collection/fees_discount/save`;
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
            this.fees_discounts[this.editIndex] = data.fees_discount;
            this.tableData[this.editIndex] = data.fees_discount;
            this.initTable();
          } else {
            this.fees_discounts.unshift(data.fees_discount);
            var element = data.fees_discount;
            this.tableData.unshift({
              item: element,
              data: {
                item1: element.fees_discount_id,
                item2: element.fees_discount_name,
                item3: element.fees_discount_code,
                item4: `${this.rupeesIcon} ${element.fees_discount_amount}`,
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
      this.$refs.fees_discounts.edit(item);
      this.editedIndex = item.fees_discount_id;
    },
    async deleteData(item, index) {
      var data = new FormData();
      data.append("fees_discount_status", "deleted");
      const res = await this.callApi(
        "post",
        `/api/school/fees_collection/fees_discount/delete/${item.fees_discount_id}`,
        data
      );
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.fees_discounts.splice(index, 1);
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
          timer: 2500,
        });
      }
    },
  },
};
</script>


<style scoped>
</style>
