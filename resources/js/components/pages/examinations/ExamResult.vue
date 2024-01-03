<template>
  <div>
    <div class="dashboard-content-one">
      <!-- Breadcubs Area Start -->
      <Breadcrumb pageTitle="Marks Grade" :breadcrumbList="breadcrumbList" />
      <!-- End Breadcubs Area -->
      <!-- Exam Result Area Start Here -->
      <div class="row gutters-20">
        <div class="col-12">
          <div class="card height-auto">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>Select Criteria</h3>
                </div>
              </div>
              <form class="mg-b-20">
                <div class="row gutters-8">
                  <div class="col-xl-3 col-lg-6 col-sm-3 col-12 form-group">
                    <label for="exam_group">Exam Group *</label>
                    <Select2
                      :items="examGroupList"
                      ref="examGroupList"
                      placeholder="--SELECT A GROUP--"
                      @change="selectGroup"
                    />
                  </div>
                  <div class="col-xl-3 col-lg-6 col-sm-5 col-12 form-group">
                    <label for="exam_name">Exam *</label>
                    <Select2
                      :item="examNames_list"
                      ref="examNames_list"
                      @change="selectExamName"
                      placeholder="--SELECT EXAM--"
                    />
                  </div>
                  <div class="col-xl-2 col-lg-6 col-sm-5 col-12 form-group">
                    <label for="session">Session *</label>
                    <Select2
                      :item="sessionList"
                      ref="sessionList"
                      placeholder="--SELECT SESSION--"
                    />
                  </div>
                  <div class="col-xl-2 col-lg-6 col-sm-5 col-12 form-group">
                    <label for="class">Class *</label>
                    <Select2
                      :item="class_list"
                      ref="class_list"
                      placeholder="--Select Class--"
                      @change="selectClass"
                    />
                  </div>
                  <div class="col-xl-2 col-lg-6 col-sm-5 col-12 form-group">
                    <label for="section">Section *</label>
                    <Select2 :item="section_list" ref="section_list" placeholder="Select Section"
                    @change="selectSection"/>
                  </div>
                </div>
                <div class="d-flex justify-content-end">
                  <button
                    type="submit"
                    class="btn btn-gradient-yellow btn-lg btn-hover-bluedark text-white"
                    @click.prevent="getData()"
                  >
                    <i class="fa fa-search"></i> Search
                  </button>
                </div>
              </form>
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>Exam Result</h3>
                </div>
              </div>
              <div class="table table-responsive">
              <table>
                      <thead v-if="result_list">
                        <tr>
                          <th>Admission No</th>
                          <th>Roll Number</th>
                          <th>Student Name</th>
                          <th >
                            <span
                              v-if="result_list[0].exam_subjects" 
                            >{{ result_list[0].exam_subjects.subjects.name }}</span>
                          </th>

                          <th>Grand Total</th>
                          <th>Percent(%)</th>
                          <th>Result</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="result, index in result_list" :key="index">
                          <td>{{ result.students != null ? result.students.admission_number : '' }}</td>
                          <td>{{ result.students != null ? result.students.roll_number : '' }}</td>
                          <td>{{ result.students != null ? result.students.first_name : '' }}
                            {{ result.students != null ? result.students.middle_name : '' }}
                            {{ result.students != null ? result.students.last_name : '' }}
                        </td>
                          <td >
                            <span

                            >{{ result.marks }}</span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Exam Result Area End Here -->
      <Footer />
    </div>
  </div>
</template>

<script>
export default {

    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "admin.dashboard" },
                    name: "Home",
                },
                {
                    name: "Marks Grade",
                },
            ],
            examGroupList: [],
            examNames_list: [],
            section_list: [],
            class_list: [],
            sessionList: [],
            result_list:[
                {
                    exam_subjects: {
                        subjects:{}
                    }
                }
            ],
            exam_subjects:[],
            sectionId:-1,

        };
    },
    computed:{
    },
    mounted() {
        this.$parent.loadOtherScript();
        this.getExamGroup();
        this.getSession();
    },
    methods: {
        async getClassList() {
            const res = await this.callApi("get", `/api/school/general/get_class_list`, null);
            this.log("CLASS", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.class_list = data.class_list;
                    this.$refs.class_list.updateList(data.class_list);
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
                    this.$refs.section_list.updateList(data.school_class_sections);
                }
            }
        },
        selectSection(section_id) {
            this.sectionId = section_id;
            this.log('fhfhuffffffy',this.sectionId);
        },
        async getExamGroup() {
            const res = await this.callApi(
                "get",
                `/api/school/examinations/exam_group/getExamGroup`,
                null
            );
            this.log("EXAM GROUPS", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.examGroupList = data.examGroup_list;
                    this.$refs.examGroupList.updateList(data.examGroup_list);
                }
            }
        },
        selectGroup(group_id){
            this.group_id = group_id;
            this.getExamNames();

        },
        async getExamNames(group_id) {
            // this.examGroupId = val;
            const res = await this.callApi(
                "get",
                `/api/school/examinations/demo_exam_schedule/${this.group_id}`,
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
        selectExamName(new_examId) {
            this.new_examId = new_examId;
            this.getClassList();
        },
        async getSession() {
            const res = await this.callApi(
                "get",
                `/api/school/general/session`,
                null
            );
            this.log("SESSION", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.log(data.school_sessions);
                    this.sessionList = data.school_sessions;
                    this.$refs.sessionList.updateList(data.school_sessions);
                }
            }
        },
        async getData()
        {
            this.isLoaded = false;
            var data = new FormData();
            data.append('examgroup_id', this.group_id);
            data.append('exam_id', this.new_examId);
            data.append('class_id', this.classId);
            data.append('section_id', this.sectionId);
            const res = await this.callApi(
                "post",
                `/api/school/examinations/assign_marks/result`,
                data
            );
            this.log('Result Data',res);
            if(res.status == 200){
                var data = res.data;
                if(data.status == "success"){
                    this.result_list = data.results;
                }
            }
        },
    },
};
</script>
