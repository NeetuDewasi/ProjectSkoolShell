<template>
    <div class="dashboard-content-one">
        <Breadcrumb pageTitle="Leave Group Rules" :breadcrumbList="breadcrumbList" />
        <div class="row gutters-20">
            <div class="col-12">
                <div class="card height-auto">
                    <div class="card-body">
                        <form class="new-added-form">
                            <div class="row">
                                <div class="col-12" v-for="(type, index) in leaveTypes" :key="index">
                                    <div class="form-group row mb-3">
                                        <label class="col-md-3 text-right">{{ type.leave_type_title }}</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="number" v-model="editItem.leave_type_counts[index]" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn-fill-lg text-light shadow-dodger-blue bg-dodger-blue" @click.prevent="submitData()">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <Footer />
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
                        to: { name: "school.hr.leaves.groups" },
						name: "Groups",
					},
					{
						name: "Rules",
					},
				],
                leaveGroupId: -1,
                leaveTypes: [],
                editItem: {
                    leave_type_ids: [],
                    leave_type_counts: [],
                },
                noData: false
		    };
        },
        created(){
            toast = Toast.fire({
                icon: "warning",
                title: "Loading Data..",
                timer: 0,
            });
        },
        mounted() {
            this.$parent.loadOtherScript();
            this.leaveGroupId = this.$route.params.group_id;
            this.showData();
        },
        methods: {
            async showData() {
				const res = await this.callApi("get", `/api/school/hr/leaves/groups/${this.leaveGroupId}/rules`, null);

                this.log('ShowData CALLED>>>',res);
                if (res.status == 200) {
					var data = res.data;
					if (data.status == "success") {
						this.leaveTypes = data.leave_types;
                        this.leaveGroup = data.leave_group;
                        this.leaveGroupRules = data.leave_group_rules;
                        this.leaveTypes.forEach((element, index) => {
                            this.editItem.leave_type_ids[index] = element.leave_type_id;
                            this.editItem.leave_type_counts[index] = 0;
                            if(this.leaveGroupRules.length > index) {
                                this.editItem.leave_type_counts[index] = this.leaveGroupRules[index].leave ? this.leaveGroupRules[index].leave : 0;
                            }
                        });
					} else {
                        toast = Toast.fire({
                            icon: "error",
                            title: "Something went wrong",
                            timer: 0,
                        });
						this.noData = true;
					}
				}
				toast.close();
			},
            async submitData() {
                var data = new FormData();
                data.append("leave_rule_data", JSON.stringify(this.editItem));
                let url = `/api/school/hr/leaves/groups/${this.leaveGroupId}/rules/save`;
                const res = await this.callApi("post",url,data);
                this.log('submitData CALLED>>>',res);

                if (res.status == 200) {
                    var data = res.data;
                    if (data.status == "success") {
                        this.leaveTypes = data.leave_types;
                        this.leaveGroup = data.leave_group;
                        this.leaveGroupRules = data.leave_group_rules;
                        this.leaveTypes.forEach((element, index) => {
                            this.editItem.leave_type_ids[index] = element.leave_type_id;
                            this.editItem.leave_type_count[index] = 0;
                            if(this.leaveGroupRules.length > index) {
                                this.editItem.leave_type_counts[index] = this.leaveGroupRules[index].leave ? this.leaveGroupRules[index].leave : 0;
                            }
                        });
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
            }
        },
    };
</script>
<style scoped>
</style>
