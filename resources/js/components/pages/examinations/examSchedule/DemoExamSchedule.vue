<template>
    <div class="modal-content">
        <div class="modal-header">
            <!-- <button type="button" class="close" data-dismiss="modal">×</button> -->
            <h4 class="modal-title mb-5">Exam Schedule</h4>
        </div>

        <div class="modal-body">
            <div class="row pb10">

                <div class="col-xl-6 col-lg-12 form-group">
                    <label>Select Group</label>
                    <Select2 ref="examgroup_list" placeholder="--Select Group--"
                    :items="examgroup_list" @change="getExamNames" />
                </div>
                <div class="col-xl-6 col-lg-12 form-group">
                    <label>Select Name</label>
                    <Select2 placeholder="--Select Exam--" ref="examNames_list"
                    :items="examNames_list"  @change="showData"/>
                </div>
                 <div class="table table-responsive" v-show="!noData">
                        <Table ref="table" :tableData="tableData" :tableHead="tableHead" />
                    </div>
                    <NoData v-show="noData" />
            </div>
        </div>
    </div>
</template>

<script>


export default {
    data() {
        return {
             tableHead: {
                items: {
                    item1: { label: 'Sr.No.' },
                    item2: { label: 'Subjects' },
                    item3: { label: 'Date From' },
                    item4: { label: 'Start Time' },
                    item5: { label: 'Duration' },
                    item6: { label: 'Room No.' },
                    item7: { label: 'Marks(max.)' },
                    item8: { label: 'Marks(min.)' },
                },
                actions: true,
            },
            examgroup_list:[],
            examNames_list:[],
            exam_list:[],
            tableData: [],
            isLoaded: false,
            noData: false,
        };
    },
    created() {
        this.getExamGroup();
    },
    mounted() {

    },
    methods: {
        async getExamGroup() {
            const res = await this.callApi(
                "get",
                `/api/school/examinations/exam_group/getExamGroup`,
                null,
            );
            this.log('GROUP ID', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.examgroup_list = data.examGroup_list;
                    this.$refs.examgroup_list.updateList(data.examGroup_list);
                }
            }
        },

        async getExamNames(val) {
            const res = await this.callApi(
                "get",
                `/api/school/examinations/demo_exam_schedule/${val}`,
                null,
            );
            this.log('EXAM NAMES', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.examNames_list = data.exam_names;
                    this.$refs.examNames_list.updateList(data.exam_names);
                }
            }
        },

        async showData()
        {
            const res = await this.callApi(
                "get",
                `/api/school/examinations/demo_exam_schedule/get`,
                null,
            );
            this.log('hdewgfeufhri')
            this.log('EXAMs', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.exam_list = data.examSchedule_list;
                    this.initTable();
                }

                
            }
            this.$refs.table.loadTable();
            this.isLoaded = true;
        },
        initTable() {
            this.tableData = [];
            this.exam_list.forEach((element) => {
                this.tableData.push({
                    // id: element.exam_subject_id,
                    item: element,
                    data: {
                        item1: element.exam_subject_id ? element.exam_subject_id : '',
                        item2: element.subjects.name ? element.subjects.name : '',
                        item3: element.exam_date ? element.exam_date : '',
                        item4: element.exam_time ? element.exam_time : '',
                        item5: element.exam_duration ? element.exam_duration : '',
                        item6: element.exam_room_no ? element.exam_room_no : '',
                        item7: element.exam_maxmarks ? element.exam_maxmarks : '',
                        item8: element.exam_minmarks ? element.exam_minmarks : '',
                    },
                    action:{
                        edit:false,
                        delete:false
                    },

                });
            });

        },
    }
};
</script>
