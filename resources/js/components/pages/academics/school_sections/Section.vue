<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb pageTitle="Sections " :breadcrumbList="breadcrumbList" />
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="row">
                        <div class="col-4">
                            <SectionCreate ref="sectionCreate" />
                        </div>
                        <div class="col-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="item-title">
                                        <h3>Sections</h3>
                                    </div>
                                    <div class="table" v-show="!noData">
                                        <Table ref="table" :tableHead="tableHead" :tableData="tableData" />
                                    </div>
                                    <NoData v-show="noData" />
                                </div>
                            </div>
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
import SectionCreate from "./SectionCreate.vue";

export default {
    components: {
        SectionCreate,
    },
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "admin.dashboard" },
                    name: "Home",
                },
                {
                    name: "Section",
                },
            ],
            sectionList: [],
            initSectionList: [],
            tableHead: {
                items: {
                    item1: { label: "Sr.No." },
                    item2: { label: "Section" },
                },
                actions: true,
            },
            tableData: [],
            isLoaded: false,
            noData: false,
            editItem: {},
            editedIndex: -1,
        };
    },
    created() {
        toast = Toast.fire({
            icon: "warning",
            title: "Loading data..",
            timer: 0,
        });
        this.showData();
    },
    mounted() {
        this.$parent.loadOtherScript();
    },
    methods: {
        async showData() {
            this.isLoaded = false;
            const res = await this.callApi(
                "get",
                `/api/school/academics/school_sections`,
                null
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.sectionList = data.school_sections;
                    this.initTable();
                } else {
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
            this.$refs.table.loadTable();
            this.isLoaded = true;
            toast.close();
        },

        initTable() {
            this.tableData = [];
            this.sectionList.forEach((element) => {
                this.tableData.push({
                    item: element,
                    data: {
                        item1: element.section_id,
                        item2: element.section_name,
                    },
                    action: {
                        edit: true,
                        delete: true,
                    },
                });
            });
        },
        async saveData(item) {
            this.editItem = item;
            var data = new FormData();
            data.append("name", this.editItem.section_name);
            const res = await this.callApi(
                "post",
                `/api/school/academics/school_sections/save`,
                data
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.$refs.sectionCreate.resetForm();
                    if (this.noData) {
                        this.noData = false;
                    }
                    this.sectionList.push(data.school_sections);
                    this.initTable();
                    toast = Toast.fire({
                        icon: "success",
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
            } else {
                toast = Toast.fire({
                    icon: data.status,
                    title: data.message,
                    timer: 2500,
                });
            }
        },

        edit(item) {
            this.$refs.sectionCreate.edit(item);
            window.scrollTo(0, 0);
        },

        async updateData(item, itemID) {
            this.editItem = item;
            this.editedIndex = itemID;
            var data = new FormData();
            data.append("name", this.editItem.section_name);

            const res = await this.callApi(
                "post",
                `/api/school/academics/school_sections/update/${this.editedIndex}`,
                data
            );

            if (res.status == 200) {
                this.$refs.sectionCreate.resetForm();

                var data = res.data;
                if (data.status == "success") {
                    this.initTable();
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                } else {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 0,
                    });
                }
            } else {
                toast = Toast.fire({
                    icon: data.status,
                    title: data.message,
                    timer: 0,
                });
            }
        },

        async deleteData(item, index) {
            var data = new FormData();
            data.append("status", "deleted");
            const res = await this.callApi(
                "post",
                `/api/school/academics/school_sections/delete/${item.section_id}`,
                data
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.sectionList.splice(this.sectionList.indexOf(item), 1);
                    this.tableData.splice(this.sectionList.indexOf(item), 1);
                    if (!this.tableData.length) {
                        this.noData = true;
                    }
                    SwalCustomBtn.fire("Deleted!", data.message, "success");
                } else {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 0,
                    });
                }
            } else {
                toast = Toast.fire({
                    icon: data.status,
                    title: data.message,
                    timer: 0,
                });
            }
        },
    },
};
</script>
