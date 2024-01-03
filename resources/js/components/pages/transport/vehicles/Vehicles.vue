<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb pageTitle="Vehicles" :breadcrumbList="breadcrumbList" />

            <div class="row gutters-20">
                <div class="col-5">
                    <div class="card height-auto">
                        <div>
                            <div class="card-header ">
                                <div class="item-title">
                                    <h3>Add Vehicles information </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <form class="mg-b-20">
                                    <div class="col-12">
                                        <Add_Transport_Vehicles ref="addVehicle" :itemCategories="itemCategories" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-7">
                    <div class="card height-auto">
                        <div class="card-header ">
                            <div class="item-title">
                                <h3>Vehicles information</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div>
                                <div class="table table-responsive" v-show="!noData">
                                    <Table ref="table" :tableData="tableData" :tableHead="tableHead" />
                                </div>
                                <NoData v-show="noData" />
                            </div>
                            <!-- All Transport List Area End Here -->
                        </div>
                        <!-- All Subjects Area End Here -->
                    </div>
                </div>
            </div>
            <Footer />
        </div>
    </div>
</template>
<script>
var toast;
import Add_Transport_Vehicles from "./AddVehicles.vue";
export default {
    components: {
        Add_Transport_Vehicles,
    },
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "school.dashboard" },
                    name: "Home",
                },
                {
                    name: "TransportVehicles",
                },
            ],
            TransporTroutesList: [],
            tableHead: {
                items: {
                    item1: { label: "Sr.No." },
                    item2: { label: "Vehicle No " },
                    item3: { label: "Vehicle Model" },
                    item4: { label: "Registration Number" },
                    item5: { label: "Insurance Date" },
                    item6: { label: "PUC Date" },
                    item7: { label: "Service Date" },
                    item8: { label: "Note" },
                },
                actions: true,
            },
            tableData: [],
            isLoaded: true,
            noData: false,
            itemCategories: [],
        };
    },
    mounted() {
        this.$parent.loadOtherScript();
    },
    created() {
        toast = Toast.fire({
            icon: "warning",
            title: "Loading Data..",
            timer: 0,
        });
        this.showData();
    },
    methods: {
        async showData() {
            const res = await this.callApi(
                "get",
                `/api/school/transport/vehicles`,
                null
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.TransporTroutesList = data.vehicle_no;
                    this.initTable();
                } else {
                    toast = Toast.fire({
                        icon: "error",
                        title: "Something went wrong",
                        timer: 2500,
                    });
                    this.noData = true;
                }
            }
            this.$refs.table.loadTable();
            this.isLoaded = false;
            toast.close();
        },
        initTable() {
            this.tableData = [];
            this.TransporTroutesList.forEach((element) => {
                this.tableData.push({
                    item: element,
                    data: {
                        item1: element.vehicle_id,
                        item2: element.vehicle_no,
                        item3: element.vehicle_model,
                        item4: element.vehicle_registration_no,
                        item5: Vue.filter("formatDate")(
                            element.vehicle_insurance_date
                        ),
                        item6: Vue.filter("formatDate")(
                            element.vehicle_puc_date
                        ),
                        item7: Vue.filter("formatDate")(
                            element.vehicle_service_date
                        ),
                        item8: element.vehicle_note ? element.vehicle_note : "",
                    },
                    action: {
                        edit: true,
                        delete: true,
                    },
                });
            });
        },
        async submitForm(item, itemId) {
            var formData = new FormData();
            formData.append("vehicle_no", item.vehicle_no);
            formData.append("registration_no", item.vehicle_registration_no);
            formData.append("vehicle_model", item.vehicle_model);
            formData.append("model_year", item.vehicle_model_year);
            formData.append("insurance_date", item.vehicle_insurance_date);
            formData.append("puc_date", item.vehicle_puc_date);
            formData.append("service_date", item.vehicle_service_date);
            formData.append("note", item.vehicle_note ? item.vehicle_note : "");

            let $url = "";
            if (itemId !== -1) {
                $url = `/api/school/transport/vehicles/update/${itemId}`;
            } else {
                $url = `/api/school/transport/vehicles/save`;
            }

            const res = await this.callApi("post", $url, formData);

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    if (this.noData) {
                        this.noData = false;
                    }
                    this.$refs.addVehicle.resetForm();
                    if (itemId !== -1) {
                        this.initTable();
                    } else {
                        this.TransporTroutesList.unshift(data.vehicle_no);
                        var element = data.vehicle_no;
                        this.tableData.unshift({
                            item: element,
                            data: {
                                item1: element.vehicle_id,
                                item2: element.vehicle_no,
                                item3: element.vehicle_model,
                                item4: element.vehicle_registration_no,
                                item5: Vue.filter("formatDate")(
                                    element.vehicle_insurance_date
                                ),
                                item6: Vue.filter("formatDate")(
                                    element.vehicle_puc_date
                                ),
                                item7: Vue.filter("formatDate")(
                                    element.vehicle_service_date
                                ),
                                item8: element.vehicle_note
                                    ? element.vehicle_note
                                    : "",
                            },
                            action: {
                                edit: true,
                                delete: true,
                            },
                        });
                    }
                }
                toast = Toast.fire({
                    icon: data.status,
                    title: data.message,
                    timer: 2500,
                });
            } else {
                toast = Toast.fire({
                    icon: "error",
                    title: "Something went wrong",
                    timer: 2500,
                });
            }
            this.editedIndex = -1;
        },

        edit(item, index) {
            this.$refs.addVehicle.edit(item, index);
        },
        async deleteData(item, index) {
            var formData = new FormData();
            formData.append("status", "deleted");
            const res = await this.callApi(
                "post",
                `/api/school/transport/vehicles/delete/${item.vehicle_id}`,
                formData
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.TransporTroutesList.splice(index, 1);
                    this.tableData.splice(index, 1);
                    SwalCustomBtn.fire("Deleted!", data.message, "success");
                } else {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                }
            } else {
                toast = Toast.fire({
                    icon: "error",
                    title: "Something Went Wrong, Not able to delete",
                    timer: 2500,
                });
            }
        },
    },
};
</script>
