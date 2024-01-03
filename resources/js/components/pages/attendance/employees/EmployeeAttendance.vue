<template>
	<div>
		<div class="dashboard-content-one">
			<Breadcrumb pageTitle="employee Attendance" :breadcrumbList="breadcrumbList" />
			<div class="row gutters-20">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<form class="new-added-form">
								<div class="row">
									<div class="col-6 form-group">
										<label>Department</label>
										<Select2
											key="department_list"
											ref="department_list"
											:item="department_list"
											@change="selectDepartment" />
									</div>
									<div class="col-6 form-group">
										<label>Date</label>
										<DatePicker
											format="DD-MMM-YYYY"
											value-type="format"
											type="date"
											placeholder="Select a date"
											v-model="displayDate"
											:default-value="new Date()"
											:disabled-date="disabledAfterToday"
											class="form-control vue-datepicker my-0"
										/>
									</div>
								</div>
							</form>

							<div class="heading-layout1 row">
								<div class="col-xl-9 form-group">
									<input
										type="text"
										placeholder="Search Employee"
										class="form-control"
                                        v-model="searchEmployee" />
								</div>
								<div class="col-md-3 d-flex justify-content-between" >
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
									<div
										class="
											card
											shadow-lg
											col-2
											rounded-2
											d-flex
											align-items-center
											m-3
										"
										:class="
											selectBackground(employee.attendance)
										"
										v-for="(employee, index) in filteredList"
										:key="index"
									>
										<div class="mt-5">
											<div class="text-center">
												<img
													class="employee-avatar"
													src="/assets/img/figure/student.png"
													width="50"
													height="50"
												/>

												<div>
													{{
														`${employee.employee_first_name} ${employee.employee_last_name}`
													}}
												</div>

												<div
													class="
														d-flex
														justify-content-between
														align-items-baseline
													"
												>
													<div
														class="text-center mr-2"
													>
														<div
															style="
																font-size: 12px;
															"
														>
															Reg. No.
														</div>
													</div>
													<div class="text-center">
														<div>
															{{
																employee.employee_registration_number
															}}
														</div>
													</div>
												</div>

												<div
													class="
														d-flex
														justify-content-between
														align-items-baseline
													"
												>
													<div
														class="text-center mr-2"
													>
														<div
															style="
																font-size: 12px;
															"
														>
															Department
														</div>
													</div>
													<div class="text-center">
														<div>
															{{
																employee.employee_department_name
															}}
														</div>
													</div>
												</div>
											</div>
											<div
												class="
													d-flex
													w-100
													justify-content-between
												"
											>
												<div
													class="btn att-p-btn mx-2"
													@click="
														employee.attendance = 1
													"
												>
													P
												</div>
												<div
													class="btn att-l-btn mx-2"
													@click="
														employee.attendance = 2
													"
												>
													L
												</div>
												<div
													class="btn att-h-btn mx-2"
													@click="
														employee.attendance = 3
													"
												>
													H
												</div>
												<div
													class="btn att-a-btn mx-2"
													@click="
														employee.attendance = 4
													"
												>
													A
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<button
									type="button"
									class="
										btn-fill-lg
										text-light
										shadow-dodger-blue
										bg-dodger-blue
									"
									@click.prevent="saveData()"
								>
									SAVE
								</button>
							</div>

                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <h4>Employees On Leave</h4>
                                </div>
                            </div>
							<div>
								<div class="row">
									<div
										class="card
											shadow-lg
											col-2
											rounded-2
											d-flex
											align-items-center
											m-3"
										v-for="(employee, index) in employeesOnLeave"
										:key="index"
									>
										<div class="mt-5">
											<div class="text-center">
												<img
													class="employee-avatar"
													src="/assets/img/figure/student.png"
													width="50"
													height="50"
												/>

												<div>
													{{
														`${employee.employee_first_name} ${employee.employee_last_name}`
													}}
												</div>

												<div
													class="d-flex
														justify-content-between
														align-items-baseline"
												>
													<div
														class="text-center mr-2"
													>
														<div
															style="font-size: 12px;"
														>
															Reg. No.
														</div>
													</div>
													<div class="text-center">
														<div>
															{{
																employee.employee_registration_number
															}}
														</div>
													</div>
												</div>

												<div
													class="d-flex
														justify-content-between
														align-items-baseline"
												>
													<div
														class="text-center mr-2"
													>
														<div
															style="font-size: 12px;"
														>
															Department
														</div>
													</div>
													<div class="text-center">
														<div>
															{{
																employee.employee_department_name
															}}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<Footer />
		</div>
	</div>
