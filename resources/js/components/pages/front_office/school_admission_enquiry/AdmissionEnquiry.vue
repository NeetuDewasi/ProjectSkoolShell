<template>
	<div>
		<div class="dashboard-content-one">
			<!-- Breadcubs Area Start -->
			<Breadcrumb
				pageTitle="Admission Enquiry"
				:breadcrumbList="breadcrumbList"
			>
                <template v-slot:button>
                    <button type="submit" class="btn btn-success btn-sm text-white"  @click="$router.push({name: 'school.front_office.add_admission_enquiry'})">
                        <i class="fa fa-plus"></i> Add Admission Enquiry
                    </button>
                </template>
            </Breadcrumb>
			<!-- End Breadcubs Area -->
			<!-- Admission Enquiery Area Start -->
			<div class="row gutters-20">
				<div class="col-12">
					<div class="card height-auto">
						<div class="card-body">
							<div class="heading-layout1">
								<div class="item-title">
									<h3>Select Criteria</h3>
								</div>
							</div>
							<form class="mg-b-20">
								<div class="row gutters-20">
									<div class="col-12 form-group">
										<label>Class</label>
										<Select2
											ref="class_list_select2"
											placeholder="--SELECT A CLASS--"
											:items="class_list"
											@change="selectClass"
										/>
									</div>
								</div>
							</form>
							<div class="heading-layout1">
								<div class="item-title">
									<h3>Admission Enquiry</h3>
								</div>
							</div>
							<div
								class="table table-responsive"
								v-show="!noData"
							>
								<Table
									ref="table"
									:tableData="filteredList"
									:tableHead="tableHead"
								/>
							</div>
							<NoData v-show="noData" />
						</div>
					</div>
				</div>
			</div>
			<!-- Admission Enquiery Area End Here -->
			<Footer />
		</div>
	</div>
</template>

<script>
var toast;
import AddAdmissionEnquiryForm from "./AddAdmissionEnquiryForm.vue";
export default {
  components: {
    AddAdmissionEnquiryForm,
  },
  data() {
    return {
      breadcrumbList: [
        {
          to: { name: "school.dashboard" },
          name: "Home",
        },
        {
          name: "Admission Enquiry",
        },
      ],
      enquiries: [],

      tableHead: {
        items: {
          item1: { label: "Sr.No." },
          item2: { label: "Class Name" },
          item3: { label: "Parent Name" },
          item4: { label: "Phone Number" },
          item5: { label: "Email" },
          item6: { label: "Student Name" },
          item7: { label: ""},
        },
        actions: true,
      },
      tableData: [],
      isLoaded: true,
      noData: false,
      class_list: [],
      selectedClass: -1,
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
  computed: {
    filteredList() {
      if (this.selectedClass != -1) {
        let selectClassName = "";
        this.class_list.forEach((e) => {
          if (e.value == this.selectedClass) {
            selectClassName = e.name;
          }
        });
        return this.tableData.filter((item) => {
          return item.data.item2 == selectClassName;
        });
      }
      return this.tableData;
    },
  },
  mounted() {
    this.$parent.loadOtherScript();
    this.getClassData();
  },
  methods: {
    async getClassData() {
      const res = await this.callApi(
        "get",
        `/api/school/front_office/admission_enquiry/data_list`,
        null
      );
      if (res.status == 200) {
        var data = res.data;
        this.class_list = data.class_list;
        this.$refs.class_list_select2.updateList(data.class_list);
        // this.$refs.class_list_select2.setSelected(this.selectedClass);
      }
    },
    selectClass(val) {
      this.selectedClass = val;
    //   this.errorItem.class_list = "";

    //   this.$refs.table.updateList(this.filteredList);
    },
    async showData() {
      this.isLoaded = false;
      const res = await this.callApi(
        "get",
        `/api/school/front_office/admission_enquiry`,
        null
      );
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
            this.log('response data*****',data.enquiries);
          this.enquiries = data.enquiries;
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
      this.enquiries.forEach((element) => {
        this.tableData.push({
          item: element,
          data: {
             item1: element.admission_enquiry != null ? element.admission_enquiry.admission_enquiry_id : "",
            item2: element.enquiry_student_class != null ? element.enquiry_student_class.name :'',
            item3: element.admission_enquiry != null ? element.admission_enquiry.admission_enquiry_name :'',
            item4: element.admission_enquiry != null ? element.admission_enquiry.admission_enquiry_phone :'',
            item5: element.admission_enquiry != null ? element.admission_enquiry.admission_enquiry_email :'',
            item6: element.enquiry_student_name,
            item7: {
              type: "action",
              options: {
                label: "View",
                style: "",
                class: "btn btn-info",
                icon: '<i class="fas fa-eye" ></i>',
                method: this.enquiryDetail,
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
    enquiryDetail(item) {
      this.$router.push(`/school/front_office/admission_enqiry_view/${item.enquiry_student_id}`);
    },
    edit(item) {
      this.$router.push({
        path: `/school/front_office/edit_admission_enquiry/${item.admission_enquiry.admission_enquiry_id}`,
      });
    },
    async deleteData(item, index) {
      var data = new FormData();
      data.append("enquiry_student_status", "deleted");
      const res = await this.callApi(
        "post",
        `/api/school/front_office/admission_enquiry/delete/${item.enquiry_student_id}`,
        data
      );

      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.enquiries.splice(index, 1);
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
