<template>
	<div>
		<div class="dashboard-content-one">
			<!-- Breadcubs Area Start -->
			<Breadcrumb
				pageTitle="Collect Fees"
				:breadcrumbList="breadcrumbList"
			/>
			<!-- End Breadcubs Area -->
			<div class="row gutters-20">
				<div class="col-12">
					<!-- <CollectFeesSearch ref="collectFees" /> -->
					<div class="card height-auto">
						<div class="card-body">
							<div class="heading-layout1">
								<div class="item-title">
									<h3>Select Criteria</h3>
								</div>
							</div>
							<form class="mg-b-20">
								<div class="row gutters-20">
									<div
										class="
											col-xl-6 col-lg-6 col-12
											form-group
										"
									>
										<label>Class</label>
										<Select2
											ref="class_list"
											placeholder="--SELECT A CLASS--"
											:items="class_list"
											@change="selectClass"
										/>
									</div>
									<div
										class="
											col-xl-6 col-lg-6 col-12
											form-group
										"
									>
										<label>Section</label>
										<Select2
											ref="section_list"
											placeholder="--SELECT A SECTION--"
											:items="section_list"
											@change="selectSection"
										/>
									</div>
								</div>
							</form>
							<div class="heading-layout1">
								<div class="item-title">
									<h3>Fees Collection</h3>
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
				<!-- Collect Fees List Area End Here -->
			</div>
			<Footer />
		</div>
	</div>
</template>

<script>
var toast;
// import CollectFeesSearch from "./CollectFeesSearch.vue";
export default {
	// components: {
	// 	CollectFeesSearch,
	// },
	data() {
		return {
			breadcrumbList: [
				{
					to: { name: "admin.dashboard" },
					name: "Home",
				},
				{
					name: "Collect Fees",
				},
			],
			collectFees: [],
			initCollectFees: [],
			tableHead: {
				items: {
					item1: { label: "Sr.No." },
					item2: { label: "Class" },
					item3: { label: "Section" },
					item4: { label: "Admission Number" },
					item5: { label: "Student Name" },
					item6: { label: "Father Name" },
					item7: { label: "Date Of Birth" },
					item8: { label: "Phone Number" },
					item9: { label: "Collect Fee" },
				},
				actions: false,
			},
			tableData: [],
			isLoaded: false,
			noData: false,
			class_list: [],
			section_list: [],
			selectedSection: -1,
			selectedClass: -1,
			selectedClassName: "",
			selectedSectionName: "",
		};
	},
	created() {
		toast = Toast.fire({
			icon: "warning",
			title: "Loading data..",
			timer: 0,
		});
		this.showData();
	},
	mounted() {
		this.$parent.loadOtherScript();

    this.getClassList();
  },
  computed: {
    filteredList() {
      if (this.selectedClass != -1) {
        if (this.selectedSection != -1) {
          return this.tableData.filter((item) => {
            return (
              this.selectedClassName == item.data.item2 &&
              this.selectedSectionName == item.data.item3
            );
          });
        }
        return this.tableData.filter((item) => {
          return this.selectedClassName == item.data.item2;
        });
      }
      return this.tableData;
    },
  },
  methods: {
    getSelectedClassName() {
      this.class_list.forEach((e) => {
        if (e.value == this.selectedClass) {
          this.selectedClassName = e.name;
        }
      });
      this.log(this.selectedClassName);
    },
    getSelectedSectionName() {
      this.section_list.forEach((e) => {
        if (e.value == this.selectedSection) {
          this.selectedSectionName = e.name;
        }
      });
      this.log(this.selectedSectionName);
    },
    selectSection(val) {
      this.selectedSection = val;
      this.getSelectedSectionName();
    },
    async selectClass(val) {
      this.selectedClass = val;
      this.getSelectedClassName();
      if (this.selectedClass == -1) {
        this.section_list = [];
        this.$refs.section_list.updateList([]);
        return;
      }
      const res = await this.callApi(
        "get",
        `/api/school/class/sections/${this.selectedClass}`,
        null
      );
      this.log(res);
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.section_list = data.school_class_sections;
          this.$refs.section_list.updateList(data.school_class_sections);
        }
      }
    },
    async getClassList() {
      const res = await this.callApi(
        "get",
        `/api/school/general/get_class_list`,
        null
      );
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.class_list = data.class_list;
          this.$refs.class_list.updateList(data.class_list);
        }
      }
    },
    async showData() {
      this.isLoaded = false;
      var data = new FormData();
      data.append("class", this.selectedClass);
      data.append("section", this.selectedSection);
      const res = await this.callApi(
        "post",
        `/api/school/fees_collection/collect_fees/student_collect_fees`,
        data
      );
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.collectFees = data.student_admissions;
          this.initTable();
        }
      }
      this.$refs.table.loadTable();
      this.isLoaded = true;
    },
    initTable() {
      this.tableData = [];
      this.collectFees.forEach((element) => {
        this.tableData.push({
          item: element,
          data: {
            item1: element.student_admission_id,
            item2:
              element.school_class != null
                ? element.school_class.class_name
                : "",
            item3:
              element.school_section != null
                ? element.school_section.section_name
                : "",
            item4: element.admission_number,
            item5: `${element.first_name} ${element.last_name}`,
            item6:
              element.student_guardian != null
                ? element.student_guardian.father.first_name != null
                  ? element.student_guardian.father.first_name
                  : ""
                : "",
            item7: Vue.filter('formatDate')(element.date_of_birth),
            item8: element.mobile,
            item9: {
              type: "action",
              options: {
                label: "Collect Fee",
                style: "",
                class: "btn btn-info",
                // icon: '<i class="fas fa-plus"></i>',
                method: this.commonFunction
              },
            },
          },
          action: {},
        });
      });
    },
    commonFunction(item, index) {
      this.$router.push(`/school/fees/statement/${item.student_admission_id}`);
    },
  },
};
</script>


<style scoped>
</style>
