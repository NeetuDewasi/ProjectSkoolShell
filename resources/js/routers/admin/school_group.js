import AdminSchoolGroupCreate from "../../components/admin/pages/school_group/CreateSchoolGroup.vue";
import AdminSchoolGroup from "../../components/admin/pages/school_group/SchoolGroups.vue";
import AdminCategoryCreate from "../../components/admin/pages/categories/CategoryCreate.vue";

export default [
    {
        name: "admin.school_group.create",
        path: "/admin/school_group/create",
        component: AdminSchoolGroupCreate,
        props: true,
    },
    {
        name: "admin.school_group.list",
        path: "/admin/school_group/list",
        component: AdminSchoolGroup,
        props: true,
    },
    {
        name: "admin.school_group.create",
        path: "/admin/school_group/create/:edit_id",
        component: AdminSchoolGroupCreate,
        props: true,
    },
    {
        name: "admin.category.create",
        path: "/admin/category/create",
        component: AdminCategoryCreate,
        props: true,
    },
    
];