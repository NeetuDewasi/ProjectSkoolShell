<template>
  <div>
    <div class="dashboard-content-one">
      <!-- Breadcubs Area Start -->
      <Breadcrumb pageTitle="Homework" :breadcrumbList="breadcrumbList" >
        <template v-slot:button>
                <button type="submit" class="btn btn-success btn-sm text-white"  @click="$router.push({name: 'school.homework.add_homework'})">
                    <i class="fa fa-plus"></i> Add Homework
                </button>
            </template>
      </Breadcrumb>
      <div class="row gutters-20">
        <div class="col-12">
          <div class="card height-auto">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>select Craiteria</h3>
                </div>
              </div>
              <form class="mg-b-20">
                <div class="row gutters-20">
                  <div class="col-xl-4 col-lg-4 col-12 form-group">
                    <label>Class</label>
                    <Select2
                      ref="class_list"
                      placeholder="--SELECT A CLASS--"
                      :items="class_list"
                      @change="selectClass"
                    />
                  </div>
                  <div class="col-xl-4 col-lg-4 col-12 form-group">
                    <label>Section</label>
                    <Select2
                      ref="section_list"
                      placeholder="--SELECT A SECTION--"
                      :items="section_list"
                      @change="selectSection"
                    />
                  </div>
                  <div class="col-xl-4 col-lg-4 col-12 form-group">
                    <label>Subject</label>
                    <Select2
                      ref="subject_list"
                      placeholder="--SELECT A SUBJECT--"
                      :items="subject_list"
                      @change="selectSubject"
                    />
                  </div>
                </div>
              </form>
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>Homework</h3>
                </div>
              </div>
              <div class="table table-responsive" v-show="!noData">
                <Table
                  ref="table"
                  :tableData="filteredList"
                  :responsive="true"
                  :tableHead="tableHead"
                />
              </div>
              <NoData v-show="noData" />
            </div>
          </div>
        </div>
      </div>
      <!-- Homework List Area End Here -->
      <Footer />
    </div>
    <div class="pop-container" v-show="isPublising">
      <div class="pop-container-inner">
        <div class="row">
          <div class="col-12 form-group">
              <span class="form-check-label ml-4"
                >Homework Submission Date</span
              >
              <DatePicker
                format="DD-MMM-YYYY"
                value-type="format"
                type="date"
                placeholder="Select a date"
                v-model="displaySumissionDate"
                :default-value="new Date()"
                class="form-control vue-datepicker my-0 w-100"
              />
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-5">
                <span>Do You Want to Homework Published Today</span>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-5">
          <div class="col-4">
              <button type="submit"
                class=
                  " btn btn-success text-light shadow-dodger-blue me-3"
                @click.prevent="datePublished()"
              >
                  OK
              </button>
              <button type="submit"
                class=
                  " btn btn-danger text-light"
                   @click.prevent="dateCancel()"
                >
                  Cancel
              </button>
          </div>
        </div>
      </div>
    </div>
    <!-- Evaluation Homework -->
    <div class="pop-container" v-show="isEvaluating">
      <div class="pop-container-inner">
        <div class="row" v-if="studentList.length">
          <div class="col-xl-7 col-lg-7 col-12 form-group">
            <div class="row">
              <div class="col-12 text-dark m-2 h1">
                <span>Title : </span>
                <span>{{homeworkEvaluation.homework_title}}</span>
              </div>
              <div class="col-12 text-dark m-2 h1">
                <span>Class : </span>
                <span>
                  {{homeworkEvaluation.homework_class_id.name}}
                  {{homeworkEvaluation.homework_section_id.name}}
                </span>
              </div>
              <div class="col-12 text-dark m-2 h1">
                <span>Subject : </span>
                <span>
                  {{homeworkEvaluation.homework_subject_id.name}}
                </span>
              </div>
              <div class="col-12 mt-3 mb-0 mx-3">
                  <h5>
                    Student List <span class="text-danger">*</span>
                  </h5>
              </div>
              <table v-for="(student,index) in studentList" :key="index" class="col-10 table-borderedless ml-5 ">
                <tr>
                  <td class="col-2">
                    <input :id="`studentChecked${index}`" type="checkbox" name="selectStudent[]" @change.prevent="selectStudent(student.student_admission_id, index)"/>
                  </td>
                  <td>
                    <span @click="selectStudent(student.student_admission_id,index)">{{ getStudentFullName(student) }}</span>
                  </td>
                  <td class="col-6">
                    <DatePicker
                      format="DD-MMM-YYYY"
                      value-type="format"
                      type="date"
                      placeholder="Select a date"
                      v-model="displayEvaluationDate[index]"
                      :default-value="new Date()"
                      class="form-control vue-datepicker my-0 w-100 mx-0"
                    />

                  </td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-xl-5 col-lg-5 col-12">
            <div class="row">
                <div class="col-12">
                    <span>
                      <i class="fa fa-calendar" aria-hidden="true"></i>
                      Published On :
                    </span>
                    <span>{{homeworkEvaluation.homework_issue_date}}</span>
                </div>
            </div>
          </div>
        </div>
        <div class="popup-action-container">
            <div class="">
                <button type="submit"
                class=
                    " btn btn-success text-light shadow-dodger-blue me-3"
                @click.prevent="dateEvaluation()"
                >
                    OK
                </button>
                <button type="submit"
                class=
                    " btn btn-danger text-light"
                    @click.prevent="evaluationCancel()"
                >
                    Cancel
                </button>
            </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
