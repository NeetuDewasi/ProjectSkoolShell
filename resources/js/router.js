import Vue from "vue";
import Router from "vue-router";
Vue.use(Router);

import AdminDashboard from "./components/admin/pages/dashboard/Dashboard.vue";
import SchoolDashboard from "./components/pages/dashboard/Dashboard.vue";
import AdminSchoolGroupRoutes from "./routers/admin/school_group";
import AdminSchoolRoutes from "./routers/admin/schools";
import StudentRoutes from "./routers/school/student";
import AttendanceRoutes from "./routers/school/attendance";
import AcademicRoutes from "./routers/school/academic";
import CertificateRoutes from "./routers/school/certificate";
import CommunicateRoutes from "./routers/school/communicate";
import DownloadCenterRoutes from "./routers/school/download_center";
import ExaminationRoutes from "./routers/school/examination";
import ExpenseRoutes from "./routers/school/expenses";
import FeesCollectionRoutes from "./routers/school/fees_collection";
import FrontOfficeRoutes from "./routers/school/front_office";
import HomeworkRoutes from "./routers/school/homework";
import HostelRoutes from "./routers/school/hostel";
import HumanResourceRoutes from "./routers/school/human_resource";
import IncomeRoutes from "./routers/school/income";
import InventoryRoutes from "./routers/school/inventory";
import LibraryRoutes from "./routers/school/library";
import ReportRoutes from "./routers/school/report";
import SystemSettingsRoutes from "./routers/school/system_settings";
import TransportRoutes from "./routers/school/transport";
import NoPageFound from "./routers/NoPageFound";

const routes = [
    {
        name: "admin.dashboard",
        path: "/admin/dashboard",
        component: AdminDashboard,
        props: true,
    },
    {
        name: "school.Dashoard",
        path: "/school/Dashboard",
        component: SchoolDashboard,
        props: true,
    },
    ...AdminSchoolGroupRoutes,
    ...AdminSchoolRoutes,
    ...StudentRoutes,
    ...AttendanceRoutes,
    ...AcademicRoutes,
    ...CertificateRoutes,
    ...CommunicateRoutes,
    ...DownloadCenterRoutes,
    ...ExaminationRoutes,
    ...ExpenseRoutes,
    ...FeesCollectionRoutes,
    ...FrontOfficeRoutes,
    ...HomeworkRoutes,
    ...HostelRoutes,
    ...HumanResourceRoutes,
    ...IncomeRoutes,
    ...InventoryRoutes,
    ...LibraryRoutes,
    ...ReportRoutes,
    ...SystemSettingsRoutes,
    ...TransportRoutes,
    ...NoPageFound,
];
function getMenus() {
    const activeSchool = sessionStorage.getItem("activeSchool");
    axios.get("/api/menus/" + activeSchool)
        .then((response) => {
            var result = response.data;
        })
        .catch((error) => {
            console.error(error);
        });
}

getMenus();

import axios from "axios";
export default new Router({
    mode: "history",
    routes,
});
