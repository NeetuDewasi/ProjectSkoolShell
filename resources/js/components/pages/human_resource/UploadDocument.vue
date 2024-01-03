<template>
    <div>
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start -->
            <Breadcrumb pageTitle="Human Resource" :breadcrumbList="breadcrumbList" />
            <!-- End Breadcubs Area -->
            <!-- Add upload documents Area Start Here -->
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card height-auto">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Upload Documents</h3>
                                </div>
                            </div>
                            <form class="new-added-form" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-6 col-12 form-group">
                                        <label>Resume</label>
                                        <div class="image-select">
                                            <div class="img">
                                                <img src="/assets/img/image_upload.png">
                                            </div>
                                            <input type="file" placeholder="Drag and Drop a file here or click" name="" value="">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-12 form-group">
                                        <label>Joining Latter</label>
                                        <div class="image-select">
                                            <div class="img">
                                                <img src="/assets/img/image_upload.png">
                                            </div>
                                            <input type="file" placeholder="Drag and Drop a file here or click" name="" value="">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-12 form-group">
                                        <label>Other Documents</label>
                                        <div class="image-select">
                                            <div class="img">
                                                <img src="/assets/img/image_upload.png">
                                            </div>
                                            <input type="file" placeholder="Drag and Drop a file here or click" name="" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 form-group mg-t-8 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-gradient-yellow btn-lg btn-hover-bluedark mx-3 text-white" @click="$router.push({name: 'admin.hr.staff.socialMediaLink'})">
                                        Back
                                    </button>
                                    <button type="submit" class="btn btn-lg btn-gradient-yellow btn-hover-bluedark text-white">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Add Upload Documents Area End Here -->
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
						name: "Documents Upload",
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
.image-select{
            border-radius: 10px;
            box-shadow: 0 0 2px #aeaeae;
            position: relative;
            height: 120px;
        }
        .image-select .img{
            width: 100%;
            text-align: center;
        }
        .image-select .img img{
            width: 20%;
        }
        .image-select input{
            opacity: 0;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }
</style>
