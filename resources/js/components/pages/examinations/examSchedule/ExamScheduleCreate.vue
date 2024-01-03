<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb pageTitle="Exam Schedule" :breadcrumbList="breadcrumbList" />
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card height-auto">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Add New Exam</h3>
                                </div>
                            </div>
                            <form class="new-added-form">
                                <div class="row">
                                    <div class="col-lg-6 col-12 form-group">
                                        <label>Exam Name</label>
                                        <input type="text" placeholder="" class="form-control" v-model="editItem.schedule_exam_name">
                                    </div>
                                    <div class="col-lg-6 col-12 form-group">
                                        <label>Select Class *</label>
                                    <Select2 ref="class_list_select2" placeholder="--SELECT A CLASS--"
                                                    :items="class_list" @change="selectClass" />
                                    </div>
                                    <div class=" col-lg-6 col-12 form-group">
                                        <label>Select Section</label>
                                       <Select2 ref="section_list_select2" :items="section_list"
                                                    @change="selectSection" />
                                    </div>
                                    <div class=" col-lg-6 col-12 form-group">
                                        <label>Select Time</label>
                                        <input type="time" placeholder="" class="form-control"
                                        v-model="editItem.schedule_time">
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                                        <label>Select Date</label>
                                        <DatePicker format="DD-MMM-YYYY" value-type="format" type="date"
                                                    placeholder="Select a date" v-model="exam_date"
                                                    class="form-control vue-datepicker my-0 w-100" ref="published_at"
                                                    :default-value="new Date()"
                                                  />
                                        <i class="far fa-calendar-alt"></i>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                                        <label>Duration</label>
                                       <input type="text" placeholder="" class="form-control" v-model="editItem.exam_duration">
                                    </div>
                                    <div class="col-lg-6 col-12 form-group">
                                        <div class="float-right">
                                            <span class="btn btn-success pointer" @click="addSubject" >+ ADD MORE</span>
                                        </div>
                                        <AddSubjects ref="addSubjects"
                                        v-for="sub,index in addSubjectArray"
                                            :key="index"
                                            :index="index"
                                            />
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                   <button type="submit" class="btn btn-lg btn-gradient-yellow btn-hover-bluedark mx-3 text-white"
                                    @click.prevent="submitData()">
										{{frmBtn}}
                                    </button>
                                    <button type="reset" class="btn btn-lg bg-blue-dark btn-hover-yellow text-white">
                                        Reset
                                    </button>
                                </div>
                            </form>
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
import AddSubjects from './AddExamSubjects.vue';
	export default {
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "admin.dashboard" },
                    name: "Home",
                },
                {
                    name: "Exam Schedule",
                },
            ],
            class_list: [],
            section_list: [],
            addSubjectArray:['1','2'],
            examSubject_ids:[],
            subject_ids:[],
            exam_date:'',
            editItem:{},
            editedIndex: -1,
            countArray:1,

        };
    },
    computed: {
        frmBtn: function () {
            return this.editedIndex !== -1 ? "Update" : "Save";
        }
    },
    created(){
        if(this.$route.params.examSchedule_id){
            this.editedIndex =this.$route.params.examSchedule_id;
            this.log(this.$route.params.examSchedule_id);
        }
        this.getEditItemData(this.$route.params.examSchedule_id);

    },
    mounted() {
        this.$parent.loadOtherScript();
        this.getClassList();
        this.exam_date = moment(new Date()).format('DD-MMM-YYYY');

    },
    watch:{
        exam_date: function (val) {
            this.exam_date = val;
            this.editItem.schedule_exam_date = moment(new Date(val)).format('YYYY-MM-DD');
        }
    },
    methods: {
        addSubject(){
            this.addSubjectArray.push(countArray++);
        },
        async getClassList() {
            const res = await this.callApi("get", `/api/school/general/get_class_list`, null);
            this.log("CLASS", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.class_list = data.class_list;
                    this.$refs.class_list_select2.updateList(data.class_list);
                }
            }
        },
        async selectClass(val) {
            this.classId = val;
            const res = await this.callApi("get", `/api/school/general/class/${this.classId}/sections`, null);
            this.log("SECTIONS", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.sections = data.school_class_sections;
                    this.$refs.section_list_select2.updateList(data.school_class_sections);
                    if (this.editedIndex !== -1) {
                        this.$refs.section_list_select2.setSelected(this.sectionId);
                    }
                }
            }
        },
        async getEditItemData(editedIndex) {

            const res = await this.callApi(
                "get",
                `/api/school/examinations/exam_schedule/edit/${this.editedIndex}`,
                null,
            );
            this.log('SELECTED DATA', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                     this.editItem = data.exam_schedule;

                    this.$refs.class_list_select2.setSelected(
						data.exam_schedule.school_class.class_id
					);
					this.classId = data.exam_schedule.school_class.class_id;
					this.selectClass(
						data.exam_schedule.school_class.class_id
					);
					this.$refs.section_list_select2.setSelected(
						data.exam_schedule.school_section.section_id
					);
					this.sectionId =
						data.exam_schedule.school_section.section_id;

                    if(data.exam_schedule.exam_subjects.length > 0){
                        this.addSubjectArray = [];
                        await data.exam_schedule.exam_subjects.forEach(
                            (element, index) => {
                                this.addSubjectArray.push(index);
                            }
                        );

                        this.addSubjectArray.forEach((element, index) => {
                            this.$refs.addSubjects[index].$refs.subject_list.setSelected(
                                data.exam_schedule.exam_subjects[index].subject_id
                            );
                        });

                    }
                }

            }
        },

        //     var data = new FormData();
        //     data.append('class', this.classId);
        //     data.append('section', this.sectionId);
        //     data.append("content_type", this.editItem.upload_content_type);
        //     data.append("title", this.editItem.upload_title);
        //     data.append("content_for", this.editItem.studentIds);
        //     data.append("is_publish", this.editItem.upload_is_publish ? 1 : 0);
        //     data.append("published_at", this.editItem.upload_published_at);
        //     data.append("description", this.editItem.upload_description != null && this.editItem.upload_description != "" ? this.editItem.description : '');
        //     data.append("image", this.imageFilePath ? this.imageFilePath : "");

        //     const res = await this.callApi(
        //         "post",
        //         `/api/school/download_center/upload_content/update/${this.editedIndex}`,
        //         data,
        //     );
        //     var data = res.data;
        //     if (res.status == 200) {
        //         var data = res.data;
        //         if (data.status == 'success') {
        //             this.editedIndex = -1;
        //             toast = Toast.fire({
        //                 icon: data.status,
        //                 title: data.message,
        //                 timer: 2500,
        //             });
        //         }
        //         else {
        //             toast = Toast.fire({
        //                 icon: data.status,
        //                 title: data.message,
        //                 timer: 2500,
        //             });
        //         }

        //     }
        //     this.editedIndex = -1;
        // },
        selectSection(val) {
            this.sectionId = val;
        },
        getSubjectData(subjectId){
            this.examSubject_ids = subjectId;
        },
        closeSubjectForm(index){
            this.addSubjectArray.splice(index, 1);
            this.subjectId.splice(index, 1);
        },
        async submitData(){
            var data = new FormData();
            data.append('classId',this.classId ? this.classId : '');
            data.append('sectionId',this.sectionId ? this.sectionId : '');
            data.append('exam_name',this.editItem.schedule_exam_name ? this.editItem.schedule_exam_name : '');
            data.append('exam_date', this.editItem.schedule_exam_date ? this.editItem.schedule_exam_date : '');
            data.append('exam_time', this.editItem.schedule_time ? this.editItem.schedule_time : '');
            data.append('exam_duration', this.editItem.exam_duration ? this.editItem.exam_duration : '');
            this.addSubjectArray.forEach((ele,index) => {
               data.append("subject_ids[]",this.$refs.addSubjects[index].$refs.subject_list.$refs.commonSelect2.value)
            });
            // data.append("subject_ids", this.subject_ids);
            let url = "";
            if (this.editedIndex != -1) {
                url = `/api/school/examinations/exam_schedule/update/${this.editedIndex}`;
            } else {
                url = `/api/school/examinations/exam_schedule/save`;
            }
            const res = await this.callApi("post", url, data);
            this.log('REQUEST', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    })
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
    },
    components: { AddSubjects }
};
</script>


<style scoped>
</style>
