<template>
    <div>
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start -->
            <Breadcrumb
                pageTitle="Add Student Mamaber"
                :breadcrumbList="breadcrumbList"
            />
            <!-- End Breadcubs Area -->
            <!-- Add Student Mamaber Here -->
            <div class="row gutters-20">
                <div class="col-12">
                   <div class="row">
						<div class="col-lg-6 col-md-12 form-group">
							<label>Select Class</label>
							<Select2
								ref="class_list"
								placeholder="--SELECT A CLASS--"
								:items="class_list"
								@change="selectClass"
							/>
						</div>
						<div class="col-lg-6 col-md-12 form-group">
							<label>Select Section</label>
							<Select2
								placeholder="--SELECT A SECTION--"
								ref="section_list"
								:items="section_list"
								@change="selectSection"
							/>
						</div>
					</div>
                      <div class="col-12">
    					<div class="card" v-show="addStudentFormVisible">
    						<div class="card-body">
    							<div class="item-title justify-content-between d-flex">
    								<h3>Add Student Card</h3>
                                    <button class="btn btn-sm rounded rounded-2 close-button float-end mt-0 pt-0"
                                     @click="closeForm()"><i class="fa fa-times p-1 m-1"></i></button>
    							</div>
                      <div class="new-added-form" >
                        <div class="row">
                          <div class="col-xl-6 col-lg-12 col-md-12 col-12 form-group">
                            <label> Add Library Card Number*</label>
                            <input type="text" placeholder="" class="form-control" v-model="card_number"/>
                          </div>
                          <div class="col-12 form-group mg-t-8">
                            <button @click.prevent="addStudent()"
                              type="submit"
                              class="
                        btn-lg btn btn-gradient-yellow btn-hover-bluedark
                        text-white
                      "
                            >
                              Save
                            </button>
                            <button
                              type="reset"
                              class="
                        btn-lg btn
                        bg-blue-dark
                        btn-hover-yellow
                        text-white
                      "
                            >
                              Reset
                            </button>
                          </div>
                        </div>
                      </div>
                      </div>
                      </div>
                      </div>
                </div>
                <div class="col-12">
					<div class="card">
						<div class="card-body">
							<div class="item-title">
								<h3>Student List</h3>
							</div>
							<div class="table table-responsive" v-show="!noData">
								<Table
									ref="table"
									:tableData="tableData"
									:tableHead="tableHead"
								/>
							</div>
							<NoData v-show="noData" />
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</template>

<script>
// import AddStudentCreate from './AddStudentCreate.vue';
var toast;
export default {
    // components: {
    //     AddStudentCreate,
    // },
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "admin.dashboard" },
                    name: "Home",
                },
                {
                    name: "BookList",
                },
            ],
            addStudentFormVisible: false,
            class_list: [],
			section_list: [],
            selectedClass:[],
            selectedSection:[],
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
            card_number : '',
            student_id : -1
        };
    },
created(){
    this.getClassList();

},
computed: {
        filterData() {
            if (this.classId != -1) {

                if (this.sectionId != -1) {

                    return this.tableData.filter(item => {
                        return item.data.item3 == (`this.selectedClassName` + ' ' + this.selectedSectionName);
                    })
                }
                this.log('This is filter data', this.filterData);
                return  this.tableData.filter(item => {
                    return item.data.item3.includes(this.selectedClassName);
                });
            }
            return this.tableData;
        }
    },

	methods: {
        closeForm(){
            this.addStudentFormVisible = false;
        },
		async selectClass(val) {
			this.classId = val;
            this.getSelectedClassName();
			const res = await this.callApi(
				"get",
				`/api/school/class/sections/${this.classId}`,
				null
			);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.sections = data.school_class_sections;
					this.$refs.section_list.updateList(
						data.school_class_sections
					);
				}
			}
            // this.getData(this.classId,this.sectionId);
		},
		async getClassList() {
			const res = await this.callApi(
				"get",
				`/api/school/general/get_class_list`,
				null
			);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.class_list = data.class_list;
					this.$refs.class_list.updateList(data.class_list);
				}
			}
		},
		selectSection(sectionId) {
            this.sectionId = sectionId;
            this.getSelectedSectionName();
            // if(this.sectionId != -1){
			this.getData(this.classId,this.sectionId);
            // }
		},

        getSelectedClassName() {
            if (this.classId != -1) {
                this.class_list.forEach(element => {
                    if (element.value == this.classId) {
                        this.selectedClassName = element.name;
                    }
                });
            }
        },
        getSelectedSectionName() {
            if (this.sectionId != -1) {
                this.section_list.forEach(element => {
                    if (element.value == this.sectionId) {
                        this.selectedSectionName = element.name;
                        this.log('Section Id',this.selectedSectionName);
                    }
                });
            }
        },
         async getData(classId,sectionId) {
            this.isLoaded = false;
           var formData = new FormData();
            formData.append('class_id', classId);
            formData.append('section_id', sectionId);
            this.log(classId,sectionId);
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

        async addStudent() {
            var data = new FormData();
            data.append('card_number', this.card_number);
            data.append('student_id', this.student_id);
            const res = await this.callApi(
                "post",
                `/api/school/add_student_card`,
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
        initTable() {
            this.tableData = [];
            this.studentList.forEach((element) => {
                this.tableData.push({
                    item: element,
                    data: {
                        item1: element.student_admission_id,
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
                                icon: '<i class="fa fa-plus" aria-hidden="true"></i>',
                                method : this.createStudent
                            }
                        },
                    },
                    action: {
                        edit: true,
                        delete: true,
                    },
                });
            });
            this.log('tabale data',this.tableData);
            this.log('tabale data students', this.studentList);
        },
        createStudent(student){
            this.student_id = student.student_admission_id;
             this.addStudentFormVisible = !this.addStudentFormVisible;
        },

},
};
</script>
<style>
.close-button{
    background-color: rgb(230, 121, 121) !important;
    opacity: 0.5;
    padding: 0px !important;
}
</style>
