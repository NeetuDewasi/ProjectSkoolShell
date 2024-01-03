<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb pageTitle="Add Marks Grade" :breadcrumbList="breadcrumbList" />
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card height-auto">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Add New Grade</h3>
                                </div>
                            </div>
                            <form class="new-added-form">
                                <div class="row gutters-20">
                                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                                        <label>Exam Name</label>
                                       <Select2
                                            :item="exam_nameList" ref="exam_nameList"
                                        />
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                                        <label>Grade Name</label>
                                        <input type="text" placeholder=""
                                        class="form-control" v-model="editItem.grade_name">
                                    </div>
                                    <div class="col--xl-6 col-lg-6 col-12 form-group">
                                        <label>Grade Point</label>
                                       <Select2
                                            :item="h"
                                        />
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                                        <label>Percentage From</label>
                                        <input type="text" placeholder=""
                                        v-model = "editItem.percentFrom" class="form-control">
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                                        <label>Percentage Upto</label>
                                        <input type="text" placeholder=""
                                        v-model="editItem.percentUpto" class="form-control">
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                                        <label>Comments</label>
                                        <textarea class="textarea form-control" name="message" id="form-message"
                                        v-model="editItem.comments" cols="" rows=""></textarea>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mg-t-13">
                                    <button type="submit" class="btn btn-lg btn-gradient-yellow btn-hover-bluedark mx-3 text-white" @click="$router.push({name: 'admin.examinations.marks'})">
                                            Save
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
            <Footer/>
        </div>
    </div>
</template>

<script>
    var toast;
    export default{
        data() {
			return {
				breadcrumbList: [
					{
						to: { name: "admin.dashboard" },
						name: "Home",
					},
					{
						name: "Add Marks Grade",
					},
				],
                    exam_nameList:[],
		    };
        },
        mounted() {
           this.$parent.loadOtherScript();
           this.getExamName();
        },
        methods:{
            async getExamName(){
              const res = await this.callApi(
                "get",
                `/api/school/examinations/exam_schedule/exam_names`,
                null,
            );
            this.log('Dropdown',res);
            if(res.status == 200){
                var data = res.data;
                if(data.status=="success"){
                    this.exam_nameList = data.exam_names;
                    this.$refs.exam_nameList.updateList(this.exam_names);
                }
            }
        },
    },
    };
</script>

<style scoped>

</style>
