<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb pageTitle="Assign Class Section " :breadcrumbList="breadcrumbList" />
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="row d-flex">
                        <div class="col-4">
                            <div class="card">
                                <div class="card-header">
                                    <div class="item-title">
                                        <h3>Assign Class Section</h3>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="new-added-form">
                                        <div class="col form-group">
                                            <label>Select Class
                                                <strong class="text-danger">*</strong>
                                            </label>
                                            <Select2 ref="class_list" :items="classes" placeholder="--SELECT A CLASS--"
                                                @change="selectClass" />
                                            <span class="error-label" v-if="classError != ''"
                                                v-text="classError"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="item-title">
                                        <div class="text-muted">
                                            <h3>Sections</h3>
                                            <div>click on section then assign</div>
                                        </div>
                                    </div>
                                    <div class="mt-5">
                                        <div class="
										items items-name
										rounded-pill
										btn
										shadow
										p-3
										m-4
									" v-for="(section, index) in sections" :key="index" @click="updateSection(section)" :class="
										isSelected(section) ? 'bg-selected' : ''
									">
                                            {{ section.section_name }}
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
                    name: "Assign Class Section",
                },
            ],
            isStudentPhoto: false,
            isLoaded: false,
            noData: false,
            sections: [],
            classes: [],
            editItem: {},
            class_sections: [],
            selectedClassId: -1,
            classError: "",
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
                `/api/school/academics/assign_class_section`,
                null
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.sections = data.school_sections;
                    this.classes = data.school_classes;
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
            this.class_sections = [];
            if (this.selectedClassId != -1) {
                this.getSections(val);
            }
        },
        async getSections(val) {
            const res = await this.callApi(
                "get",
                `/api/school/academics/assign_class_section/${val}`,
                null
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.class_sections = data.school_class_sections;
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
        isSelected(mySection) {
            var selected = false;
            if (this.class_sections) {
                this.class_sections.forEach((section) => {
                    if (section.section_id == mySection.section_id) {
                        selected = true;
                        return true;
                    }
                });
            }
            return selected;
        },

        async updateSection(mySection) {
            var selectedIndex = -1;
            if (this.class_sections) {
                this.class_sections.forEach((section, index) => {
                    if (section.section_id == mySection.section_id) {
                        selectedIndex = index;
                        return;
                    }
                });
            }

            if (selectedIndex !== -1) {
                this.class_sections.splice(selectedIndex, 1);
            } else {
                this.class_sections.push(mySection);
            }

            if (this.selectedClassId === -1) {
                this.classError = "class is required";
                return;
            }
            var sectionIds = [];
            this.class_sections.forEach((section) => {
                sectionIds.push(section.section_id);
            });
            var formData = new FormData();
            formData.append("section_ids", sectionIds);
            const res = await this.callApi(
                "post",
                `/api/school/academics/assign/class_section/${this.selectedClassId}`,
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
