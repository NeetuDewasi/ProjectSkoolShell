<template>
  <div>
    <div class="dashboard-content-one">
      <Breadcrumb pageTitle="Student Details " :breadcrumbList="breadcrumbList" />
      <div class="row gutters-20">
        <div class="col-12">
          <StudentDetailsCreate ref="detailsCreate" />
        </div>
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="item-title">
                <h3>Detail List</h3>
              </div>
              <div class="table-responsive" v-show="!noData">
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
import StudentDetailsCreate from "./StudentDetailsCreate.vue";
export default {
    components: {
        StudentDetailsCreate,
    },
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "admin.dashboard" },
                    name: "Home",
                },
                {
                    name: "Student Details",
                },
            ],
            studentList: [],
            tableHead: {
                items: {
                    item1: { label: "Sr.No." },
                    item2: { label: "Admission No." },
                    item3: { label: "Class" },
                    item4: { label: "Student Name" },
                    item5: { label: "Father Name" },
                    item6: { label: "Mother Name" },
                    item7: { label: "Mobile Number" },
                },
                actions: true,
            },
            tableData: [],
            isLoaded: false,
            noData: false,
            editedIndex: -1,
            classId: -1,
            sectionId: -1,
            father:{},
            student_admissions:[],
            student_guardian:{},
        };
    },
    mounted() {
        this.$parent.loadOtherScript();
        this.getStudentData();
    },
    methods: {
        async getStudentData() {
            this.isLoaded = false;
            const res = await this.callApi(
                "get",
                `/api/school/students/student_details/all_students`,
                null
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.studentList = data.detailList;
                    this.initTable();
                }
            }
            this.$refs.table.loadTable();
            this.isLoaded = true;
        },
        async getData(classId,sectionId) {
            this.isLoaded = false;
           var formData = new FormData();
            formData.append('class_id', classId);
            formData.append('section_id', sectionId);
            const res = await this.callApi(
                "post",
                `/api/school/students/student_admissions/students`,
                formData,
            );
            this.log('DATA',res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.studentList = data.student_details;
                    this.initTable();
                }
            }
            this.$refs.table.loadTable();
            this.isLoaded = true;
        },
        initTable() {
            this.tableData = [];
            this.studentList.forEach((element) => {
                this.tableData.push({
                    item: element,
                    data: {
                        item1: element.admission_id,
                        item2: element.admission_number ? element.admission_number:'',
                        item3: `${element.school_class.class_name != null ? element.school_class.class_name : ''} ${element.school_section.section_name != null ? element.school_section.section_name : ''}`,
                        item4: `${element.first_name} ${element.middle_name != null ? element.middle_name :''} ${element.last_name != null ? element.last_name : ''}`,
                        item5: `${element.student_guardian != null ? (element.student_guardian.father.first_name != null ? element.student_guardian.father.first_name : '') + ' ' + (element.student_guardian.father.middle_name != null ? element.student_guardian.father.middle_name : '') + ' ' + (element.student_guardian.father.last_name != null ? element.student_guardian.father.last_name : '') : ''}`,
                        item6: `${element.student_guardian != null ? (element.student_guardian.mother.first_name != null ? element.student_guardian.mother.first_name : '') + ' ' + (element.student_guardian.mother.middle_name != null ? element.student_guardian.mother.middle_name : '') + ' ' + (element.student_guardian.mother.last_name != null ? element.student_guardian.mother.last_name : '') : ''}`,
                        item7: element.student_guardian != null ? (element.student_guardian.father.mobile != null ? element.student_guardian.father.mobile : '') : '',
                        item8: {
                            type: 'action',
                            options: {
                                style: 'border:non',
                                class: 'btn',
                                icon: '<i class="fa fa-eye" aria-hidden="true"></i>',
                                method: this.showDetails
                            }
                        },
                    },
                    action: {
                        edit: true,
                        delete: true,
                    },
                });
            });
        },
        showDetails(item, index) {
            this.$router.push(`/school/students/student_details/details_view/${item.student_admission_id}`);
        },
        edit(item, index) {
            this.$router.push({
                path: `/school/students/admission/${item.student_admission_id}`,
            });
        },

        async deleteData(item, index) {
            var data = new FormData();
            data.append("status", "deleted");
            const res = await this.callApi(
                "post",
                `/api/school/students/student_details/delete/${item.student_admission_id}`,
                data
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.studentList.splice(index, 1);
                    this.tableData.splice(index, 1);
                    SwalCustomBtn.fire("Deleted!", data.message, "success");
                    toast = Toast.fire({
                        icon: data.status,
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
            }
        },
    },
};
</script>
