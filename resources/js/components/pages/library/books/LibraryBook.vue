<template>
	<div>
		<div class="dashboard-content-one">
			<Breadcrumb pageTitle="Books" :breadcrumbList="breadcrumbList">
				<template v-slot:button>
					<button
						type="submit"
						class="btn btn-success btn-sm text-white"
						@click="
							$router.push({
								name: 'school.library.books.create',
							})
						"
					>
						<i class="fa fa-plus"></i> Add New Book
					</button>
				</template>
			</Breadcrumb>
			<div class="row gutters-20">
				<div class="col-12">
					<div class="card height-auto">
						<div class="card-body">
							<div class="heading-layout1">
								<div class="item-title">
									<h3>Book List</h3>
								</div>
							</div>
							<div v-show="!noData">
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
			<Footer />
		</div>
	</div>
</template>

<script>
var toast;
export default {
	data() {
		return {
			breadcrumbList: [
				{
					to: { name: "admin.dashboard" },
					name: "Home",
				},
				{
					name: "Library",
				},
				{
					name: "Books",
				},
			],
			books: [],
			tableHead: {
				items: {
					item1: { label: "Sr.No." },
					item2: { label: "Code" },
					item3: { label: "Category" },
					item4: { label: "Title" },
					item5: { label: "Author" },
					item6: { label: "Shelf" },
					item7: { label: "Availability" },
				},
				actions: true,
			},
			tableData: [],
			isLoaded: false,
			noData: false,
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
				`/api/school/library/books`,
				null
			);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.books = data.books;
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
			this.books.forEach((element) => {
				this.tableData.push({
					item: element,
					data: {
						item1: element.book_id,
						item2: element.book_code,
						item3: element.book_category_name,
						item4: element.book_title,
						item5: element.book_author,
						item6: element.book_shelf,
						item7: element.book_availability,
					},
					action: {
						edit: true,
						delete: true,
					},
				});
			});
		},
		edit(item) {
			this.$router.push({
				path: `/school/hr/books/basic_info/create/${item.employee_id}`,
			});
		},
		async deleteData(item, index) {
			var data = new FormData();
			data.append("fees_master_status", "deleted");
			const res = await this.callApi(
				"post",
				`/api/school/hr/books/delete/${item.employee_id}`,
				data
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.books.splice(index, 1);
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
