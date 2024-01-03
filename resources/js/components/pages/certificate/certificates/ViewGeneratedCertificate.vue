<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb pageTitle="Certificate" :breadcrumbList="breadcrumbList" />
            <div class="card row bg-image gutters-20" :style="`background-image: url(${certificate_list.certificate_background_image}); height: ${bgHeight} `">
                <div class="col-lg-12" >

                    <div class="">
                        <div class="mt-5">
                            <div class="card-header row px-3" :style="`height:${headerHeight}`">
                                <div class="col-3 text-center">
                                    {{certificate_list.certificate_header_left_text !=null ? certificate_list.certificate_header_left_text : '' }}
                                </div>
                                <div class="col-6 text-center">
                                    <h1>Certificate</h1>
                                    <h4>Of Completion</h4>
                                </div>
                                <div class="col-3 ">
                                    <span class="text-center">
                                        {{certificate_list.certificate_header_right_text !=null ? certificate_list.certificate_header_right_text : ''}}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" :style="`height:${bodyHeight};width:${bodyWidth}`" >
                            <div class="text-center">
                                 {{bodyText}}
                            </div>
                        </div>
                        <div class="card-footer" :style="`height:${footerHeight}`">
                            <div class="float-left">
                                {{certificate_list.certificate_footer_left_text !=null ? certificate_list.certificate_footer_left_text : '' }}
                            </div>
                            <div class="float-right">
                                {{certificate_list.certificate_footer_right_text !=null ? certificate_list.certificate_footer_right_text : '' }}
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

export default {

    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "admin.dashboard" },
                    name: "Home",
                },
                {
                    name: "Certificate View",
                },
            ],
            class_list: [],
            section_list: [],
            classId: -1,
            sectionId: -1,
            certificate_list: {},
            student:{},
            editedIndex: -1,
            editItem: {
                studentIds: [],
            },
            headerHeight : 'auto',
            bodyText:'',
            student_photo:'',
            bodyHeight:'auto',
            bodyWidth:'auto',
            bgHeight : '350px',
            footerHeight:'auto'
        };
    },

    mounted() {
        this.$parent.loadOtherScript();
        if(this.$route.params.certificate_id && this.$route.params.student_admission_id){
            this.student_admission_id = this.$route.params.student_admission_id;
            this.certificate_id = this.$route.params.certificate_id;
           this.getGeneratedCertificates();
        }else{
            this.$router.go(-1);
        }
    },
   methods:{
     async getGeneratedCertificates() {
            const res = await this.callApi(
                "get",
                `/api/school/certificate/student_certificate/${this.student_admission_id}/${this.certificate_id}`,
                null,
            );

            if (res.status == 200) {
                var data = res.data;
                 this.log('students',data.student);
                if (data.status == "success") {
                    this.certificate_list = data.certificateList;
                    this.student = data.student
                    this.bodyText = data.certificateList.certificate_body_text;
                    this.student_photo = this.student.student_student_photo
                    if(this.bodyText.includes('[name]')){
                        this.bodyText = this.bodyText.replace('[name]',this.getStudentFullName());
                    }
                    if(this.bodyText.includes('[class]')){
                        this.bodyText = this.bodyText.replace('[class]',this.student.school_class.class_name);
                    }
                    if(this.bodyText.includes('[section]')){
                        this.bodyText = this.bodyText.replace('[section]',this.student.school_section.section_name);
                    }
                    if(this.bodyText.includes('[DOB]')){
                        this.bodyText = this.bodyText.replace('[DOB]',this.student.student_date_of_birth);
                    }
                    if(this.bodyText.includes('[father first name]')){
                        this.bodyText = this.bodyText.replace('[father first name]',this.student_guardian.father_first_name)
                    }
                    if(this.bodyText.includes('[father_middle_name]')){
                        this.bodyText = this.bodyText.replace('[father middle name]',this.student_guardian.father_middle_name)
                    }
                    if(this.bodyText.includes('[father_last_name]')){
                        this.bodyText = this.bodyText.replace('[father last name]',this.student_guardian.father_last_name)
                    }
                    if(this.bodyText.includes('[mother first name]')){
                        this.bodyText = this.bodyText.replace('[mother first name]',this.student_guardian.mother_first_name)
                    }
                    if(this.bodyText.includes('[mother middle name]')){
                        this.bodyText = this.bodyText.replace('[mother middle name]',this.student_guardian.mother_middle_name)
                    }
                    if(this.bodyText.includes('[mother last name]')){
                        this.bodyText = this.bodyText.replace('[mother last name]',this.student_guardian.mother_last_name)
                    }
                    this.log(this.bodyText)
                }
            }
        },
        getStudentFullName(){
            return (this.student.student_first_name)  + ' ' + (this.student.student_middle_name != null ? this.student.student_middle_name : '') + ' ' + (this.student.student_last_name != null ? this.student.student_last_name : '');
        }
   },
};
</script>

<style>
.bg-image{
    background-repeat: no-repeat;
    /* background-size: contain; */
    background-size: 100% 100%;
    box-sizing:v-bind("bgHeight") !important ;
    height: v-bind(bgHeight) !important;

}
</style>
<style scoped>
.card-header{
    border: none !important;
    background-color: transparent !important;
    border-bottom:none !important;
}
.card-body{
    padding:0,0,0,0 !important;
    background-color: transparent !important;
    box-shadow:none !important;
}
.card-footer{
    border-top:none;
    background-color: transparent !important;

}
</style>
