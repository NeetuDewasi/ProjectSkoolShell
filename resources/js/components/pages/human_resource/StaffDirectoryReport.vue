<template>
    <div>
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start -->
            <Breadcrumb pageTitle="Staff Directory Report" :breadcrumbList="breadcrumbList" />
            <!-- End Breadcubs Area -->
            <!-- Staff Directory Report Area Start -->
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card height-auto">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Select Craiteria</h3>
                                </div>
                            </div>
                            <form class="mg-b-20">
                                <div class="row gutters-20">
                                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                                        <label>Role *</label>
                                        <Select2
                                            :item="[{value: 0, name: 'Select'}, {value: 1, name: '1'}, {value: 2, name: '2'}]"
                                        />
                                    </div>
                                    <div class="col-xl-6 col-lg-3 col-12 form-group">
                                        <label>Search By Keyword</label>
                                        <input type="text" placeholder="Search by Name, Staff ID, Roll etc..." class="form-control">

                                    </div>
                                 </div>
                               <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-gradient-yellow btn-lg btn-hover-bluedark text-white">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </form>
                            <div class="card shadow-lg col-12 rounded-2 m-3"
                                v-for="(staff, index) in staffList"
                                :key="index">
                                <div class="mt-5 d-flex justify-content-between">
                                    <div class="pl-4">
                                        <img class="staff-avatar" :src="staff.avtar"
                                            width="100"
                                            height="100"
                                        />
                                    </div>
                                    <div class="text-dark font-bold pr-lg-5">
                                        <div>Name</div>
                                        <div>Father Name</div>
                                        <div>Mother Name</div>
                                        <div>Gender</div>
                                        <div>Mobile Number</div>
                                        <div>Date Of Birth</div>
                                    </div>
                                    <div class="pr-lg-5">
                                        <div>{{staff.name}}</div>
                                        <div>{{staff.f_name}}</div>
                                        <div>{{staff.m_name}}</div>
                                        <div>{{staff.gender}}</div>
                                        <div>{{staff.mobile}}</div>
                                        <div>{{staff.dob}}</div>
                                    </div>
                                    <div class="text-dark font-bold pr-lg-5">
                                        <div>Role</div>
                                        <div>Desgination</div>
                                        <div>Department</div>
                                        <div>Date Of Joining</div>
                                        <div>Email</div>
                                        <div>Staff Id</div>
                                    </div>
                                     <div class="pr-lg-5">
                                        <div>{{staff.role}}</div>
                                        <div>{{staff.desgination}}</div>
                                        <div>{{staff.department}}</div>
                                        <div>{{staff.doj}}</div>
                                        <div>{{staff.email}}</div>
                                        <div>{{staff.staff_id}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Staff Directory Report Area End Here -->
            <Footer/>
        </div>
    </div>
</template>

<script>
    // import EvaluationReportListItem from "./EvaluationReportListItem.vue";
    export default{
        // components: {
		// 	EvaluationReportListItem,
		// },
        data() {
			return {
				breadcrumbList: [
					{
						to: { name: "admin.dashboard" },
						name: "Home",
					},
					{
						name: "Staff Directory Report",
					},
				],
                staffList: [
                    {
                        avtar: "/assets/img/figure/student.png",
                        name: "Abc",
                        f_name: "def",
                        m_name: "xyz",
                        gender: "male",
                        mobile: "8921345632",
                        dob: "29/04/1996",
                        role: "Admin",
                        desgination: "Director",
                        department: "Science",
                        doj: "02/10/22",
                        email: "abc@gmailcom",
                        staff_id: "s-101",
                    },
                    {
                        avtar: "/assets/img/figure/student.png",
                        name: "Abc",
                        f_name: "def",
                        m_name: "xyz",
                        gender: "male",
                        mobile: "8921345632",
                        dob: "29/04/1996",
                        role: "Admin",
                        desgination: "Director",
                        department: "Science",
                        doj: "02/10/22",
                        email: "abc@gmailcom",
                        staff_id: "s-101",
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
    .staff-avatar{
        border-radius: 50%;
        border:black 1px solid;
    }

</style>
