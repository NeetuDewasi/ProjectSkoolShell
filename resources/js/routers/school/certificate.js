import Certificate from "../../components/pages/certificate/certificates/Certificate.vue";
import AddCertificate from "../../components/pages/certificate/certificates/AddCertificate.vue";
import GenerateCertificate from "../../components/pages/certificate/certificates/GenerateCertificate.vue";
import AddGenerateCertificate from "../../components/pages/certificate/certificates/AddGenerateCertificate.vue";
import ViewGeneratedCertificate from "../../components/pages/certificate/certificates/ViewGeneratedCertificate.vue";
import AddStudentIdCard from '../../components/pages/certificate/id_cards/AddStudentIdCard.vue';
import StudentIdCard from '../../components/pages/certificate/id_cards/StudentIdCard.vue';
import GenerateIdCard from "../../components/pages/certificate/id_cards/GenerateIdCard.vue";
import ViewGeneratedIdCard from "../../components/pages/certificate/id_cards/ViewGeneratedIdCard.vue";

export default [
    {
        name: "school.certificate.student",
        path: "/school/certificate/student",
        component: Certificate,
        props: true,
    },
    {
        name: "school.add_certificate.student",
        path: "/school/add_certificate/student",
        component: AddCertificate,
        props: true,
    },
    {
        name: "school.add_certificate.student",
        path: "/school/add_certificate/student/edit_id",
        component: AddCertificate,
        props: true,
    },
    {
        name: "school.certificate.generate",
        path: "/school/certificate/generate",
        component: GenerateCertificate,
        props: true,
    },
     {
        name: "school.certificate.view_certificate",
        path: "/school/certificate/view_certificate/:student_admission_id/:certificate_id",
        component: ViewGeneratedCertificate,
        props: true,
    },
    {
        name: "school.certificate.generate",
        path: "/school/certificate/generate",
        component: AddGenerateCertificate,
        props: true,
    },

    {
        name: "school.certificate.id_card_add",
        path: "/school/certificate/id_card_add",
        component: AddStudentIdCard,
        props: true,
    },
     {
        name: "school.certificate.id_card_add",
        path: "/school/certificate/id_card_add/edit_id",
        component: AddStudentIdCard,
        props: true,
    },
     {
        name: "school.certificate.id_card",
        path: "/school/certificate/id_card",
        component: StudentIdCard,
        props: true,
    },

    {
        name: "school.certificate.generate_id_card",
        path: "/school/certificate/generate_id_card",
        component: GenerateIdCard,
        props: true,
    },
      {
        name: "school.certificate.id_cards.generated_id_cards",
        path: "/school/certificate/id_cards/viewGenerated_id_cards/:student_admission_id/:idCard_id",
        component: ViewGeneratedIdCard,
        props: true,
    },
];