</template>


<script>
    var toast;
    export default {
        data() {
            return {
                breadcrumbList: [
                    {
                        to: { name: "admin.dashboard" },
                        name: "Home",
                    },
                    {
                        name: "Add Attendance",
                    },
                ],
                employees: [],
                employeesOnLeave: [],
                department_list: [],
                sectionList: [],
                isLoaded: false,
                noData: false,
                editItem: {},
                displayDate: "",
                attendanceDate: moment(new Date()).format("YYYY-MM-DD"),
                selectedDepartmentId: -1,
                selectedSection: -1,
                searchEmployee: '',
            };
        },
        watch: {
            displayDate: function (val) {
                this.displayDate = val;
                this.attendanceDate = moment(new Date(val)).format("YYYY-MM-DD");

                this.getEmployees();
            },
        },
        mounted() {
            this.$parent.loadOtherScript();
            this.getDepartmentList();
            this.displayDate = moment(new Date()).format("DD-MMM-YYYY");
        },
        computed: {
            filteredList() {
                if (this.searchEmployee  == '') return this.employees;
                return this.employees.filter(item => {
                    return (item.employee_first_name.toLowerCase().includes(this.searchEmployee.toLowerCase()) || item.employee_last_name.toLowerCase().includes(this.searchEmployee.toLowerCase()) || item.employee_registration_number.toLowerCase().includes(this.searchEmployee.toLowerCase()));
                });
            },
        },
        methods: {
            disabledAfterToday(date) {
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                return date > today;
            },
            selectBackground(attendance) {
                if (attendance == 1) return "att-p";
                else if (attendance == 2) return "att-l";
                else if (attendance == 3) return "att-h";
                else if (attendance == 4) return "att-a";
            },
            async getDepartmentList() {
                const res = await this.callApi(
                    "get",
                    `/api/school/general/get_department_list`,
                    null
                );
                if (res.status == 200) {
                    var data = res.data;
                    if (data.status == "success") {
                        this.department_list = data.department_list;
                        this.$refs.department_list.updateList(this.department_list);
                    }
                }
            },
            selectDepartment(val) {
                this.selectedDepartmentId = val;
                this.getEmployees();
            },
            async getEmployees() {
                if (
                    this.selectedDepartmentId === -1 ||
                    this.attendanceDate == null ||
                    this.attendanceDate == ""
                )
                    return;
                var data = new FormData();
                data.append("department_id", this.selectedDepartmentId);
                data.append("attendance_date", this.attendanceDate);
                const res = await this.callApi(
                    "post",
                    `/api/school/attendance/employee_attendance/`,
                    data
                );

                if (res.status == 200) {
                    var data = res.data;
                    if (data.status == "success") {
                        this.employees = data.employees;
                        this.employeesOnLeave = data.employees_on_leave;
                    }
                }
            },
            async saveData() {
                var employeeAttendances = [];
                this.employees.forEach((employee) => {
                    employeeAttendances.push({
                        id: employee.employee_id,
                        attendance: employee.attendance,
                    });
                });

                var data = new FormData();
                data.append(
                    "employee_attendance",
                    JSON.stringify(employeeAttendances)
                );
                data.append("department_id", this.selectedDepartmentId);
                data.append("attendance_date", this.attendanceDate);
                const res = await this.callApi(
                    "post",
                    `/api/school/attendance/employee_attendance/save`,
                    data
                );

                if (res.status == 200) {
                    var data = res.data;
                    if (data.status == "success") {
                        this.department_list.push(data.school_class);
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
        },
    };
</script>

<style scoped>
.employee-avatar {
	border-radius: 50%;
	border: black 1px solid;
}

.att-p {
	background-color: rgb(193, 255, 208);
}
.att-l {
	background-color: rgb(255, 249, 193);
}
.att-h {
	background-color: rgb(193, 235, 255);
}
.att-a {
	background-color: rgb(255, 193, 193);
}

.att-p-btn {
	background-color: rgb(102, 172, 119);
	color: white;
}
.att-l-btn {
	background-color: rgb(173, 167, 106);
	color: white;
}
.att-h-btn {
	background-color: rgb(95, 150, 175);
	color: white;
}
.att-a-btn {
	background-color: rgb(187, 104, 104);
	color: white;
}

.form-control.mx-datepicker {
	width: 100%;
}

.mx-input-wrapper input.mx-input {
	background-color: transparent;
	box-shadow: none;
	border: none;
}
.form-control.mx-datepicker .mx-input-wrapper i {
	top: auto;
}
</style>
