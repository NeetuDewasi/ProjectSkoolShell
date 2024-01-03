import AddIncome from "../../components/pages/income/Add_Income/AddIncome.vue";
import AddIncomeForm from "../../components/pages/income/Add_Income/AddIncomeForm.vue";
import IncomeHead from "../../components/pages/income/Income_Head/IncomeHead.vue";
import IncomeHeadForm from "../../components/pages/income/Income_Head/IncomeHeadForm.vue";
import AddIncomeStaff from "../../components/pages/income/AddIncomeStaff.vue";

// import IncomeReport from "../../components/pages/income/IncomeReport.vue";
import SearchIncome from "../../components/pages/income/Search_Income/SearchIncome.vue";
import IncomeDetailViewPage from "../../components/pages/income/Search_Income/IncomeDetailViewPage.vue";




export default [
    {
        name: "school.income.AddIncome",
        path: "/school/income/AddIncome",
        component: AddIncome,
        props: true,
    },
    {
        name: "school.income.AddIncome.edit",
        path: "/school/income/AddIncome/edit/:edit_id",
        component: AddIncome,
        props: true,
    },
    {
        name: "school.income.AddIncomeStaff",
        path: "/school/income/AddIncomeStaff",
        component: AddIncomeStaff,
        props: true,
    },

    {
        name: "school.income.AddIncomeStaff.edit",
        path: "/school/income/AddIncomeStaff/edit/:edit_id",
        component: AddIncomeStaff,
        props: true,
    },

    {
        name: "school.income.AddIncomeForm",
        path: "/school/income/AddIncomeForm",
        component: AddIncomeForm,
        props: true,
    },

    {
        name: "school.income.AddIncomeForm.edit",
        path: "/school/income/AddIncomeForm/edit/:edit_id",
        component: AddIncomeForm,
        props: true,
    },

    {
        name: "school.income.IncomeHead",
        path: "/school/income/IncomeHead",
        component: IncomeHead,
        props: true,
    },
    {
        name: "school.income.IncomeHeadForm",
        path: "/school/income/IncomeHeadForm",
        component: IncomeHeadForm,
        props: true,
    },
    {
        name: "school.income.IncomeHeadForm.edit",
        path: "/school/income/IncomeHeadForm/edit/:edit_id",
        component: IncomeHeadForm,
        props: true,
    },
    {
        name: "school.income.SearchIncome",
        path: "/school/income/SearchIncome",
        component: SearchIncome,
        props: true,
    },
    // {
    //     name: "school.income.report",
    //     path: "/school/income/report",
    //     component: IncomeReport,
    //     props: true,
    // },

    {
        name: "school.income.details",
        path: "/school/income/search_income/:id",
        component: IncomeDetailViewPage,
        props: true,
    },
];
