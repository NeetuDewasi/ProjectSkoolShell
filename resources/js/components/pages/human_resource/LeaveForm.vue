<template>
    <div>
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start -->
            <Breadcrumb pageTitle="Human Resource" :breadcrumbList="breadcrumbList" />
            <!-- End Breadcubs Area -->
            <!-- Add leaveType Area Start Here -->
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card height-auto">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Leave Form</h3>
                                </div>
                            </div>
                            <form class="new-added-form" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-6 col-12 form-group">
                                        <label>Medical Leave</label>
                                        <input type="text" placeholder="Number Of Leaves" class="form-control">
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-12 form-group">
                                        <label>Casual Leave</label>
                                        <input type="text" placeholder="Number Of Leaves" class="form-control">
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-12 form-group">
                                        <label>Maternity Leave</label>
                                        <input type="text" placeholder="Number Of Leaves" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12 mg-t-8 d-flex justify-content-end text-white">
                                    <button type="submit" class="btn btn-gradient-yellow btn-lg btn-hover-bluedark mx-3 text-white" @click="$router.push({name: 'admin.hr.staff_payroll_form'})">
                                            Back
                                        </button>
                                    <button type="submit" class="btn btn-lg btn-gradient-yellow btn-hover-bluedark text-white" @click="$router.push('bank_form')">
                                        Save And Next
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Add Leave Form Area End Here -->
            <Footer/>
        </div>
    </div>
</template>

<script>
    // import { defineComponent } from '@vue/composition-api'
    export default{
        data() {
			return {
				breadcrumbList: [
					{
						to: { name: "admin.dashboard" },
						name: "Home",
					},
                   {
						name: "Staff",
					},
                    {
                        to: {name: "admin.hr.add_staff"},
						name: "Staff Detial",
					},
                    {
						name: "Leave Information",
					},
				],
		    };
        },
        mounted() {
           this.$parent.loadOtherScript();
        }
    };
</script>

<style scoped>
    .add-more{
        background: #f0f1f3;
        width: 100%;
    }
</style>
