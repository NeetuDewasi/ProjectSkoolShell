<template>
    <div>
        <div class="content-wrapper" style="min-height: 606px;">

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-4 card">
                        <!-- Horizontal Form -->
                        <div class="box box-primary card-body">
                            <div class="box-header with-border">
                                <h3 class="box-title"> Add Exam Group</h3>
                            </div><!-- /.box-header -->
                             <AddExamGroup ref="addExamGroup" />
                        </div>

                    </div>

                    <div class="col-md-8">
                        <div class="box box-primary">
                            <div class="card height-auto">
                                <div class="card-body">
                                    <div class="heading-layout1">
                                        <div class="item-title">
                                            <h3>Exam Group List</h3>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <Table ref="table" :tableData="tableData" :tableHead="tableHead" />
                                        <NoData v-show="noData" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>
<script>
var toast;
import AddExamGroup from "./AddExamGroup.vue";
export default {
    components: {
        AddExamGroup
    },
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "admin.dashboard" },
                    name: "Home",
                },
                {
                    name: "Exam Group",
                },
            ],
            examGroups: [],
            tableHead: {
                items: {
                    item1: { label: "Sr.No." },
                    item2: { label: "Class " },
                    item3: { label: "Group Name" },
                    item4: { label: "Exam Type" },
                    item5: { label: "Description " },
                },
                actions: true,
            },
            tableData: [],
            isLoaded: false,
            noData: false,
            exam_groups: [],
            examGroup_id:-1,
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
                "/api/school/examinations/exam_group",
                null,
            );
            this.log('DAAATTTAAA', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.examGroups = data.examGroup_list;
                    this.initTable();
                }
            } else {
                this.noData = true;
                toast = Toast.fire({
                    icon: "error",
                    title: "something went wrong",
                    timer: 2500,
                });
            }
            this.$refs.table.loadTable();
            this.isLoaded = true;
        },
        initTable() {
            this.log('jhhkjjj');
            this.tableData = [];
            this.examGroups.forEach((element) => {
                this.tableData.push({
                    item: element,
                    data: {
                        item1: element.examGroup_id,
                        item2: element.school_class.name,
                        item3: element.examGroup_name != null ? element.examGroup_name : '',
                        item4: element.examGroup_type.name ? element.examGroup_type.name : '',
                        item5: element.examGroup_description ? element.examGroup_description : '',
                        item6: {
                            type: 'action',
                            options: {
                                style: 'border:none',
                                icon: '<i class="fa fa-plus" aria-hidden="true"></i>',
                                method: this.addExam
                            }
                        }
                    },
                    action: {
                        edit: true,
                        delete: true,
                    },
                });
            });

        },
        addExam(item,index) {
            this.$router.push(`/school/examinations/demo_exam_list/${item.examGroup_id}`);
        },
        edit(item, index) {
            this.$refs.addExamGroup.edit(item, index);
            window.scrollTo(0, 0);
        },
        async deleteData(item, index) {
            var data = new FormData();
            data.append("status", "deleted");
            const res = await this.callApi(
                "post",
                `/api/school/examinations/exam_group/delete/${item.examGroup_id}`,
                data
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.examGroups.splice(index, 1);
                    this.tableData.splice(index, 1);
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

<style scoped>
</style>
