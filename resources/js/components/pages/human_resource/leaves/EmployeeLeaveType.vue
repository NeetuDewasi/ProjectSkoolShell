<template>
    <div>
        <div class="dashboard-content-one">
			<Breadcrumb
				pageTitle="Leave Types"
				:breadcrumbList="breadcrumbList"
			/>
			<div class="row gutters-20">
				<div class="col-12">
					<EmployeeLeaveTypeCreate ref="employeeLeaveTypeCreate" />
				</div>
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div class="item-title">
								<h3>Leave Types List</h3>
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
			<Footer />
		</div>
    </div>
</template>

<script>
    import EmployeeLeaveTypeCreate from './EmployeeLeaveTypeCreate.vue'
    var toast;
    export default{
        components: {EmployeeLeaveTypeCreate},
        data() {
			return {
				breadcrumbList: [
					{
						to: { name: "admin.dashboard" },
						name: "Home",
					},
					{
						name: "Leave",
					},
					{
						name: "Types",
					},
				],
                selectedDepartmentId: -1,
                leaveTypes: [],
                tableHead: {
					items: {
						item1: { label: "Sr.No." },
						item2: { label: "Title" },
					},
					actions: true,
				},
                editItem: {},
                editedIndex: -1,
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
					`/api/school/hr/leaves/types`,
					null,
				);
				if (res.status == 200) {
					var data = res.data;
					if (data.status == "success") {
                        this.log('yes',res.data);
						this.leaveTypes = data.leave_types;
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
				this.leaveTypes.forEach((element) => {
					this.tableData.push({
						item: element,
						data: {
							item1: element.leave_type_id,
							item3: element.leave_type_title,
						},
						action: {
                            edit : true,
							delete: true,
						},
					});
				});
			},
            async submitData(item, index) {
                this.log("submitData(item, index)", index);
                this.editItem = item;
                if(index != -1) this.editedIndex = item.leave_type_id;

                var data = new FormData();
                data.append("leave_type_title", this.editItem.leave_type_title);

                let url = `/api/school/hr/leaves/types/save`;
                if(this.editedIndex != -1) url = `/api/school/hr/leaves/types/update/${this.editedIndex}`

                const res = await this.callApi(
                    "post",
                    url,
                    data
                );

                if (res.status == 200) {
                    var data = res.data;
                    if (data.status == "success") {
                        this.$refs.employeeLeaveTypeCreate.resetForm();
                        if (this.noData) {
                            this.noData = false;
                        }
                        if(this.editedIndex != -1) {
                            this.leaveTypes[index] = data.leave_type;
                            this.tableData[index] = data.leave_type;
                        } else {
                            this.leaveTypes.unshift(data.leave_type);
                            this.tableData.unshift({
                                item: data.leave_type,
                                data: {
                                    item1: data.leave_type.leave_type_id,
                                    item2: data.leave_type.leave_type_title,
                                },
                                action: {
                                    edit : true,
                                    delete: true,
                                },
                            });
                        }
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
                this.$refs.employeeLeaveTypeCreate.edit(item);
                window.scrollTo(0, 0);
            },
            async deleteData(item, index) {
				var data = new FormData();
				data.append("status", "deleted");
				const res = await this.callApi(
					"post",
					`/api/school/hr/leaves/types/delete/${item.leave_type_id}`,
					data,
				);
				if (res.status == 200) {
					var data = res.data;
					if (data.status == "success") {
						this.leaveTypes.splice(index, 1)
                         this.tableData.splice(index, 1);
                        SwalCustomBtn.fire('Deleted!', data.message, 'success');
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
                        title: "Something Went Wrong, unable to delete",
                        timer: 0,
                    });
                }
			},
        },
    };
</script>
<style scoped>

</style>
