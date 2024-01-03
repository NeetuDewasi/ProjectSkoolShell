import MainReport from "../../components/pages/reports_dynamic/MainReport.vue";
import StudentDetailReport from "../../components/pages/reports_dynamic/StudentDetailReport.vue";
import AttendanceReport from "../../components/pages/reports_dynamic/AttendanceReport.vue";
import FinanceReport from "../../components/pages/reports_dynamic/FinanceReport.vue";
import ExaminationReport from "../../components/pages/reports_dynamic/ExaminationReport.vue";
import LibraryReport from "../../components/pages/reports_dynamic/LibraryReport.vue";
import HumanResource from "../../components/pages/reports_dynamic/HumanResource.vue";
import InventoryReport from "../../components/pages/reports_dynamic/InventoryReport.vue";
import HostelReport from "../../components/pages/reports_dynamic/HostelReport.vue";
import TransportReport from "../../components/pages/reports_dynamic/TransportReport.vue";
import StudentReport from "../../components/pages/reports/StudentReport.vue";
import StudentHostelFullReport from "../../components/pages/reports/StudentHostelFullReport.vue";
import StudentTransportReport from "../../components/pages/reports/StudentTransportReport.vue";
import TransactionReport from "../../components/pages/reports/TransactionReport.vue";
import StudentLoginCredential from "../../components/pages/reports/StudentLoginCredential.vue";
import StudentEvaluationReport from "../../components/pages/reports/StudentEvaluationReport.vue";
import GuardianReport from "../../components/pages/reports/GuardianReport.vue";
import USerLog from "../../components/pages/reports/USerLog.vue";
import PayrollReport from "../../components/pages/reports/PayrollReport.vue";
import ExamMarksReport from "../../components/pages/reports/ExamMarksReport.vue";
import FeesStatementRpt from "../../components/pages/reports/FeesStatementRpt.vue";


export default [

    {
        name: "school.reports.StudentTransportReport",
        path: "/school/reports/transports",
        component: StudentTransportReport,
        props: true,
    },

    {
        name: "school.reports.StudentHostelFullReport",
        path: "/school/reports/hostels",
        component: StudentHostelFullReport,
        props: true,
    },
    {
        name: "school.reports.TransactionReport",
        path: "/school/reports/transactions",
        component: TransactionReport,
        props: true,
    },

    {
        name: "school.reports.USerLog",
        path: "/school/reports/user_logs",
        component: USerLog,
        props: true,
    },
    {
        name: "school.reports.StudentReport",
        path: "/school/reports/students",
        component: StudentReport,
        props: true,
    },

    {
        name: "school.reports.GuardianReport",
        path: "/school/reports/guardians",
        component: GuardianReport,
        props: true,
    },

    {
        name: "school.reports.studentLogincredential",
        path: "/school/reports/login_credentials",
        component: StudentLoginCredential,
        props: true,
    },

    {
        name: "school.reports.StudentEvaluationReport",
        path: "/school/reports/evaluation",
        component: StudentEvaluationReport,
        props: true,
    },

    {
        name: "school.reports.PayrollReport",
        path: "/school/reports/payroll",
        component: PayrollReport,
        props: true,
    },

    {
        name: "school.reports.examMarks",
        path: "/school/reports/exam_marks",
        component: ExamMarksReport,
        props: true,
    },
    {
        name: "school.reports.FeesStatementRpt",
        path: "/school/reports/fees_statement",
        component: FeesStatementRpt,
        props: true,
    },

    {
        name: "school.reports.main_report",
        path: "/school/reports/main_report",
        component: MainReport,
        props: true,
    },
    {
        name: "school.reports.admission_report",
        path: "/school/reports/admission_report",
        component: StudentDetailReport,
        props: true,
    },
    {
        name: "school.reports.attendance_report",
        path: "/school/reports/attendance_report",
        component: AttendanceReport,
        props: true,
    },
    {
        name: "school.reports.finance_report",
        path: "/school/reports/finance_report",
        component: FinanceReport,
        props: true,
    },
    {
        name: "school.reports.examination_report",
        path: "/school/reports/examination_report",
        component: ExaminationReport,
        props: true,
    },
    {
        name: "school.reports.human_resource",
        path: "/school/reports/human_resource",
        component: HumanResource,
        props: true,
    },
    {
        name: "school.reports.library_report",
        path: "/school/reports/library_report",
        component: LibraryReport,
        props: true,
    },

    {
        name: "school.reports.inventory_report",
        path: "/school/reports/inventory_report",
        component: InventoryReport,
        props: true,
    },
    {
        name: "school.reports.hostel_report",
        path: "/school/reports/hostel_report",
        component: HostelReport,
        props: true,
    },
    {
        name: "school.reports.transport_report",
        path: "/school/reports/transport_report",
        component: TransportReport,
        props: true,
    },
];
