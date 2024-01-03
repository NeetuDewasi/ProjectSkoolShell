<template>
    <div>
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start -->
            <Breadcrumb pageTitle="Staff Attendence" :breadcrumbList="breadcrumbList" />
            <!-- End Breadcubs Area -->
            <!-- Staff Attendence  Area Start -->
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card height-auto">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Select Craiteria </h3>
                                </div>
                            </div>
                            <form class="mg-b-20 new-added-form">
                                <div class="row gutters-20">
                                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                                        <label>Role *</label>
                                        <Select2
                                            :item="[{value: 0, name: 'Select'}, {value: 1, name: '1'}, {value: 2, name: '2'}]"
                                        />
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                                        <label>Attendence Date</label>
                                         <input type="text" placeholder="dd/mm/yyyy" class="form-control air-datepicker">
                                        <i class="far fa-calendar-alt"></i>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-gradient-yellow btn-lg btn-hover-bluedark text-white">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="heading-layout1 d-flex justify-content-between">
                                <div class="item-title">
                                    <h3>Attendence List</h3>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="text-center mx-2">
                                        <div class="btn att-p-btn">P</div>
                                        <div>Present</div>
                                    </div>
                                    <div class="text-center mx-2">
                                        <div class="btn att-l-btn">L</div>
                                        <div>Late</div>
                                    </div>
                                    <div class="text-center mx-2">
                                        <div class="btn att-h-btn">H</div>
                                        <div>Half Day</div>
                                    </div>
                                    <div class="text-center mx-2">
                                        <div class="btn att-a-btn">A</div>
                                        <div>Absent</div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="row">
                                    <div class="card shadow-lg col-2 rounded-2 d-flex align-items-center m-3"
                                        :class="selectClass(attendance)"
                                        v-for="(attendance, index) in attendanceList"
                                        :key="index">
                                        <div class="mt-5">
                                            <div class="text-center">
                                                <img class="student-avatar" src="/assets/img/figure/student.png"
                                                    width="50"
                                                    height="50" />
                                                <div class="d-flex justify-content-between">
                                                    <div class="text-center">
                                                        <div>Staff Id</div>
                                                        <div>{{attendance.staff_id}}</div>
                                                    </div>
                                                    <div class="text-center">
                                                        <div>Role</div>
                                                        <div>{{attendance.role}}</div>
                                                    </div>
                                                </div>
                                                <div>Student Name</div>
                                            </div>
                                            <div class="d-flex w-100 justify-content-between">
                                                <div class="btn att-p-btn mx-2">P</div>
                                                <div class="btn att-l-btn mx-2">L</div>
                                                <div class="btn att-h-btn mx-2">H</div>
                                                <div class="btn att-a-btn mx-2">A</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Staff Attendence Area End Here -->
            <Footer/>
        </div>
    </div>
</template>

<script>
    // import EvaluationReportListItem from "./EvaluationReportListItem.vue";
    export default{
        data() {
			return {
				breadcrumbList: [
					{
						to: { name: "admin.dashboard" },
						name: "Home",
					},
					{
						name: "Staff Attendence",
					},
				],
                attendanceList: [
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
                        attendance: 1,
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
                        attendance: 1,
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
                        attendance: 1,
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
                        attendance: 1,
                    },
                ],
		    };
        },
        mounted() {
           this.$parent.loadOtherScript();
        },
        methods: {
            selectClass(attendance) {
                if(attendance.attendance == 1)
                return 'att-p';
                else if(attendance.attendance == 2)
                return 'att-l';
                else if(attendance.attendance == 3)
                return 'att-h';
                else if(attendance.attendance == 4)
                return 'att-a';
            }
        }
    };
</script>

<style scoped>
    .student-avatar{
        border-radius: 50%;
        border:black 1px solid;
    }

    .att-p{
        background-color: rgb(193, 255, 208);
    }
    .att-l{
        background-color: rgb(255, 249, 193);
    }
    .att-h{
        background-color: rgb(193, 235, 255);
    }
    .att-a{
        background-color: rgb(255, 193, 193);
    }

    .att-p-btn{
        background-color: rgb(102, 172, 119);
        color: white;
    }
    .att-l-btn{
        background-color: rgb(173, 167, 106);
        color: white;
    }
    .att-h-btn{
        background-color: rgb(95, 150, 175);
        color: white;
    }
    .att-a-btn{
        background-color: rgb(187, 104, 104);
        color: white;
    }
</style>
