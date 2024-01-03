<template>
  <div>
    <div class="dashboard-content-one">
      <Breadcrumb pageTitle="Id Card" :breadcrumbList="breadcrumbList" />
      <div class="row gutters-20">
        <div>
          <div
            class="modal-content"
          >
            <div class="modal-body" id="card_detail" style="border: 5px solid #007bff;">
              <div class="modal-inner-content">
                <table cellpadding="0" cellspacing="0" width="100%" >
                  <tbody>
                    <tr>
                      <td
                        valign="top"
                        style="background: #007bff; text-align: center;color: #fff;padding: 0;min-height: 110px;display: block;"
                      >
                        <table cellpadding="0" cellspacing="0" width="100%">
                          <tbody class="mb-2">
                            <tr>
                              <td valign="top">
                                <div style="color: #fff;position: relative; z-index: 1;">
                                  <div class="col-12 text-center logo">
                                    <img
                                      :src="id_card_list.idCard_logo"
                                      style="height: 50px; width:60px;"
                                    />
                                  </div>
                                  <span class="sttext1">{{id_card_list.id_school_name}}</span>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td
                                valign="top"
                                style="color: #fff"
                              >{{id_card_list.address_phone_email}}</td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td valign="top" style="background: #fff">
                        <table
                          cellpadding="0"
                          cellspacing="0"
                          width="100%"
                          style="margin-top: -40px; position: relative;z-index: 1;"
                        >
                          <tbody>
                            <tr>
                              <td valign="top" style="text-align: center;">
                                <div class="stimg center-block mt-5">
                                  <img
                                    :src="students.student_student_photo"
                                    class="img-responsive img-circles block-center"
                                    style="border:3px solid #000000"
                                  />
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td valign="top" style="text-align: center;">
                                <h4
                                  style="margin:0; text-transform: uppercase;font-weight: bold; margin-top: 10px;"
                                >
                                  {{ students.student_first_name != null ?
                                  students.student_first_name : ""}}
                                  {{ students.student_middle_name != null ?
                                  students.student_middle_name : ""}}
                                  {{ students.student_last_name != null ?
                                  students.student_last_name : ""}}
                                </h4>
                                <p style="font-size: 15px;color: #9b1818;"></p>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td valign="top">
                        <table
                          cellpadding="0"
                          width="90%"
                          align="center"
                          style="background: #fff;padding: 20px 20px;display: block;width: 90%; margin:0 auto"
                        >
                          <tbody>
                            <tr style="border: 2px solid #000000:">
                              <td valign="top">
                                <ul class="vertlist text-center">
                                  <li>
                                    Admission Number :
                                    <span>
                                      {{students.student_admission_number != null ?
                                      students.student_admission_number : ""}}
                                    </span>
                                  </li>
                                  <li>
                                    Class :

                                    <span>
                                      {{students.school_class && students.school_class.class_name != null ? students.school_class.class_name : ''}}
                                      {{students.school_section && students.school_section.section_name != null ? students.school_section.section_name : ''}}
                                    </span>



                                  </li>

                                  <li>
                                    Father's Name :
                                    <span>{{ students.student_guardian && students.student_guardian.father.first_name != null ? students.student_guardian.father.first_name : ''}}
                                      {{students.student_guardian && students.student_guardian.father.last_name != null ?
                                    students.student_guardian.father.last_name : ''}}</span>
                                  </li>

                                  <li>
                                    Mother's Name :
                                    <span>
                                      {{students.student_guardian && students.student_guardian.mother && students.student_guardian.mother.first_name != null ? students.student_guardian.mother.first_name : ''}}

                                      {{students.student_guardian && students.student_guardian.mother && students.student_guardian.mother.last_name != null ? students.student_guardian.mother.last_name : ''}}</span>
                                  </li>

                                  <li>
                                    Address :
                                    <span
                                      v-if="students.student_address"
                                    >{{ students.student_address.current.address_line1 }}</span>
                                    <span
                                      v-if="students.student_address && students.student_address.current.address_line2 != null"
                                    >{{ students.student_address.current.address_line2 }}</span>
                                    <span
                                      v-if="students.student_address && students.student_address.current.location != null"
                                    >{{ students.student_address.current.location }}</span>
                                    <span
                                      v-if="students.student_address && students.student_address.current.landmark != null"
                                    >{{ students.student_address.current.landmark }}</span>
                                    <span
                                      v-if="students.student_address && students.student_address.current.city != null"
                                    >{{ students.student_address.current.city }}</span>
                                  </li>
                                  <li>
                                    D.O.B
                                    <span>{{students.student_date_of_birth}}</span>
                                  </li>
                                </ul>
                                <div class="">
                                    <img
                                    :src="id_card_list.idCard_signature" style="height: 50px;"
                                  /><br />
                                  <label>Principal Signature</label>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
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
                    name: "Id Card View",
                },
            ],
            id_card_list:{},
            idCardList:{},
            students:{},
            student_guardian:{
                father: {},
                mother: {},
            },
            student_address: {
                    permanent: {},
                    current: {},
                },
            school_class: {},
            school_section: {},
        };
    },
    mounted() {
        if (this.$route.params.idCard_id && this.$route.params.student_admission_id) {
            this.student_admission_id = this.$route.params.student_admission_id;
            this.idCard_id = this.$route.params.idCard_id;
               this.getGeneratedIdCards();
        } else {
            this.$router.go(-1);
        }
    },
    methods:{
        async getGeneratedIdCards(){
            const res = await this.callApi(
                "get",
                 `/api/school/certificate/generate_id_card/${this.student_admission_id}/${this.idCard_id}`,
                 null,
                 );
                this.log('Id Cards',res) ;
                this.log('Students',res) ;
                if (res.status == 200) {
                     var data = res.data;
                if(data.status == "success"){
                    this.id_card_list = data.idCardList;
                    this.students = data.student;
                }
            }


        }
    },
};
</script>

