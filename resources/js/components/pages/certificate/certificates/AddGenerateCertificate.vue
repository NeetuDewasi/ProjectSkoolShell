<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb pageTitle="Generate Certificate" :breadcrumbList="breadcrumbList" />
            <div class="row gutters-20">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Select Criteria</h3>
                                </div>
                            </div>

                            <form class="new-added-form">
                                <div class="row">
                                    <div class="col-6 form-group">
                                        <label>Select Class</label>
                                        <Select2 ref="class_list_select2" placeholder="--SELECT A CLASS--"
                                            :items="class_list" @change="selectClass" />
                                    </div>
                                    <div class="col-6 form-group">
                                        <label>Select Section</label>
                                        <Select2 ref="section_list_select2" :items="section_list" @change="selectSection" />
                                    </div>
                                    <div class="col-6 form-group">
                                        <label>Select Certificate</label>
                                        <Select2 ref="certificate_list" :items="certificate_list"
                                            @change="selectCertificate" />
                                    </div>
                                    <div class="col-6 form-group">
                                        <label>Student Name</label>
                                        <div v-for="(student, index) in studentList" :key="student.student_admission_id">
                                            <div>
                                                <span>
                                                    <input :id="`studentChecked${index}`" type="checkbox"
                                                        name="selectStudent[]"
                                                        @change.prevent="selectStudent(student.student_admission_id, index)" />
                                                </span>
                                                <span @click="selectStudent(student.student_admission_id, index)">
                                                    {{
                                                        getStudentFullName(student)
                                                    }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="d-flex justify-content-end mt-5">
                                    <button type="submit" class="btn-fill-lg text-light shadow-dodger-blue bg-dodger-blue"
                                        @click.prevent="submitData()">
                                        {{ formBtn }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="card">
        <div class="card-body">
          <div class="item-title">
            <h3>Student Certificate List</h3>
          </div>

        </div>
      </div> -->
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
                    name: "Generate Certificate",
                },
            ],
            class_list: [],
            section_list: [],
            classId: -1,
            sectionId: -1,
            studentList: [],
            certificate_List: [],
            certificate_list: [],
            editedIndex: -1,
            editItem: {
                studentIds: [],
            },
        };
    },
    computed: {
        formBtn: function () {
            return this.editedIndex != -1 ? "Update" : "Save";
        }
    },
    mounted() {
        this.$parent.loadOtherScript();
        this.getClassList();
        this.getCertificateList();
    },
    methods: {
        async getClassList() {
            const res = await this.callApi(
                "get",
                `/api/school/general/get_class_list`,
                null,
            );
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
            const res = await this.callApi(
                "get",
                `/api/school/general/class/${this.classId}/sections`,
                null,
            );
            this.log('section data', res)
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.sections = data.school_class_sections;
                    this.$refs.section_list_select2.updateList(data.school_class_sections);
                }
            }
            this.getStudents();
        },
        selectSection(val) {
            this.sectionId = val;
            this.getStudents();
        },
        async getStudents() {
            var formData = new FormData();
            formData.append('class_id', this.classId);
            formData.append('section_id', this.sectionId);

            const res = await this.callApi(
                "post",
                `/api/school/students/student_admissions`,
                formData,
            );
            // console.log("GET_STUDENT>>>", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.studentList = data.student_admissions;
                } else {
                    this.studentList = [];
                }
            }
        },
        getStudentFullName(student) {
            return student.student_first_name + (student.student_middle_name ? ' ' + student.student_middle_name : '') + (student.student_last_name ? ' ' + student.student_last_name : '')
        },
        selectStudent(studentId, index) {
            if (this.editItem.studentIds.includes(studentId)) {
                this.editItem.studentIds.splice(this.editItem.studentIds.indexOf(studentId), 1);
                $('#studentChecked' + index).prop('checked', false)
            } else {
                this.editItem.studentIds.push(studentId);
                $('#studentChecked' + index).prop('checked', true)
            }
        },
        async getCertificateList() {
            const res = await this.callApi(
                "get",
                `/api/school/certificate/student_certificate/certificate_list`,
                null,
            );
            this.log('List of Certificates', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.certificate_list = data.certificateList;
                    this.$refs.certificate_list.updateList(data.certificateList);
                }
            }
        },
        selectCertificate(val) {
            this.certificate_id = val;
        },

        async submitData() {
            toast = Toast.fire({
                icon: "warning",
                title: "Please Wait!! Creating new Content",
                timer: 0,
            });
            var data = new FormData();
            data.append('class_id', this.classId);
            data.append('section_id', this.sectionId);
            data.append('certificate_id', this.certificate_id);
            this.editItem.studentIds.forEach(element => {
                data.append('admission_ids[]', element);
            });
            let url = "";
            if (this.editedIndex != -1) {
                url = `/api/school/certificate/generate_certificate/update/${this.editedIndex}`;
            } else {
                url = `/api/school/certificate/generate_certificate/save`;
            }
            const res = await this.callApi("post", url, data);
            this.log('CERTIFICATE', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == 'success') {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                } else {
                    toast = Toast.fire({
                        icon: "warning",
                        title: "Something went wrong!",
                        timer: 2500,
                    });
                }

            }
        }
    },
};
</script>

