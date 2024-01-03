<template>
	<div>
		<div class="dashboard-content-one">
			<Breadcrumb
				pageTitle="Communication"
				:breadcrumbList="breadcrumbList"
			/>

			<div class="row gutters-20">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div class="item-title text-center bg-secondary">
								<h3 class="text-light">Detail page</h3>
							</div>
							<!-- <div class="table" v-show="!noData">
                <Table ref="table" :tableData="filterData" :tableHead="tableHead" />
              </div>
              <NoData v-show="noData" />-->
              <div class="row" v-if="viewEmail_sms_list">
                <div class="col-12 ms-5">
                  <b>
                    <label>Title :</label>
                  </b>
                  <b>
                    <span
                      v-if="viewEmail_sms_list.message_title != null"
                    >{{ viewEmail_sms_list.message_title }}</span>
                  </b>
                </div>
                <div class="col-12 ms-5">
                  <b>
                    <label>Email :</label>
                  </b>
                  <b>
                    <span
                      v-if="viewEmail_sms_list.message_email && viewEmail_sms_list.message_email != null"
                    ></span>
                    <i
                      class="fas fa-check text-success"
                      v-if="viewEmail_sms_list.message_email == 1"
                    ></i>
                    <i class="fas fa-times text-danger" v-else></i>
                  </b>
                </div>
                <div class="col-12 ms-5">
                  <b>
                    <label>SMS :</label>
                  </b>
                  <span
                    v-if="viewEmail_sms_list.message_sms && viewEmail_sms_list.message_sms != null"
                  ></span>
                  <i class="fas fa-check text-success" v-if="viewEmail_sms_list.message_sms == 1"></i>
                  <i class="fas fa-times text-danger" v-else></i>
                </div>
                <div class="col-12 ms-5">
                  <b>
                    <label>Message For :</label>
                  </b>
                  <b>{{ viewEmail_sms_list.message_message_for != null ? viewEmail_sms_list.message_message_for : "" }}</b>
                </div>

                <span class="col-12 ms-5">
                  <span
                    v-if="viewEmail_sms_list.message_message_for && viewEmail_sms_list.message_message_for == 'departments'"
                  >
                    <b>
                      <label>Department :</label>
                    </b>
                    <b>
                      <span
                        v-if="viewEmail_sms_list.departments && viewEmail_sms_list.departments != ''"
                      >
                        <span
                          v-for="department in viewEmail_sms_list.departments"
                          :key="department.department_id"
                        >{{ department.department_name }} &nbsp;</span>
                      </span>
                    </b>
                  </span>
                  <span
                    v-else-if="viewEmail_sms_list.message_message_for && viewEmail_sms_list.message_message_for == 'individuals'"
                  >
                    <b>
                      <label>Employees :</label>
                    </b>
                    <b>
                      <span
                        v-if="viewEmail_sms_list.employees && viewEmail_sms_list.employees != ''"
                      >
                        <span
                          v-for="employee in viewEmail_sms_list.employees"
                          :key="employee.employee_id"
                        >{{ employee.employee_first_name }} &nbsp;</span>
                      </span>
                    </b>
                    <b>
                      <span
                        v-if="viewEmail_sms_list.employees && viewEmail_sms_list.employees != ''"
                      >
                        <span
                          v-for="employee in viewEmail_sms_list.employees"
                          :key="employee.employee_id"
                        >{{ employee.employee_last_name }} &nbsp;</span>
                      </span>
                    </b>
                  </span>
                  <span v-else>
                    <b>
                      <label>Students :</label>
                    </b>
                    <b>
                      <span
                        v-if="viewEmail_sms_list.student_list && viewEmail_sms_list.student_list != ''"
                      >
                        <span
                          v-for="students in viewEmail_sms_list.student_list"
                          :key="students.student_admission_id"
                        >{{ students.student_first_name }} &nbsp;</span>
                      </span>
                    </b>

                    <b>
                      <span
                        v-if="viewEmail_sms_list.student_list && viewEmail_sms_list.student_list != ''"
                      >
                        <span
                          v-for="students in viewEmail_sms_list.student_list"
                          :key="students.student_admission_id"
                        >{{ students.student_last_name }} &nbsp;</span>
                      </span>
                    </b>
                    <b>
                      <span
                        v-if="viewEmail_sms_list.student_list && viewEmail_sms_list.student_list != ''"
                      >
                        <span
                          v-for="students in viewEmail_sms_list.student_list"
                          :key="students.student_admission_id"
                        >{{ students.student_first_name }} &nbsp;</span>
                      </span>
                    </b>
                    <div class="col-12">
                      <span>
                        <b>
                          <label>Class :</label>
                        </b>
                      </span>
                      <b>
                        <span
                          v-if="viewEmail_sms_list.student_list && viewEmail_sms_list.student_list != ''"
                        >
                          <span
                            v-for="students in viewEmail_sms_list.student_list"
                            :key="students.student_admission_id"
                          >{{ students.school_class.class_name }} &nbsp;</span>
                        </span>
                      </b>
                    </div>
                    <span class="col-12">
                      <span>
                        <b>
                          <label>Section :</label>
                        </b>
                      </span>
                      <b>
                        <span
                          v-if="viewEmail_sms_list.student_list && viewEmail_sms_list.student_list != ''"
                        >
                          <span
                            v-for="students in viewEmail_sms_list.student_list"
                            :key="students.student_admission_id"
                          >{{ students.school_section.section_name }} &nbsp;</span>
                        </span>
                      </b>
                    </span>
                  </span>
                </span>
                <div class="col-12 ms-5 d-flex">
                  <b>
                    <label>Description :</label>
                  </b>

                  <b>
                    <span v-html="viewEmail_sms_list.message_description"></span>
                  </b>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <Footer />
  </div>
</template>

<script>
// var toast;
export default {
	data() {
		return {
			breadcrumbList: [
				{
					to: { name: "admin.dashboard" },
					name: "Home",
				},
				{
					name: "Communication",
				},
			],
			content_list: [],
			tableHead: {
				items: {
					item1: { label: "Sr.No." },
					item2: { label: "Class" },
					item3: { label: "Title" },
					item4: { label: "Content For" },
					item5: { label: "Published At" },
					item6: { label: "Description" },
					item7: { label: "" },
				},
				actions: true,
			},
            viewEmail_sms_list:{}
        };
    },
    created() {
        this.message_id = this.$route.params.message_id;
        this.viewData();
        this.$parent.loadOtherScript();

    },
    methods: {
        async viewData() {
            this.isLoaded = false;
            const res = await this.callApi(
                "get",
                `/api/school/communicate/send_email/${this.message_id}`,
                    null,
            );
            this.log("API_RES>>>>>", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.viewEmail_sms_list = data.view_email_sms;
                }
            }
		},
	},
};
</script>
