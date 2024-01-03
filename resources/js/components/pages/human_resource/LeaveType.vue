<template>
    <div>
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start -->
            <Breadcrumb pageTitle="Leave Type" :breadcrumbList="breadcrumbList" />
            <!-- End Breadcubs Area -->
            <!-- Add Leave Type Area Start Here -->
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card height-auto">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                <h3>Add Leave Type</h3>
                                </div>
                            </div>
                            <form class="new-added-form">
                                <div class="row gutters-20 d-flex justify-content-between">
                                    <div class="col-xl-9 col-lg-9 col-12 form-group">
                                        <label> Leave Type Name <strong class="text-danger">*</strong></label>
                                        <input type="text" placeholder="Enter Leave Type Name" class="form-control" v-model="editItem.department_name" />
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-12 form-group justify-content-end mt-5 ms-5">
                                        <button type="submit" class="btn btn-lg btn-gradient-yellow btn-hover-bluedark mx-3 text-white mt-4"
                                                @click.prevent="submitForm()">
                                                {{formBtn}}
                                        </button>
                                        <button type="reset" class="btn btn-lg bg-blue-dark btn-hover-yellow text-white mt-4">
                                            Reset
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <div class="col-8-xxxl col-12">
                                <div class="card height-auto">
                                    <div class="card-body">
                                        <div class="heading-layout1">
                                            <div class="item-title">
                                                <h3>All Department Lists</h3>
                                            </div>
                                        </div>
                                        <div class="table-responsive" v-if="!noData">
                                            <table class="table display text-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input checkAll">
                                                                <label class="form-check-label">ID</label>
                                                            </div>
                                                        </th>
                                                        <th>Name</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <LeaveTypeReport :leaveTypes="dleaveTypeItem" :index=index v-for="(dleaveTypeItem, index) in leaveTypes" :key="index" />
                                                </tbody>
                                            </table>
                                        </div>
                                        <div v-else>
                                            No Data Found
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- All Leave Type List Area End Here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Footer />
    </div>
</template>
<script>
    import LeaveTypeReport from "./LeaveTypeReport.vue";
    export default {
        components: {
            LeaveTypeReport,
        },
        data() {
            return {
                breadcrumbList: [
                    {
                    to: { name: "admin.dashboard" },
                    name: "Home",
                    },
                    {
                    name: "Department",
                    },
                ],
            };
        },
        mounted() {
            this.$parent.loadOtherScript();
        },
    };
</script>


<style scoped>

</style>
