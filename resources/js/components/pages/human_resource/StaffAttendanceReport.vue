<template>
    <div>
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start -->
            <Breadcrumb pageTitle="Staff Attendance Report" :breadcrumbList="breadcrumbList" />
            <!-- End Breadcubs Area -->
            <!-- Staff Attendance Start Here -->
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card height-auto">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Select Craiteria</h3>
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
                                        <label>From Date</label>
                                        <input type="text" placeholder="dd/mm/yyyy" class="form-control air-datepicker"/>
                                        <i class="far fa-calendar-alt"></i>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-12 form-group">
                                        <label>To Date</label>
                                        <input type="text" placeholder="dd/mm/yyyy" class="form-control air-datepicker"/>
                                        <i class="far fa-calendar-alt"></i>
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
                                            <th>Staff Name</th>
                                            <th>Present</th>
                                            <th>Absent</th>
                                            <th>Late</th>
                                            <th>Holiday</th>
                                            <th>Half Day</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <StaffAttendanceListItem :staffAttendance="staffAttendanceItem" v-for="(staffAttendanceItem, index) in staffAttendance" :key="index" />
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Staff Attendance Report End Here -->
            <Footer/>
        </div>
    </div>
</template>

<script>
	import StaffAttendanceListItem from "./StaffAttendanceListItem.vue";
	export default {
		components: {
			StaffAttendanceListItem,
		},
		data() {
			return {
				breadcrumbList: [
					{
						to: { name: "admin.dashboard" },
						name: "Home",
					},
					{
						name: "staff Attendance",
					},
				],
				staffAttendance: [
					{
						id: "1",
						name: "Abc",
						present: "10",
						absent: "5",
						late: "0",
						holiday: "2",
						half_day: "2",
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
