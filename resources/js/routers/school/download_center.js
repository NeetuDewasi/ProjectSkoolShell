// import UploadContent from "../../components/pages/downloadCenter/upload_content/UploadContent.vue";
import UploadContentAdd from "../../components/pages/downloadCenter/upload_content/UploadContentAdd.vue";
import Syllabus from "../../components/pages/downloadCenter/Syllabus.vue";
import SyllabusView from "../../components/pages/downloadCenter/SyllabusView.vue";
import StudyMaterial from "../../components/pages/downloadCenter/StudyMaterial.vue";
import StudyMaterialView from "../../components/pages/downloadCenter/StudyMaterialView.vue";
import Assignments from "../../components/pages/downloadCenter/Assignments.vue";
import AssignmentView from "../../components/pages/downloadCenter/AssignmentView.vue";
import OtherDownloads from "../../components/pages/downloadCenter/OtherDownloads.vue";
import OtherView from "../../components/pages/downloadCenter/OtherView.vue";
import UploadContent from "../../components/pages/downloadCenter/upload_content/UploadContent.vue";

export default [
    {
        name: "school.download_center.uploads",
        path: "/school/download_center/upload_content/add_uploads",
        component: UploadContentAdd,
        props: true,
    },
    {
        name: "school.download_center.uploads",
        path: "/school/download_center/upload_content/uploads",
        component: UploadContent,
        props: true,
    },
    {
        name: "school.download_center.add_uploads",
        path: "/school/download_center/upload_content/add_uploads/:upload_content_id",
        component: UploadContentAdd,
        props: true,
    },

    {
        name: "school.download_center.syllabus",
        path: "/school/download_center/syllabus",
        component: Syllabus,
        props: true,
    },
    {
        name: "school.download_center.syllabus_view",
        path: "/school/download_center/syllabus_view/:upload_content_id",
        component: SyllabusView,
        props: true,
    },
    {
        name: "school.download_center.study_material",
        path: "/school/download_center/study_material",
        component: StudyMaterial,
        props: true,
    },
    {
        name: "school.download_center.study_material_view",
        path: "/school/download_center/study_material_view/:upload_content_id",
        component: StudyMaterialView,
        props: true,
    },
    {
        name: "school.download_center.other",
        path: "/school/download_center/other",
        component: OtherDownloads,
        props: true,
    },
    {
        name: "school.download_center.other_view",
        path: "/school/download_center/other_view/:upload_content_id",
        component: OtherView,
        props: true,
    },
    {
        name: "school.download_center.assignments",
        path: "/school/download_center/assignments",
        component: Assignments,
        props: true,
    },
    {
        name: "school.download_center.assignment_view",
        path: "/school/download_center/assignments_view/:upload_content_id",
        component: AssignmentView,
        props: true,
    },
];
