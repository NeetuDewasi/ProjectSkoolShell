import Homework from "../../components/pages/homework/school_homework/Homework.vue";
import AddHomework from "../../components/pages/homework/school_homework/AddHomeworkForm.vue";
import HomeworkDetails from "../../components/pages/homework/school_homework/HomeworkDetails.vue";

export default [
    {
        name: "school.homework.homework",
        path: "/school/school_homework/homework",
        component: Homework,
        props: true,
    },
    {
        name: "school.homework.add_homework",
        path: "/school/homework/add_homework",
        component: AddHomework,
        props: true,
    },
    {
        name: "school.homework.edit_homework",
        path: "/school/homework/edit_homework/:edit_id",
        component: AddHomework,
        props: true,
    },
    {
        name: "school.homework.homework_view",
        path: "/school/homework/homework_view/:homework_id",
        component: HomeworkDetails,
        props: true,
    },
];
