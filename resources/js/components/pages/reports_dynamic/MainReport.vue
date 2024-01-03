<template>
    <div>
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start -->
            <Breadcrumb
                pageTitle="Reports"
                :breadcrumbList="breadcrumbList"
            />
            <!-- End Breadcubs Area -->
            <div class="row gutters-20">
                <!-- All Transport List Area Start Here -->
                <div class="col-12">
                    <div class="card height-auto">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Student Reports</h3>
                                </div>
                            </div>
                            <div class="row d-flex form group">
                                <div class="col-lg-4 col-12 form-group">
                                    <i class="fa fa-file"></i>
                                       Student Report
                                </div>
                                <div class="col-lg-4 col-12 form-group">
                                    <i class="fa fa-file"></i>
                                    <label>Class and Section Report </label>
                                </div>
                                <div class="col-lg-4 col-12 form-group">
                                    <i class="fa fa-file"></i>
                                    <label>Guardian Report </label>
                                </div>
                                <div class="col-lg-4 col-12 form-group">
                                    <i class="fa fa-file"></i>
                                    <label>Student History </label>
                                </div>
                                <div class="col-lg-4 col-12 form-group">
                                    <i class="fa fa-file"></i>
                                    <label>Student Login Credential </label>
                                </div>
                                <div class="col-lg-4 col-12 form-group">
                                    <i class="fa fa-file"></i>
                                    <label>Class Subject Report</label>
                                </div>
                                <div class="col-lg-4 col-12 form-group">
                                    <i class="fa fa-file"></i>
                                    <label>Admission Report </label>
                                </div>
                                <div class="col-lg-4 col-12 form-group">
                                    <i class="fa fa-file"></i>
                                    <label>Sibling Report </label>
                                </div>
                                <div class="col-lg-4 col-12 form-group">
                                    <i class="fa fa-file"></i>
                                    <label>Student Profile </label>
                                </div>
                                <div class="col-lg-4 col-12 form-group">
                                    <i class="fa fa-file"></i>
                                    <label>Homework Evaluation Report </label>
                                </div>
                                <div class="col-lg-4 col-12 form-group">
                                    <i class="fa fa-file"></i>
                                    <label>Student Gender Ratio Report </label>
                                </div>
                                <div class="col-lg-4 col-12 form-group">
                                    <i class="fa fa-file"></i>
                                    <label>Student Teacher Ratio Report </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
        			name: "StudentReport",
                }
                           ],
        		};
            },
    };
</script>

