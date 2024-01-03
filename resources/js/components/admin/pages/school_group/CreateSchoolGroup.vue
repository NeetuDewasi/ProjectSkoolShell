<template>
    <div class="dashboard-content-one">
        <Breadcrumb
            pageTitle="School Group "
            :breadcrumbList="breadcrumbList"
        />
        <div class="row gutters-20">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Create New School Group</h3>
                            </div>
                        </div>

                        <form class="new-added-form">
                            <div class="row">
                                <div
                                    class="col-xl-6 col-lg-6 col-12 form-group"
                                >
                                    <label>
                                        Group Name
                                        <strong class="text-danger">*</strong>
                                    </label>
                                    <input
                                        type="text"
                                        v-model="editItem.group_name"
                                        placeholder
                                        class="form-control"
                                        :class="
                                            errorItem.group_name != ''
                                                ? 'error-field'
                                                : ''
                                        "
                                        @keyup="
                                            editItem.group_name != ''
                                                ? (errorItem.group_name = '')
                                                : ''
                                        "
                                    />
                                    <span
                                        class="error-label"
                                        v-if="errorItem.group_name != ''"
                                        v-text="errorItem.group_name"
                                    ></span>
                                </div>

                                <div
                                    class="col-xl-6 col-lg-6 col-12 form-group"
                                >
                                    <label>
                                        Contact Person Name
                                        <strong class="text-danger">*</strong>
                                    </label>
                                    <input
                                        type="text"
                                        v-model="editItem.contact_person_name"
                                        placeholder
                                        class="form-control"
                                        :class="
                                            errorItem.contact_person_name != ''
                                                ? 'error-field'
                                                : ''
                                        "
                                        @keyup="
                                            editItem.contact_person_name != ''
                                                ? (errorItem.contact_person_name =
                                                      '')
                                                : ''
                                        "
                                    />
                                    <span
                                        class="error-label"
                                        v-if="
                                            errorItem.contact_person_name != ''
                                        "
                                        v-text="errorItem.contact_person_name"
                                    ></span>
                                </div>
                                <div
                                    class="col-xl-6 col-lg-6 col-12 form-group"
                                >
                                    <label>
                                        Mobile Number
                                        <strong class="text-danger">*</strong>
                                    </label>
                                    <input
                                        type="text"
                                        v-model="editItem.mobile_number"
                                        placeholder
                                        class="form-control"
                                    />
                                </div>
                                <div
                                    class="col-xl-6 col-lg-6 col-12 form-group"
                                >
                                    <label>
                                        Alternative Mobile Number
                                        <strong class="text-danger">*</strong>
                                    </label>
                                    <input
                                        type="text"
                                        v-model="editItem.alternative_mobile_number"
                                        placeholder
                                        class="form-control"
                                    />

                          
                                </div>
                                <div
                                    class="col-xl-6 col-lg-6 col-12 form-group"
                                >
                                    <label>
                                        Email Id
                                        <strong class="text-danger">*</strong>
                                    </label>
                                    <input
                                        type="text"
                                        v-model="editItem.email_id"
                                        placeholder
                                        class="form-control"
                                        :class="
                                            errorItem.email_id != ''
                                                ? 'error-field'
                                                : ''
                                        "
                                        @keyup="
                                            editItem.email_id != ''
                                                ? (errorItem.email_id = '')
                                                : ''
                                        "
                                    />
                                    <span
                                        class="error-label"
                                        v-if="errorItem.email_id != ''"
                                        v-text="errorItem.email_id"
                                    ></span>
                                </div>
                                <div
                                    class="col-xl-6 col-lg-6 col-12 form-group"
                                >
                                    <label>
                                        Alternative Email Id
                                        <strong class="text-danger">*</strong>
                                    </label>
                                    <input
                                        type="text"
                                        v-model="editItem.alternative_email_id"
                                        placeholder
                                        class="form-control"
                                    />
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12 form-group mb-5">
                                    <button
                                        type="button"
                                        class="btn-fill-md text-light shadow-dodger-blue bg-dodger-blue"
                                        @click.prevent="submitData()"
                                    >
                                        {{ formBtn }}
                                    </button>

                                    <button
                                        type="button"
                                        class="btn-fill-md text-light shadow-dodger-blue btn-gradient-yellow"
                                        @click.prevent="resetForm()"
                                    >
                                        {{ resetButton }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <Footer />
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
                    name: "School Group",
                },
            ],
            editItem: {},
            errorItem: {
                group_name: "",
                contact_person_name: "",
                mobile_number: "",
                email_id: "",
            },
            isFormValid: false,
            editedIndex: -1,
        };
    },
    computed: {
        formBtn: function () {
            return this.editedIndex === -1 ? "Save" : "Update";
        },
        resetButton: function () {
            return this.editedIndex === -1 ? "Reset" : "Cancel";
        },
    },
    mounted(){
        if(this.$route.params.edit_id){
            this.editedIndex = this.$route.params.edit_id;
            console.log('edit id',this.editedIndex);
            this.getEditItem();
        }
    },
    methods: {
       async submitData() {
            var isVaild = await this.validGroupForm();
            if (!isVaild) {
                return;
            }
            toast = Toast.fire({
                icon: "warning",
                title: "Please Wait!! Creating new Group",
                timer: 0,
            });
            var data = new FormData();
            data.append('group_name',this.editItem.group_name ? this.editItem.group_name : '');
            data.append('contact_person', this.editItem.contact_person_name ? this.editItem.contact_person_name : '');
            data.append('mobile_number', this.editItem.mobile_number ? this.editItem.mobile_number : '');
            data.append('alternative_mobile_number', this.editItem.alternative_mobile_number ? this.editItem.alternative_mobile_number : '');
            data.append('email_id', this.editItem.email_id ? this.editItem.email_id : '');
            data.append('alternative_email_id', this.editItem.alternative_email_id ? this.editItem.alternative_email_id : '');
            let url = "";
            if(this.editedIndex == -1){
                url = `/api/admin/school_group/save`
            }else {
                url= `/api/admin/school_group/update/${this.editedIndex}`
            }
            const res = await this.callApi("post", url, data);
            this.log('added dataa',res);
            if(res.status == 200){
                var data = res.data;
                if(data.status == 'success'){
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                    this.resetForm();
                    setTimeout(() => {
                        this.$router.push({
                            path: `/admin/school_group/list`,
                        });
                    }, 3000);
                }
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
        }
    },
            
        validGroupForm() {
            this.isFormValid = true;
            if (
                this.editItem.group_name == null ||
                this.editItem.group_name == ""
            ) {
                this.errorItem.group_name = "Group group_name is required";
                this.isFormValid = false;
            } else {
                this.errorItem.group_name = "";
            }
            if (
                this.editItem.contact_person_name == null ||
                this.editItem.contact_person_name == ""
            ) {
                this.errorItem.contact_person_name = "Contact Person Name is required";
                this.isFormValid = false;
            } else {
                this.errorItem.contact_person_name = "";
            }
            if (
                this.editItem.mobile_number == null ||
                this.editItem.mobile_number == ""
            ) {
                this.errorItem.mobile_number = "mobile_number is required";
                this.isFormValid = false;
            } else {
                this.errorItem.mobile_number = "";
            }
            if (
                this.editItem.email_id == null ||
                this.editItem.email_id == ""
            ) {
                this.errorItem.email_id = "email_id is required";
                this.isFormValid = false;
            } else {
                this.errorItem.email_id = "";
            }
            return this.isFormValid;
        },
       async getEditItem(){
        const res = await this.callApi(
            "get",
            `/api/admin/school_group/edit/${this.editedIndex}`,null
        );
        this.log('editd ddaaataaa',this.res);
        if(res.status==200){
            var data = res.data;
            if(data.status == 'success'){
                this.editItem = data.group;
            }
        }
       },
        resetForm() {
            this.editItem = {};
            this.editedIndex = -1;
        },
    },
};
</script>
