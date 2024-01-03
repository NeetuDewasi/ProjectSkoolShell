<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb pageTitle="Assign Subjects" :breadcrumbList="breadcrumbList" />
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="row d-flex">
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="heading-layout1">
                                        <div class="item-title">
                                            <h3>Select Criteria</h3>
                                        </div>
                                    </div>

                                    <div class="new-added-form">

                                            <div class="col-12 form-group">
                                                <label>Select Class
                                                    <strong class="text-danger">*</strong></label>
                                                <Select2 ref="class_list" :items="classes"
                                                    placeholder="--SELECT A CLASS--" @change="selectClass" :class="
                                                    	classError != ''
                                                    		? 'error-field'
                                                    		: ''
                                                    " />
                                                <span class="error-label" v-if="classError != ''"
                                                    v-text="classError"></span>
                                            </div>
                                            <div class="col-12 form-group">
                                                <label>Select Section
                                                    <span class="text-danger">*</span></label>
                                                <Select2 ref="section_list" :items="sections"
                                                    placeholder="--SELECT A CLASS--" @change="selectSection" :class="
                                                    	sectionError != ''
                                                    		? 'error-field'
                                                    		: ''
                                                    " />
                                                <span class="error-label" v-if="sectionError != ''"
                                                    v-text="sectionError"></span>
                                            </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-9">
                            <div class="card">
                                <div class="card-header">
                                    <div class="
									heading-layout1
									d-flex
									justify-content-between
								">
                                        <div class="item-title">
                                            <h3>Assign subject period</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div v-if="classPeriods.length">
                                        <div class="table table-responsive text-center">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <!-- <th>select Previous Day</th> -->
                                                        <th>Day</th>
                                                        <th v-for="period in classPeriods" :key="period.period_id">
                                                            <div>
                                                                {{ period.period_name }}
                                                            </div>
                                                            <div>
                                                                <small>
                                                                    ({{
                                                                    period.period_start
                                                                    | formatTime
                                                                    }}-{{
                                                                    period.period_end
                                                                    | formatTime
                                                                    }})
                                                                </small>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(day, dayIndex) in days" :key="day">
                                                        <!-- <th>
													<select
														class="day-subject"
														@change="
															sameAs(dayIndex)
														"
														v-model="
															daysAs.days[
																dayIndex
															]
														"
													>
														<option value="-1">
															--SELECT DAY--
														</option>
														<option
															v-for="(
																pd, pdIndex
															) in days"
															:key="pdIndex"
															:value="pd"
														>
															{{ pd }}
														</option>
													</select>
												</th> -->
                                                        <th>{{ day }}</th>
                                                        <td class="form-group" v-for="(
														period, ind
													) in classPeriods" :key="period.period_id">
                                                            <select class="day-subject form-control" v-model="
                                                            	editItem
                                                            		.daysSubjects[
                                                            		dayIndex
                                                            	][ind]
                                                            " @change="
                                                    	editItem
                                                    		.subjectTeacher[
                                                    		dayIndex
                                                    	][ind] == null
                                                    ">
                                                                <option value="null">
                                                                    --SELECT SUBJECT--
                                                                </option>
                                                                <option v-for="subject in class_subjects" :key="
                                                                	subject.subject_id
                                                                " :value="subject">
                                                                    {{
                                                                    subject.subject_name
                                                                    }}
                                                                </option>
                                                            </select>
                                                            <br />
                                                            <select v-if="
                                                            	editItem
                                                            		.daysSubjects[
                                                            		dayIndex
                                                            	][ind] != null &&
                                                            	editItem
                                                            		.daysSubjects[
                                                            		dayIndex
                                                            	][ind] != 'null' &&
                                                            	editItem
                                                            		.daysSubjects[
                                                            		dayIndex
                                                            	][ind] != ''
                                                            " :class="
                                                    	`subject_teacher`[
                                                    		dayIndex
                                                    	][ind]
                                                    " v-model="
															editItem
																.subjectTeacher[
																dayIndex
															][ind]
														" class="form-control">
                                                                <option value="null">
                                                                    --SELECT TEACHER--
                                                                </option>
                                                                <option v-for="teacher in editItem
                                                                	.daysSubjects[
                                                                	dayIndex
                                                                ][ind].teachers" :key="
                                                        	teacher.teacher_id
                                                        " :value="
																teacher.teacher_id
															">
                                                                    {{
                                                                    teacher.teacher_name
                                                                    }}
                                                                </option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="
										btn btn-info
										w-100
										text-center
										f_s_18
										mt-4
									" v-if="!isSaving" @click="submitForm">
                                            <span>Update</span>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <LottieAnimation :width="200" :height="200" path="assets/lottie/no_data.json" />
                                    </div>
                                </div>
                            </div>
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
                    name: "Class Assign Subjects",
                },
            ],
            isStudentPhoto: false,
            noData: false,
            sections: [],
            classes: [],
            editItem: {},
            class_sections: [],
            selectedClassId: -1,
            sectionId: -1,
            classError: "",
            sectionError: "",
            subjects: [],
            classPeriods: [],
            class_subjects: [],
            days: [
                "Monday",
                "Tuesday",
                "Wednesday",
                "Thursday",
                "Friday",
                "Saturday",
            ],
            daysAs: {
                days: [],
            },
            teachers: [],
            assignedSubjects: [],
            assignedTeachers: [],
            isSaving: false,
        };
    },

    mounted() {
        this.$parent.loadOtherScript();
    },
    created() {
        toast = Toast.fire({
            icon: "warning",
            title: "Loading data..",
            timer: 0,
        });
        this.showData();
    },
    methods: {
        async showData() {
            this.isLoaded = false;
            const res = await this.callApi(
                "get",
                `/api/school/academics/assign/classes/periods`,
                null
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.classes = data.school_classes;
                    this.$refs.class_list.updateList(data.school_classes);
                    this.$refs.class_list.setSelected(
                        data.school_classes[0].value
                    );
                    this.selectClass(data.school_classes[0].value);
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
            toast.close();
        },
        async getPeriods() {
            this.classPeriods = [];
            var formData = new FormData();
            formData.append("class", this.selectedClassId);
            formData.append("section", this.sectionId);
            const res = await this.callApi(
                "post",
                `/api/school/academics/periods/periods`,
                formData
            );
            this.log('periods',res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.classPeriods = data.periods;
                    var subject = [];
                    this.classPeriods.forEach((element) => {
                        subject.push(null);
                    });

                    var daySubs = [];
                    var ds = [];
                    this.days.forEach((d) => {
                        daySubs.push(JSON.parse(JSON.stringify(subject)));
                        ds.push("-1");
                    });
                    this.editItem = {
                        daysSubjects: daySubs,
                        subjectTeacher: JSON.parse(JSON.stringify(daySubs)),
                    };
                    this.daysAs = {
                        days: ds,
                    };
                } else {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                    this.noData = true;
                }
            } else {
                toast = Toast.fire({
                    icon: data.status,
                    title: data.message,
                    timer: 2500,
                });
            }
            this.isLoaded = true;
            toast.close();
        },
        selectClass(val) {
            if (this.classPeriods && this.classPeriods.length) {
                this.classPeriods = [];
            }
            this.selectedClassId = val;
            this.classError = "";
            this.getSections(val);
            this.sections = [];
            this.$refs.section_list.setSelected(-1);
        },
        async getSections(val) {
            this.classError = "";
            const res = await this.callApi(
                "get",
                `/api/school/class/sections/${val}`,
                null
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.sections = data.school_class_sections;
                    this.$refs.section_list.updateList(
                        data.school_class_sections
                    );
                    if (this.sections.length) {
                        this.$refs.section_list.setSelected(
                            data.school_class_sections[0].value
                        );
                        this.sectionId = data.school_class_sections[0].value;
                        this.selectSection(data.school_class_sections[0].value);
                        this.getPeriods();
                    }
                } else {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                    this.noData = true;
                }
            } else {
                toast = Toast.fire({
                    icon: data.status,
                    title: data.message,
                    timer: 2500,
                });
            }
        },
        async selectSection(val) {
            this.sectionId = val;
            await this.getPeriods();
            if (this.classPeriods.length) {
                await this.getClassSectionSubject();
            }
            this.sectionError = "";
        },
        async getClassSectionSubject() {
            var formData = new FormData();
            formData.append("class", this.selectedClassId);
            formData.append("section", this.sectionId);
            const res = await this.callApi(
                "post",
                `/api/school/academics/assign/class_sections/subjects/section/class`,
                formData
            );
            console.log('Class Section SUbjects',res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.assignedSubjects = data.assign_subjects;
                    this.assignedTeachers = data.assign_teachers;
                    this.class_subjects = data.school_class_section_subjects;
                    if (this.assignedSubjects && this.assignedSubjects.length) {
                        var i = 0;
                        this.days.forEach((element, index) => {
                            this.classPeriods.forEach((currentItem, ind) => {
                                this.editItem.daysSubjects[index][ind] =
                                    this.assignedSubjects[i];
                                this.editItem.subjectTeacher[index][ind] =
                                    this.assignedTeachers[i].teacher_id;
                                i++;
                            });
                        });
                    }
                } else {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                    this.noData = true;
                }
            } else {
                toast = Toast.fire({
                    icon: data.status,
                    title: data.message,
                    timer: 2500,
                });
            }
        },
        validForm() {
            var isValidate = false;
            if (this.selectedClassId == -1) {
                this.classError = "class is required";
                isValidate = false;
            } else {
                isValidate = true;
            }
            if (this.sectionId == -1) {
                this.sectionError = "section is required";
                isValidate = false;
            } else {
                isValidate = true;
            }
            return isValidate;
        },
        async submitForm() {
            var isValid = await this.validForm();
            if (!isValid) {
                return;
            }
            toast = Toast.fire({
                icon: "warning",
                title: "Saving Data ! Pleace wait",
                timer: 0,
            });
            this.isSaving = true;
            var formData = new FormData();
            formData.append("class", this.selectedClassId);
            formData.append("section", this.sectionId);
            // this.log("subject_list",JSON.stringify(this.editItem.daysSubjects));

            // this.log(
            //     "teacher_list",
            //     JSON.stringify(this.editItem.subjectTeacher));
            formData.append(
                "subject_list",
                JSON.stringify(this.editItem.daysSubjects)
            );
            formData.append(
                "teacher_list",
                JSON.stringify(this.editItem.subjectTeacher)
            );
            this.classPeriods.forEach((element, index) => {
                this.log("periods[]", element.period_id);
                formData.append("periods[]", element.period_id);
            });
            this.days.forEach((day) => {
                this.log("days[]", day);
                formData.append("days[]", day);
            });
            const res = await this.callApi(
                "post",
                "/api/school/academics/assign/class/time_table",
                formData
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    toast = Toast.fire({
                        icon: "success",
                        title: data.message,
                        timer: 2500,
                    });
                } else {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 0,
                    });
                }
                 toast.close();
            }
            this.isSaving = false;
        },

        sameAs(day) {
            let sourceDay = this.days.indexOf(this.daysAs.days[day]);
            if (sourceDay != -1) {
                this.editItem.daysSubjects[day] =
                    this.editItem.daysSubjects[sourceDay];
            }
        },
    },
};
</script>
