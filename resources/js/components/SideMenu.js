import axios from "axios";

const AdminMenuList = [
    {
        flatIcon: "flaticon-dashboard",
        imageIcon: null,
        title: "Dashboard",
        to: { name: "admin.dashboard" },
        subMenuList: null,
    },
    {
        flatIcon: "flaticon-multiple-users-silhouette",
        imageIcon: null,
        title: "School Group",
        subMenuList: [
            {
                name: "Create New",
                to: { name: "admin.school_group.create" },
            },
            {
                name: "View All",
                to: { name: "admin.school_group.list" },
            },
        ],
    },
    {
        flatIcon: "fas fa-graduation-cap",
        imageIcon: null,
        title: "Schools",
        subMenuList: [
            {
                name: "Create New",
                to: { name: "admin.school.create" },
            },

            {
                name: "View All",
                to: { name: "admin.school.list" },
            },
        ],
    },
    {
        flatIcon: "flaticon-classmates",
        imageIcon: null,
        title: "Categories",
        subMenuList: [
            {
                name: "Create New",
                to: { name: "admin.category.create" },
            },
        ],
    },
    {
        flatIcon: "flaticon-chat",
        imageIcon: null,
        title: "Assign",
        subMenuList: [
            {
                name: "Assign New",
                to: { name: "admin.assign.create" },
            },
        ],
    },
    {
        flatIcon: "flaticon-multiple-users-silhouette",
        imageIcon: null,
        title: "Component",
        subMenuList: [
            {
                name: "Create New",
                to: { name: "admin.component.create" },
            },
        ],
    },
];

