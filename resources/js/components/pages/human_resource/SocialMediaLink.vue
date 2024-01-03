<template>
    <div>
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start -->
            <Breadcrumb pageTitle="Human Resource" :breadcrumbList="breadcrumbList" />
            <!-- End Breadcubs Area -->
            <!-- Add Social Media Links Area Start Here -->
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card height-auto">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Social Media Links</h3>
                                </div>
                            </div>
                            <form class="new-added-form" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                                        <label>Facebook URL</label>
                                        <input type="text" placeholder="" class="form-control">
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                                        <label>Twitter URL</label>
                                        <input type="text" placeholder="" class="form-control">
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                                        <label>Linkedin URL</label>
                                        <input type="text" placeholder="" class="form-control">
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                                        <label>Instagram URL</label>
                                        <input type="text" placeholder="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12 form-group mg-t-8 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-gradient-yellow btn-lg btn-hover-bluedark mx-3 text-white" @click="$router.push({name: 'admin.hr.staff.bankDetailForm'})">
                                        Back
                                    </button>
                                    <button type="submit" class="btn btn-lg btn-gradient-yellow btn-hover-bluedark text-white" @click="$router.push({name: 'admin.hr.staff.uploadDocument'})">
                                        Save And Next
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Add Social Media Links Area End Here -->
            <Footer/>
        </div>
    </div>
</template>

<script>
    // import { defineComponent } from '@vue/composition-api'
    export default{
        data() {
			return {
				breadcrumbList: [
					{
						to: { name: "admin.dashboard" },
						name: "Home",
					},
                    {
						name: "Staff",
					},
                    {
                        to: {name: "admin.hr.add_staff"},
						name: "Staff Detial",
					},
                    {
						name: "Social Media Information",
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
    .add-more{
        background: #f0f1f3;
        width: 100%;
    }
</style>
