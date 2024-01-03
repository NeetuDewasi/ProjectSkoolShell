<template>
    <div>
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start -->
            <Breadcrumb pageTitle="Leave Request" :breadcrumbList="breadcrumbList" />
            <!-- End Breadcubs Area -->
            <!-- Leave Request Area Start Here -->
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card height-auto">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Leave Request Form</h3>
                                </div>
                            </div>
                            <form class="new-added-form" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                                        <label>Apply Date</label>
                                        <input type="text" placeholder="dd/mm/yyyy" class="form-control air-datepicker">
                                        <i class="far fa-calendar-alt"></i>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                                        <label>Leave Type *</label>
                                        <Select2
                                            :item="[{value: 0, name: 'Select'}, {value: 1, name: '1'}, {value: 2, name: '2'}]"
                                        />
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                                        <label>Leave Date</label>
                                        <div class="input-group">
                                            <span class="far fa-calendar-alt input-group-text display-1 fs-1 p-4"></span>
                                            <input type="text" class="form-control" placeholder="dd/mm/yyyy" aria-label="date" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                                        <label>Attach Document</label>
                                        <input type="file" placeholder="drag and drop a file here or click" class="form-control-file" name="file" id="form-file">
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-12 form-group">
                                        <label>Reason</label>
                                        <textarea class="textarea form-control" name="" id="" rows="8" cols="10" ></textarea>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-5 ">
                                    <button type="submit" class="btn btn-lg btn-gradient-yellow btn-hover-bluedark mx-3 text-white">
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
            <!-- Leave Request Form Area End Here -->
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
						name: "Leave Request",
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
