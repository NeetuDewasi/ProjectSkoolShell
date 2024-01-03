import StudentAdmission from "../../components/pages/students/StudentAdmission.vue";
import StudentCategories from "../../components/pages/students/student_categories/StudentCategories.vue";
import StudentDetails from "../../components/pages/students/student_details/StudentDetails.vue";
import StudentDetailViewPage from "../../components/pages/students/student_details/StudentDetailViewPage.vue";
import StudentDetailsCreate from "../../components/pages/students/student_details/StudentDetailsCreate.vue";
import StudentHistory from "../../components/pages/students/student_history/StudentHistory.vue";
import StudentHouse from "../../components/pages/students/student_house/StudentHouse.vue";
import StudentList from "../../components/pages/students/StudentList.vue";
import StudentListItem from "../../components/pages/students/StudentListItem.vue";
import StudentReport from "../../components/pages/students/student_report/StudentReport.vue";
import StudentGuardianReport from "../../components/pages/students/StudentGuardianReport.vue";
import StudentGeneralSettings from "../../components/pages/students/StudentGeneralSettings.vue";
import StudentGuardianDetail from "../../components/pages/students/StudentGuardianDetail.vue";
import StudentAddress from "../../components/pages/students/StudentAddress.vue";
import StudentTransports from "../../components/pages/students/StudentTransports.vue";
import StudentHostels from "../../components/pages/students/StudentHostels.vue";
import StudentOtherDetails from "../../components/pages/students/StudentOtherDetails.vue";
import StudentDocuments from "../../components/pages/students/StudentDocuments.vue";
import XStudents from "../../components/pages/students/x_students/XStudents.vue";
import XStudentDeatilPage from "../../components/pages/students/x_students/XStudentDeatilPage.vue";

export default [
    {
        name: "school.students",
        path: "/school/students",
        component: StudentList,
        props: true,
    },
    {
        name: "school.students.list_item",
        path: "/school/students/list_item",
        component: StudentListItem,
        props: true,
    },
    {
        name: "school.students.admissions",
        path: "/school/students/admission",
        component: StudentAdmission,
        props: true,
    },

    {
        name: "school.students.admissions.edit",
        path: "/school/students/admission/:edit_id",
        component: StudentAdmission,
        props: true,
    },
    {
        name: "school.students.reports",
        path: "/school/students/reports",
        component: StudentReport,
        props: true,
    },
    {
        name: "school.students.houses",
        path: "/school/students/house",
        component: StudentHouse,
        props: true,
    },
    {
        name: "school.students.history",
        path: "/school/students/history",
        component: StudentHistory,
        props: true,
    },
    {
        name: "school.students.details",
        path: "/school/students/details",
        component: StudentDetails,
        props: true,
    },
    {
        name: "school.students.details_view",
        path: "/school/students/student_details/details_view/:student_admission_id",
        component: StudentDetailViewPage,
        props: true,
    },
    {
        name: "school.students.details_create",
        path: "/school/students/details_create",
        component: StudentDetails,
        props: true,
    },
    {
        name: "school.students.guardian_report",
        path: "/school/students/guardian_report",
        component: StudentGuardianReport,
        props: true,
    },
    {
        name: "school.students.categories",
        path: "/school/students/categories",
        component: StudentCategories,
        props: true,
    },
    {
        name: "school.students.categories.edit",
        path: "/school/students/categories:edit_id",
        component: StudentCategories,
        props: true,
    },
    {
        name: "school.students.settings",
        path: "/school/students/settings",
        component: StudentGeneralSettings,
        props: true,
    },

    {
        name: "school.students.x_students",
        path: "/school/students/x_students",
        component: XStudents,
        props: true,
    },
    {
        name: "school.students.disabled",
        path: "/school/students/disabled",
        component: XStudentDeatilPage,
        props: true,
    },
    {
        name: "school.students.guardian_detail",
        path: "/school/students/:student_admission_id/guardian_detail",
        component: StudentGuardianDetail,
        props: true,
    },

    {
        name: "school.students.guardian_detail",
        path: "/school/students/:edit_id/guardian_detail",
        component: StudentGuardianDetail,
        props: true,
    },

    {
        name: "school.students.address",
        path: `/school/students/:student_admission_id/address`,
        component: StudentAddress,
        props: true,
    },

    {
        name: "school.students.transports",
        path: "/school/students/:student_admission_id/transports",
        component: StudentTransports,
        props: true,
    },
    {
        name: "school.students.hostels",
        path: "/school/students/:student_admission_id/hostels",
        component: StudentHostels,
        props: true,
    },

    {
        name: "school.students.student_other_details",
        path: "/school/students/:student_admission_id/student_other_details",
        component: StudentOtherDetails,
        props: true,
    },
    {
        name: "school.students.documents",
        path: "/school/students/:admission_id/documents",
        component: StudentDocuments,
        props: true,
    },
];
