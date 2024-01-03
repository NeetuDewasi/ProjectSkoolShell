import StudentAttendance from "../../components/pages/attendance/students/StudentAttendance.vue";
import EmployeeAttendance from "../../components/pages/attendance/employees/EmployeeAttendance.vue";

export default [
    {
        name: "school.attendance.students",
        path: "/school/attendance/students",
        component: StudentAttendance,
        props: true,
    },
    {
        name: "school.attendance.employees",
        path: "/school/attendance/employees",
        component: EmployeeAttendance,
        props: true,
    },
];
