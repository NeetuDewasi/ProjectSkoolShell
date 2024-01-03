<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb pageTitle="Schools" :breadcrumbList="breadcrumbList" />

            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="item-title">
                                <h3>School List</h3>
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
                    name: "Schools",
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
                    // item6: { label: "Address"}
                },
                actions: true,
            },
            tableData: [],
            isLoaded: false,
            noData: false,
            editedIndex: -1,
            schools:[{
                school : {} }
            ],
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
                `/api/admin/schools`,
                null,
            );
            this.log('showData function', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.schools = data.schools;
                    this.initTable();
                }
            }
            this.$refs.table.loadTable();
            this.isLoaded = true;
            toast.close();
        },
        initTable() {
            this.tableData = [];
            console.log('schools data',this.schools);
            this.schools.forEach((element) => {
                this.tableData.push({
                    item: element,
                    data: {
                        item1:
                            element.user_id != null
                                ? element.user_id
                                : "",
                        item2:  element.name != null
                            ? element.name : "",

                        item3: `${element.school.contact_person_name != null ? element.school.contact_person_name : ''} `,

                        item4: `${element.school.mobile_number != null ? element.school.mobile_number : ''} `,
                        item5: `${element.school.email_id != null ? element.school.email_id : ''}`,
                                item6: {
                  type: "action",
                  options: {
                    // label: "Files",
                    style: "",
                    class: "btn btn-info",
                    icon: '<i class="fas fa-plus" ></i>',
                    method: this.addDocuments,
                    },
                    },
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
                path: `/admin/school/create/${item.school.school_id}`
            });
        },

        addDocuments(item){
             this.$router.push({
                path: `/admin/school/documents/${item.school.school_id}`
            });
        },
        async deleteData(item, index) {
            this.log('delete function');
            // var data = new FormData();
            // data.append("status", "deleted");
            const res = await this.callApi(
                "delete",
                `/api/admin/schools/deleteSchool/${item.school.school_id}`,
                null
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.schools.splice(index, 1);
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






