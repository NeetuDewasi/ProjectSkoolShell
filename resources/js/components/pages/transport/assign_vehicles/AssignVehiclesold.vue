<template>
    <div>
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start -->
            <Breadcrumb pageTitle="Item Issueing Information " :breadcrumbList="breadcrumbList" />
            <!-- End Breadcubs Area -->
            <!-- Add Item Store Start Here -->
            <div class="row gutters-20">
                <div class="col-5">
                    <div class="card height-auto">
                        <div>
                            <div class="card-header ">
                                <div class="item-title">
                                    <h3>Add Issue Item </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="col-12">
                                    <form class="new-added-form">
                                        <div class="row">
                                            <div class="col-12 form-group">
                                                <label>Vehicle *</label>
                                                <select class="form-control">
                                                    <option aria-placeholder="---Select Vehicle---">
                                                        ---SELECT Vehicle---
                                                    </option>
                                                    <option v-for="vehicle in vehicles" :key="vehicle.value"
                                                        :value="vehicle.value">
                                                        {{ vehicle.vehicle_name }}
                                                    </option>
                                                </Select>
                                                <span v-if="vehicleError != ''" class="error-label"
                                                    v-text="vehicleError"></span>
                                            </div>
                                            <div class="col-12 form-group">
                                                <label>Driver*</label>
                                                <Select :class="
                                                    editItem.drivers == null
                                                        ? 'error-field'
                                                        : ''
                                                " v-model="editItem.drivers"
                                                    aria-placeholder="---Select Driver---" class="form-control">
                                                    <option value="">
                                                        ---SELECT DRIVER---
                                                    </option>
                                                    <option v-for="driver in drivers" :key="driver.value"
                                                        :value="driver.value">
                                                        {{ driver.name }}
                                                    </option>
                                                </Select>
                                                <span v-if="driverError != ''" class="error-label"
                                                    v-text="driverError"></span>
                                            </div>
                                            <div class="col-12 form-group">
                                                <label>Route *</label>
                                                <Select class="form-control" v-model="editItem.routes">
                                                    <option value="">
                                                        ---SELECT ROUTE---
                                                    </option>
                                                    <option v-for="route in routes" :value="route.value"
                                                        :key="route.value">
                                                        {{ route.name }}
                                                    </option>
                                                </Select>
                                                <span v-if="routeError != ''" class="error-label"
                                                    v-text="routeError"></span>
                                            </div>
                                            <div class="col-12 form-group">
                                                <button class="
							btn-lg btn btn-gradient-yellow btn-hover-bluedark
							text-white
						" @click.prevent="submitForm()"> Save
                                                    {{ formBtn }}
                                                </button>
                                                <button type="reset" class="
							btn-lg btn
							bg-blue-dark
							btn-hover-yellow
							text-white
						">
                                                    Reset
                                                </button>
                                            </div>


                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-7">
                    <div class="card height-auto">
                        <div class="card-header ">
                            <div class="item-title">
                                <h3>Vehicles Assigning Information </h3>
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
                <Footer />
            </div>
        </div>
    </div>
</template>
<script>
var toast;
export default {
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "school.dashboard" },
                    name: "Home",
                },
                {
                    name: "TransportAssignVehicles",
                },
            ],
            isLoaded: true,
            noData: false,
            vehicleId: -1,
            driverId: -1,
            routeId: -1,
            vehicleError: "",
            driverError: "",
            routeError: "",
            vehicles: [],
            drivers: [],
            routes: [],
            assignedRoutes: [],
            editItem: {},
        };
    },
    mounted() {
        this.$parent.loadOtherScript();
        toast = Toast.fire({
            icon: "warning",
            title: "Loading data...",
            timer: 0,
        });
        this.showData();
    },
    created() { },
    methods: {
        async showData() {
            const res = await this.callApi(
                "get",
                "/api/school/transport/assign_vehicle"
            );
            if (res.status == 200) {
                toast.close();
                var data = res.data;
                if (data.status == "success") {
                    this.vehicles = data.vehicles;
                    this.drivers = data.drivers;
                    this.routes = data.routes;

                    var drivers = [];
                    this.vehicles.forEach((currentItem) => {
                        drivers.push("");
                    });
                    this.editItem = {
                        drivers: drivers,
                        routes: JSON.parse(JSON.stringify(drivers)),
                    };
                    this.vehicles.forEach((element,) => {
                        this.editItem.drivers =
                            element.assign_route.driver.value;
                        this.editItem.routes =
                            element.assign_route.route.route_id;
                    });
                } else {
                    this.vehicles = data.vehicles;
                    this.drivers = data.drivers;
                    this.routes = data.routes;
                    var drivers = [];
                    this.vehicles.forEach((currentItem) => {
                        drivers.push("");
                    });
                    this.editItem = {
                        drivers: drivers,
                        routes: JSON.parse(JSON.stringify(drivers)),
                    };
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                    this.noData = true;
                }
            } else {
                toast = Toast.fire({
                    icon: data.status,
                    title: data.message,
                    timer: 2500,
                });
            }
        },
        async submitForm() {
            var isVaild = await this.validItemForm();
            if (!isVaild) {
                return;
            }
        //    this.editItem.incomeHeadId = this.selectedIncomeHead;
        //    this.editItem.incomeItemId = this.selectedIncomeItem;

            toast = Toast.fire({
                icon: "warning",
                title: "Please Wait!! Creating new Item",
                timer: 0,
            });
            this.$parent.submitForm(this.editItem, this.editedIndex);
            this.editItem = {};
            this.editedIndex = -1;
        },

        // edit(item) {
        //     this.selectedIncomeHead = item.income_head != null ? item.income_head.value : -1;
        //     this.$refs.income_head_list_select2.setSelected(this.selectedIncomeHead);
        //     this.selectedIncomeItem = item.item_name != null ? item.item_name.value : -1;
        //     this.$refs.item_name_select2.setSelected(this.selectedIncomeItem);
        //     this.editItem = item;
        //     this.editedIndex = item.id;
        // },

        validItemForm() {
            this.isFormValid = true;
             if (this.vehicleId == -1) {
                this.errorItem.vehicleError = "vehicle is required";
                this.isFormValid = false;
            } else {
                this.errorItem.vehicleError = "";
            }

            if (this.driverId == -1) {
                this.errorItem.driverError = "Driver is required";
                this.isFormValid = false;
            } else {
                this.errorItem.driverError = "";
            }

            if (this.routeId == -1) {
                this.errorItem.routeError = "Route is required";
                this.isFormValid = false;
            } else {
                this.errorItem.routeError = "";
            }
            return this.isFormValid;
        },
            selectedVehicle(val) {
            this.vehicleId = val;
            this.vehicleError = "";
        },
        selectedDriver(val) {
            this.driverId = val;
            this.driverError = "";
        },
        selectedRoute(val) {
            this.routeId = val;
            this.routeError = "";
        },
        async submitData(vehicle, driverId, routeId,) {
            var formData = new FormData();
            formData.append("route_id", routeId);
            formData.append("driver_id", driverId);
            formData.append("vehicle_id", vehicle);
            const res = await this.callApi(
                "post",
                "/api/school/transport/assign_vehicle/save",
                formData
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                } else {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                }
            }
        },
    },
};
</script>


<style scoped>
</style>
