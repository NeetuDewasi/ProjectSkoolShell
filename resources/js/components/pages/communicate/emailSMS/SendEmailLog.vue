<template>
    <div>
        <div class="dashboard_content-one">
            <!-- <Breadcrumb pageTitle="Send Messages" :breadcrumbList="breadcrumbList" /> -->
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form class="new-added-form">
                                <div class="row">
                                    <div class="col-lg-7 col-12 form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control mb-4" v-model="editItem.message_title"
                                            @keypress="
                                                errorItem.message_title = ''
                                                " :class="errorItem.message_title != ''
        ? 'error-field'
        : ''
        " />
                                        <span class="error-label" v-if="errorItem.message_title != ''"
                                            v-text="errorItem.message_title"></span>
                                        <label>Send Through</label>
                                        <div class="d-flex">
                                            <div class="form-check">
                                                <input type="checkbox" name="checkEmail" class="form-check-input" v-model="editItem.message_email
                                                    " />
                                                <label class="form-check-label">Email</label>
                                            </div>
                                            <div class="form-check ml-5">
                                                <input type="checkbox" name="checkSMS" class="form-check-input" v-model="editItem.message_sms
                                                    " />
                                                <label class="form-check-label">SMS</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <VueTrix v-model="editItem.message_content
                                                " @keypress="
        errorItem.message_content =
        ''
        " :class="errorItem.message_content !=
        ''
        ? 'error-field'
        : ''
        " />
                                            <span class="error-label" v-if="errorItem.message_content !=
                                                ''
                                                " v-text="errorItem.message_content
        "></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-12">
                                        <div class="form-group">
                                            <label>Message For</label>
                                            <select class="form-control" v-model="message_for">
                                                <option value="departments">
                                                    DEPARTMENTS
                                                </option>
                                                <option value="individuals">
                                                    INDIVIDUALS
                                                </option>
                                                <option value="parents">
                                                    PARENTS
                                                </option>
                                            </select>
                                        </div>
                                        <div class v-show="message_for == 'departments'
                                            ">
                                            <div class="col-12">
                                                <div v-for="(
                                                        department, index
                                                    ) in department_list" :key="department.value
                                                        ">
                                                    <div>
                                                        <span>
                                                            <input :id="`departmentChecked${index}`" type="checkbox"
                                                                name="selectDepartment[]" @change.prevent="
                                                                    selectDepartment(
                                                                        department.value,
                                                                        index
                                                                    )
                                                                    " />
                                                        </span>
                                                        <span @click="
                                                            selectDepartment(
                                                                department.value,
                                                                index
                                                            )
                                                            ">
                                                            {{
                                                                department.name
                                                            }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class v-show="message_for == 'individuals'
                                            ">
                                            <div class="form-group">
                                                <Select2 ref="designation_list" :items="designation_list"
                                                    @change="selectEmployees" />
                                            </div>
                                            <div class="col-12">
                                                <div v-for="(
                                                        employee, index
                                                    ) in employee_list" :key="employee.employee_id">
                                                    <div>
                                                        <span>
                                                            <input :id="`employeeChecked${index}`" type="checkbox"
                                                                name="selectEmployee[]"
                                                                @change.prevent="selectEmployee(employee.employee_id, index)" />


                                                        </span>
                                                        <span>
                                                            {{
                                                                getEmployeeFullName(
                                                                    employee
                                                                )
                                                            }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class v-show="message_for == 'parents'">
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label>Class</label>
                                                        <Select2 placeholder="--SELECT A CLASS--" ref="class_list_select2"
                                                            :items="class_list" @change="selectClass
                                                                " />
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label>Section</label>
                                                        <Select2 ref="section_list_select2" :items="section_list
                                                            " @change="selectSection
        " />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div v-for="(
                                                        student, index
                                                    ) in studentList" :key="student.student_admission_id
                                                        ">

                                                    <div>
                                                        <span>
                                                            <input :id="`studentChecked${index}`" type="checkbox"
                                                                name="selectStudent[]" @change.prevent="
                                                                    selectStudent(
                                                                        student.student_admission_id,
                                                                        index
                                                                    )
                                                                    " />
                                                        </span>
                                                        <span @click="
                                                            selectStudent(
                                                                student.student_admission_id,
                                                                index
                                                            )
                                                            ">
                                                            {{
                                                                getStudentFullName(
                                                                    student
                                                                )
                                                            }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit"
                                        class="btn btn-fill-sm rounded text-light shadow-dodger-blue bg-dodger-blue"
                                        @click.prevent="submitData()">
                                        {{ formBtn }}
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
export default {
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "admin.dashboard" },
                    name: "Home",
                },
                {
                    name: "Send Email/SMS",
                },
            ],
            errorItem: {
                message_title: "",
                message_content: "",
            },
            message_for: "departments",

            editItem: {

                studentIds: [],

            },
            employeeIds: [],
            departmentIds: [],
            employeeIds: [],
            classId: -1,
            sectionId: -1,
            class_list: [],
            section_list: [],
            employee_list: [],
            designation_list: [],
            departmentId: -1,
            studentList: [],
            department_list: [],
            studentId: -1,
            departId: -1,
            editedIndex: -1,
        };
    },
    created() {
        this.getDepartment();
    },
    watch: {
        message_for: function (val) {
            if (val == "individuals") {
                this.getDesignation();
            } else if (val == "parents") {
                this.getClassList();
            }
        },
    },
    mounted() {
        this.$parent.loadOtherScript();
        if (this.$route.params.message_id) {
            this.message_id = this.$route.params.message_id;
            this.editedIndex = this.$route.params.message_id;
            this.getEditItemData(this.$route.params.message_id);
        }
    },
    computed: {
        formBtn: function () {
            return this.editedIndex !== -1 ? "Update" : "Save";
        },
        resetButton: function () {
            return this.editedIndex === -1 ? "Reset" : "Cancel";
        },
    },
    methods: {
        //// FOR DEPARTMENT  /////
        selectDepartment(value, index) {

            this.employeeIds = [];
            this.editItem.studentIds = [];
            // this.editItem.departmentIds = [];

            if (
                this.departmentIds &&
                this.departmentIds.includes(value)
            ) {
                this.departmentIds.splice(
                    this.departmentIds.indexOf(value),
                    1
                );
                $("#departmentChecked" + index).prop("checked", false);
            } else {
                this.departmentIds.push(value);
                $("#departmentChecked" + index).prop("checked", true);
                console.log('depart ids', this.departmentIds);

            }
        },

        //// FOR EMPLOYEE  /////
        selectEmployee(value, index) {

            this.departmentIds = [];
            this.editItem.studentIds = [];
            // this.editItem.departmentIds = [];

            if (
                this.employeeIds &&
                this.employeeIds.includes(value, index)
            ) {
                this.employeeIds.splice(
                    this.employeeIds.indexOf(value, index),
                    1
                );
                $("#employeeChecked" + index).prop("checked", false);
            } else {
                this.employeeIds.push(value);
                $("#employeeChecked" + index).prop("checked", true);
                console.log('empolyee ids', this.employeeIds);

            }
        },

        getSelectedAndCheckedEmployees() {
            const selectedEmployees = this.employee_list.filter(employee => this.employeeIds.includes(employee.employee_id));
            return selectedEmployees;
        },

        //// FOR PARENT  /////
        selectStudent(value, index) {
            this.editItem.departmentIds = [];
            this.employeeIds = [];
            if (this.editItem.studentIds.includes(value)) {
                this.editItem.studentIds.splice(
                    this.editItem.studentIds.indexOf(value),
                    1
                );
                $("#studentChecked" + index).prop("checked", false);
            } else {
                this.editItem.studentIds.push(value);
                $("#studentChecked" + index).prop("checked", true);
            }
        },
        async getDepartment() {
            var formData = new FormData();
            const res = await this.callApi(
                "get",
                `/api/school/communicate/send_email/department`,
                formData
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.department_list = data.departments;
                    console.log("check Department>>>", this.department_list);
                } else {
                    this.department_list = [];
                }
            }
        },

        //// For Individual  ////
        selectEmployees(departmentId) {
            this.departmentId = departmentId;
            this.log('department id', this.departmentId);
            this.showEmployees();
        },

        async getDesignation() {
            var formData = new FormData();
            const res = await this.callApi(
                "get",
                `/api/school/communicate/send_email/department`,
                formData
            );
            // // console.log("GET_Department>>>", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.designation_list = data.departments;
                    this.$refs.designation_list.updateList(data.departments);
                } else {
                    this.designation_list = [];
                }
            }
        },

        async showEmployees() {
            var formData = new FormData();
            formData.append("departmentId", this.departmentId);
            const res = await this.callApi(
                "post",
                `/api/school/communicate/send_email`,
                formData
            );
            this.log('Employees', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.employee_list = data.employees;
                } else {
                    this.employee_list = [];
                }
            }
        },
        getEmployeeFullName(employee) {
            return (
                employee.employee_f_name +
                (employee.employee_l_name ? " " + employee.employee_l_name : "")
            );
        },
        async getClassList() {
            const res = await this.callApi(
                "get",
                `/api/school/general/get_class_list`,
                null
            );
            // // console.log("Classes", this.class_list);
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
                null
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.section_list = data.school_class_sections;
                    this.$refs.section_list_select2.updateList(
                        data.school_class_sections
                    );
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
            formData.append("class_id", this.classId);
            formData.append("section_id", this.sectionId);

            const res = await this.callApi(
                "post",
                `/api/school/students/student_admissions`,
                formData
            );
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

        async saveData() {

            var data = new FormData();
            data.append(
                "title",
                this.editItem.message_title ? this.editItem.message_title : ""
            );
            data.append("email", this.editItem.message_email ? 1 : 0);
            data.append("sms", this.editItem.message_sms ? 1 : 0);
            data.append(
                "content",
                this.editItem.message_content
                    ? this.editItem.message_content
                    : ""
            );
            data.append(
                "message_for",
                this.message_for ? this.message_for : ""
            );
            var receiver_ids = "";
            if (this.message_for == "departments")
                receiver_ids = this.editItem.departmentIds
                    ? this.editItem.departmentIds
                    : "";
            else if (this.message_for == "individuals")
                receiver_ids = this.employeeIds
                    ? this.employeeIds
                    : "";
            if (this.message_for == "parents")
                receiver_ids = this.editItem.studentIds
                    ? this.editItem.studentIds
                    : "";
            data.append("receiver_ids", receiver_ids);

            const res = await this.callApi(
                "post",
                `/api/school/communicate/send_email/save`,
                data
            );
            // // console.log("res", res);
            if (res.status == 200) {
                var data = res.data;

                if (data.status == "success") {
                    toast = Toast.fire({
                        icon: "success",
                        message_title: data.message,
                        timer: 2500,
                    });
                } else {
                    toast = Toast.fire({
                        icon: data.status,
                        message_title: data.message,
                        timer: 2500,
                    });
                }
            } else {
                toast = Toast.fire({
                    icon: data.status,
                    message_title: data.message,
                    timer: 2500,
                });
            }
        },

        async submitData() {
            var isVaild = await this.validEmailForm();
            if (!isVaild) {
                return;
            }
            if (this.editedIndex !== -1) {
                this.updateData();
            } else {
                this.saveData();
            }
            this.editItem = {
                studentIds: [],
                departmentIds: [],
                employeeIds: [],
            };
            this.editedIndex = -1;
            this.message_for = {};
        },

        validEmailForm() {
            this.isFormValid = true;
            if (
                this.editItem.message_title == null ||
                this.editItem.message_title == ""
            ) {
                this.errorItem.message_title = "Title is required";
                this.isFormValid = false;
            } else {
                this.errorItem.message_title = "";
            }
            if (
                this.editItem.message_content == null ||
                this.editItem.message_content == ""
            ) {
                this.errorItem.message_content = "This field is required";
                this.isFormValid = false;
            } else {
                this.errorItem.message_content = "";
            }

            return this.isFormValid;
        },
        async getEditItemData(id) {
            const res = await this.callApi(
                "get",
                `/api/school/communicate/send_email/edit/${id}`,
                null
            );
            console.log("Edited Item", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.editItem = data.edited_email_sms;
                    this.editItem.message_title =
                        data.edited_email_sms.message_title;
                    this.editItem.message_email =
                        data.edited_email_sms.message_email;
                    this.editItem.message_sms =
                        data.edited_email_sms.message_sms;
                    this.editItem.message_content =
                        data.edited_email_sms.message_content;
                    this.message_for =
                        data.edited_email_sms.message_message_for;

                    if (
                        data.edited_email_sms.message_message_for ==
                        "departments"
                    ) {
                        this.log('depart edit', this.department_list);
                        this.department_list.forEach((element, index) => {
                            data.edited_email_sms.message_receiver_ids.forEach(
                                (e, index) => {
                                    if (element.value == e) {
                                        this.selectDepartment(
                                            e, index
                                        );
                                    }
                                }
                            );
                        });
                    } else if (
                        data.edited_email_sms.message_message_for ==
                        "individuals"
                    ) {
                        this.$refs.designation_list.setSelected(
                            data.edited_email_sms.employee_department
                        );
                        this.getDesignation();
                        this.selectEmployees(
                            data.edited_email_sms.employee_department
                        );
                        this.departmentId = data.edited_email_sms.employee_department;
                        this.showEmployees();
                        setTimeout(() => {
                            this.log('enmp list', this.employee_list);
                            this.employee_list.forEach((element, index) => {
                                data.edited_email_sms.message_receiver_ids.forEach(
                                    (e, index) => {
                                        if (element.employee_id == e) {
                                            this.selectEmployee(
                                                e, index
                                            );
                                        }
                                    }
                                );
                            });
                        }, 1000);
                    } else {

                        this.$refs.class_list_select2.setSelected(
                            data.edited_email_sms.student_list[0].school_class.class_id
                        );
                        this.selectClass(
                            data.edited_email_sms.student_list[0].school_class.class_id
                        );
                        this.$refs.section_list_select2.setSelected(
                            data.edited_email_sms.student_list[0].school_section.section_id
                        );
                        this.selectSection(
                            data.edited_email_sms.student_list[0].school_section.section_id
                        );
                        setTimeout(() => {
                            this.editItem.studentIds = [];
                            this.studentList.forEach((element, index) => {
                                data.edited_email_sms.student_list.forEach((e) => {
                                    if (element.student_admission_id == e.student_admission_id) {
                                        this.selectStudent(
                                            element.student_admission_id,
                                            index
                                        );
                                    }
                                }
                                );
                            });
                        }, 1000);
                    }
                }
            }
        },
        async updateData() {
            this.log('emp ids', this.employeeIds);
            var data = new FormData();
            data.append("message_title", this.editItem.message_title);
            data.append("message_email", this.editItem.message_email ? 1 : 0);
            data.append("message_sms", this.editItem.message_sms ? 1 : 0);
            data.append("message_content", this.editItem.message_content);
            data.append("message_for", this.message_for);
            var receiver_ids = "";
            if (this.message_for == "departments")

                receiver_ids = this.departmentIds;

            else if (this.message_for == "individuals")
                receiver_ids = this.employeeIds;
            if (this.message_for == "parents")
                receiver_ids = this.editItem.studentIds;
            data.append("receiver_ids", receiver_ids);

            const res = await this.callApi(
                "post",
                `/api/school/communicate/send_email/update/${this.editedIndex}`,
                data
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                    this.editItem = {
                        studentIds: [],
                        departmentIds: [],
                        employeeIds: [],
                    };
                    this.editedIndex = -1;
                    this.message_for = {};
                    setTimeout(() => {
                        this.$router.push({
                            path: `/school/communicate/email_log`,
                        });
                    }, 1000);
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

<style scoped>
.trix-editor {
    height: 100% !important;
    /* max-height: 150px !important;
	  	overflow-y: auto !important; */
}
</style>
