<template>

    <div>
        <div class="dashboard-content-one">
            <Breadcrumb pageTitle="Exam List" :breadcrumbList="breadcrumbList" />
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card height-auto">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>All Exam List</h3>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table display data-table text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input checkAll">
                                                    <label class="form-check-label">ID</label>
                                                </div>
                                            </th>
                                            <th>Exam Name</th>
                                            <th>Subject</th>
                                            <th>Class</th>
                                            <th>Section</th>
                                            <th>Time</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <ExamListItem :exam="examItem" v-for="(examItem, index) in exams" :key="index" />
                                    </tbody>
                                </table>
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
	import ExamListItem from "./ExamListItem.vue";
	export default {
		components: {
			ExamListItem,
		},
		data() {
			return {
				breadcrumbList: [
					{
						to: { name: "admin.dashboard" },
						name: "Home",
					},
					{
						name: "Exam List",
					},
				],
				exams: [
					{
						id: "1",
						testname: "Class Test",
						subject: "Maths",
						class: "4",
						section: "A",
						time: "10.00 am -12.00 pm",
						date: "21/06/2022",
					},
				],
			};
		},
		mounted() {
			this.$parent.loadOtherScript();
		},
	};
</script>


<style scoped>
</style>
