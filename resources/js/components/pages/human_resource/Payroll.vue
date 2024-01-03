<template>
    <div>
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start -->
            <Breadcrumb pageTitle="Payroll" :breadcrumbList="breadcrumbList" />
            <!-- End Breadcubs Area -->
            <!-- Payroll Start Here -->
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card height-auto">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Select craitera</h3>
                                </div>
                            </div>
                            <form class="mg-b-20 new-added-form">
                                <div class="row gutters-20">
                                    <div class="col-xl-4 col-lg-4 col-12 form-group">
                                       <label>Role </label>
                                       <Select2
                                            :item="[{value: 0, name: 'Select'}, {value: 1, name: '1'}, {value: 2, name: '2'}]"
                                        />
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-12 form-group">
                                        <label>Month </label>
                                        <Select2
                                            :item="[{value: 0, name: 'Select'}, {value: 1, name: '1'}, {value: 2, name: '2'}]"
                                        />
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-12 form-group">
                                        <label>Year </label>
                                        <Select2
                                            :item="[{value: 0, name: 'Select'}, {value: 1, name: '1'}, {value: 2, name: '2'}]"
                                        />
                                    </div>
                                </div>
                                 <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-gradient-yellow btn-lg btn-hover-bluedark text-white">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table class="table display data-table text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input checkAll">
                                                    <label class="form-check-label">ID</label>
                                                </div>
                                            </th>
                                            <th>Staff ID</th>
                                            <th>Name</th>
                                            <th>Role</th>
                                            <th>Department</th>
                                            <th>Desgination</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <PayrollListItem :payroll="payrollItem" v-for="(payrollItem, index) in payroll" :key="index" />
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Payroll Report End Here -->
            <Footer/>
        </div>
    </div>
</template>

<script>
    import PayrollListItem from "./PayrollListItem.vue";
    export default{
        components: {
			PayrollListItem,
		},
        data() {
			return {
				breadcrumbList: [
					{
						to: { name: "admin.dashboard" },
						name: "Home",
					},
					{
						name: "Payroll",
					},
				],
                payroll: [
					{
                        id: "1",
                        staff_id: "s-101",
                        name: "abc",
                        role: "admin",
                        department: "science",
                        designation: "hod",
                        phone: "892414141",
                        status: "generated",
					},
                ],
		    };
        },
        mounted(){
            this.$parent.loadOtherScript();
        },
    };
</script>


<style scoped>

</style>
