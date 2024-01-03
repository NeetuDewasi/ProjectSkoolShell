import AddExpenses from "../../components/pages/expenses/school_expenses/ExpensesCreate.vue";
import ExpensesHead from "../../components/pages/expenses/school_expenses_head/ExpensesHead.vue";
import AddExpensesHead from "../../components/pages/expenses/school_expenses_head/CreateExpensesHead.vue";
import Expenses from "../../components/pages/expenses/school_expenses/Expenses.vue";

export default [{
        name: "school.expenses.create",
        path: "/school/expenses/create",
        component: AddExpenses,
        props: true,
    },
    {
        name: "school.expenses.edit",
        path: "/school/expenses/edit/:edit_id",
        component: AddExpenses,
        props: true,
    },
    {
        name: "school.expenses.head",
        path: "/school/expenses/head",
        component: ExpensesHead,
        props: true,
    },
    {
        name: "school.expenses.add_head",
        path: "/school/expenses/add_head",
        component: AddExpensesHead,
        props: true,
    },
    {
        name: "school.expenses.edit_head",
        path: "/school/expenses/edit_head/:edit_id",
        component: AddExpensesHead,
        props: true,
    },
    {
        name: "school.expenses.expenses",
        path: "/school/expenses/expenses",
        component: Expenses,
        props: true,
    },
];
