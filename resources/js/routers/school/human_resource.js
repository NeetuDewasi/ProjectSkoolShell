import Employee from "../../components/pages/human_resource/employees/Employee.vue";
import EmployeeBasicInformationCreate from "../../components/pages/human_resource/employees/EmployeeBasicInformationCreate.vue";
import EmployeeAddressCreate from "../../components/pages/human_resource/employees/EmployeeAddressCreate.vue";
import EmployeeDocumentUpload from "../../components/pages/human_resource/employees/EmployeeDocumentUpload.vue";
import Department from "../../components/pages/human_resource/departments/Department.vue";
import DepartmentCreate from "../../components/pages/human_resource/departments/DepartmentCreate.vue";
import PayrollForm from "../../components/pages/human_resource/PayrollForm.vue";
import EmployeeLeaveGroup from "../../components/pages/human_resource/leaves/EmployeeLeaveGroup.vue";
import EmployeeLeaveGroupRule from "../../components/pages/human_resource/leaves/EmployeeLeaveGroupRule.vue";
import EmployeeLeaveType from "../../components/pages/human_resource/leaves/EmployeeLeaveType.vue";
import EmployeeLeave from "../../components/pages/human_resource/leaves/EmployeeLeave.vue";
import EmployeeLeaveApply from "../../components/pages/human_resource/leaves/EmployeeLeaveApply.vue";
import BankDetailForm from "../../components/pages/human_resource/BankAccountDetailForm.vue";
import UploadDocument from "../../components/pages/human_resource/UploadDocument.vue";
import SocialMediaLinks from "../../components/pages/human_resource/SocialMediaLink.vue";
import StaffDirectoryReport from "../../components/pages/human_resource/StaffDirectoryReport.vue";
import StaffAttendance from "../../components/pages/human_resource/StaffAttendance.vue";
import StaffAttendanceReport from "../../components/pages/human_resource/StaffAttendanceReport.vue";
import StaffLeaveRequest from "../../components/pages/human_resource/LeaveRequest.vue";
import ApproveLeave from "../../components/pages/human_resource/ApproveLeave.vue";
import Payroll from "../../components/pages/human_resource/Payroll.vue";
import LeaveType from "../../components/pages/human_resource/LeaveType.vue";
import Designation from "../../components/pages/human_resource/Designation.vue";
import ExEmployees from "../../components/pages/human_resource/ExEmployees.vue";
import AddStaff from "../../components/pages/human_resource/AddStaff.vue";
import StaffAddress from "../../components/pages/human_resource/StaffAddress.vue";

export default [
    {
        name: "school.hr.employees",
        path: "/school/hr/employees",
        component: Employee,
        props: true,
    },
    {
        name: "school.hr.employees.basic_info.create",
        path: "/school/hr/employees/basic_info/create/:id?",
        component: EmployeeBasicInformationCreate,
        props: true,
    },
    {
        name: "school.hr.employees.address.create",
        path: "/school/hr/employees/address/create/:id",
        component: EmployeeAddressCreate,
        props: true,
    },
    {
        name: "school.hr.employees.documents",
        path: "/school/hr/employees/documents_upload/:id",
        component: EmployeeDocumentUpload,
        props: true,
    },
    {
        name: "school.hr.departments",
        path: "/school/hr/departments",
        component: Department,
        props: true,
    },
    {
        name: "school.hr.departments.create",
        path: "/school/hr/departments/create",
        component: DepartmentCreate,
        props: true,
    },
    {
        name: "school.hr.edit_staff",
        path: "/school/hr/edit_staff/:edit_id",
        component: AddStaff,
        props: true,
    },
    {
        name: "school.hr.add_staff_address",
        path: "/school/hr/add_staff_address/:employee_id",
        component: StaffAddress,
        props: true,
    },
    {
        name: "school.hr.staff_directory_report",
        path: "/school/hr/staff_directory_report",
        component: StaffDirectoryReport,
        props: true,
    },
    {
        name: "school.hr.staff_attendance",
        path: "/school/hr/staff_attendance",
        component: StaffAttendance,
        props: true,
    },
    {
        name: "school.hr.staff_attendance_report",
        path: "/school/hr/staff_attendance_report",
        component: StaffAttendanceReport,
        props: true,
    },
    {
        name: "school.hr.staff_payroll",
        path: "/school/hr/staff_payroll",
        component: Payroll,
        props: true,
    },
    {
        name: "school.hr.staff_payroll_form",
        path: "/school/hr/staff_payroll_form/:employee_id",
        component: PayrollForm,
        props: true,
    },

    {
        name: "school.hr.staff_leave_request",
        path: "/school/hr/staff_leave_request",
        component: StaffLeaveRequest,
        props: true,
    },
    {
        name: "school.hr.leaves.groups",
        path: "/school/hr/leaves/groups",
        component: EmployeeLeaveGroup,
        props: true,
    },
    {
        name: "school.hr.leaves.groups.rules",
        path: "/school/hr/leaves/groups/:group_id/rules",
        component: EmployeeLeaveGroupRule,
        props: true,
    },
    {
        name: "school.hr.leaves.types",
        path: "/school/hr/leaves/types",
        component: EmployeeLeaveType,
        props: true,
    },
    {
        name: "school.hr.leaves",
        path: "/school/hr/leaves",
        component: EmployeeLeave,
        props: true,
    },
    {
        name: "school.hr.leaves.apply",
        path: "/school/hr/leaves/apply",
        component: EmployeeLeaveApply,
        props: true,
    },
    {
        name: "school.hr.staff_leave_approval",
        path: "/school/hr/staff_leave_approval",
        component: ApproveLeave,
        props: true,
    },
    {
        name: "school.hr.staff.bankDetailForm",
        path: "/school/hr/bank_form",
        component: BankDetailForm,
        props: true,
    },

    {
        name: "school.hr.staff.uploadDocument",
        path: "/school/hr/upload_documents",
        component: UploadDocument,
        props: true,
    },
    {
        name: "school.hr.staff.socialMediaLink",
        path: "/school/hr/social_media_links",
        component: SocialMediaLinks,
        props: true,
    },
    {
        name: "school.hr.leave_type",
        path: "/school/hr/leave_type",
        component: LeaveType,
        props: true,
    },
    {
        name: "school.hr.departments",
        path: "/school/hr/departments",
        component: Department,
        props: true,
    },
    {
        name: "school.hr.designations",
        path: "/school/hr/designations",
        component: Designation,
        props: true,
    },

    {
        name: "school.hr.ex_employees",
        path: "/school/hr/ex_employees",
        component: ExEmployees,
        props: true,
    },
];
