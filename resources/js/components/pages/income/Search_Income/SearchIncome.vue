<template>
    <div>
        <div>
            <div class="dashboard-content-one">
                <!-- Breadcubs Area Start -->
                <Breadcrumb pageTitle="Search Income Lists" :breadcrumbList="breadcrumbList" />
                <!-- End Breadcubs Area -->
                <!-- All Income Lists Start Here -->
                <div class="row gutters-20">
                    <div class="col-8-xxxl col-12">
                        <div class="card height-auto">
                            <div class="card-body">
                                <div class="heading-layout1">
                                </div>
                                <form class="mg-b-20">
                                    <div class="col-12">
                                        <div class="row form-group">
                                            <div class="col-6">
                                                <label>Select Income Head Type : <strong
                                                        class="text-danger bolder">*</strong></label>
                                                <Select2 ref="income_head_list_select2" :items="income_head_list"
                                                    @change="selectIncomeHead" :selectedId="selectedIncomeHead" />

                                            </div>
                                            <div class="col-6">
                                                <label>Select Type Of Search : <strong
                                                        class="text-danger bolder">*</strong></label>
                                                <select class="form-control" v-model="filterDate"
                                                    @change="selectedDate()">
                                                    <option value="">--SELECT DATE--</option>
                                                    <option value="today">Today's</option>
                                                    <option value="yesterday">Yesterday's</option>
                                                    <option value="this_week">This Week's</option>
                                                    <option value="last_week">Last Week's</option>
                                                    <option value="this_month">This Month's</option>
                                                    <option value="last_three_months">Last 3 Months</option>
                                                    <option value="last_six_months">Last 6 Months</option>
                                                    <option value="this_year">
                                                        This Year (From
                                                        {{ thisYearStartDate | formatDate }})
                                                    </option>
                                                    <option value="last_year">
                                                        Last Year From
                                                        {{ lastYearStartDate | formatDate }}
                                                        to
                                                        {{ lastYearEndDate | formatDate }}
                                                    </option>
                                                    <option value="life_time">Life time</option>
                                                    <option value="custom_date">Custom Date</option>
                                                </select>
                                                <div class="col-12 mt-2" v-if="isCustomDate">
                                                    <div class="row form-group">
                                                        <div class="col-6">
                                                            <input type="date" class="form-control"
                                                                v-model="filterDateTo"
                                                                @change="startDate = filterDateTo" />
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="date" class="form-control"
                                                                v-model="filterDateFrom" :min="startDate" :max="endDate"
                                                                @change="endDate = filterDateFrom" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="item-title">
                                    <h3>All Income Lists</h3>
                                </div>
                                <div class="table table-responsive" v-show="filterData.length">
                                    <Table ref="table" :tableData="filterData" :tableHead="tableHead" />
                                </div>
                                <NoData v-show="!filterData.length" />
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
//import SearchIncomeInfo from "./SearchIncomeInfo.vue";
export default {
    components: {
        // SearchIncomeInfo,
    },
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

            Incomereports: [],
            initItemList: [],
            income_head_list: [],
            tableHead: {
                items: {
                    item1: { label: "Sr.No." },
                    item2: { label: "Income Head" },
                    item3: { label: "Income Name" },
                    item4: { label: "Invoice Number" },
                    item5: { label: "Income Date" },
                    item6: { label: "Amount" },
                    item7: { label: "Document" },
                    item8: { label: "Description" },
                    item9: { label: "View Detail" },
                },
                actions: false,
            },
            tableData: [],
            isLoaded: true,
            noData: false,
            editIndex: -1,
            itemCategories: [],
            income_head_list: [],
            selectedIncomeHead: '-1',
            filterType: "all",
            filterDateTo: moment(new Date()).format("YYYY-MM-DD"),
            filterDateFrom: moment(new Date()).format("YYYY-MM-DD"),
            subscribePanel: false,
            filterDate: "",
            isCustomDate: false,
            startDate: '',
            endDate: moment(new Date()).format("YYYY-MM-DD"),
            thisYearStartDate: moment(new Date()).format("YYYY-MM-DD"),
            lastYearStartDate: moment(new Date()).format("YYYY-MM-DD"),
            lastYearEndDate: moment(new Date()).format("YYYY-MM-DD"),
            headName: '',
        };
    },
    mounted() {
        this.$parent.loadOtherScript();
        this.getIncomeHeadData();

    },
    created() {
        toast = Toast.fire({
            icon: "warning",
            title: "Loading Data..",
            timer: 0,
        }); const today = new Date();
        var currentMonth = today.getMonth();

        var year = today.getFullYear();
        if (currentMonth <= 2) {
            year -= 1;
        }

        this.thisYearStartDate = moment(new Date(year, 3, 1)).format("YYYY-MM-DD");

        var lastYear = today.getFullYear();
        if (currentMonth <= 2) {
            lastYear -= 1;
        }

        this.lastYearStartDate = moment(new Date(lastYear - 1, 3, 1)).format(
            "YYYY-MM-DD"
        );
        this.lastYearEndDate = moment(new Date(lastYear, 2, 31)).format(
            "YYYY-MM-DD"
        );
        this.showData();
        this.getIncomeHeadData();
    },
    computed: {
        filterData: function () {
            return this.tableData.filter((item) => {
                if (this.headName && this.headName != null && this.headName != '') {
                    if (this.startDate == '') {
                        if (this.headName == item.data.item2) {
                            return item
                        }
                    } else if (this.headName == item.data.item2 && item.data.item5 >= this.startDate && item.data.item5 <= this.endDate) {
                        return item
                    }
                }
                else if (item.data.item5 >= this.startDate &&
                    item.data.item5 <= this.endDate) {
                    return item
                } else if (this.startDate == '') {
                    return item;
                }

            });

        },
    },
    methods: {
        async getIncomeHeadData() {
            const res = await this.callApi(
                "get",
                `/api/school/income/SearchIncome/income_head_list`,
                null
            );
            this.log(res);
            if (res.status == 200) {
                var data = res.data;
                this.income_head_list = data.income_head_list;
                this.$refs.income_head_list_select2.updateList(data.income_head_list);
            }
        },
        async showData() {
            const res = await this.callApi(
                "get",
                `/api/school/income/SearchIncome`,
                null,

            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.Incomereports = data.incomes;
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
            this.Incomereports.forEach((element) => {
                this.tableData.push({
                    item: element,
                    data: {
                        item1: element.id,
                        item2: element.income_head != null ? element.income_head.name : "",
                        item3: element.item_name != null ? element.item_name.name : "",
                        item4: element.invoice_number,
                        item5: element.income_date,
                        item6: element.amount,
                        item7: {
                            type: 'file',
                            path: element.document,
                        },
                        item8: element.description,
                        item9: {
                            type: "action",
                            options: {
                                label: "View Detail",
                                style: "",
                                class: "btn btn-info",
                                icon: '<i class="fas fa-eye" ></i>',
                                method:this.commonFunction
                            },
                        },
                    },
                    action: {
                        edit: false,
                        delete: false,
                    },
                });
            });
        },
        selectIncomeHead(val) {
            this.selectedIncomeHead = val;
            this.getHeadName();
        },
        getHeadName() {
            this.headName = "";
            this.income_head_list.forEach(element => {
                if (this.selectedIncomeHead == element.value) {
                    this.headName = element.name;
                }
            });
        },
        commonFunction(item, index) {
            this.$router.push({name: 'school.income.details', params: {id: item.id}});
        },
        selectedDate() {
            if (this.filterDate == "") {
                this.startDate = '';
                this.endDate = '';
                this.isCustomDate = false;
                return;
            }
            if (this.filterDate == "today") {
                this.startDate = moment(new Date()).format("YYYY-MM-DD");
                this.endDate = moment(new Date()).format("YYYY-MM-DD");
                this.isCustomDate = false;
                return;
            }

            if (this.filterDate == "yesterday") {
                const today = new Date();
                const yesterday = new Date(today);

                yesterday.setDate(yesterday.getDate() - 1);

                this.startDate = moment(yesterday).format("YYYY-MM-DD");
                this.endDate = moment(yesterday).format("YYYY-MM-DD");
                this.isCustomDate = false;
                return;
            }

            if (this.filterDate == "this_week") {
                const firstDay = new Date();
                const first = firstDay.getDate() - firstDay.getDay(); // First day is the day of the month - the day of the week
                const firstday = new Date(firstDay.setDate(first));

                this.startDate = moment(firstday).format("YYYY-MM-DD");
                this.endDate = moment(new Date()).format("YYYY-MM-DD");
                this.isCustomDate = false;
                return;
            }

            if (this.filterDate == "last_week") {
                const today = new Date();
                const firstThisWeek = today.getDate() - today.getDay(); // First day is the day of the month - the day of the week
                const firstdayThisWeek = new Date(today.setDate(firstThisWeek));
                const lastdate = new Date(firstdayThisWeek);
                lastdate.setDate(lastdate.getDate() - 1);

                const firstDay = new Date(lastdate);
                const first = firstDay.getDate() - firstDay.getDay(); // First day is the day of the month - the day of the week
                const firstday = new Date(firstDay.setDate(first));

                this.startDate = moment(firstday).format("YYYY-MM-DD");
                this.endDate = moment(lastdate).format("YYYY-MM-DD");
                this.isCustomDate = false;
                return;
            }

            if (this.filterDate == "this_month") {
                const today = new Date();
                const firstDate = new Date(today.getFullYear(), today.getMonth(), 1);

                this.startDate = moment(firstDate).format("YYYY-MM-DD");
                this.endDate = moment(new Date()).format("YYYY-MM-DD");
                this.isCustomDate = false;
                return;
            }

            if (this.filterDate == "last_three_months") {
                const today = new Date();

                var currentMonth = today.getMonth();
                var year = today.getFullYear();
                if (currentMonth <= 2) {
                    year -= 1;
                }
                const firstDate = new Date(year, today.getMonth() - 2, 1);

                this.startDate = moment(firstDate).format("YYYY-MM-DD");
                this.endDate = moment(new Date()).format("YYYY-MM-DD");
                this.isCustomDate = false;
                return;
            }

            if (this.filterDate == "last_six_months") {
                const today = new Date();

                var currentMonth = today.getMonth();
                var year = today.getFullYear();
                if (currentMonth <= 2) {
                    year -= 1;
                }
                const firstDate = new Date(year, today.getMonth() - 5, 1);

                this.startDate = moment(firstDate).format("YYYY-MM-DD");
                this.endDate = moment(new Date()).format("YYYY-MM-DD");
                this.isCustomDate = false;
                return;
            }

            if (this.filterDate == "last_six_months") {
                const today = new Date();

                var currentMonth = today.getMonth();
                var year = today.getFullYear();
                if (currentMonth <= 2) {
                    year -= 1;
                }
                const firstDate = new Date(year, today.getMonth() - 5, 1);

                this.startDate = moment(firstDate).format("YYYY-MM-DD");
                this.endDate = moment(new Date()).format("YYYY-MM-DD");
                this.isCustomDate = false;
                return;
            }
            if (this.filterDate == "this_year") {
                this.startDate = moment(this.thisYearStartDate).format("YYYY-MM-DD");
                this.endDate = moment(new Date()).format("YYYY-MM-DD");
                this.isCustomDate = false;
                return;
            }

            if (this.filterDate == "last_year") {
                this.startDate = moment(this.lastYearStartDate).format("YYYY-MM-DD");
                this.endDate = moment(this.lastYearEndDate).format("YYYY-MM-DD");
                this.isCustomDate = false;
                return;
            }

            if (this.filterDate == "life_time") {
                this.startDate = moment(new Date(2020, 3, 1)).format("YYYY-MM-DD");
                this.endDate = moment(new Date()).format("YYYY-MM-DD");
                return;
            }

            this.isCustomDate = this.filterDate == "custom_date";
        },

    },

};
</script>
