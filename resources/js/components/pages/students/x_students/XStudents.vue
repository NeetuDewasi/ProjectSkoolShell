<template>
  <div>
    <div class="dashboard-content-one">
      <Breadcrumb pageTitle="Ex Student Details " :breadcrumbList="breadcrumbList" />
      <div class="row gutters-20">
        <div class="col-12">
          <XStudentsCreate ref="studentsCreate" />
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
import XStudentsCreate from "./XStudentsCreate.vue";
export default {
    components: {
        XStudentsCreate,
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
                    item2: { label: "Admission Number" },
                    item3: { label: "Class" },
                    item4: { label: "Student Name" },
                    item5: { label: "Father Name" },
                    item6: { label: "Mother Name" },
                    item7: { label: "Mobile Number" },
                    item8: {label:  "Status"},
                    item9: { label: "" },
                },
                    actions: true,
            },
            tableData: [],
            isLoaded: false,
            noData: false,
            editedIndex: -1,
            classId:-1,
            sectionId:-1,
        };
    },
    mounted() {
        this.$parent.loadOtherScript();
    this.getData();
    },
    methods: {
        async getData(sectionId, classId) {
            this.sectionId = sectionId;
            this.classId = classId
            var formData = new FormData();
            formData.append('class' ,classId);
            formData.append('section' ,sectionId);
            this.isLoaded = false;
            const res = await this.callApi(
                "post",
                `/api/school/students/ex_student`,
                formData
            );
            this.log('Student Data',res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.studentList = data.ex_student;
                    this.initTable();
                }
            }
            this.$refs.table.loadTable();
            this.isLoaded = true;
            // toast.close();
        },
        initTable() {
            this.tableData = [];
            this.studentList.forEach((element) => {
                this.tableData.push({
                    item: element,
                    data: {
                        item1: element.student_admission_id,
                        item2: element.student_admission_number ? element.student_admission_number:'',
                        item3: `${element.school_class.class_name != null ? element.school_class.class_name : ''} ${element.school_section.section_name != null ? element.school_section.section_name : ''}`,
                        item4: `${element.student_first_name} ${element.student_middle_name} ${element.student_last_name}`,
                        item5: `${element.student_guardian != null ? (element.student_guardian.father.first_name != null ? element.student_guardian.father.first_name : '') + (element.student_guardian.father.middle_name != null ? element.student_guardian.father.middle_name : '') + (element.student_guardian.father.last_name != null ? element.student_guardian.father.last_name : '') : ''}`,
                        item6: `${element.student_guardian != null ? (element.student_guardian.mother.first_name != null ? element.student_guardian.mother.first_name : '') + (element.student_guardian.mother.middle_name != null ? element.student_guardian.mother.middle_name : '') + (element.student_guardian.mother.last_name != null ? element.student_guardian.mother.last_name : '') : ''}`,
                        item7: element.student_guardian != null ? (element.student_guardian.father.mobile != null ? element.student_guardian.father.mobile : '') : '',
                        item8: element.student_status,
                    },
                    action: {
                        edit: true,
                        delete: true,
                    },
                });
            });

			// if (res.status == 200) {
			// 	var data = res.data;
			// 	if (data.status == "success") {
			// 		this.studentList = data.student_admissions;
			// 		this.initTable();
			// 	}
			// }
			// this.$refs.table.loadTable();
			// this.isLoaded = true;
			// // toast.close();
		},
		// initTable() {
		// 	this.tableData = [];
		// 	this.studentList.forEach((element) => {
		// 		this.tableData.push({
		// 			item: element,
		// 			data: {
		// 				item1: element.student_admission_id,
		// 				item2: element.student_admission_number,
		// 				item3: element.student_first_name,
		// 				item4: element.student_last_name,
		// 				item5: `${
		// 					element.school_class.class_name != null
		// 						? element.school_class.class_name
		// 						: ""
		// 				} ${
		// 					element.school_section.section_name != null
		// 						? element.school_section.section_name
		// 						: ""
		// 				}`,
		// 				item6:
		// 					element.student_guardian != null
		// 						? element.student_guardian.father_first_name !=
		// 						  null
		// 							? element.student_guardian.father_first_name
		// 							: ""
		// 						: "",
		// 				item7:
		// 					element.student_guardian != null
		// 						? element.student_guardian.father_last_name !=
		// 						  null
		// 							? element.student_guardian.father_last_name
		// 							: ""
		// 						: "",
		// 				item8:
		// 					element.student_guardian != null
		// 						? element.student_guardian.mother_first_name !=
		// 						  null
		// 							? element.student_guardian.mother_first_name
		// 							: ""
		// 						: "",
		// 				item9:
		// 					element.student_guardian != null
		// 						? element.student_guardian.mother_last_name !=
		// 						  null
		// 							? element.student_guardian.mother_last_name
		// 							: ""
		// 						: "",
		// 				item10:
		// 					element.student_guardian != null
		// 						? element.student_guardian.father_mobile != null
		// 							? element.student_guardian.father_mobile
		// 							: ""
		// 						: "",
		// 			},
		// 			action: {
		// 				edit: true,
		// 				delete: true,
		// 			},
		// 		});
		// 	});
		// },
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
