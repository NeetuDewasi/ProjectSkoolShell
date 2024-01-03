import AdmissionEnquiry from "../../components/pages/front_office/school_admission_enquiry/AdmissionEnquiry.vue";
import AddAdmissionEnquiryForm from "../../components/pages/front_office/school_admission_enquiry/AddAdmissionEnquiryForm.vue";
import Complain from "../../components/pages/front_office/school_complain/Complain.vue";
import PhoneCallLog from "../../components/pages/front_office/school_phone_call_log/PhoneCallLog.vue";
import PostalReceiveDispatch from "../../components/pages/front_office/school_postal/PostalReceiveDispatch.vue";
import ComplainType from "../../components/pages/front_office/school_complain_type/ComplainType.vue";
import AddComplainType from "../../components/pages/front_office/school_complain_type/AddComplainTypeForm.vue";
import VisitorBook from "../../components/pages/front_office/school_visitor_book/VisitorBook.vue";
import Purpose from "../../components/pages/front_office/school_purposes/Purpose.vue";
import AddPurposeForm from "../../components/pages/front_office/school_purposes/AddPurposeForm.vue";
import Source from "../../components/pages/front_office/school_source/Source.vue";
import AddSourceForm from "../../components/pages/front_office/school_source/AddSourceForm.vue";
import Reference from "../../components/pages/front_office/student_reference/Reference.vue";
import AddReferenceForm from "../../components/pages/front_office/student_reference/AddReferenceForm.vue";
import AddVisitorForm from "../../components/pages/front_office/school_visitor_book/AddVisitorForm.vue";
import ViewVisitorDetail from "../../components/pages/front_office/school_visitor_book/ViewVisitorDetail.vue";
import AddPhoneCallLogForm from "../../components/pages/front_office/school_phone_call_log/AddPhoneCallLogForm.vue";
import AddPostalForm from "../../components/pages/front_office/school_postal/AddPostalForm.vue";
import AddComplainForm from "../../components/pages/front_office/school_complain/AddComplainForm.vue";
import ViewAdmissionEnquiry from "../../components/pages/front_office/school_admission_enquiry/ViewAdmissionEnquiry.vue";
import ViewCallsDetail from "../../components/pages/front_office/school_phone_call_log/ViewCallsDetail.vue";
import ViewPostalDetail from "../../components/pages/front_office/school_postal/ViewPostalDetail.vue";
import ViewComplainDetail from "../../components/pages/front_office/school_complain/ViewComplainDetail.vue";


export default [{
        name: "school.front_office.admission",
        path: "/school/front_office/admission",
        component: AdmissionEnquiry,
        props: true,
    },
    {
        name: "school.front_office.add_admission_enquiry",
        path: "/school/front_office/add_admission_enquiry",
        component: AddAdmissionEnquiryForm,
        props: true,
    },
    {
        name: "school.front_office.edit_admission_enquiry",
        path: "/school/front_office/edit_admission_enquiry/:edit_id",
        component: AddAdmissionEnquiryForm,
        props: true,
    },
    {
        name: "school.front_office.visitors",
        path: "/school/front_office/visitors",
        component: VisitorBook,
        props: true,
    },
    {
        name: "school.front_office.visitors_detail",
        path: "/school/front_office/visitors_detail/:visitor_id",
        component: ViewVisitorDetail,
        props: true,
    },
    {
        name: "school.front_office.add_visitors",
        path: "/school/front_office/add_visitors",
        component: AddVisitorForm,
        props: true,
    },
    {
        name: "school.front_office.edit_visitors",
        path: "/school/front_office/edit_visitors/:edit_id",
        component: AddVisitorForm,
        props: true,
    },
    {
        name: "school.front_office.phone_log",
        path: "/school/front_office/phone_log",
        component: PhoneCallLog,
        props: true,
    },
    {
        name: "school.front_office.add_phone_log",
        path: "/school/front_office/add_phone_log",
        component: AddPhoneCallLogForm,
        props: true,
    },
    {
        name: "school.front_office.edit_phone_log",
        path: "/school/front_office/edit_phone_log/:edit_id",
        component: AddPhoneCallLogForm,
        props: true,
    },
    {
        name: "school.front_office.postal",
        path: "/school/front_office/postal",
        component: PostalReceiveDispatch,
        props: true,
    },
    {
        name: "school.front_office.add_postal",
        path: "/school/front_office/add_postal",
        component: AddPostalForm,
        props: true,
    },
    {
        name: "school.front_office.edit_postal",
        path: "/school/front_office/edit_postal/:edit_id",
        component: AddPostalForm,
        props: true,
    },
    {
        name: "school.front_office.add_complain",
        path: "/school/front_office/add_complain",
        component: AddComplainForm,
        props: true,
    },
    {
        name: "school.front_office.edit_complain",
        path: "/school/front_office/edit_complain/:edit_id",
        component: AddComplainForm,
        props: true,
    },
    {
        name: "school.front_office.complain",
        path: "/school/front_office/complain",
        component: Complain,
        props: true,
    },
    {
        name: "school.front_office.complain_type",
        path: "/school/front_office/complain_type",
        component: ComplainType,
        props: true,
    },
    {
        name: "school.front_office.add_complain_type",
        path: "/school/front_office/add_complain_type",
        component: AddComplainType,
        props: true,
    },
    {
        name: "school.front_office.edit_complain_type",
        path: "/school/front_office/edit_complain_type/:edit_id",
        component: AddComplainType,
        props: true,
    },
    {
        name: "school.front_office.purpose",
        path: "/school/front_office/purpose",
        component: Purpose,
        props: true,
    },
    {
        name: "school.front_office.add_purpose",
        path: "/school/front_office/add_purpose",
        component: AddPurposeForm,
        props: true,
    },
    {
        name: "school.front_office.edit_purpose",
        path: "/school/front_office/edit_purpose/:edit_id",
        component: AddPurposeForm,
        props: true,
    },
    {
        name: "school.front_office.source",
        path: "/school/front_office/source",
        component: Source,
        props: true,
    },
    {
        name: "school.front_office.add_source",
        path: "/school/front_office/add_source",
        component: AddSourceForm,
        props: true,
    },
    {
        name: "school.front_office.edit_source",
        path: "/school/front_office/edit_source/:edit_id",
        component: AddSourceForm,
        props: true,
    },
    {
        name: "school.front_office.reference",
        path: "/school/front_office/reference",
        component: Reference,
        props: true,
    },
    {
        name: "school.front_office.add_reference",
        path: "/school/front_office/add_reference",
        component: AddReferenceForm,
        props: true,
    },
    {
        name: "school.front_office.edit_reference",
        path: "/school/front_office/edit_reference/:edit_id",
        component: AddReferenceForm,
        props: true,
    },
    {
        name: "school.front_office.admission_enqiry_view",
        path: "/school/front_office/admission_enqiry_view/:enquiry_student_id",
        component: ViewAdmissionEnquiry,
        props: true,
    },
    {
        name: "school.front_office.phone_call_view",
        path: "/school/front_office/phone_call_view/:phone_id",
        component: ViewCallsDetail,
        props: true,
    },
    {
        name: "school.front_office.postal_view",
        path: "/school/front_office/postal_view/:postal_id",
        component: ViewPostalDetail,
        props: true,
    },
    {
        name: "school.front_office.complain_view",
        path: "/school/front_office/complain_view/:complain_id",
        component: ViewComplainDetail,
        props: true,
    },
];
