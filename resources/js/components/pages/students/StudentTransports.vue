<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb
                pageTitle="Student Transport"
                :breadcrumbList="breadcrumbList"
            />
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Add Student Transport Details</h3>
                                </div>
                            </div>

                            <form class="new-added-form">
                                <div
                                    class="col-xl-4 col-lg-6 col-12 form-group mt-3"
                                >
                                    <label>If Transport Available</label>
                                    <div class="row ms-5">
                                        <input
                                            class="form-radio-input mr-3 mt-2"
                                            v-model="isTransport"
                                            type="radio"
                                            value="yes"
                                            name="transport"
                                            id="rteYes"
                                        />
                                        <span class="mr-5">Yes</span>
                                        <input
                                            class="form-radio-input mr-2 mt-2"
                                            v-model="isTransport"
                                            type="radio"
                                            value="no"
                                            name="transport"
                                            id="rteNo"
                                        />
                                        <span class="ml-3">No</span>
                                    </div>
                                </div>
                                <div class="row" v-show="isTransport == 'yes'">
                                    <label
                                        class="form-group row ml-3"

                                    >
                                        Route List
                                    </label>
                                    <div
                                        class="row col-md-12 col-sm-8 form-group"

                                    >
                                        <Select2 class="col-md-12 col-12"
                                            ref="route_list"
                                            :items="route_list"
                                            @change="selectRoute"
                                            :class="
                                                errorItem.route_list != ''
                                                    ? 'error-field'
                                                    : ''
                                            "
                                        />
                                        <span
                                            class="error-label"
                                            v-if="errorItem.route_list != ''"
                                            v-text="errorItem.route_list"
                                        ></span>
                                    </div>
                                    <div class="col-md-12 col-sm-12 form-group">
                                        <button
                                            type="submit"
                                            class="btn-fill-lg text-light shadow-dodger-blue bg-dodger-blue"
                                            @click="$router.push('address')"
                                        >
                                            Back
                                        </button>
                                        <button
                                            type="submit"
                                            class="btn-fill-lg text-light shadow-dodger-blue bg-dodger-blue"
                                            :class="formBtnClass"
                                            @click.prevent="submitData()"
                                        >
                                            {{ formBtn }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <Footer />
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
                    to: {
                        name: "admin.dashboard",
                    },
                    name: "Home",
                },
                {
                    name: "Student",
                },
                {
                    to: {
                        name: "admin.students.admissions",
                    },
                    name: "Admission",
                },
                {
                    name: "Student Transport",
                },
            ],
            isLoaded: false,
            noData: false,
            editItem: {},
            isTransport: "",
            route_list: [],
            selectedRouteId: "-1",
            admission_id: -1,
            errorItem: {
                route_list: "",
            },
            editedIndex:-1
        };
    },
    computed: {
        formBtn: function () {
            return this.editedIndex != -1 ? "Update & Next" : "Save & Next";
        },
        formBtnClass: function () {
            return this.editedIndex != -1 ? "btn-warning" : "btn-success";
        },
    },
    computed: {
        formBtn: function () {
            return this.editedIndex != -1 ? "Update & Next" : "Save & Next";
        },
        formBtnClass: function () {
            return this.editedIndex != -1 ? "btn-warning" : "btn-success";
        },
    },
    mounted() {
        this.$parent.loadOtherScript();
        this.admission_id = this.$route.params.student_admission_id;
        if (this.$route.params.student_admission_id) {
            this.getEditItemData();
        }
        this.getRoute();
    },
    methods: {
        async getRoute() {
            const res = await this.callApi(
                "get",
                `/api/school/students/student_transports/route_list`,
                null
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.route_list = data.route_list;
                    this.$refs.route_list.updateList(data.route_list);
                }
            }
        },
        selectRoute(routeId) {
            this.selectedRouteId = routeId;
            this.errorItem.route_list = "";
        },
        async getEditItemData() {
            var data = new FormData();
            data.append("admission", this.admission_id);
            const res = await this.callApi(
                "post",
                `/api/school/students/student_transports/edit`,
                data
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.editItem = data.edit_transport;
                    this.editedIndex = data.edit_transport.student_transport_id;
                    this.$refs.route_list.setSelected(
                        data.edit_transport.school_route_id
                    );
                    this.selectedRouteId = data.edit_transport.school_route_id;
                } else {
                    this.editedIndex = -1;
                }
            }
        },
        async submitData() {
            if (this.isTransport == "yes") {
                var isVaild = await this.validTransactionForm();
                if (!isVaild) {
                    return;
                }
            }
                toast = Toast.fire({
                    icon: "warning",
                    title: "Please Wait!! Creating new Admission",
                    timer: 0,
                });
                var data = new FormData();
                data.append("admission_id", this.admission_id ? this.admission_id : '');
                data.append("is_transport",this.isTransport ? this.isTransport : '');
                data.append(
                    "school_route_id",
                    this.selectedRouteId != -1 ? this.selectedRouteId : ""
                );
                let url = "";
                if(this.editedIndex == -1 ){
                    url = `/api/school/students/student_transports/save`;
                }else{
                    url = `/api/school/students/student_transports/update/${this.editedIndex}`
                }
                const res = await this.callApi(
                    "post",
                    url,
                    data
                );
                this.log('res' ,res);
                if (res.status == 200) {
                    var data = res.data;
                    if (data.status == "success") {
                        toast = Toast.fire({
                            icon: data.status,
                            title: data.message,
                            timer: 2500,
                        });
                        setTimeout(() => {
                            this.$router.push({
                                path: `/school/students/${this.admission_id}/hostels`,
                            });
                        }, 3000);
                    } else {
                        toast = Toast.fire({
                            icon: data.status,
                            title: data.message,
                            timer: 2500,
                        });
                    }
                } else {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                }

        },
        validTransactionForm() {
            this.isFormValid = true;
            if (this.selectedRouteId == -1) {
                this.errorItem.route_list = "Route Name  is required";
                this.isFormValid = false;
            } else {
                this.errorItem.route_list = "";
            }
            return this.isFormValid;
        },
    },
};
</script>
