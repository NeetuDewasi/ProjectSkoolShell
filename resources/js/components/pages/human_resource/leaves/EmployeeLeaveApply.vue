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
                                        <label>Leave Type *</label>
                                        <Select2
                                            :items="leave_type_list" ref="leave_type_list" placeholder="--SELECT TYPE--"
                                            @change="selectLeaveType" />
                                    </div>
                                    <div class="col-md-6 col-12 form-group">
										<label>Leave Date *</label>
										<DatePicker
											format="DD-MMM-YYYY hh:mm A"
											value-type="format"
											type="datetime"
                                            range
											placeholder="Select a date"
											v-model="displayLeaveDate"
											:default-value="new Date()"
											class="
												form-control
												vue-datepicker
												my-0
											"
											:class="
												errorItem.leaveFromDate != ''
													? 'error-field'
													: ''
											"
										/>
										<span
											class="error-label"
											v-if="errorItem.leaveFromDate != ''"
											v-text="errorItem.leaveFromDate"
										></span>
									</div>
                                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                                        <label>Attach Document</label>
                                        <input type="file" placeholder="drag and drop a file here or click" class="form-control-file"
                                        ><div class="imageContainer">
                                                <img :src="selectFile" alt />
                                                <input type="file" accept="image/*" @change="imageFileSelect" />
                                                </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-12 form-group">
                                        <label>Reason</label>
                                        <textarea class="textarea form-control" rows="8" cols="10"
                                        v-model="editItem.reason"></textarea>
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
                displayLeaveDate: [new Date(), new Date()],
                errorItem: {},
                leave_type_list:[],
                editItem:{},
                imageFilePath: null,
                srcImageFile: null,
		    };
        },
        watch: {
        displayLeaveDate: function (val) {
            this.displayLeaveDate = val;
            this.editItem.leave_on = moment(new Date(val)).format('YYYY-MM-DD');
        }
    },
    computed: {
 selectFile: function () {
      return this.srcImageFile != null
        ? this.srcImageFile
        : "/assets/img/nb.jpg";
    },
    },
        mounted() {
           this.$parent.loadOtherScript();
           this.getLeaveTypes();
        },
        methods:{
            async getLeaveTypes(){
                const res = await this.callApi(
                "get",
                `/api/school/hr/leaves/getLeaveType`,
                null,
            );
            this.log('leaves',res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.leave_type_list = data.leave_type_list;
                    this.$refs.leave_type_list.updateList(data.leave_type_list);
                }
            }
            },
            selectLeaveType(val){
              this.leaveType_id = val;
            },
            imageFileSelect(e) {
            const file = e.target.files[0];
            if (file) {
                this.srcImageFile = URL.createObjectURL(file);
                URL.revokeObjectURL(file);
                this.imageFilePath = file;
            } else {
                this.srcImageFile = null;
                this.imageFilePath = null;
            }
        },
        async saveData() {
            var isVaild = await this.validContentForm();
            if (!isVaild) {
                return;
            }
            toast = Toast.fire({
                icon: "warning",
                title: "Please Wait!! Creating new Content",
                timer: 0,
            });
            var data = new FormData();
            data.append("leave_type_id",this.leaveType_id);
            data.append("published_at", this.editItem.leave_on && this.editItem.leave_on != null ? this.editItem.leave_on : '');
            data.append("reason", this.editItem.reason && this.editItem.reason != null ? this.editItem.reason : '');
            data.append("image", this.imageFilePath ? this.imageFilePath : "");
            let url = "";
            if(editedIndex != -1 ){
                url = `api/school/hr/leaves/update/${editedIndex}`;
            }else{
                url = `api/school/hr/leaves/update/save`;
            }
            const res = await this.callApi("post", url, data);

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {

                    this.resetForm();
                    toast = Toast.fire({
                        icon: "success",
                        title: data.message,
                        timer: 2500,
                    });
                } else {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
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


<style scoped>

</style>
