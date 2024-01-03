<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb pageTitle="Library Categories" :breadcrumbList="breadcrumbList" />
            <div class="row gutters-20">
				<div class="col-12">
					<LibraryBookCategoryCreate ref="libraryBookCategoryCreate" />
				</div>
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div class="item-title">
								<h3>Categories List</h3>
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
            <Footer/>
        </div>
    </div>
</template>

<script>
    import LibraryBookCategoryCreate from './LibraryBookCategoryCreate.vue';
    var toast;
    export default{
        components: {LibraryBookCategoryCreate},
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
						name: "Categories",
					},
				],
                categories: [],
                tableHead: {
					items: {
						item1: { label: "Sr.No." },
						item2: { label: "Name" },
					},
					actions: true,
				},
                tableData: [],
                isLoaded: false,
                noData: false
		    };
        },
        created(){
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
					`/api/school/library/categories`,
					null,
				);
				if (res.status == 200) {
					var data = res.data;
					if (data.status == "success") {
                        this.log('yes',res.data);
						this.categories = data.categories;
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
				this.categories.forEach((element) => {
					this.tableData.push({
						item: element,
						data: {
							item1: element.category_id,
							item2: element.category_name,
						},
						action: {
                            edit : true,
							delete: true,
						},
					});
				});
			},
            async saveData(item) {
                this.editItem = item;
                var data = new FormData();
                data.append("category_name", this.editItem.category_name);
                const res = await this.callApi(
                    "post",
                    `/api/school/library/categories/save`,
                    data
                );

                if (res.status == 200) {
                    var data = res.data;
                    if (data.status == "success") {
                        if (this.noData) {
                            this.noData = false;
                        }
                        this.categories.push(data.category);
                        this.initTable();
                        toast = Toast.fire({
                            icon: "success",
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
                } else {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                }
            },

            edit(item) {
                this.$refs.libraryBookCategoryCreate.edit(item);
                window.scrollTo(0, 0);
            },

            async updateData(item, itemID) {
                this.editItem = item;
                this.editedIndex = itemID;
                var data = new FormData();
                data.append("category_name", this.editItem.category_name);
                const res = await this.callApi(
                    "post",
                    `/api/school/library/categories/update/${this.editedIndex}`,
                    data
                );

                if (res.status == 200) {
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
                            timer: 0,
                        });
                    }
                } else {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 0,
                    });
                }
            },
            async deleteData(item, index) {
				var data = new FormData();
				data.append("status", "deleted");
				const res = await this.callApi(
					"post",
					`/api/school/library/categories/delete/${item.category_id}`,
					data,
				);
                this.log('res' , res);
				if (res.status == 200) {
					var data = res.data;
					if (data.status == "success") {
						this.categories.splice(index, 1)
                         this.tableData.splice(index, 1);
                        SwalCustomBtn.fire('Deleted!',data.message,'success');
					}else{
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
