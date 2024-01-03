<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb pageTitle="Exam Schedule" :breadcrumbList="breadcrumbList" />
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card height-auto">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Add New Exam</h3>
                                </div>
                            </div>
                            <form class="new-added-form">
                                <div class="row">
                                    <div class="col-lg-6 col-12 form-group">
                                        <label>Exam Name</label>
                                        <input type="text" placeholder="" class="form-control"
                                        v-model="editItem.exam_name">
                                    </div>

                                    <div class="col-lg-6 col-12 form-group">
                                        <label>Select Class *</label>
                                        <Select2 ref="class_list" placeholder="--SELECT A CLASS--"
                                                    :items="class_list" @change="selectClass" />
                                    </div>
                                    <div class=" col-lg-6 col-12 form-group">
                                        <label>Select Section</label>
                                       <Select2 ref="section_list" :items="section_list"
                                                    @change="selectSection" />
                                    </div>
                                    <div class=" col-lg-6 col-12 form-group">
                                        <label>Select Time</label>
                                        <input type="text" placeholder="" class="form-control"
                                        >
                                        <i class="far fa-clock"></i>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                                        <label>Select Date</label>
                                        <input type="text" placeholder="dd/mm/yyyy" class="form-control air-datepicker"
                                        v-model="editItem.exam_date">
                                        <i class="far fa-calendar-alt"></i>
                                    </div>

                                </div>
                                <div class="d-flex justify-content-end">
                                   <button type="submit" class="btn btn-lg btn-gradient-yellow btn-hover-bluedark mx-3 text-white"
                                   @click.prevent="submitData()">
                                    </button>
                                    <button type="reset" class="btn btn-lg bg-blue-dark btn-hover-yellow text-white">
                                        Reset
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
	export default {
		data() {
			return {
				breadcrumbList: [
					{
						to: { name: "admin.dashboard" },
						name: "Home",
					},
					{
						name: "Exam Schedule",
					},
				],
                editItem:{

                },
			};
		},
        computed:{
             formBtn: function () {
            return this.editedIndex !== -1 ? 'Update' : 'Save';
        },
        },
		mounted() {
			this.$parent.loadOtherScript();
		},
        methods:{
            async getClassList() {
                const res = await this.callApi(
                    "get",
                    `/api/school/examinations/exam_group/getExamGroup`,
                    null,
                );
                if (res.status == 200) {
                    var data = res.data;
                    if (data.status == "success") {
                        this.examgroup_list = data.examGroup_list;
                        this.$refs.examgroup_list.updateList(data.examGroup_list);
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
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.sections = data.school_class_sections;
                    this.$refs.section_list.updateList(data.school_class_sections);
                    if (this.editedIndex !== -1) {
                        this.$refs.section_list.setSelected(this.sectionId);
                    }
                }
            }
        },
        selectSection(val) {
            this.sectionId = val;
        },
        getSubjectData(subjectId, index) {
			this.exam_subjectIds[index] = subjectId;
        },
        },
	};
</script>


<style scoped>
</style>