<style type="text/css">
@media print {
    .page-break {
        display: block;
        page-break-before: always;
    }

}

* {
    margin: 0;
    padding: 0;
}

/*body{ font-family: 'arial'; margin:0; padding: 0;font-size: 12px; color: #000;}*/
.tc-container {
    width: 100%;
    position: relative;
    text-align: center;
}

.tcmybg {
    background: top center;
    background-size: contain;
    position: absolute;
    left: 0;
    bottom: 10px;
    width: 200px;
    height: 200px;
    margin-left: auto;
    margin-right: auto;
    right: 0;
}

/*begin students id card*/
.studentmain {
    background: #efefef;
    width: 100%;
    margin-bottom: 30px;
}

.studenttop img {
    width: 30px;
    vertical-align: top;
}

.studenttop {
    background: #300469;
    padding: 2px;
    color: #fff;
    overflow: hidden;
    position: relative;
    z-index: 1;
}

.sttext1 {
    font-size: 24px;
    font-weight: bold;
    line-height: 30px;
}
.col-12 .text-center .logo{
    width: 20px;
    height: 20px;
     font-size: 14px;
    align-content: center;
    line-height: 0px;
}

.stgray {
    background: #efefef;
    padding-top: 5px;
    padding-bottom: 10px;
}

.staddress {
    margin-bottom: 0;
    padding-top: 2px;
}

.stdivider {
    border-bottom: 2px solid #000;
    margin-top: 5px;
    margin-bottom: 5px;
}

.stlist {
    padding: 0;
    margin: 0;
    list-style: none;
}

.stlist li {
    text-align: left;
    display: inline-block;
    width: 100%;
    padding: 0px 5px;
}

.stlist li span {
    width: 65%;
    float: right;
}

.stimg {
    width: 80px;
    height: auto;
}

.stimg img {
    width: 100%;
    height: auto;
    border-radius: 2px;
    display: block;
}

.img-circles {
    border-radius: 8px !important;
}

.center-block {
    display: block;
    margin-right: auto;
    margin-left: auto;
}

.staround {
    padding: 3px 10px 3px 0;
    position: relative;
    overflow: hidden;
}

.staround2 {
    position: relative;
    z-index: 9;
}

.stbottom {
    background: #453278;
    height: 20px;
    width: 100%;
    clear: both;
    margin-bottom: 5px;
}

.principal {
    margin-top: -40px;
    margin-right: 10px;
    float: right;
}

.stred {
    color: #000;
}

.spanlr {
    padding-left: 5px;
    padding-right: 5px;
}

.cardleft {
    width: 20%;
    float: left;
}

.cardright {
    width: 77%;
    float: right;
}

.signature {
    /* border: 1px solid #ddd; */
    display: block;
    text-align: left;
    padding: auto;
    margin-top: 20px;
    color: #000;
}

.vertlist {
    padding: 0;
    margin: 0;
    list-style: none;
}

.vertlist li {
    text-align: left;
    display: inline-block;
    width: 100%;
    padding-bottom: 5px;
    color: #000;
}

.vertlist li span {
    width: 65%;
    float: right;
}
</style>
