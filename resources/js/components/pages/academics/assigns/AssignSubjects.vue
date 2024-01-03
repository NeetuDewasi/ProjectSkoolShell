<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb pageTitle="Assign Subjects" :breadcrumbList="breadcrumbList" />
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="row d-flex">
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="heading-layout1">
                                        <div class="item-title">
                                            <h3>Select Criteria</h3>
                                        </div>
                                    </div>

                                    <div class="new-added-form">
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label>Select Class
                                                    <strong class="text-danger">*</strong></label>
                                                <Select2 ref="class_list" :items="classes"
                                                    placeholder="--SELECT A CLASS--" @change="selectClass" />
                                                <span class="error-label" v-if="classError != ''"
                                                    v-text="classError"></span>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label>Select Section
                                                    <span class="text-danger">*</span></label>
                                                <Select2 ref="section_list" :items="sections"
                                                    placeholder="--SELECT A SECTION--" @change="selectSection" />
                                                <span class="error-label" v-if="sectionError != ''"
                                                    v-text="sectionError"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-8">
                            <div class="card">
                                <div class="card-header">
                                    <div class="
									heading-layout1
									d-flex
									justify-content-between
								">
                                        <div class="item-title">
                                            <h3>Assign Subject</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mt-5">
                                        <div class="
										btn
										items items-name
										rounded-pill
										shadow
										p-3
										m-4
									" v-for="(subject, index) in subjects" :key="index" @click="updateSection(subject)" :class="
										isSelected(subject) ? 'bg-selected' : ''
									">
                                            {{ subject.subject_name }}
                                        </div>
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
            sections: [],
            classes: [],
            editItem: {},
            class_sections: [],
            selectedClassId: -1,
            sectionId: -1,
            classError: "",
            sectionError: "",
            subjects: [],
            class_subjects: [],
            oldClassSubject: [],
        };
    },

    mounted() {
        this.$parent.loadOtherScript();
    },
    created() {
        this.showData();
        toast = Toast.fire({
            icon: "warning",
            title: "Loading data..",
            timer: 0,
        });
       
    },
    methods: {
        async showData() {
            this.isLoaded = false;
            const res = await this.callApi(
                "get",
                `/api/school/academics/assign/classes`,
                null
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.classes = data.school_classes;
                    this.subjects = data.subjects;
                    this.log('classes',this.classes);
                    this.$refs.class_list.updateList(data.school_classes);
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
            this.selectedClassId = val;
            this.classError = "";
            this.sectionId = -1;
            this.getSections(val);
            this.$refs.section_list.updateList([]);
            this.$refs.section_list.setSelected(-1);
            this.sections = [];
            this.class_subjects = [];
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
        selectSection(val) {
            this.sectionId = val;
            this.getClassSectionSubject(val, this.selectedClassId);
            this.sectionError = "";
        },
        async getClassSectionSubject(sectionId, classId) {
            var formData = new FormData();
            formData.append("class", this.selectedClassId);
            formData.append("section", this.sectionId);
            this.log('Class Section Subjects',res);
            const res = await this.callApi(
                "post",
                `/api/school/academics/assign/class_sections/subjects/section/class`,
                formData
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.class_subjects = data.school_class_section_subjects;
                    this.oldClassSubject = this.class_subjects;
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
        isSelected(mySubject) {
            var selected = false;
            if (this.sectionId !== -1) {
                if (this.class_subjects.length) {
                    this.class_subjects.forEach((subject) => {
                        if (subject.subject_id == mySubject.subject_id) {
                            selected = true;
                            return true;
                        }
                    });
                }
            }
            return selected;
        },
        async updateSection(mySubject) {
            var selectedIndex = -1;
            if (this.class_subjects.length) {
                this.class_subjects.forEach((subject, index) => {
                    if (subject.subject_id == mySubject.subject_id) {
                        selectedIndex = index;
                        return;
                    }
                });
            }

            if (selectedIndex !== -1) {
                this.class_subjects.splice(selectedIndex, 1);
            } else {
                this.class_subjects.push(mySubject);
            }

            if (this.selectedClassId === -1) {
                this.classError = "class is required";
                return;
            }
            if (this.sectionId === -1) {
                this.sectionError = "section is required";
                return;
            }
            var subjectIds = [];
            this.class_subjects.forEach((subject) => {
                subjectIds.push(subject.subject_id);
            });
            var oldClassSubjectIds = [];
            this.oldClassSubject.forEach((element) => {
                oldClassSubjectIds.push(element.subject_id);
            });

            var formData = new FormData();
            formData.append("subject_ids[]", subjectIds);
            formData.append("oldClassSubjectIds[]", oldClassSubjectIds);
            const res = await this.callApi(
                "post",
                `/api/school/academics/assign/class_section/subject/${this.selectedClassId}/${this.sectionId}`,
                formData
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
    },
};
</script>

