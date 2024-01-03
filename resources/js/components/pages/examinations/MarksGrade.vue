<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb pageTitle="Marks Grade" :breadcrumbList="breadcrumbList" />
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card height-auto">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Select Criteria</h3>
                                </div>
                            </div>
                            <form class="mg-b-20">
                                <div class="row gutters-8">
                                    <div class="col-xl-6 col-lg-6 col-sm-4 col-12 form-group">
                                        <input type="text" placeholder="Search by Grade ..." class="form-control">
                                    </div>
                                    <div class="col-xl-6 col-lg-5 col-sm-5 col-12 form-group">
                                        <input type="text" placeholder="Search by Point ..." class="form-control">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-gradient-yellow btn-lg btn-hover-bluedark text-white">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </form>
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Exam Grade List</h3>
                                </div>
                                <div class="d-flex justify-content-end ">
                                    <button type="submit" class="btn btn-gradient-yellow btn-lg btn-hover-bluedark text-white"  @click="$router.push('add_grade')">
                                       <i class="fa fa-plus"></i> Add
                                    </button>
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
                                            <th>Grade Name</th>
                                            <th>Grade Point</th>
                                            <th>Percent From</th>
                                            <th>Percent Upto</th>
                                            <th>Comment</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <MarksGradeListItem :mark="markItem" v-for="(markItem, index) in marks" :key="index" />
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Exam Grade List Area End Here -->
            </div>
            <!-- Marks Grade Area End Here -->
            <Footer/>
        </div>
    </div>
</template>

<script>
    import MarksGradeListItem from "./MarksGradeListItem.vue";
    export default{
        components: {
			MarksGradeListItem,
		},
        data() {
			return {
				breadcrumbList: [
					{
						to: { name: "admin.dashboard" },
						name: "Home",
					},
					{
						name: "Marks Grade",
					},
				],
                marks: [
					{
                        id: "1",
                        name: "General",
                        grade: "A+",
						gradePoint: "4.50",
                        percentageFrom: "95.00",
                        percentageTo: "100.00",
                        comment: "Very Good!!!",
					},
                ],
		    };
        },
        mounted() {
           this.$parent.loadOtherScript();
        }
    };
</script>


<style scoped>

</style>
