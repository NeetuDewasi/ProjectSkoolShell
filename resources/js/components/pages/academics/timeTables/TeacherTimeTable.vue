<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb pageTitle="Teacher Time Table" :breadcrumbList="breadcrumbList" />
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="row d-flex">
                        <div class="col-3">
                            <div class="card">
                                <div class="card-body">
                                    <form class="new-added-form">
                                        <div class="d-flex">
                                            <div class="flex-grow-1 mr-5 form-group">
                                                <label>Select Teacher  </label>
                                                <Select2 ref="teacher_list_select2" items="teacher_list_select2"
                                                    @change="selectTeacher" />
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table">
                                        <table>
                                            <tr>
                                                <!-- <th v-for="day,dayIndex in days" :key="dayIndex">{{day}}</th> -->

                                            </tr>
                                            <tr v-for="data,index in time_table" :key="index">
                                                <td>
                                                    <th>{{ data.day }}</th>
                                                    <span class="mr-5" v-if="data.periods">{{data.periods.period_name ? data.periods.period_name  : ''}}Period</span><br>
                                                    <span v-if="data.school_class">{{data.school_class.class_name ? data.school_class.class_name : ''}}</span>
                                                    <span class="mr-5" v-if="data.school_class">{{data.school_section.section_name ? data.school_section.section_name  : ''}}</span><br>
                                                    <span v-if="data.subjects">{{data.subjects.subject_name ? data.subjects.subject_name : ''}}</span><br>
                                                    <span v-if="data.periods">{{data.periods.period_start ? data.periods.period_start : '' }}-{{data.periods.period_end ? data.periods.period_end  : ''}}</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                    name: "Teacher Time Table",
                },
            ],
            teachers: [],
            time_table: [],
            teacher_timeTable: [],
            periods: {},
            subjects: {},
            days: [
                "Monday",
                "Tuesday",
                "Wednesday",
                "Thursday",
                "Friday",
                "Saturday",
                "Sunday",
            ],
        };
    },
    mounted() {
        toast = Toast.fire({
            icon: "warning",
            title: "Loading data..",
            timer: 0,
        });
        this.showEmployees();
    },
    methods: {
        selectTeacher(employee_id) {
            this.employee_id = employee_id;
            this.showData();
        },
        async showEmployees() {
            const res = await this.callApi(
                "get",
                `/api/school/academics/teachers`,
                null
            );
            // console.log("EMPLOYEE DATA>>>", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.teacher_list = data.teachers;
                    this.$refs.teacher_list_select2.updateList(data.teachers);
                } else {
                    this.teacher_list = [];
                }
            }
        },
        async showData() {
            this.isLoaded = false;
            let formData = new FormData();
            formData.append("employee_id", this.employee_id);
            const res = await this.callApi(
                "post",
                `/api/school/academics/class_period_subjects`,
                formData
            );
            this.log("TimeTable daaataaa", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.time_table = data.teacher_timeTable;
                    this.log("IINNIITTT", this.time_table);
                }
            }
            toast.close();
        },
    },
};
</script>
