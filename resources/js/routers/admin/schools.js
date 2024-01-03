import AdminSchoolCreate from "../../components/admin/pages/schools/CreateSchool.vue";
import AdminSchools from "../../components/admin/pages/schools/Schools.vue";
import AdminSchoolDocuments from "../../components/admin/pages/schools/SchoolDocuments.vue";
import AdminSchoolDocumentsAdd from "../../components/admin/pages/schools/SchoolDocumentsAdd.vue";
import AdminSchoolDocumentsEdit from "../../components/admin/pages/schools/SchoolDocumentsAdd.vue";
import AdminAssignModule from "../../components/admin/pages/schools/AssignModule.vue";
import AdminAddComponent from "../../components/admin/pages/menu_components/AddComponent.vue";
export default [
    {
        name: "admin.school.create",
        path: "/admin/school/create",
        component: AdminSchoolCreate,
        props: true,
    },
    {
        name: "admin.school.create",
        path: "/admin/school/create/:edit_id",
        component: AdminSchoolCreate,
        props: true,
    },
    {
        name: "admin.school.list",
        path: "/admin/school/list",
        component: AdminSchools,
        props: true,
    },
    {
        name: "admin.school.documents",
        path: "/admin/school/documents/:school_id",
        component: AdminSchoolDocuments,
        props: true,
    },
    {
        name: "admin.school.create.documents",
        path: "/admin/school/documents/create/:school_id",
        component: AdminSchoolDocumentsAdd,
        props: true,
    },
    {
        name: "admin.school.create.documents",
        path: "/admin/school/documents/:edit_id/edit",
        component: AdminSchoolDocumentsEdit,
        props: true,
    },
    {
        name: "admin.assign.create",
        path: "/admin/assign/create",
        component: AdminAssignModule,
        props: true,
    },
    {
        name: "admin.component.create",
        path: "/admin/component/create",
        component: AdminAddComponent,
        props: true,
    },
];
