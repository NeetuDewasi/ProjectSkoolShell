<template>
  <div>
    <div class="dashboard-content-one">
      <!-- Breadcubs Area Start -->
      <Breadcrumb pageTitle="Add Homework" :breadcrumbList="breadcrumbList" >
        <template v-slot:button>
            <button type="submit" class="btn btn-primary btn-sm text-white"  @click="$router.push({name: 'school.homework.homework'})">
                <i class="fa fa-eye"></i> All View Homework
            </button>
        </template>
      </Breadcrumb>
      <div class="row gutters-20">
        <div class="col-12">
          <div class="card height-auto">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>Add Homework Form</h3>
                </div>
              </div>
              <form class="new-added-form" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-lg-6 col-12">
                    <div class="row">
                      <div class="col-xl-12 col-lg-12 col-12 form-group">
                        <label
                          >Title<span class="text-danger bold">*</span>
                        </label>
                        <input
                          type="text"
                          placeholder="Enter Homework Title"
                          class="form-control mb-4"
                          v-model="editItem.homework_title"
                          :class="
                            errorItem.homework_title != '' ? 'error-field' : ''
                          "
                          @keyup="
                            editItem.homework_title != ''
                              ? (errorItem.homework_title = '')
                              : ''
                          "
                        />
                        <span
                          class="error-label"
                          v-if="errorItem.homework_title != ''"
                          v-text="errorItem.homework_title"
                        ></span>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-12 form-group">
                        <label
                          >Subject<span class="text-danger bold">*</span></label
                        >
                        <Select2
                          ref="subject_list_select2"
                          placeholder="--SELECT SUBJECT--"
                          :items="subject_list"
                          :selectedId="selectedSubject"
                          @change="selectSubject"
                          :class="
                            errorItem.subject_list != '' ? 'error-field' : ''
                          "
                        />
                        <span
                          class="error-label"
                          v-if="errorItem.subject_list != ''"
                          v-text="errorItem.subject_list"
                        >
                        </span>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-12 form-group">
                        <input
                          type="checkbox"
                          id="checkDate"
                          class="form-check-input checkAll mt-3 mr-0"
                          @change="isShowDate"
                        />
                        <label class="form-check-label ml-4"
                          >Homework Published Date</label
                        >
                        <DatePicker
                          format="DD-MMM-YYYY"
                          value-type="format"
                          type="date"
                          placeholder="Select a date"
                          v-model="displayDate1"
                          :default-value="new Date()"
                          :disabled-date="disabledAfterToday"
                          v-if="isShowing"
                          class="form-control vue-datepicker my-0 w-100"
                        />
                      </div>
                      <div class="col-xl-12 col-lg-12 col-12 form-group" v-if="isShowing">
                        <label>Submission Date <span class="text-danger font-bold">*</span></label>
                        <DatePicker
                          format="DD-MMM-YYYY"
                          value-type="format"
                          type="date"
                          placeholder="Select a date"
                          v-model="displayDate2"
                          :disabled-date ="disabledBeforeDate1"
                          class="form-control vue-datepicker my-0 w-100"
                        />
                      </div>
                      <div class="col-xl-12 col-lg-12 col-12 form-group" v-if="isShowing">
                        <label>Evaluation Date <span class="text-danger font-bold">*</span></label>
                        <DatePicker
                          format="DD-MMM-YYYY"
                          value-type="format"
                          type="date"
                          placeholder="Select a date"
                          v-model="displayDate3"
                          class="form-control vue-datepicker my-0 w-100"
                        />
                      </div>
                      <div class="col-12 form-group">
                        <label>Description</label>
                        <VueTrix v-model="editItem.homework_description" />
                      </div>
                      <div class="col-12 form-group" >
                         <label>Upload File</label>
                        <div class="imageContainer">
                            <!-- <img :src="selectedImage"/>
							<input multiple type="file"  name="documents[]"  accept=".png,.jpg,.jpeg" @change="imageFileSelect"
                            class="filename" /> -->
                              <img
                                                            :src="srcImageFile"
                                                            alt
                                                        />
                                                       <input type="file" accept=".png,.jpg,.jpeg" @change="imageFileSelect">
                      </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-6 col-lg-6 col-12">
                    <div class="row">
                      <div class="col-lg-6 col-12 classSection form-group">
                        <label>Class</label>
                        <Select2
                          ref="class_list_select2"
                          placeholder="--SELECT A CLASS--"
                          :items="class_list"
                          @change="selectClass"
                          :selectedId="selectedClass"
                          :class="
                            errorItem.class_list != '' ? 'error-field' : ''
                          "
                        />
                        <span
                          class="error-label"
                          v-if="errorItem.class_list != ''"
                          v-text="errorItem.class_list"
                        >
                        </span>
                      </div>
                      <div class="col-lg-6 col-12 classSection form-group">
                        <label>Section</label>
                        <Select2
                          ref="section_list_select2"
                          :items="section_list"
                          @change="selectSection"
                          :selectedId="selectedSection"
                          :class="
                            errorItem.section_list != '' ? 'error-field' : ''
                          "
                        />
                        <span
                          class="error-label"
                          v-if="errorItem.section_list != ''"
                          v-text="errorItem.section_list"
                        >
                        </span>
                      </div>
                      <div>
                      </div>
                      <div class="col-12">
                        <div
                          v-for="(student, index) in studentList"
                          :key="student.student_admission_id"
                        >
                          <div>
                            <span>
                              <input
                                :id="`studentChecked${index}`"
                                type="checkbox"
                                name="selectStudent[]"
                                @change.prevent="
                                  selectStudent(
                                    student.student_admission_id,
                                    index
                                  )
                                "
                              />
                            </span>
                            <span
                              @click="
                                selectStudent(
                                  student.student_admission_id,
                                  index
                                )
                              "
                            >
                              {{ getStudentFullName(student) }}
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="d-flex justify-content-end mg-t-8">
                  <button
                    type="submit"
                    class="
                      btn-fill-lg
                      text-light
                      shadow-dodger-blue
                      bg-dodger-blue
                    "
                    @click.prevent="submitForm()"
                  >
                    {{ formBtn }}
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- Add Homework End Here -->
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
						to: { name: "school.dashboard" },
						name: "Home",
					},
					{
						name: "Add Homework",
					},
				],
				editItem: {
					studentIds: [],
				},
				isShow: true,
				class_list: [],
				section_list: [],
				subject_list: [],
				errorItem: {
					homework_title: "",
					subject_list: "",
					class_list: "",
					section_list: "",
                     homework_submission_date: "",
				},
				imageFilePathList: [],
                imageNameList:[],
                imageExtention : [],
				selectedSubject: -1,
				selectedSection: -1,
				selectedClass: -1,
				selectedClassName: "",
				selectedSectionName: "",
				selectedSubjectName: "",
				studentList: [],
                srcImageFile: null,
                imageFilePath : null,
				isShowing: false,
				studentId: -1,
				displayDate1: "",
				displayDate2: "",
				 displayDate3: "",
				homework_issue_date: moment(new Date()).format("YYYY-MM-DD"),
				homework_submission_date: moment(new Date()).format("YYYY-MM-DD"),
				homework_evaluation_date: moment(new Date()).format("YYYY-MM-DD"),
			};
		},
		computed: {
			formBtn: function () {
				return this.$route.params.edit_id ? "Update" : "Save";
			},
			selectedImage: function () {
				return this.srcImageFile != null
					? this.srcImageFile
					: "/assets/img/book_cover.png";
			},
		},
		watch: {
			displayDate1: function (val) {
				this.displayDate1 = val;
				this.homework_issue_date = moment(new Date(val)).format(
					"YYYY-MM-DD"
				);
			},
			displayDate2: function (val) {
				this.displayDate2 = val;
				this.homework_submission_date = moment(new Date(val)).format(
					"YYYY-MM-DD"
				);
			},
            displayDate3: function (val) {
				this.displayDate3 = val;
				this.homework_evaluation_date = moment(new Date(val)).format(
					"YYYY-MM-DD"
				);
			},
		},
		mounted() {
			if (this.$route.params.edit_id) {
				this.getEditData();
			}
			this.$parent.loadOtherScript();
			this.getClassSectionSubjectData();
			this.displayDate1 = moment(new Date()).format("DD-MMM-YYYY");
			this.displayDate2 = "";
			this.displayDate3 = "";
		},
		methods: {
              imageFileSelect(e) {
               console.log('SRC FILEGFDGFDGHFHF');
            const file = e.target.files[0];
            if (file) {
                this.srcImageFile = URL.createObjectURL(file);
                URL.revokeObjectURL(file);
                this.imageFilePath = file;
                 console.log('SRC FILE', this.srcImageFile);
                console.log('iage', this.imageFilePath);
            } else {
                this.srcImageFile = null;
                this.imageFilePath = null;
            }
        },
			isChecked(id) {
				var isSelected = false;
				this.editItem.homework_for.forEach((e) => {
					if (id == e.student_admission_id) {
						isSelected = true;
					}
				});
				return isSelected;
			},
			disabledAfterToday(date) {
				const today = new Date();
				today.setHours(0, 0, 0, 0);

				return date < today;
			},
            disabledBeforeDate1(date) {
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                return date < today;
            },

			// imageFileSelect(e) {
			// 	const inputFiles = e.target.files;
            //         console.log(inputFiles.length);
            //         Array.from(inputFiles).forEach((file) => {
            //             if(file){
            //                 this.imageFilePathList.push(file);+
            //                 this.imageNameList.push(file.name);
            //                 if(file.name.split(".")[1] == "jpg" || file.name.split(".")[1] == "jpeg" || file.name.split(".")[1] == "png" || file.name.split(".")[1] == "gif"){
            //                     this.imageExtention.push('image');
            //                 }else if(file.name.split(".")[1] == "doc" || file.name.split(".")[1] == "docx"){
            //                     this.imageExtention.push('document');
            //                 }else if(file.name.split(".")[1] == "pdf" ){
            //                     this.imageExtention.push('pdf');
            //                 }else if(file.name.split(".")[1] == "xls" || file.name.split(".")[1] == "xlsx"){
            //                     this.imageExtention.push('excel');
            //                 }else if(file.name.split(".")[1] == 'ppt' || file.name.split('.')[1] == 'pptx'){
            //                     this.imageExtention.push('power point');
            //                 }
            //             }
            //         });
			// 	this.errorItem.imageFilePath = "";
			// },
			isShowDate() {
				if ($("#checkDate").is(":checked")) {
					this.isShowing = true;
				} else {
					this.isShowing = false;
				}
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
				this.errorItem.section_list = "";
				this.getSelectedClassName();
				if (this.selectedClass == -1) {
					this.section_list = [];
					this.$refs.section_list_select2.updateList([]);
					this.subject_list = [];
					this.$refs.subject_list_select2.updateList([]);
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
						this.$refs.section_list_select2.updateList(
							data.school_class_sections
						);
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
						this.$refs.subject_list_select2.updateList(
							data.subject_list
						);
					}
				}
				this.getStudents();
			},
			async selectSection(val) {
				this.selectedSection = val;
				this.errorItem.section_list = "";
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
						this.$refs.subject_list_select2.updateList(
							data.subject_list
						);
					}
				}
				this.getStudents();
			},

			selectSubject(val) {
				this.selectedSubject = val;
				this.getSelectedSubjectName();
			},
			async getStudents() {
				var formData = new FormData();
				formData.append("class_id", this.selectedClass);
				formData.append("section_id", this.selectedSection);

				const res = await this.callApi(
					"post",
					`/api/school/students/student_admissions`,
					formData
				);
				// console.log("GET_STUDENT>>>", res);
				if (res.status == 200) {
					var data = res.data;
					if (data.status == "success") {
						this.studentList = data.student_admissions;
                        if(!this.$route.params.edit_id){
                            this.editItem.studentIds =[];
                            setTimeout(() => {
                                this.studentList.forEach((student,index) => {
                                    this.selectStudent(student.student_admission_id, index)
                                });
                            }, 500);
                        }
					} else {
						this.studentList = [];
					}
				}
			},
			async getEditData() {
				const res = await this.callApi(
					"get",
					`/api/school/homework/homework/edit/${this.$route.params.edit_id}`,
					null
				);
				if (res.status == 200) {
					var data = res.data;
					if (data.status == "success") {
						this.editItem = data.homework;
						this.selectedClass = data.homework.homework_class_id.value;
						this.selectedSection =
							data.homework.homework_section_id.value;
						this.selectedSubject =
							data.homework.homework_subject_id.value;
                        this.srcImageFile = data.homework.homework_document != ''  && data.homework.homework_document != null ? data.homework.homework_document : null ;
                        if(data.homework.homework_issue_date != null){
                            $('#checkDate').prop('checked' , true);
                            this.isShowing = true;
                        }
                        this.displayDate1 = data.homework.homework_issue_date != null ? moment(String(data.homework.homework_issue_date)).format('DD-MMM-YYYY') : null;
                        this.displayDate2 = data.homework.homework_submission_date != null ? moment(String(data.homework.homework_submission_date)).format('DD-MMM-YYYY') : null;
                        this.displayDate3 = moment(String(data.homework.homework_evaluation_date)).format('DD-MMM-YYYY');
                        this.homework_issue_date = moment(String( data.homework.homework_issue_date)).format("YYYY-MM-DD");
                        this.homework_submission_date = data.homework.homework_submission_date != null ? moment(String( data.homework.homework_submission_date)).format("YYYY-MM-DD") : null;

						await this.getStudents();
                        this.log(data.homework);
						this.editItem.studentIds = [];
						if (this.studentList && this.studentList.length ) {
							this.studentList.forEach((e, i) => {
								if (this.isChecked(e.student_admission_id)) {
									this.selectStudent(e.student_admission_id, i);
								}
							});
						}
					}
				}
			},
			async getClassSectionSubjectData() {
				const res = await this.callApi(
					"get",
					`/api/school/homework/homework/data_list`,
					null
				);
				console.log(res);
				if (res.status == 200) {
					var data = res.data;
					this.class_list = data.class_list;
					this.$refs.class_list_select2.updateList(data.class_list);
					this.$refs.class_list_select2.setSelected(this.selectedClass);

					this.section_list = data.section_list;
					this.$refs.section_list_select2.updateList(data.section_list);
					this.$refs.section_list_select2.setSelected(
						this.selectedSection
					);

					this.subject_list = data.subject_list;
					this.$refs.subject_list_select2.updateList(data.subject_list);
					this.$refs.subject_list_select2.setSelected(
						this.selectedSubject
					);
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
			selectStudent(studentId, index) {
				if (this.editItem.studentIds.includes(studentId)) {
					this.editItem.studentIds.splice(
						this.editItem.studentIds.indexOf(studentId),
						1
					);
					$("#studentChecked" + index).prop("checked", false);
				} else {
					this.editItem.studentIds.push(studentId);
					$("#studentChecked" + index).prop("checked", true);
				}
			},
            resetForm() {
                $('#checkDate').prop('checked', false);
                this.isShowing = false;
                this.editItem = {};
                this.srcImageFile = null;
                this.imageFilePath = null;
                this.studentIds = {};
                this.editItem.studentIds =[];
                this.displayDate1 = null;
                this.displayDate2 = null;
                this.displayDate3 = null;
                this.$refs.class_list_select2.setSelected("-1");
                this.$refs.subject_list_select2.setSelected("-1");
                this.$refs.section_list_select2.setSelected("-1");
            },
			async submitForm() {
				var isVaild = await this.validHomeworkForm();
				if (!isVaild) {
					return;
				}
                if(this.$route.params.edit_id){
                   toast = Toast.fire({
                        icon: "warning",
                        title: "Please Wait!! Updating Homework",
                        timer: 0,
                    });
                } else {
                    toast = Toast.fire({
                        icon: "warning",
                        title: "Please Wait!! Creating New Homework",
                        timer: 0,
                    });
                }
				var data = new FormData();
				data.append("homework_class_id", this.selectedClass);
				data.append("homework_section_id", this.selectedSection);
				data.append("homework_subject_id", this.selectedSubject);
				data.append("homework_title", this.editItem.homework_title);
				data.append("homework_for", JSON.stringify(this.editItem.studentIds));
				data.append(
					"homework_issue_date",
					this.isShowing ? this.homework_issue_date : ""
				);
				data.append(
					"homework_submission_date",
					this.isShowing
						? this.homework_submission_date != null ? this.homework_submission_date :''
						: ""
				);
                data.append(
					"homework_evaluation_date",
					this.isShowing
						? this.homework_evaluation_date != null ? this.homework_evaluation_date :''
						: ""
				);
                // this.imageNameList.forEach(element => {
                //     data.append("imageNameList[]", element);
                // });
                // this.imageFilePathList.forEach(ele =>{
                //     data.append('imagePathList[]' , ele)
                // });
                // this.imageExtention.forEach(e => {
                //     data.append('extensions[]' , e)
                // });
                console.log('iage', this.imageFilePath);
                data.append("image", this.imageFilePath ? this.imageFilePath : "");
				data.append(
					"homework_description",
					this.editItem.homework_description
						? this.editItem.homework_description
						: ""
				);
				let $url = "";
				if (this.$route.params.edit_id) {
					$url = `/api/school/homework/homework/update/${this.$route.params.edit_id}`;
				} else {
					$url = `/api/school/homework/homework/save`;
				}
				const res = await this.callApi("post", $url, data, "multipart");
				if (res.status == 200) {
					var data = res.data;
					if (data.status == "success") {
						this.resetForm();
						if (this.$route.params.edit_id) {
							toast = Toast.fire({
								icon: data.status,
								title: data.message,
								timer: 2500,
							});
							setTimeout(() => {
								this.$router.push("/school/homework");
							}, 2500);
						}
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
                        icon: "error",
                        title: "Something went wrong",
                        timer: 0,
                    });
                }
			},
			validHomeworkForm() {
				this.isFormValid = true;
				if (this.selectedClass == -1) {
					this.errorItem.class_list = "Class is required";
					this.isFormValid = false;
				} else {
					this.errorItem.class_list = "";
				}
				if (this.selectedSection == -1) {
					this.errorItem.section_list = "Section is required";
					this.isFormValid = false;
				} else {
					this.errorItem.section_list = "";
				}
				if (this.selectedSubject == -1) {
					this.errorItem.subject_list = "Subject is required";
					this.isFormValid = false;
				} else {
					this.errorItem.subject_list = "";
				}
				if (
					this.editItem.homework_title == null ||
					this.editItem.homework_title == ""
				) {
					this.errorItem.homework_title = "Homework Title is required";
					this.isFormValid = false;
				} else {
					this.errorItem.homework_title = "";
				}


				return this.isFormValid;
			},
		},
	};
</script>


<style scoped>
.imageContainer {
  width: 100%;
  height: 150px;
  border: grey dashed 2px;
  border-radius: 10px;
  position: relative;
  background: #ffffff;
  text-align: center;
  padding: 10px;
  margin: auto;
  margin-bottom: 40px;
  cursor: pointer;
}

.imageContainer img {
	/* width: 100%; */
	height: 100%;
}

.imageContainer input {
	width: 100%;
	height: 100%;
	opacity: 0;
	position: absolute;
	top: 0;
	left: 0;
}
.employee_avatar{
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
    bottom: 0;
    right: 0;
}
.displayContainer {
	box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
	border-radius: 3px;
	margin: 10px;
	display: flex;
	justify-content: space-between;
	align-items: center;
}
.displayContainer > div:first-child {
    width: 70%;
	display: flex;
	align-items: center;
}
.filename {
	display: inline-block;
	width: 80%;
	white-space: nowrap;
	overflow: hidden;
	align-self: center;
	text-overflow: ellipsis;
}
.upload-file{
    border:1px solid black;
}
</style>