var toast;
import AddHomeworkForm from "./AddHomeworkForm.vue";
export default {
  components: {
    AddHomeworkForm,
  },
  data() {
    return {
      breadcrumbList: [
        {
          to: { name: "admin.dashboard" },
          name: "Home",
        },
        {
          name: " Homework",
        },
      ],
      homeworks: [],
      homework_date : [],
      tableHead: {
        items: {
          item1: { label: "Sr.No." },
          item2: { label: "Class" },
          item3: { label: "Section" },
          item4: { label: "Subject" },
          item5: { label: "Homework Title" },
          item6: { label: "Homework Published Date" },
          item7: { label: "Submission Date" },
          item8: { label: "" },
          item9: { label: "" },
          item10: { label: "View Deatil" },
        },
        actions: true,
      },
      tableData: [],
      isLoaded: true,
      noData: false,
      selectedClass: -1,
      selectedClassName: "",
      section_list: [],
      selectedSection: -1,
      selectedSectionName: "",
      class_list: [],
      subject_list: [],
      selectedSubject: -1,
      selectedSubjectName: "",
      checkbox:false,
      isPublising: false,
      isEvaluating: false,
      displaySumissionDate: "",
      displayEvaluationDate: [],
      // homework_evaluation_date : moment(new Date()).format("YYYY-MM-DD"),
      homeworkId : -1,
      editIndex : -1,
      studentList:[],
      homeworkEvaluation:{},
      studentIds: [],
    };
  },
  created() {
    toast = Toast.fire({
      icon: "warning",
      title: "Loading Data..",
      timer: 0,
    });
    this.showData();
    this.getClassSectionSubjectData();
  },
  mounted() {
    this.$parent.loadOtherScript();
  },
  watch: {
    filteredList: function () {
      this.noData = this.filteredList.length == 0;
    },
  },
  computed: {
    filteredList() {
      if (this.selectedClass != -1) {
        if (this.selectedSection != -1) {
          if (this.selectedSubject != -1) {
            return this.tableData.filter((item) => {
              return (
                item.data.item2 == this.selectedClassName &&
                item.data.item3 == this.selectedSectionName &&
                item.data.item4 == this.selectedSubjectName
              );
            });
          } else {
            return this.tableData.filter((item) => {
              return (
                item.data.item2 == this.selectedClassName &&
                item.data.item3 == this.selectedSectionName
              );
            });
          }
        } else {
          return this.tableData.filter((item) => {
            return item.data.item2 == this.selectedClassName;
          });
        }
      }
      return this.tableData;
    },
  },
  methods: {
    selectStudent(studentId, index) {
        this.log("SELECT_STUDENT_CALLED_AT INDEX>>>>"+ index, studentId);
        if (this.studentIds.includes(studentId)) {
            this.studentIds.splice(
                this.studentIds.indexOf(studentId),
                1
            );
            $("#studentChecked" + index).prop("checked", false);
        } else {
            this.studentIds.push(studentId);
            $("#studentChecked" + index).prop("checked", true);
        }
    },
    getStudentFullName(student) {
        return (
            student.student_first_name +
            (student.student_middle_name
                ? " " + student.student_middle_name
                : "") +
            (student.student_last_name
                ? " " + student.student_last_name
                : "")
        );
    },
    getSelectedClassName() {
      this.class_list.forEach((e) => {
        if (e.value == this.selectedClass) {
          this.selectedClassName = e.name;
        }
      });
    },
    getSelectedSectionName() {
      this.section_list.forEach((e) => {
        if (e.value == this.selectedSection) {
          this.selectedSectionName = e.name;
        }
      });
    },
    getSelectedSubjectName() {
      this.subject_list.forEach((e) => {
        if (e.value == this.selectedSubject) {
          this.selectedSubjectName = e.name;
        }
      });
    },
    async selectClass(val) {
      this.selectedClass = val;
      this.getSelectedClassName();
      if (this.selectedClass == -1) {
        this.section_list = [];
        this.$refs.section_list.updateList([]);
        this.subject_list = [];
        this.$refs.subject_list.updateList([]);
        return;
      }
      const res = await this.callApi(
        "get",
        `/api/school/class/sections/${this.selectedClass}`,
        null
      );
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.section_list = data.school_class_sections;
          this.$refs.section_list.updateList(data.school_class_sections);
        }
      }

      let formData = new FormData();
      formData.append("class_id", this.selectedClass);
      formData.append("section_id", this.selectedSection);
      const resSubject = await this.callApi(
        "post",
        `/api/school/general/get_subject_list`,
        formData
      );
      if (resSubject.status == 200) {
        var data = resSubject.data;
        if (data.status == "success") {
          this.subject_list = data.subject_list;
          this.$refs.subject_list.updateList(data.subject_list);
        }
      }
    },
    async selectSection(val) {
      this.selectedSection = val;
      this.getSelectedSectionName();
      let formData = new FormData();
      formData.append("class_id", this.selectedClass);
      formData.append("section_id", this.selectedSection);
      const res = await this.callApi(
        "post",
        `/api/school/general/get_subject_list`,
        formData
      );
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.subject_list = data.subject_list;
          this.$refs.subject_list.updateList(data.subject_list);
        }
      }
    },
    selectSubject(val) {
      this.selectedSubject = val;
      this.getSelectedSubjectName();
    },
    async getClassSectionSubjectData() {
      const res = await this.callApi(
        "get",
        `/api/school/homework/homework/data_list`,
        null
      );
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.class_list = data.class_list;
          this.$refs.class_list.updateList(data.class_list);
          this.$refs.class_list.setSelected(this.selectedClass);
          this.section_list = data.section_list;
          this.$refs.section_list.updateList(data.section_list);
          this.$refs.section_list.setSelected(this.selectedSection);

          this.subject_list = data.subject_list;
          this.$refs.subject_list.updateList(data.subject_list);
          this.$refs.subject_list.setSelected(this.selectedSubject);
        }
      }
      toast.close();
    },
    async showData() {
      this.isLoaded = false;
      const res = await this.callApi(
        "get",
        `/api/school/homework/homework`,
        null
      );
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.homeworks = data.homeworks;
          console.log('res->data' , this.homeworks);
          this.initTable();
        } else {
          toast = Toast.fire({
            icon: "error",
            title: "Something went wrong",
            timer: 0,
          });
          this.noData = true;
        }
      }
      this.$refs.table.loadTable();
      this.isLoaded = true;
      toast.close();
    },
    initTable() {
      this.tableData = [];
      this.homeworks.forEach((element, index) => {
        element.is_published = this.homeworks[index].is_published ? true : false;
        element.is_evaluated = this.homeworks[index].is_evaluated ? true : false;
        this.tableData.push(this.prepareData(element));
      });
    },
    prepareData(element) {
        return {
          item: element,
          data: {
            item1: element.homework_id,
            item2:
              element.homework_class_id != null
                ? element.homework_class_id.name
                : "",
            item3:
              element.homework_section_id != null
                ? element.homework_section_id.name
                : "",
            item4:
              element.homework_subject_id != null
                ? element.homework_subject_id.name
                : "",
            item5: element.homework_title != null ? element.homework_title : "",
            item6: element.homework_issue_date != null ? Vue.filter('formatDate')(element.homework_issue_date) : "",
            item7: element.homework_submission_date != null ? Vue.filter('formatDate')(element.homework_submission_date) : "",
            item8: !element.is_published ? {
                type: "action",
                options: {
                  label: "",
                  style: " ",
                  class: "toggle-button ",
                  icon:  `<i class="fas fa-toggle-off text-warning" ></i>`,
                  method: this.toggleCheckbox,
                },
            } : '',
            item9: element.is_published ? {
                type: "action",
                options: {
                  label: "Evaluate",
                  style: "",
                  class: "btn btn-warning text-white",
                  icon: '<i class="fas fa-check"></i>',
                  method: this.evaluateHomework,
              },
            } : '',
            item10: {
                type: "action",
                options: {
                  label: "View",
                  style: "",
                  class: "btn btn-info",
                  icon: '<i class="fas fa-eye"></i>',
                  method: this.homeworkDetail,
              },
            },
          },
          action: {
            edit: true,
            delete: true,
          },
        };
    },
    homeworkDetail(item) {
      this.$router.push(`/school/homework/homework_view/${item.homework_id}`);
    },
    toggleCheckbox(item, index) {
        this.homeworkId = item.homework_id;
        this.displaySumissionDate  = moment(String(item.homework_submission_date)).format('DD-MMM-YYYY');
        this.isPublising = true;
        this.editIndex = index;

    },
    dateCancel(){
      this.isPublising = false;
    },
    async datePublished(){
        var data = new FormData();
        data.append('homework_submission_date',this.displaySumissionDate);
        const res = await this.callApi(
        "post",
        `/api/school/homework/homework/update_date/${this.homeworkId}`,
        data
      );
      if(res.status == 200){
        var data = res.data
        if(data.status == 'success'){
            this.dateCancel();
            this.homeworks[this.editIndex] = data.homework;
            // this.tableData[this.editIndex] = this.prepareData(data.homework);
            this.initTable();
        }
      }
    },
    evaluateHomework(item, index) {
        this.homeworkId = item.homework_id;
        this.isEvaluating = true;
        this.editIndex = index;
        this.homeworkEvaluation = item;
        this.studentIds = [];
        this.studentList = item.homework_for;
        setTimeout(() => {
          if (this.studentList && this.studentList.length) {
              this.studentList.forEach((e, i) => {
                  this.displayEvaluationDate.push(moment(new Date()).format('DD-MMM-YYYY'));
                  if(e.evaluation_date != null) {
                    this.displayEvaluationDate[i]  = moment(String(e.evaluation_date)).format('DD-MMM-YYYY');
                    this.log('evaluation_date', e.evaluation_date);
                    this.selectStudent(e.student_admission_id, i);
                  }
              });
          }
        }, 500);
        this.log(item);
    },
    evaluationCancel(){
      this.isEvaluating= false;
    },
    async dateEvaluation(){
      var data = new FormData();
      this.log('data====',this.displayEvaluationDate);
      data.append('homework_evaluation_date',JSON.stringify(this.displayEvaluationDate));
      data.append('homework_for',JSON.stringify(this.studentIds));
      const res = await this.callApi(
        "post",
        `/api/school/homework/homework/update_evaluaton_date/${this.homeworkId}`,
        data
      );
      if(res.status == 200){
        var data = res.data
        if(data.status == 'success'){
            this.evaluationCancel();
            this.log("DATE_UPDATED", this.editIndex);
            this.homeworks[this.editIndex] = data.homework;
            // this.tableData[this.editIndex] = this.prepareData(data.homework);
            this.initTable();
        }
      }
    },

    edit(item) {
      this.$router.push({
        path: `/school/homework/edit_homework/${item.homework_id}`,
      });
    },
    async deleteData(item, index) {
      var data = new FormData();
      data.append("homework_status", "deleted");
      const res = await this.callApi(
        "post",
        `/api/school/homework/homework/delete/${item.homework_id}`,
        data
      );
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.homeworks.splice(this.homeworks.indexOf(item.homework_id), 1);
          this.tableData.splice(this.homeworks.indexOf(item.homework_id), 1);
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
          icon: "error",
          title: "Something Went Wrong, Not able to delete",
          timer: 0,
        });
      }
    },
  },
};
</script>


<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}


input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
.toggle-button{
  background: none;
  outline: none;
  border: none;
  font-size: 1.5em;
  margin:0;
  padding: 0;

}
.pop-container{
    z-index: 1000;
  position: fixed;
  top:0;
  left:0;
  right:0;
  bottom:0;
  background: rgba(0,0,0,0.15);
  display: flex;
  justify-content: center;
  align-items: center;
}
.pop-container .pop-container-inner {
  box-shadow: 0 0 5px rgba(0,0,0,0.35);
  padding: 10px;
  min-height: 250px;
  min-width: 250px;
  max-width: 75%;
  max-height: 90%;
  overflow-x: hidden;
  overflow-y: auto;
  border-radius: 5px;
  background: white;
  position: relative;
  padding-bottom: 60px;
}
.popup-action-container{
  position: absolute;
  bottom: 10px;
  right: 10px;
}
.homework-title{
  font-size: 1.5em;
  color: #000;
  font-weight: normal;
  padding-left: 25px;
  box-sizing: border-box;
}
</style>
