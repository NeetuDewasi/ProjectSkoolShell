<template>

    <div>
        <div class="dashboard-content-one">
            <Breadcrumb pageTitle="Exam List" :breadcrumbList="breadcrumbList" />
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card height-auto">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>All Exam List</h3>
                                </div>
                            </div>
                            <div class="table table-responsive" v-show="!noData">
                                <Table ref="table" :tableData="tableData" :tableHead="tableHead" />
                            </div>
                            <NoData v-show="noData" />
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
                    to: { name: "admin.dashboard" },
                    name: "Home",
                },
                {
                    name: "Exam List",
                },
            ],
            tableHead: {
                items: {
                    item1: { label: 'Sr. No.' },
                    item2: { label: 'Exam Name' },
                    item3: { label: 'Subjects' },
                    item4: { label: 'Class' },
                    item5: { label: 'Exam Date' },
                    item6: { label: 'Exam Time' },
                    item7: { label: 'Duration' },
                    item8: { label: 'Status' },
                },
                actions: true,
            },
            tableData: [],
            isLoaded: false,
            noData: false,
            examSchedule: [],
        };
    },
    mounted() {
        this.$parent.loadOtherScript();
        toast = Toast.fire({
            icon: 'warning',
            title: 'Loading Data ..',
            timer: 0
        });
        this.showData();
    },
    methods: {

        async showData() {
            this.isLoaded = false;
            const res = await this.callApi(
                'get',
                `/api/school/examinations/exam_schedule`,
                null,
            );
            if (res.status == 200) {
                var data = res.data;
                this.log('DAATAAA', res);
                if (data.status == "success") {
                    this.examSchedule = data.examSchedule_list;
                    console.table(this.examSchedule);
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
            this.examSchedule.forEach((element) => {
                this.tableData.push({
                    item: element,
                    data: {
                        item1: element.examSchedule_id,
                        item2: element.schedule_exam_name != null ? element.schedule_exam_name : '',
                        item3: element.exam_subjects.length,
                        item4: element.school_class != null ? (element.school_class.class_name + (element.school_section != null ? (' ' + element.school_section.section_name) : '')) : '',
                        item5: element.schedule_exam_date != null ? element.schedule_exam_date : '',
                        item6: element.schedule_time != null ? element.schedule_time : '',
                        item7: element.exam_duration != null ? element.exam_duration : '',
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
                path: `/school/examinations/scheduleCreate/${item.examSchedule_id}`,
            });
        },
        async deleteData(item, index) {
            var data = new FormData();
            data.append("status", "deleted");
            const res = await this.callApi(
                "post",
                `/api/school/examinations/exam_schedule/delete/${item.examSchedule_id}`,
                data
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.examSchedule.splice(index, 1);
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
