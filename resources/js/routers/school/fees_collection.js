import CollectFees from "../../components/pages/fees_collection/school_collect_fees/CollectFees.vue";
import FeesDiscount from "../../components/pages/fees_collection/school_fees_discount/FeesDiscount.vue";
import AddDiscount from "../../components/pages/fees_collection/school_fees_discount/AddDiscount.vue";
import FeesMaster from "../../components/pages/fees_collection/school_fees_master/FeesMaster.vue";
import AddFeesMasterForm from "../../components/pages/fees_collection/school_fees_master/AddFeesMasterForm.vue";
import FeesGroup from "../../components/pages/fees_collection/school_fees_group/FeesGroup.vue";
import AddFeesGroup from "../../components/pages/fees_collection/school_fees_group/AddFeesGroup.vue";
import FeesType from "../../components/pages/fees_collection/school_fees_types/FeesType.vue";
import AddFeesType from "../../components/pages/fees_collection/school_fees_types/AddFeesType.vue";
import FeesStatement from "../../components/pages/fees_collection/FeesStatement.vue";
import AddFeesForm from "../../components/pages/fees_collection/AddFeesForm.vue";
import FeesPaymentDetail from "../../components/pages/fees_collection/FeesPaymentDetail.vue";

export default [{
        name: "school.fees.collection",
        path: "/school/fees/collection",
        component: CollectFees,
        props: true,
    },
    {
        name: "school.fees.add_fees",
        path: "/school/fees/add_fees/:student_id/:fees_master_id",
        component: AddFeesForm,
        props: true,
    },
    {
        name: "school.fees.edit_fees",
        path: "/school/fees/edit_fees/:edit_id/:fee_master_id",
        component: AddFeesForm,
        props: true,
    },
    {
        name: "school.fees.statement",
        path: "/school/fees/statement/:student_id",
        component: FeesStatement,
        props: true,
    },
    {
        name: "school.fees.master",
        path: "/school/fees/master",
        component: FeesMaster,
        props: true,
    },
    {
        name: "school.fees.add_master",
        path: "/school/fees/add_master",
        component: AddFeesMasterForm,
        props: true,
    },
    {
        name: "school.fees.edit_master",
        path: "/school/fees/edit_master/:edit_id",
        component: AddFeesMasterForm,
        props: true,
    },
    {
        name: "school.fees.groups",
        path: "/school/fees/groups",
        component: FeesGroup,
        props: true,
    },
    {
        name: "school.fees.add_groups",
        path: "/school/fees/add_groups",
        component: AddFeesGroup,
        props: true,
    },
    {
        name: "school.fees.edit_groups",
        path: "/school/fees/edit_groups/:edit_id",
        component: AddFeesGroup,
        props: true,
    },
    {
        name: "school.fees.type",
        path: "/school/fees/type",
        component: FeesType,
        props: true,
    },
    {
        name: "school.fees.add_type",
        path: "/school/fees/add_type",
        component: AddFeesType,
        props: true,
    },
    {
        name: "school.fees.edit_type",
        path: "/school/fees/edit_type/:edit_id",
        component: AddFeesType,
        props: true,
    },
    {
        name: "school.fees.discount",
        path: "/school/fees/discount",
        component: FeesDiscount,
        props: true,
    },
    {
        name: "school.fees.add_discount",
        path: "/school/fees/add_discount",
        component: AddDiscount,
        props: true,
    },
    {
        name: "school.fees.edit_discount",
        path: "/school/fees/edit_discount/:edit_id",
        component: AddDiscount,
        props: true,
    },
    {
        name: "school.fees.fees_payment",
        path: "/school/fees/fees_payment/:admission_id/:fee_master_id/:fee_id?",
        component: FeesPaymentDetail,
        props: true,
    },

];