const SchoolMenuList = [{
    flatIcon: "flaticon-dashboard",
    imageIcon: null,
    title: "Dashboard",
    to: { name: "school.dashboard" },
    subMenuList: null,
},

// academics
{
    flatIcon: "fas fa-graduation-cap",
    imageIcon: null,
    title: "Academics",
    subMenuList: [{
        name: "Class",
        to: { name: "school.academics.classes" },
    },
    {
        name: "Sections",
        to: { name: "school.academics.sections" },
    },
    {
        name: "Subjects",
        to: { name: "school.academics.subjects" },
    },
    {
        name: "Assign Class Section",
        to: { name: "school.academics.assign_class_section" },
    },

    {
        name: "Assign Subjects",
        to: { name: "school.academics.assign_subjects" },
    },

    {
        name: 'Assign Teacher Subject',
        to: { name: 'school.academics.assign_subjects_teacher' },
    },
    {
        name: "Class Periods",
        to: { name: "school.academics.class.periods" },
    },
    {
        name: "Class Timetable",
        to: { name: "school.academics.class_time_table" },
    },
    {
        name: "Teacher Timetable",
        to: { name: "school.academics.teachers_time_table" },
    },
    ],
},
// students
{
    flatIcon: "flaticon-classmates",
    imageIcon: null,
    title: "Students",
    subMenuList: [
        {
            name: "Student Categories ",
            to: { name: "school.students.categories" },
        },
        {
            name: "Student Admission",
            to: { name: "school.students.admissions" },
        },
        {
            name: "Student Details",
            to: { name: "school.students.details" },
        },
        // {
        //     name: "Student Report ",
        //     to: { name: "school.students.reports" },
        // },
        // {
        //     name: "Guardian Report ",
        //     to: { name: "school.students.guardian_report" },
        // },
        // {
        //     name: "Student History ",
        //     to: { name: "school.students.history" },
        // },
        {
            name: "Student House ",
            to: { name: "school.students.houses" },
        },
        {
            name: "Ex-Student ",
            to: { name: "school.students.x_students" },
        },
    ],
},
// attendance
{
    flatIcon: "flaticon-checklist",
    imageIcon: null,
    title: "Attendance",
    subMenuList: [
        {
            name: "Student Attendance",
            to: { name: "school.attendance.students" },
        },
        {
            name: "Employee Attendance",
            to: { name: "school.attendance.employees" },
        },
    ],
},

// certificate
{
    flatIcon: "fas fa-certificate",
    imageIcon: null,
    title: "Certificate",
    subMenuList: [{
        name: "Student Certificate",
        to: { name: "school.certificate.student" },
    },
    {
        name: "Generate Certificate",
        to: { name: "school.certificate.generate" },
    },
    {
        name: "Student ID Card",
        to: { name: "school.certificate.id_card" },
    },
    {
        name: "Generate ID Card",
        to: { name: "school.certificate.generate_id_card" },
    },
    ],
},
// communicate
{
    flatIcon: "flaticon-chat",
    imageIcon: null,
    title: "Communicate",
    subMenuList: [{
        name: "Notice Board",
        to: { name: "school.communicate.notice" },
    },
    // {
    //     name: "Send Message",
    //     to: { name: "school.communicate.message" },
    // },
    {
        name: "Send Email/SMS",
        to: { name: "school.communicate.email" },
    },
    {
        name: "Email/SMS Log",
        to: { name: "school.communicate.email_log" },
    },
    ],
},
// download center
{
    flatIcon: "fas fa-download",
    imageIcon: null,
    title: "Download Center",
    subMenuList: [{
        name: "Upload Content",
        to: { name: "school.download_center.uploads" },
    },

    {
        name: "Assignments",
        to: { name: "school.download_center.assignments" },
    },
    {
        name: "Study Material",
        to: {
            name: "school.download_center.study_material",
        },
    },
    {
        name: "Syllabus",
        to: { name: "school.download_center.syllabus" },
    },
    {
        name: "Other Downloads",
        to: { name: "school.download_center.other" },
    },
    ],
},
// Examination
{
    flatIcon: "flaticon-shopping-list",
    imageIcon: null,
    title: "Examinations",
    subMenuList: [
        {
            name: 'Exam Type',
            to: { name: 'school.examinations.exam_type' },
        },
        {
            name: 'Exam Group',
            to: { name: 'school.examinations.demo_exam_group' },
        },
        // {
        //     name: "Exam List",
        //     to: { name: "school.examinations" },
        // },
        {
            name: "Exam Schedule",
            to: { name: "school.examschedule_list" },
        },
        // {
        //     name: "Marks Grade",
        //     to: { name: "school.examinations.marks" },
        // },
        {
            name: "Admit Card",
            to: { name: "school.examinations.design_admitcard" },
        },
        {
            name: "Print Admit Card",
            to: { name: "school.examinations.print_admit_card" },
        },
        {
            name: "Exam Result ",
            to: { name: "school.examinations.result" },
        },
        {
            name: "Design Marksheet ",
            to: { name: "school.examinations.design_marksheet" },
        },
        {
            name: "Print Marksheet ",
            to: { name: "school.examinations.print_marksheet" },
        },
        {
            name: "Marks Grade ",
            to: { name: "school.examinations.add_grade" },
        },
    ],
},
// expenses
{
    flatIcon: "flaticon-technological",
    imageIcon: null,
    title: "Expenses",
    subMenuList: [{
        name: "Expenses Head",
        to: { name: "school.expenses.head" },
    },
    {
        name: "Expenses",
        to: { name: "school.expenses.expenses" },
    },
    ],
},
// fees collection
{
    flatIcon: "fas fa-coins",
    imageIcon: null,
    title: "Fees Collection",
    subMenuList: [{
        name: "Fees Group",
        to: { name: "school.fees.groups" },
    },
    {
        name: "Fees Type",
        to: { name: "school.fees.type" },
    },
    {
        name: "Fees Master",
        to: { name: "school.fees.master" },
    },
    {
        name: "Fees Discount",
        to: { name: "school.fees.discount" },
    },
    {
        name: "Collect Fees",
        to: { name: "school.fees.collection" },
    },
    ],
},
// Front CMS
// {
// 	flatIcon: "flaticon-multiple-users-silhouette",
// 	imageIcon: null,
// 	title: "Front CMS",
// 	subMenuList: [
// 		{
// 			name: "Event",
// 			to: { name: "school.frontcms.event" },
// 		},
// 		{
// 			name: "Gallary",
// 			to: { name: "school.frontcms.gallary" },
// 		},
// 		{
// 			name: "News",
// 			to: { name: "school.frontcms.news" },
// 		},
//         {
// 			name: "Media Manager ",
// 			to: { name: "school.frontcms.media" },
// 		},
//         {
// 			name: "Pages",
// 			to: { name: "school.frontcms.pages" },
// 		},
//         {
// 			name: "Menus",
// 			to: { name: "school.frontcms.menus" },
// 		},
//         {
// 			name: "Banner Images",
// 			to: { name: "school.frontcms.banner" },
// 		},
// 	],
// },
// Front Office
{
    flatIcon: "fas fa-briefcase",
    imageIcon: null,
    title: "Front Office",
    subMenuList: [{
        name: "Add Purpose",
        to: { name: "school.front_office.purpose" },
    },
    {
        name: "Add Complain Type",
        to: { name: "school.front_office.complain_type" },
    },
    {
        name: "Add Source",
        to: { name: "school.front_office.source" },
    },
    {
        name: "Add Reference",
        to: { name: "school.front_office.reference" },
    },
    {
        name: "Admission Enquiry",
        to: { name: "school.front_office.admission" },
    },
    {
        name: "Visitor Book",
        to: { name: "school.front_office.visitors" },
    },
    {
        name: "Phone Call Log",
        to: { name: "school.front_office.phone_log" },
    },
    {
        name: "Postal Receive/Dispatch",
        to: { name: "school.front_office.postal" },
    },
    {
        name: "Complain",
        to: { name: "school.front_office.complain" },
    },

    ],
},
// Homework
{
    flatIcon: "fas fa-book-reader",
    imageIcon: null,
    title: "Homework",
    subMenuList: [{
        name: "Homework",
        to: { name: "school.homework.homework" },
    },
        // {
        //     name: "Evaluation Report",
        //     to: { name: "school.homework.evaluation_report" },
        // },
    ],
},
// hostel
{
    flatIcon: "flaticon-bed",
    imageIcon: null,
    title: "Hostel",
    subMenuList: [{
        name: "Hostel",
        to: { name: "school.hostel" },
    },
    {
        name: "Room Type",
        to: { name: "school.hostel.room_type" },
    },
    {
        name: "Hostel Rooms",
        to: { name: "school.hostel.room" },
    },
        // {
        //     name: "Student Hostel Report",
        //     to: { name: "school.hostel.report" },
        // },
    ],
},
// human resources
{
    flatIcon: "flaticon-multiple-users-silhouette",
    imageIcon: null,
    title: "Human Resource",
    subMenuList: [
        {
            name: "Departments",
            to: { name: "school.hr.departments" },
        },
        {
            name: "Employees",
            to: { name: "school.hr.employees" },
        },
        {
            name: "Leave Types",
            to: { name: "school.hr.leaves.types" },
        },
        {
            name: "Leave Groups",
            to: { name: "school.hr.leaves.groups" },
        },
        {
            name: "Leaves",
            to: { name: "school.hr.leaves" },
        },
        {
            name: "Payroll",
            to: { name: "school.hr.staff_payroll" },
        },
        {
            name: "Approve Leave Request",
            to: { name: "school.hr.staff_leave_approval" },
        },
        {
            name: "Leave Type",
            to: { name: "school.hr.leave_type" },
        },
        {
            name: "Ex-Employees Staff",
            to: { name: "school.hr.ex_employees" },
        },
    ],
},
// income
{
    flatIcon: "ti-money",
    imageIcon: null,
    title: "Income",
    subMenuList: [{
        name: "Add Income",
        to: { name: "school.income.AddIncome" },
    },
    {
        name: "Search Income",
        to: { name: "school.income.SearchIncome" },
    },
    {
        name: "Income Head",
        to: { name: "school.income.IncomeHead" },
    },
    ],
},
// inventory
{
    flatIcon: "ti-layout-column3",
    imageIcon: null,
    title: "Inventory",
    subMenuList: [{
        name: "Add Item",
        to: { name: "school.inventory.AddItem" },
    },
    {
        name: "Add Item Stock",
        to: { name: "school.inventory.AddItemStock" },
    },
    {
        name: "Issue Item",
        to: { name: "school.inventory.IssueItem" },
    },
    {
        name: "Item Category",
        to: { name: "school.inventory.ItemCategory" },
    },
    {
        name: "Item Store",
        to: { name: "school.inventory.ItemStore" },
    },
    {
        name: "Item Supplier",
        to: { name: "school.inventory.ItemSupplier" },
    },
    ],
},
// library
{
    flatIcon: "flaticon-books",
    imageIcon: null,
    title: "Library",
    subMenuList: [
        {
            name: "Categories",
            to: { name: "school.library.categories" },
        },
        {
            name: "Reck & Shelves",
            to: { name: "school.library.shelves" },
        },
        {
            name: "Books",
            to: { name: "school.library.books" },
        },
        {
            name: "Issue Return",
            to: { name: "school.library.issue_return"},
        },
        {
            name: "Add Student",
            to: { name: "school.library.add_library_student"},
        },
        {
            name: "Add Staff Member",
            to: { name: "school.library.add_staff"},
        },
    ],
},
// Reports
{
    flatIcon: "flaticon-script",
    imageIcon: null,
    title: "Reports",
    subMenuList: [{
        name: "Student Information Report",
        to: { name: "school.reports.main_report" },
    },
    {
        name: "Attendence Report",
        to: { name: "school.reports.attendance_report" },
    },
    {
        name: "Finance Report",
        to: { name: "school.reports.finance_report" },
    },
     {
        name: "Examination Report",
        to: { name: "school.reports.examination_report" },
    },
    {
        name: "Human Resource ",
        to: {
            name: "school.reports.human_resource",
        },
    },
    {
        name: "Library Report",
        to: { name: "school.reports.library_report" },
    },
    {
        name: "Inventory Report ",
        to: { name: "school.reports.inventory_report" },
    },
    {
        name: "Transport Report",
        to: { name: "school.reports.transport_report" },
    },

    // {
    //     name: "Exam Marks Report",
    //     to: { name: "school.reports.examMarks" },
    // },
    // {
    //     name: "Payroll Report",
    //     to: { name: "school.reports.PayrollReport" },
    // },
    // {
    //     name: "Staff attendence Report",
    //     to: { name: "school.reports.staffAttendence" },
    // },
    // {
    //     name: "Evaluation Report",
    //     to: {
    //         name: "school.reports.StudentEvaluationReport",
    //     },
    // },
    // {
    //     name: "Transport Report",
    //     to: {
    //         name: "school.reports.StudentTransportReport",
    //     },
    // },
    {
        name: "Hostel Report",
        to: {
            name: "school.reports.hostel_report",
        },
    },
    {
        name: "User Log",
        to: { name: "school.reports.USerLog" },
    },
    ],
},
// System Settings
{
    flatIcon: "flaticon-settings",
    imageIcon: null,
    title: "System Settings",
    subMenuList: [{
        name: "General Settings",
        to: { name: "school.settings.general" },
    },
    {
        name: "Session Settings",
        to: { name: "school.settings.session" },
    },
    {
        name: "Notification Settings",
        to: { name: "school.settings.notification" },
    },
    {
        name: "SMS Settings",
        to: { name: "school.settings.sms" },
    },
    {
        name: "Email Settings",
        to: { name: "school.settings.email" },
    },
    {
        name: "Payment Methods",
        to: { name: "school.settings.payment" },
    },
    {
        name: "Front CMS Settings",
        to: { name: "school.settings.frontcms" },
    },
    {
        name: "Roll Permissions",
        to: { name: "school.settings.role" },
    },
    {
        name: "Backup/Restore",
        to: { name: "school.settings.backup" },
    },
    {
        name: "Language",
        to: { name: "school.settings.language" },
    },
    {
        name: "USers",
        to: { name: "school.settings.user" },
    },
    {
        name: "Modules",
        to: { name: "school.settings.modules" },
    },
    ],
},
// Transport
{
    flatIcon: "flaticon-bus-side-view",
    imageIcon: null,
    title: "Transport",
    subMenuList: [{
        name: "Routes",
        to: { name: "school.transports.TransportRoutes" },
    },
    {
        name: "Vehicles",
        to: { name: "school.transports.TransportVehicles" },
    },
    {
        name: 'Route Point',
        to: { name: 'school.transports.route_point' },
    },
    {
        name: "Assign Vehicles",
        to: { name: "school.transports.TransportAssignVehicles" },
    },
        // {
        //     name: "Report",
        //     to: {
        //         name: "school.transports.TransportReport",
        //     },
        // },
    ],
},
];



// const getMenuData = () => {
//     axios.get('/api/admin/assign/menu_list').then((res) => {
//         console.log('ers',res)
//     }).catch((e)=>console.error('ERROR',e));
// };
// const getMenuData = () => {
//     this.$parent.getMenus();
// };
// console.log(getMenuData);
export default { AdminMenuList, SchoolMenuList };
