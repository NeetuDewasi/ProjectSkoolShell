import ExamType from "../../components/pages/examinations/exam_types/ExamType.vue";
import ExamTypeCreate from "../../components/pages/examinations/exam_types/ExamTypeCreate.vue";
import AddExamGroup from '../../components/pages/examinations/exam_groups/AddExamGroup.vue';
import DemoExamGroup from '../../components/pages/examinations/exam_groups/DemoExamGroup.vue';
import DemoNewExam from '../../components/pages/examinations/exam_groups/DemoNewExam.vue';
import DemoExamList from '../../components/pages/examinations/exam_groups/DemoExamList.vue';
import ListOfExams from "../../components/pages/examinations/ListOfExams.vue";
import ExamList from "../../components/pages/examinations/ExamList.vue";
import ExamSchedule from "../../components/pages/examinations/examSchedule/ExamSchedule.vue";
import DemoExamSchedule from "../../components/pages/examinations/examSchedule/DemoExamSchedule.vue";
import ExamScheduleCreate from "../../components/pages/examinations/examSchedule/ExamScheduleCreate.vue";
import AddExamSubjects from "../../components/pages/examinations/examSchedule/AddExamSubjects.vue";
import AssignStudentModel from "../../components/pages/examinations/exam_groups/AssignStudentModel.vue";
import ExamSubjectsModel from "../../components/pages/examinations/exam_groups/ExamSubjectsModel.vue";
import AssignMarksModel from "../../components/pages/examinations/exam_groups/AssignMarksModel.vue";
import EnterMarksModel from "../../components/pages/examinations/exam_groups/EnterMarksModel.vue";
import TeacherRemarkModel from "../../components/pages/examinations/exam_groups/TeacherRemarkModel.vue";
import ExamMarksGrade from "../../components/pages/examinations/MarksGrade.vue";
import ExamResult from "../../components/pages/examinations/ExamResult.vue";
import DesignAdmitCard from "../../components/pages/examinations/admit_card/DesignAdmitCard.vue";
import DesignAdmitCreate from "../../components/pages/examinations/admit_card/DesignAdmitCreate.vue";
import PrintAdmitCard from "../../components/pages/examinations/admit_card/print_admit_card/PrintAdmitCard";
import GenerateAdmitCard from "../../components/pages/examinations/admit_card/print_admit_card/GenerateAdmitCard";
import DesignMarksheet from "../../components/pages/examinations/marksheet/DesignMarksheet";
import PrintMarksheet from "../../components/pages/examinations/marksheet/PrintMarksheet";
import ViewMarksheet from "../../components/pages/examinations/marksheet/ViewMarksheet";
import AddGrade from "../../components/pages/examinations/marks_grade/AddGrade.vue";
import AddMarksGradeForm from "../../components/pages/examinations/AddMarksGradeForm.vue";

