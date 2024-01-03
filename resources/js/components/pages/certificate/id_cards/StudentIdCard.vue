<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb
                pageTitle="Id Card"
                :breadcrumbList="breadcrumbList"
            />

            <div class="row gutters-20">
                <div class="col-12">
                    <div class="row">
                        <div class="col-5">
                            <AddStudentIdCard ref="addStudentIdCard" />
                        </div>
                        <div class="col-7">
                            <div class="card">
                                <div class="card-body">
                                    <div class="heading-layout1">
                                        <div class="item-title">
                                            <h3>Id Card List</h3>
                                        </div>
                                    </div>
                                    <div
                                        class="table table-responsive"
                                        v-show="!noData"
                                    >
                                        <Table
                                            ref="table"
                                            :tableData="tableData"
                                            :tableHead="tableHead"
                                        />
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
import AddStudentIdCard from "./AddStudentIdCard.vue";
export default {
    components: {
        AddStudentIdCard,
    },
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "school.dashboard" },
                    name: "Home",
                },
                {
                    name: "Id Card",
                },
            ],
            tableData: [],
            isLoaded: false,
            noData: false,
            editedIndex: -1,
            classId: -1,
            sectionId: -1,
            tableHead: {
                items: {
                    item1: { label: "Sr.No." },
                    item2: { label: "Id Card Name" },
                    item3: { label: "Background Image" },
                },
                actions: true,
            },
            showIdCardList: [],
        };
    },
    mounted() {
        this.$parent.loadOtherScript();
        this.showData();
    },
    methods: {
        async showData() {
            this.isLoaded = false;
            const res = await this.callApi(
                "get",
                `/api/school/certificate/id_card/show_list`,
                null
            );
            this.log("DATAA", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.showIdCardList = data.show_idCard_list;
                    this.initTable();
                }
            }
            this.$refs.table.loadTable();
            this.isLoaded = true;
        },
        initTable() {
            this.tableData = [];
            this.showIdCardList.forEach((element) => {
                this.tableData.push({
                    item: element,
                    data: {
                        item1: element.idCard_id,
                        item2: element.id_title
                            ? element.id_title
                            : "",
                        item3: element.idCard_background_image
                            ? {
                                  type: "file",
                                  path: element.idCard_background_image,
                                  height: 70,
                              }
                            : "",
                        item4: {
                            type: "action",
                            options: {
                                style: "border:none",
                                icon: '<i class="fa fa-bars" aria-hidden="true"></i>',
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
            this.$refs.addStudentIdCard.edit(item, index);
            this.editedIndex = item.idCard_id;
        },
        // deleteData(item, index){
        //     var data = new FormData();
        //     data.append("status", "deleted");
        //     const res = await this.callApi(
        //         "post",
        //         `/api/school/certificate/id_card/delete/${item.idCard_id}`,
        //          data
        //     );
        //     if(res.status == 200){
        //     var data = res.data;
        //     if(data.status == "success"){
        //         this.show_idCard_list.splice(index, 1);
        //         this.tableData.splice(index, 1);
        //         swalCustomBtn.fire("Deleted!", data.message, "success");
        //         toast = Toast.fire({
        //             icon: data.status,
        //             title: data.message,
        //             timer: 2500,
        //         });
        //     }
        //     else{
        //         toast = Toast.fire({
        //         icon: data.status,

        //         title: data.message,
        //         timer: 2500,
        //         });
        //     }
        //     }
        // },
         async deleteData(item, index) {
            var data = new FormData();
            data.append("status", "deleted");
            const res = await this.callApi(
                "post",
                `/api/school/certificate/id_card/delete/${item.idCard_id}`,
                data
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.show_idCard_list.splice(index, 1);
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
