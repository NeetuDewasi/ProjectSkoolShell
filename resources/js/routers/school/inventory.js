import AddItemStock from "../../components/pages/inventory/stock_item/AddItemStock.vue";
import AddItemStockInfo from "../../components/pages/inventory/stock_item/AddItemStockInfo.vue";
import AddItem from "../../components/pages/inventory/school_item/AddItem.vue";
import AddItemForm from "../../components/pages/inventory/school_item/AddItemForm.vue";
import IssueItem from "../../components/pages/inventory/Issue_Item/IssueItem.vue";
import AddIssueItem from "../../components/pages/inventory/Issue_Item/AddIssueItem.vue";
import ItemCategory from "../../components/pages/inventory/school_category/ItemCategory.vue";
import ItemStore from "../../components/pages/inventory/item_store/ItemStore.vue";
import AddItemStore from "../../components/pages/inventory/item_store/AddItemStore.vue";
import ItemSupplier from "../../components/pages/inventory/Item_supplier/ItemSupplier.vue";
import ItemSupplierForm from "../../components/pages/inventory/Item_supplier/ItemSupplierForm.vue";
import ItemCategoryForm from '../../components/pages/inventory/school_category/ItemCategoryForm.vue';



export default [
    {
        name: "school.inventory.AddItem",
        path: "/school/inventory/AddItem",
        component: AddItem,
        props: true,
    },
    {
        name: "school.inventory.AddItemForm",
        path: "/school/inventory/AddItemForm",
        component: AddItemForm,
        props: true,
    },
    {
        name: "school.inventory.AddItemForm.edit",
        path: `/school/inventory/AddItemForm/edit/:edit_id`,
        component: AddItemForm,
        props: true,
    },

    {
        name: "school.inventory.AddItemStock",
        path: "/school/inventory/AddItemStock",
        component: AddItemStock,
        props: true,
    },
    {
        name: "school.inventory.AddItemStock.edit",
        path: "/school/inventory/AddItemStock/edit/:edit_id",
        component: AddItemStock,
        props: true,
    },

    {
        name: "school.inventory.AddItemStockInfo",
        path: "/school/inventory/AddItemStockInfo",
        component: AddItemStockInfo,
        props: true,
    },

    {
        name: "school.inventory.AddItemStockInfo.edit",
        path: "/school/inventory/AddItemStockInfo/edit/:edit_id",
        component: AddItemStockInfo,
        props: true,
    },



    {
        name: "school.inventory.IssueItem",
        path: "/school/inventory/IssueItem",
        component: IssueItem,
        props: true,
    },

    {
        name: "school.inventory.AddIssueItem.edit",
        path: "/school/inventory/AddIssueItem/edit/:edit_id",
        component: AddIssueItem,
        props: true,
    },

    {
        name: "school.inventory.ItemCategory",
        path: "/school/inventory/ItemCategory",
        component: ItemCategory,
        props: true,
    },
    {
        name: "school.inventory.ItemCategoryForm",
        path: "/school/inventory/ItemCategoryForm",
        component: ItemCategoryForm,
        props: true,
    },
    {
        name: "school.inventory.ItemCategoryForm.edit",
        path: "/school/inventory/ItemCategoryForm/edit/:edit_id",
        component: ItemCategoryForm,
        props: true,
    },

    {
        name: "school.inventory.ItemStore",
        path: "/school/inventory/ItemStore",
        component: ItemStore,
        props: true,
    },
    {
        name: "school.inventory.AddItemStore",
        path: "/school/inventory/AddItemStore",
        component: AddItemStore,
        props: true,
    },
    {
        name: "school.inventory.AddItemStore.edit",
        path: "/school/inventory/AddItemStore/edit/:edit_id",
        component: AddItemStore,
        props: true,
    },

    {
        name: "school.inventory.ItemSupplier",
        path: "/school/inventory/ItemSupplier",
        component: ItemSupplier,
        props: true,
    },
    {
        name: "school.inventory.ItemSupplierForm",
        path: "/school/inventory/ItemSupplierForm",
        component: ItemSupplierForm,
        props: true,
    },
    {
        name: "school.inventory.ItemSupplierForm.edit",
        path: `/school/inventory/ItemSupplierForm/edit/:edit_id`,
        component: ItemSupplierForm,
        props: true,
    },

];