export default [
    {
        name: "school.examinations.exam_type",
        path: "/school/examinations/exam_type",
        component: ExamType,
        props: true,
    },
    {
        name: "school.examinations.exam_type_create",
        path: "/school/examinations/exam_type_create",
        component: ExamTypeCreate,
        props: true,
    },
    {
        name: "school.examinations.exam_group.create",
        path: "/school/examinations/exam_group/create",
        component: AddExamGroup,
        props: true,
    },
    {
        name: "school.examinations.demo_exam_group",
        path: "/school/examinations/demo_exam_group",
        component: DemoExamGroup,
        props: true,
    },
    {
        name: "school.examinations.demo_new_exam",
        path: "/school/examinations/demo_new_exam/:examGroup_id",
        component: DemoNewExam,
        props: true,
    },
    {
        name: "school.examinations.demo_new_exam",
        path: "/school/examinations/demo_new_exam/edit/:edit_id/:examGroup_id",
        component: DemoNewExam,
        props: true,
    },
    {
        name: "school.examinations.demo_exam_list",
        path: "/school/examinations/demo_exam_list/:examGroup_id",
        component: DemoExamList,
        props: true,
    },
    {
        name: "school.examinations",
        path: "/school/examinations",
        component: ListOfExams,
        props: true,
    },
    {
        name: "school.examinations_list",
        path: "/school/examinations_list",
        component: ExamList,
        props: true,
    },
    {
        name: "school.examschedule_list",
        path: "/school/examschedule_list",
        component: DemoExamSchedule,
        props: true,
    },
    {
        name: "school.examinations.schedule",
        path: "/school/examinations/schedule",
        component: ExamSchedule,
        props: true,
    },
    {
        name: "school.examinations.schedule_create",
        path: "/school/examinations/schedule_create/:examSchedule_id",
        component: ExamScheduleCreate,
        props: true,
    },
    {
        name: "school.examinations.add_subjects",
        path: "/school/examinations/add_subjects",
        component: AddExamSubjects,
        props: true,
    },
    {
        name: "school.examinations.asign_students",
        path: "/school/examinations/asign_students/:examGroup_id/:newExam_id",
        component: AssignStudentModel,
        props: true,
    },
    {
        name: "school.examinations.exam_subject_model",
        path: "/school/examinations/exam_subject_model/:examGroup_id/:newExam_id",
        component: ExamSubjectsModel,
        props: true,
    },
    {
        name: "school.examinations.assign_marks_model",
        path: "/school/examinations/assign_marks_model/:examGroup_id/:newExam_id",
        component: AssignMarksModel,
        props: true,
    },
    {
        name: "school.examinations.enter_marks_model",
        path: "/school/examinations/enter_marks_model/:examGroup_id/:newExam_id/:subject_id",
        component: EnterMarksModel,
        props: true,
    },
    {
        name: "school.examinations.teacher_remark_model",
        path: "/school/examinations/teacher_remark_model/:examGroup_id/:newExam_id",
        component: TeacherRemarkModel,
        props: true,
    },
    {
        name: "school.examinations.marks",
        path: "/school/examinations/marks",
        component: ExamMarksGrade,
        props: true,
    },
    {
        name: "school.examinations.grade.create",
        path: "/school/examinations/grade/create",
        component: AddMarksGradeForm,
        props: true,
    },
    {
        name: "school.examinations.result",
        path: "/school/examinations/result",
        component: ExamResult,
        props: true,
    },
    {
        name: "school.examinations.design_admitcard",
        path: "/school/examinations/design_admitcard",
        component: DesignAdmitCard,
        props: true,
    },
    {
        name: "school.examinations.design_admitcard_create",
        path: "/school/examinations/design_admitcard_create",
        component: DesignAdmitCreate,
        props: true,
    },
    {
        name: "school.examinations.print_admit_card",
        path: "/school/examinations/print_admit_card",
        component: PrintAdmitCard,
        props: true,
    },
    {
        name: "school.examinations.generate_admit_card",
        path: "/school/examinations/generate_admit_card/:student_admission_id/:admitCard_id",
        component: GenerateAdmitCard,
        props: true,
    },
    {
        name: "school.examinations.design_marksheet",
        path: "/school/examinations/design_marksheet",
        component: DesignMarksheet,
        props: true,
    },
    {
        name: "school.examinations.design_marksheet_create",
        path: "/school/examinations/design_marksheet_create",
        component: DesignMarksheet,
        props: true,
    },
    {
        name: "school.examinations.print_marksheet",
        path: "/school/examinations/print_marksheet",
        component: PrintMarksheet,
        props: true,
    },
    {
        name: "school.examinations.view_marksheet",
        path: "/school/examinations/view_marksheet/:student_admission_id/:marksheet_id/:examGroupId/:new_examId",
        component: ViewMarksheet,
        props: true,
    },
    {
        name: "school.examinations.add_grade",
        path: "/school/examinations/add_grade",
        component: AddGrade,
        props: true,
    },
];
