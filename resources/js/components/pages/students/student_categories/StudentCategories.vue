<template>
  <div>
    <div class="dashboard-content-one">
      <Breadcrumb pageTitle=" Student Categories" :breadcrumbList="breadcrumbList" />
      <div class="row gutters-20">
        <div class="col-12">
          <StudentCategoriesCreate ref="studentCategoryCreate" />
        </div>
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="item-title">
                <h3>Student Categories</h3>
              </div>
              <div class="table" v-show="!noData">
                <Table ref="table" :tableData="tableData" :tableHead="tableHead" />
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
import StudentCategoriesCreate from "./StudentCategoriesCreate.vue";

export default {
	components: {
		StudentCategoriesCreate,
	},
	data() {
		return {
			breadcrumbList: [
				{
					to: { name: "admin.dashboard" },
					name: "Home",
				},
				{
					name: "Categories",
				},
			],
			tableHead: {
				items: {
					item1: { label: "Sr.No." },
					item2: { label: "Category Name" },
				},
				actions: true,
			},
			tableData: [],
			categoryList: [],
			initcategoryList: [],
			isLoaded: false,
			noData: false,
			editItem: {},
			editedIndex: -1,
		};
	},

	created() {
		this.$parent.loadOtherScript();
		toast = Toast.fire({
			icon: "warning",
			title: "Loading data...",
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
				`/api/school/students/student_categories`,
				null
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.categoryList = data.student_categories;
					this.initTable();
				} else {
					toast = Toast.fire({
						icon: data.status,
						title: data.message,
						timer: 2500,
					});
					this.noData = true;
				}
			} else {
				toast = Toast.fire({
					icon: data.status,
					title: data.message,
					timer: 2500,
				});
			}
			this.$refs.table.loadTable();
			this.isLoaded = true;
			toast.close();
		},
		initTable() {
			this.tableData = [];
			this.categoryList.forEach((element) => {
				this.tableData.push({
					item: element,
					data: {
						item1: element.category_id != null ? element.category_id : '',
						item2: element.category_name != null ? element.category_name : '',
					},
					action: {
						edit: true,
						delete: true,
					},
				});
			});
		},

		async saveData(items) {
			this.editItem = items;
			var data = new FormData();
			data.append("category_name", this.editItem.category_name ? this.editItem.category_name : '');
			const res = await this.callApi(
				"post",
				`/api/school/students/student_categories/save`,
				data
			);
			if (res.data.status == 'warning'){				
					toast = Toast.fire({
						icon: res.data.status,
						title: res.data.message,
						timer: 2500,
					});
			}
			if (res.status == 200) {
				this.$refs.studentCategoryCreate.resetForm();
				var data = res.data;
				if (data.status == "success") {
					if (this.noData) {
						this.noData = false;
					}
					this.categoryList.unshift(data.student_categories);

					if (data.status == "success") {
						toast = Toast.fire({
							icon: data.status,
							title: data.message,
							timer: 2500,
						});
					} else {
						toast = Toast.fire({
							icon: data.status,
							title: data.message,
							timer: 2500,
						});
					}

					this.tableData.unshift({
						item: data.student_categories,
						data: {
							item1: data.student_categories.category_id != null ? data.student_categories.category_id : '',
							item2: data.student_categories.category_name != null ? data.student_categories.category_name : '',
						},
						action: {
							delete: true,
							edit: true,
						},
					});
				}
			}
		},
		edit(item) {
			this.$refs.studentCategoryCreate.edit(item);
			this.editedIndex = item.category_id;
		},
		async updateData() {
			var data = new FormData();
			data.append("category_name", this.editItem.category_name);
			const res = await this.callApi(
				"post",
				`/api/school/students/student_categories/update/${this.editedIndex}`,
				data
			);

			if (res.status == 200) {
				this.$refs.studentCategoryCreate.resetForm();

				var data = res.data;
				if (data.status == "success") {
					this.initTable();
					toast = Toast.fire({
						icon: data.status,
						title: data.message,
						timer: 2500,
					});
				} else {
					toast = Toast.fire({
						icon: data.status,
						title: data.message,
						timer: 2500,
					});
				}
			}
		},
		async deleteData(item, index) {
			var data = new FormData();
			data.append("status", "deleted");
			const res = await this.callApi(
				"post",
				`/api/school/students/student_categories/delete/${item.category_id}`,
				data
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.categoryList.splice(index, 1);
					this.tableData.splice(index, 1);
					SwalCustomBtn.fire("Deleted!", data.message, "success");
					toast = Toast.fire({
						icon: data.status,
						title: data.message,
						timer: 2500,
					});
				} else {
					toast = Toast.fire({
						icon: data.status,
						title: data.message,
						timer: 2500,
					});
				}
			}
		},
	},
};
</script>
