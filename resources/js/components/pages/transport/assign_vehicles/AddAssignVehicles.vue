<template>
    <div>
        <div class="card height-auto">
            <div class="row">
                <div class="col-12 form-group">
                    <label>Route Name
                        <span class="text-danger">*</span>
                    </label>
                    <Select2 ref="route_list_select2" :items="route_list" @change="selectRoute" :selectedId="selectRoute"
                        :class="
                            errorItem.route_list != '' ? 'error-field' : ''
                        " />
                    <span class="error-label" v-if="errorItem.route_list != ''" v-text="errorItem.route_list">
                    </span>
                </div><br>
                <div class="col-12 form-group">
                    <label>Vehicle Name
                        <span class="text-danger">*</span>
                    </label>
                    <Select2 ref="vehicle_list_select2" :items="vehicle_list" @change="selectVehicle"
                        :selectedId="selectVehicle" :class="
                            errorItem.vehicle_list != '' ? 'error-field' : ''
                        " />
                    <span class="error-label" v-if="errorItem.vehicle_list != ''" v-text="errorItem.vehicle_list">
                    </span>
                </div><br>
                <div class="col-12 form-group">
                    <label>Driver Name
                        <span class="text-danger">*</span>
                    </label>
                    <Select2 ref="driver_list_select2" :items="driver_list" @change="selectDriver"
                        :selectedId="selectDriver" :class="
                            errorItem.driver_list != '' ? 'error-field' : ''
                        " />
                    <span class="error-label" v-if="errorItem.driver_list != ''" v-text="errorItem.driver_list">
                    </span>
                </div><br>
                <div class="col-12 form-group">
                    <button @click.prevent="submitForm()" class="
							btn-lg btn btn-gradient-yellow btn-hover-bluedark
							text-white
						">
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
        </div>
    </div>
</template>
<script>
var toast;
export default {
    props: ["itemCategories"],
    data() {
        return {
            editedIndex: -1,
            editItem: {},
            errorItem: {

                drivers: "",
                driver_list: "",
                routes: "",
                route_list: "",
                vehicles: "",
                vehicle_list: "",
            },
            route_list: [],
            assign_route: [],
            vehicle_list: [],
            driver_list: [],



        };
    },
    computed: {
        formBtn: function () {
            return this.editedIndex !== -1 ? "update" : "save";
        },
    },
    created() { },
    mounted() {
        this.getRouteData();
        this.getDriverData();
        this.getVehicleData();
    },
    methods: {
        async getRouteData(val) {
            this.editItem.routeId = val;
            if (this.editItem.routeId != -1) {
                const res = await this.callApi(
                    "get",
                    `/api/school/transport/assign_vehicle/route_list`,
                    null
                );
                if (res.status == 200) {
                    var data = res.data;
                    this.route_list = data.route_list;
                    this.$refs.route_list_select2.updateList(this.route_list);

                }
            }
        },
        async getDriverData(val) {
            this.editItem.driverId = val;
            if (this.editItem.driverId != -1) {
                const res = await this.callApi(
                    "get",
                    `/api/school/transport/assign_vehicle/driver_list`,
                    null
                );

                if (res.status == 200) {
                    var data = res.data;
                    this.driver_list = data.driver_list;
                    this.$refs.driver_list_select2.updateList(data.driver_list);

                }
            }
        },
        async getVehicleData(val) {
            this.editItem.vehicleId = val;
            if (this.editItem.vehicleId != -1) {
                const res = await this.callApi(
                    "get",
                    `/api/school/transport/assign_vehicle/vehicle_list`,
                    null
                );
                console.log(res);
                if (res.status == 200) {
                    var data = res.data;
                    this.vehicle_list = data.vehicle_list;
                    this.$refs.vehicle_list_select2.updateList(data.vehicle_list);
                }
            }
        },

        selectRoute(val) {

            this.editItem.selectedRoute = val;
            this.errorItem.route_list = "";
        },
        selectDriver(val) {
            this.editItem.selectedDriver = val;
            // this.selectedDriver = val;
            this.errorItem.driver_list = "";
        },
        selectVehicle(val) {
            this.editItem.selectedVehicle = val;
            // this.selectedVehicle = val;
            this.errorItem.vehicle_list = "";
        },
        async submitForm() {
            var isVaild = await this.validItemForm();
            if (!isVaild) {
                return;
            }
            this.editItem.routeId = this.selectedRoute;
            this.editItem.driverId = this.selectedDriver;
            this.editItem.vehicleId = this.selectedVehicle;
            toast = Toast.fire({
                icon: "warning",
                title: "Please Wait!! Creating new Item",
                timer: 0,
            });
            this.$parent.submitForm(this.editItem, this.editedIndex);
            this.editItem = {};
            this.editedIndex = -1;
        },

        edit(item) {
            this.selectedRoute = item.route != null ? item.route.route_id : -1;
            this.$refs.route_list_select2.setSelected(this.selectedRoute);
            this.selectedVehicle = item.vehicle != null ? item.vehicle.value : -1;
            this.$refs.vehicle_list_select2.setSelected(this.selectedVehicle);
            this.selectedDriver = item.driver != null ? item.driver.value : -1;
            this.$refs.driver_list_select2.setSelected(this.selectedDriver);
            this.editItem = item;
            this.editedIndex = item.id;
        },

        validItemForm() {
            this.isFormValid = true;
            if (this.selectedRoute == -1) {
                this.errorItem.route_list = "Select Route First is required";
                this.isFormValid = false;
            } else {
                this.errorItem.route_list = "";
            }

            if (this.selectedDriver == -1) {
                this.errorItem.driver_list = "Select Driver First is required";
                this.isFormValid = false;
            } else {
                this.errorItem.driver_list = "";
            }
            if (this.selectedVehicle == -1) {
                this.errorItem.vehicle_list = "Select Vehicle First is required";
                this.isFormValid = false;
            } else {
                this.errorItem.vehicle_list = "";
            }

            return this.isFormValid;
        },
    },
};
</script>
<style scoped>
.error-s {
    color: red;
}
</style>
<style scoped>
.imageContainer {
    width: 100%;
    height: 150px;
    border: grey dashed 2px;
    border-radius: 10px;
    position: relative;
    background: #ffffff;
    text-align: center;
    padding: 10px;
    margin: auto;
    margin-bottom: 40px;
    cursor: pointer;
}

.imageContainer img {
    /* width: 100%; */
    height: 100%;
}

.imageContainer input {
    width: 100%;
    height: 100%;
    opacity: 0;
    position: absolute;
    top: 0;
    left: 0;
}
</style>
