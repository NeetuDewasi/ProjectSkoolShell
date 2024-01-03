<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb pageTitle="School Group" :breadcrumbList="breadcrumbList" />

            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="item-title">
                                <h3>Group List</h3>
                            </div>
                            <div class="table table-responsive" v-show="!noData">
                                <Table ref="table" :tableData="tableData" :tableHead="tableHead" />
                            </div>
                            <NoData v-show="noData" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                    name: "School Group",
                },
            ],
            content_list: [],
            tableHead: {
                items: {
                    item1: { label: "Sr.No." },
                    item2: { label: "Name" },
                    item3: { label: "Owner/Contact Person" },
                    item4: { label: "Mobile" },
                    item5: { label: "Email" },
                },
                actions: true,
            },
            tableData: [],
            isLoaded: false,
            noData: false,
            editedIndex: -1,
        };
    },

    mounted() {
        this.$parent.loadOtherScript();
        toast = Toast.fire({
            icon: "warning",
            title: "Loading Data..",
            timer: 2000,
        });
        this.showData();
    },

    methods: {
        async showData() {
            this.isLoaded = false;
            const res = await this.callApi(
                "get",
                `/api/admin/school_group/groups`,
                null,
            );
            console.log('showData function', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.groups = data.groups;
                    this.initTable();
                }
            }
            this.$refs.table.loadTable();
            this.isLoaded = true;
            toast.close();
        },
        initTable() {
            this.tableData = [];
            this.groups.forEach((element) => {
                this.tableData.push({
                    item: element,
                    data: {
                        item1:
                            element.group_id != null
                                ? element.group_id
                                : "",
                        item2:
                            element.group_name != null
                                ? element.group_name : "",
                        item3:
                            element.contact_person_name != null
                                ? element.contact_person_name : "",

                        item4:
                            element.mobile_number != null
                                ? element.mobile_number
                                : "",
                        item5:
                            element.email != null
                            ? element.email
                            : "",
                    },
                    action: {
                        edit: true,
                        delete: true,
                    },
                });
            });
        },

        edit(item, index) {
            this.$router.push({
                path: `/admin/school_group/create/${item.group_id}`
            });
        },
        async deleteData(item, index) {
            var data = new FormData();
            data.append("status", "deleted");
            const res = await this.callApi(
                "post",
                `/api/admin/school_group/delete/${item.group_id}`,
                data
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.groups.splice(index, 1);
                    this.tableData.splice(index, 1);
                    SwalCustomBtn.fire("Deleted!", data.message, "success");
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                }
                else {
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






