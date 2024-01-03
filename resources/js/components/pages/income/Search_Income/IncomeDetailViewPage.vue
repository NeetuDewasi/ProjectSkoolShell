<template>
    <div>
        <div>
            <div class="dashboard-content-one">
                <!-- Breadcubs Area Start -->
                <Breadcrumb pageTitle="Income Information" :breadcrumbList="breadcrumbList" />
                <!-- End Breadcubs Area -->
                <!-- All Income Lists Start Here -->
                <div class="row gutters-20">
                    <div class="col-8-xxxl col-12">
                        <div class="card height-auto shadow">
                            <div class="card-header">
                                <h2>
                                    Income Information
                                </h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class='col-5 rounded border card shadow text-center'>
                                        <img :src="Incomereports.document" class="mt-3" width="100%" />
                                    </div>
                                    <div class="col-7 card border border-rounded">
                                        <div class="item-content mt-3">
                                            <div class="header-inline item-header pt-3  card-header">
                                                <h3 class="text-dark-medium font-medium">Invoice Detail </h3>
                                                <div class="header-elements d-flex">
                                                    <div class="mr-3"><a href="#"><i class="fas fa-print"></i></a></div>
                                                    <div><a href="#"><i class="fas fa-download"></i></a></div>
                                                </div>
                                            </div>
                                            <div class="table table-responsive  card-body">
                                                <table class="table text-nowrap  mt-5 ">
                                                    <tbody>
                                                        <tr>
                                                            <td width="75"><strong>Ref.Number</strong></td>
                                                            <td width="91"><span v-if="Incomereports.id && Incomereports.id != null ">{{ Incomereports.id }}</span></td>
                                                            <td width="108"><strong>Date : </strong></td>
                                                            <td width="107"><span v-if="Incomereports.income_date && Incomereports.income_date != null "> {{ Incomereports.income_date }}</span></td>
                                                        </tr>


                                                        <tr>
                                                            <td><strong>Income Head:</strong></td>
                                                            <td class="font-medium text-dark-medium"><span v-if="Incomereports.income_head && Incomereports.income_head != null ">{{
                                                                    Incomereports.income_head.name
                                                            }}</span></td>
                                                            <td><strong>Item : </strong> </td>
                                                            <td class="font-medium text-dark-medium"><span v-if="Incomereports.item_name && Incomereports.item_name !=null">
                                                            {{
                                                                    Incomereports.item_name.name
                                                            }}</span></td>
                                                        </tr>

                                                        <tr>
                                                            <td><strong>Number:</strong> </td>
                                                            <td class="font-medium text-dark-medium"><span v-if="Incomereports.invoice_number && Incomereports.invoice_number !=null"> {{
                                                                    Incomereports.invoice_number
                                                            }}</span></td>
                                                            <td class="font-weight-bold">Amount : </td>
                                                            <td class="font-medium text-dark-medium"><span v-if="Incomereports.amount && Incomereports.amount !=null"> {{
                                                                    Incomereports.amount
                                                            }}</span></td>
                                                        </tr>

                                                        <tr>
                                                            <td class="font-weight-bold">Description</td>
                                                            <td colspan="4" class="font-medium text-dark-medium"><span v-if="Incomereports.description &&  Incomereports.description !=null">{{
                                                                    Incomereports.description
                                                            }}</span></td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- All Subjects Area End Here -->
        <Footer />
    </div>
</template>
<script>
var toast;
export default {
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "admin.dashboard" },
                    name: "Home",
                },
                {
                    name: "SearchIncome",
                },
            ],
            Incomereports: {},


        };
    },
    mounted() {
        this.$parent.loadOtherScript();

            this.log("this.$route.params.id >>>>>>>>>>>>>>>", this.$route.params.id);
        if (this.$route.params.id) {
            this.log("this.$route.params.id", this.$route.params.id);
            this.showData()
        } else {
            this.$router.go('-1');
        }

    },
    created() {
        toast = Toast.fire({
            icon: "warning",
            title: "Loading Data..",
            timer: 0,
        });
    },
    methods: {
        async showData() {
            const res = await this.callApi(
                "get",
                `/api/school/income/SearchIncome/detail/${this.$route.params.id}`,
                null,

            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.Incomereports = data.income;
                } else {
                    toast = Toast.fire({
                        icon: "error",
                        title: "Something went wrong",
                        timer: 2500,
                    });
                    this.noData = true;
                }

            }
            this.isLoaded = false;
            toast.close();
        },

    },

};
</script>
<style scoped>
tr {
    padding: 10px
}
</style>
