<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb
                pageTitle="Examinations"
                :breadcrumbList="breadcrumbList"
            />

            <div class="row gutters-20">
                <div class="col-12">
                    <div class="row">
                        <div class="col-5">
                            <AddGradeCreate ref="addGradeCreate" />
                        </div>
                        <div class="col-7">
                            <div class="card">
                                <div class="card-body">
                                    <div class="heading-layout1">
                                        <div class="item-title">
                                            <h3>Grade List</h3>
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
import AddGradeCreate from "./AddGradeCreate.vue";
export default {
    components: {
        AddGradeCreate,
    },
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "school.dashboard" },
                    name: "Home",
                },
                {
                    name: "Add Grade",
                },
            ],
            tableData: [],
            isLoaded: false,
            noData: false,
            editedIndex: -1,
            marks_grade_list:[],
            tableHead: {
                items: {
                    item1: { label: "Sr. No." },
                    item2: { label: "Exam Type" },
                    item3: { label: "Grade Name" },
                    item4: { label: "Percent Upto" },
                    item5: { label: "Percent From" },
                    item6: { label: "Grade Point"}
                },
                actions: true,
            },

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
                `/api/school/examinations/marks_grade/get`,
                null
            );
            this.log("DATAA", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.marks_grade_list = data.marks_grade_list;
                    this.initTable();
                }
            }
            this.$refs.table.loadTable();
            this.isLoaded = true;
        },
        initTable() {
            this.tableData = [];
            this.marks_grade_list.forEach((element) => {
                this.tableData.push({
                    item: element,
                    data: {
                        item1: element.grade_id,
                        item2: `${element.grade_exam_type != null ? element.grade_exam_type.exam_type : ''}`,
                        item3: element.grade
                            ? element.grade
                            : "",
                        item4: element.percent_upto ? element.percent_upto : "",
                        item5: element.percent_from ? element.percent_from : "",
                        item6: element.grade_point ? element.grade_point : "",
                    },
                    action: {
                        edit: true,
                        delete: true,
                    },
                });
            });
        },
        edit(item, index) {
            this.$refs.addGradeCreate.edit(item, index);
            this.editedIndex = item.grade_id;
        },

         async deleteData(item, index) {
            var data = new FormData();
            data.append("status", "deleted");
            const res = await this.callApi(
                "post",
                `/api/school/examinations/marks_grade/delete/${item.grade_id}`,
                data
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.marks_grade_list.splice(index, 1);
                    this.tableData.splice(index, 1);
					if (!this.tableData.length) {
						this.noData = true;
					}
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
