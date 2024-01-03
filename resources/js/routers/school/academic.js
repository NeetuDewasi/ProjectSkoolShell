import AcademicAssignSubjects from "../../components/pages/academics/assigns/AssignSubjects.vue";
import AcademicClass from "../../components/pages/academics/school_classes/Class.vue";
import AcademicClassTimeTable from "../../components/pages/academics/timeTables/ClassTimeTable.vue";
import AcademicSections from "../../components/pages/academics/school_sections/Section.vue";
import AcademicPeriods from "../../components/pages/academics/periods/ClassPeriods.vue";
import AcademicSubjects from "../../components/pages/academics/subjects/Subject.vue";
import AcademicAssignClassSection from "../../components/pages/academics/assigns/AssingClassSection.vue";
import AssignTeacherSubject from '../../components/pages/academics/assigns/AssignTeacherSubject.vue';
import TeacherTimeTable from '../../components/pages/academics/timeTables/TeacherTimeTable.vue';
export default [
    {
        name: "school.academics.assign_subjects",
        path: "/school/academics/assign_subjects",
        component: AcademicAssignSubjects,
        props: true,
    },
    {
        name: "school.academics.teachers_time_table",
        path: "/school/academics/teachers_time_table",
        component: TeacherTimeTable,
        props: true,
    },
    {
        name: "school.academics.assign_subjects_teacher",
        path: "/school/academics/assign_subjects_teacher",
        component: AssignTeacherSubject,
        props: true,
    },
    {
        name: "school.academics.classes",
        path: "/school/academics/classes",
        component: AcademicClass,
        props: true,
    },
    {
        name: "school.academics.classes.edit",
        path: "/school/academics/class/edit/:edit_id",
        component: AcademicClass,
        props: true,
    },

    {
        name: "school.academics.class_time_table",
        path: "/school/academics/class_time_table",
        component: AcademicClassTimeTable,
        props: true,
    },
    {
        name: "school.academics.sections",
        path: "/school/academics/Sections",
        component: AcademicSections,
        props: true,
    },
    {
        name: "school.academics.sections.edit",
        path: "/school/academics/section/edit/:edit_id",
        component: AcademicSections,
        props: true,
    },
    {
        name: "school.academics.subjects",
        path: "/school/academics/subjects",
        component: AcademicSubjects,
        props: true,
    },
    {
        name: "school.academics.subjects.edit",
        path: "/school/academics/subject/edit/:edit_id",
        component: AcademicSections,
        props: true,
    },
    {
        name: "school.academics.assign_class_section",
        path: "/school/academics/assign_class_section",
        component: AcademicAssignClassSection,
        props: true,
    },
    {
        name: "school.academics.class.periods",
        path: "/school/academics/class_periods",
        component: AcademicPeriods,
        props: true,
    },
];
