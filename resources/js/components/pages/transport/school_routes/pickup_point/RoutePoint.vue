<template>
    <div>
        <div class="dashboard-content-one">
            <div class="d-flex">
                <div style="width: -webkit-fill-available">
                    <Breadcrumb pageTitle="Transport" :breadcrumbList="breadcrumbList" />
                </div>
            </div>
            <div class="row gutters-20">
                <div class="col-5">
                    <div class="card height-auto">
                        <div>
                            <div class="card-header ">
                                <div class="item-title">
                                    <h3>Add Route Points </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <form class="mg-b-20">
                                    <div class="col-12">
                                        <AddPoint ref="addVehicle"  />
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
                                <h3>Route Points</h3>
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
import AddPoint from "./AddPoint.vue";
export default {
    components: {
        AddPoint,
    },
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "school.dashboard" },
                    name: "Home",
                },
                {
                    name: "Route Pick Points",
                },
            ],
            tableHead: {
                items: {
                    item1: { label: "Sr.No." },
                    item2: { label: "Route Name" },
                    item3: { label: "Name" },
                    item4: { label: "Address" },
                    item5: { label: "Lat" },
                    item6: { label: "Long" },
                    item7: { label: "position" },
                },
                actions: true,
            },
            tableData: {},
            tableData: [],
            isLoaded: true,
            noData: false,
        };
    },
    computed:{},
    created() {},
    mounted() {},
    methods: {
    },
};
</script>
<style scope>
.mt-6 {
    margin-top: 60px !important;
}
</style>
