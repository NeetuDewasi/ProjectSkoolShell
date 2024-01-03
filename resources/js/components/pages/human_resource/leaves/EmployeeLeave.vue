<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb pageTitle="Employee Leave Requests" :breadcrumbList="breadcrumbList" >
                <template v-slot:button>
					<button type="submit" class="btn btn-success btn-sm text-white"
						@click="$router.push({name: 'school.hr.leaves.apply'})">
						<i class="fa fa-plus"></i> Apply Leave
					</button>
				</template>
            </Breadcrumb>
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card height-auto">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Leave Requests List</h3>
                                </div>
                            </div>
                            <div v-show="!noData">
                                <Table ref="table" :tableData="tableData" :tableHead="tableHead" />
                            </div>
                            <NoData v-show="noData" />
                        </div>
                    </div>
                </div>
                <!-- Fees Master List Area End Here -->
            </div>
            <Footer/>
        </div>
    </div>
</template>

<script>
    var toast;
    export default{
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
						name: "Employees",
					},
				],
                employeeLeaveRequests: [],
                tableHead: {
					items: {
						item1: { label: "Sr.No." },
						item2: { label: "Reg.No." },
						item3: { label: "Name" },
						item4: { label: "Department" },
						item5: { label: "Leave Date" },
						item6: { label: "Date of Joining" },
						item7: { label: "" },
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
					`/api/school/hr/employees`,
					null,
				);
				if (res.status == 200) {
					var data = res.data;
					if (data.status == "success") {
                        this.log('yes',res.data);
						this.employees = data.employees;
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
            collectFeeFunction(e) {
                this.log(e)
            },
            initTable() {
				this.tableData = [];
				this.employees.forEach((element) => {
					this.tableData.push({
						item: element,
						data: {
							item1: element.employee_id,
							item2: element.employee_registration_id,
							item3: `${element.employee_first_name}${element.employee_last_name ? ' ' + element.employee_last_name : ''}`,
							item4: element.employee_department != null ? element.employee_department.name : '',
							item5: element.employee_mobile != null ? element.employee_mobile : '',
							item6: Vue.filter("formatDate")(element.employee_date_of_join) ,
							item9: {
                                type: "action",
                                options: {
                                    label: "",
                                    style: "",
                                    class: "",
                                    icon: '<i class="fas fa-toggle-off"></i>',
                                    method: this.collectFeeFunction
                                },
                            },
						},
						action: {
                            edit : true,
							delete: true,
						},
					});
				});
			},
            edit(item){
                this.$router.push({
                    path: `/school/hr/employees/basic_info/create/${item.employee_id}`,
                });
            },
            async deleteData(item, index) {
				var data = new FormData();
				data.append("fees_master_status", "deleted");
				const res = await this.callApi(
					"post",
					`/api/school/hr/employees/delete/${item.employee_id}`,
					data,
				);
                this.log('res' , res);
				if (res.status == 200) {
					var data = res.data;
					if (data.status == "success") {
						this.employees.splice(index, 1)
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
