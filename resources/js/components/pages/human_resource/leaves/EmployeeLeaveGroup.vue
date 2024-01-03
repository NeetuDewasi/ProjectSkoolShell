<template>
    <div>
        <div class="dashboard-content-one">
			<Breadcrumb
				pageTitle="Leave Groups"
				:breadcrumbList="breadcrumbList"
			/>
			<div class="row gutters-20">
				<div class="col-12">
					<EmployeeLeaveGroupCreate ref="employeeLeaveGroupCreate" />
				</div>
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div class="item-title">
								<h3>Leave Groups List</h3>
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
    import EmployeeLeaveGroupCreate from './EmployeeLeaveGroupCreate.vue'
    var toast;
    export default{
        components: {EmployeeLeaveGroupCreate},
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
						name: "Groups",
					},
				],
                selectedDepartmentId: -1,
                leaveGroups: [],
                tableHead: {
					items: {
						item1: { label: "Sr.No." },
						item2: { label: "Department" },
						item3: { label: "Title" },
						item4: { label: "" },
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
					`/api/school/hr/leaves/groups`,
					null,
				);
				if (res.status == 200) {
					var data = res.data;
					if (data.status == "success") {
                        this.log('yes',res.data);
						this.leaveGroups = data.leave_groups;
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
				this.leaveGroups.forEach((element) => {
					this.tableData.push(this.prepareData(element));
				});
			},
            prepareData(element) {
                return {
                    item: element,
                    data: {
                        item1: element.leave_group_id,
                        item2: element.department ? element.department.name : "",
                        item3: element.leave_group_title,
                        item4: {
                            type: "action",
                            options: {
                                label: "Rules",
                                style: "",
                                class: "btn btn-sm btn-info",
                                icon: '<i class="fas fa-plus"></i>',
                                method: this.leaveGroupRuleAssign
                            },
                        },
                    },
                    action: {
                        edit : true,
                        delete: true,
                    },
                };
            },
            async submitData(item, index) {
                this.log("submitData(item, index)", index);
                this.editItem = item;
                if(index != -1) this.editedIndex = item.leave_group_id;

                var data = new FormData();
                data.append("leave_group_title", this.editItem.leave_group_title);
                data.append("department_id", this.editItem.department_id);

                let url = `/api/school/hr/leaves/groups/save`;
                if(this.editedIndex != -1) url = `/api/school/hr/leaves/groups/update/${this.editedIndex}`

                const res = await this.callApi(
                    "post",
                    url,
                    data
                );

                if (res.status == 200) {
                    var data = res.data;
                    if (data.status == "success") {
                        this.$refs.employeeLeaveGroupCreate.resetForm();
                        if (this.noData) {
                            this.noData = false;
                        }
                        if(this.editedIndex != -1) {
                            this.leaveGroups[index] = data.leave_group;
                            this.tableData[index] = data.leave_group;
                        } else {
                            this.leaveGroups.unshift(data.leave_group);
                            this.tableData.unshift({
                                item: data.leave_group,
                                data: {
                                    item1: data.leave_group.leave_group_id,
                                    item2: data.leave_group.department ? data.leave_group.department.name : "",
                                    item3: data.leave_group.leave_group_title,
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
                this.$refs.employeeLeaveGroupCreate.edit(item);
                window.scrollTo(0, 0);
            },
            async deleteData(item, index) {
				var data = new FormData();
				data.append("status", "deleted");
				const res = await this.callApi(
					"post",
					`/api/school/hr/leaves/groups/delete/${item.leave_group_id}`,
					data,
				);
				if (res.status == 200) {
					var data = res.data;
					if (data.status == "success") {
						this.leaveGroups.splice(index, 1)
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
            leaveGroupRuleAssign(item, index) {
                this.$router.push({name: 'school.hr.leaves.groups.rules', params: {group_id: item.leave_group_id}})
            }
        },
    };
</script>
<style scoped>

</style>
