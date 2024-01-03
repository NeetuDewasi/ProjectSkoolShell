<template>
    <div>
        <div class="row gutters-20">
            <div class="col-12">
                <div class="card">
                    <div class="page-title">
                        <h2>Detail Page</h2>
                    </div>
                    <div class="card-body">
                        <div class="row" v-if="detailList">
                            <div class="col-md-3">
                                <div class="box box-primary">
                                    <div class="box-body box-profile">
                                        <img :src="detailList.student_student_photo" class="center-cropped" />
                                        <h3 class="profile-username text-center">
                                            {{ detailList.student_first_name }}
                                            {{ detailList.student_last_name }}
                                        </h3>

                                        <ul class="list-group list-group-unbordered">
                                            <li class="list-group-item listnoback">
                                                <b>Admission No : </b>
                                                <a class="pull-right text-aqua">{{
                                                        detailList.student_admission_number
                                                }}</a>
                                            </li>
                                            <li class="list-group-item listnoback">
                                                <b>Roll Number</b>
                                                <a class="pull-right text-aqua">{{ detailList.student_roll_number }}</a>
                                            </li>
                                            <li class="list-group-item listnoback">
                                                <b>Class</b>
                                                <a class="pull-right text-aqua"
                                                    v-if="detailList.school_class && detailList.school_class.class_name != null">

                                                    {{ detailList.school_class.class_name }}
                                                </a>
                                            </li>
                                            <li class="list-group-item listnoback">
                                                <b>Section</b>
                                                <a class="pull-right text-aqua"
                                                    v-if="detailList.school_section && detailList.school_section.section_name != null">{{
                                                            detailList
                                                                .school_section
                                                                .section_name
                                                    }}</a>
                                            </li>
                                            <li class="list-group-item listnoback">
                                                <b>RTE</b>
                                                <a class="pull-right text-aqua"
                                                    v-if="detailList.student_other_detail && detailList.student_other_detail.rte != null">{{
                                                            detailList
                                                                .student_other_detail
                                                                .rte
                                                    }}</a>
                                            </li>
                                            <li class="list-group-item listnoback">
                                                <b>Gender</b>
                                                <a class="pull-right text-aqua"
                                                    v-if="detailList && detailList.gender != null">{{ detailList.gender
                                                    }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Sibling</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body" v-for="item in detailList.student_sibling"
                                        :key="item.sibling_id">
                                        <div class="box box-widget widget-user-2">
                                            <!-- Add the bg color to the header using any of the bg-* classes -->
                                            <div class="siblingview">

                                                <img :src="item.sibling.student_avatar" alt="User Avatar" />
                                                <h4>
                                                    <a href="https://smart.ezyschool.in/student/view/6">{{
                                                            item.sibling.student_first_name
                                                    }}</a>
                                                </h4>

                                            </div>
                                            <div class="box-footer no-padding">
                                                <ul class="list-group list-group-unbordered">

                                                    <li class="list-group-item">
                                                        <b>Admission No</b>

                                                        <a class="pull-right text-aqua">{{
                                                                item.sibling.student_admission_number
                                                        }}</a>

                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Class</b>

                                                        <a class="pull-right text-aqua">{{ item.sibling.school_class &&
                                                                item.sibling.school_class.class_name
                                                        }}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Section</b>
                                                        <a class="pull-right text-aqua">{{ item.sibling.school_section
                                                                &&
                                                                item.sibling.school_section.section_name
                                                        }}</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="nav-tabs-custom theme-shadow">
                                    <ul class="nav nav-tabs">
                                        <li class="active pd-style">
                                            <a href="#activity" data-toggle="tab" aria-expanded="true">Profile</a>
                                        </li>

                                        <li class="pd-style">
                                            <a href="#fee" data-toggle="tab" aria-expanded="true">Fees</a>
                                        </li>
                                        <li class="pd-style">
                                            <a href="#exam" data-toggle="tab" aria-expanded="true">Exam</a>
                                        </li>
                                        <li class="pd-style">
                                            <a href="#documents" data-toggle="tab" aria-expanded="true">Documents</a>
                                        </li>

                                        <li class="pull-right pd-style">
                                            <a style="cursor: pointer" onclick="disable_student('15')" class="text-red"
                                                data-toggle="tooltip" data-placement="bottom" title="Disable">
                                                <i class="fa fa-thumbs-o-down"></i>
                                            </a>
                                        </li>
                                        <li class="pull-right pd-style">
                                            <a href="https://smart.ezyschool.in/studentfee/addfee/18"
                                                data-toggle="tooltip" data-placement="bottom" title="Collect Fees"><i
                                                    class="fa fa-dollar"></i>
                                            </a>
                                        </li>

                                        <li class="pull-right pd-style">
                                            <a href="https://smart.ezyschool.in/student/edit/15" class=""
                                                data-toggle="tooltip" data-placement="bottom" title="Edit"><i
                                                    class="fa fa-pencil"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="activity">
                                            <div class="tshadow mb25 bozero">
                                                <div class="table-responsive around10 pt0">
                                                    <table class="table table-hover table-striped tmb0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="col-md-4">
                                                                    Admission
                                                                    Date
                                                                </td>
                                                                <td class="col-md-5">
                                                                    <span v-if="detailList && detailList != null">
                                                                        {{
                                                                                detailList.student_admission_date
                                                                        }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="col-md-4">
                                                                    Date of
                                                                    Birth
                                                                </td>
                                                                <td class="col-md-5">
                                                                    <span v-if="detailList && detailList != null">
                                                                        {{
                                                                                detailList.student_date_of_birth
                                                                        }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="col-md-4">
                                                                    Category
                                                                </td>
                                                                <td class="col-md-5">
                                                                    <span
                                                                        v-if="detailList.student_category && detailList.student_category.category_name != null">
                                                                        {{
                                                                                detailList
                                                                                    .student_category
                                                                                    .category_name
                                                                        }}
                                                                    </span>

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="col-md-4">
                                                                    Mobile
                                                                    Number
                                                                </td>
                                                                <td class="col-md-5">
                                                                    <span
                                                                        v-if="detailList.student_mobile && detailList.student_mobile != null">
                                                                        {{
                                                                                detailList.student_mobile
                                                                        }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="col-md-4">Caste</td>
                                                                <td class="col-md-5">
                                                                    <span v-if="detailList && detailList != null">
                                                                        {{
                                                                                detailList.student_cast
                                                                        }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="col-md-4">
                                                                    Religion
                                                                </td>
                                                                <td class="col-md-5">
                                                                    <span v-if="detailList && detailList != null">
                                                                        {{
                                                                                detailList.student_religion
                                                                        }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="col-md-4">Email</td>
                                                                <td class="col-md-5">
                                                                    <span
                                                                        v-if="detailList && detailList.student_email != null">
                                                                        {{
                                                                                detailList.student_email
                                                                        }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="col-md-4">Blood Group</td>
                                                                <td class="col-md-5">
                                                                    <span v-if="detailList.student_blood_group != null">
                                                                        {{ detailList.student_blood_group }} </span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tshadow mb25 bozero">
                                                <h3 class="pagetitleh2">
                                                    Address
                                                </h3>
                                                <div class="table-responsive around10 pt0">
                                                    <table class="table table-hover table-striped tmb0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="col-md-4">
                                                                    Current
                                                                    Address
                                                                </td>
                                                                <td class="col-md-5">
                                                                    <!-- <span v-if="isCurrentAddress"> -->
                                                                    <span
                                                                        v-if="detailList.student_address && detailList.student_address.current.address_line1 != null">
                                                                        {{
                                                                                detailList.student_address.current.address_line1
                                                                        }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Permanent
                                                                    Address
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        v-if="detailList.student_address && detailList.student_address.permanent.address_line1 != null">
                                                                        {{
                                                                                detailList.student_address.permanent.address_line1
                                                                        }}</span>
                                                                    <span
                                                                        v-if="detailList.student_address && detailList.student_address.permanent.address_line2 != null">
                                                                        {{
                                                                                detailList.student_address.permanent.address_line2
                                                                        }}</span>
                                                                    <span
                                                                        v-if="detailList.student_address && detailList.student_address.permanent.location != null">
                                                                        {{ detailList.student_address.permanent.location
                                                                        }}</span>
                                                                    <span
                                                                        v-if="detailList.student_address && detailList.student_address.permanent.landmark != null">
                                                                        {{ detailList.student_address.permanent.landmark
                                                                        }}</span>
                                                                    <span
                                                                        v-if="detailList.student_address && detailList.student_address.permanent.city != null">
                                                                        {{ detailList.student_address.permanent.city
                                                                        }}</span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="tshadow mb25 bozero">
                                                <h3 class="pagetitleh2">
                                                    Parent / Guardian Details
                                                </h3>
                                                <div class="table-responsive around10 pt10">
                                                    <table class="table table-hover table-striped tmb0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="col-md-4">
                                                                    Father Name :

                                                                </td>
                                                                <td class="col-md-5">
                                                                    <span v-if="detailList.student_guardian">
                                                                        <span v-if="detailList.student_guardian.father">
                                                                            <span
                                                                                v-if="detailList.student_guardian.father.first_name != null">{{
                                                                                        detailList.student_guardian.father.first_name
                                                                                }}</span>
                                                                            <span
                                                                                v-if="detailList.student_guardian.father.middle_name != null">{{
                                                                                        detailList.student_guardian.father.middle_name
                                                                                }}</span>
                                                                            <span
                                                                                v-if="detailList.student_guardian.father.last_name != null">{{
                                                                                        detailList.student_guardian.father.last_name
                                                                                }}</span>
                                                                        </span>
                                                                    </span>

                                                                </td>
                                                                <td rowspan="3">
                                                                    <span
                                                                        v-if="detailList.student_guardian && detailList.student_guardian.father && detailList.student_guardian.father.photo != null">
                                                                        <img :src="detailList.student_guardian.father.photo"
                                                                            class="profile-user-img img-responsive img-circle" /></span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Father Phone
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        v-if="detailList.student_guardian && detailList.student_guardian.father && detailList.student_guardian.father.mobile">{{
                                                                                detailList.student_guardian.father.mobile
                                                                        }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Father
                                                                    Occupation
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        v-if="detailList.student_guardian && detailList.student_guardian.father && detailList.student_guardian.father.occupation != null">{{
                                                                                detailList.student_guardian.father.occupation
                                                                        }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Mother Name
                                                                </td>
                                                                <td>
                                                                    <span v-if="detailList.student_guardian">
                                                                        <span v-if="detailList.student_guardian.mother">
                                                                            <span
                                                                                v-if="detailList.student_guardian.mother.first_name != null">{{
                                                                                        detailList.student_guardian.mother.first_name
                                                                                }}</span>
                                                                            <span
                                                                                v-if="detailList.student_guardian.mother.middle_name != null">{{
                                                                                        detailList.student_guardian.mother.middle_name
                                                                                }}</span>
                                                                            <span
                                                                                v-if="detailList.student_guardian.mother.last_name != null">{{
                                                                                        detailList.student_guardian.mother.last_name
                                                                                }}</span>
                                                                        </span>
                                                                    </span>
                                                                </td>
                                                                <td rowspan="3">
                                                                    <span
                                                                        v-if="detailList.student_guardian && detailList.student_guardian.mother && detailList.student_guardian.mother.photo != null">
                                                                        <img :src="detailList.student_guardian.mother.photo"
                                                                            class="profile-user-img img-responsive img-circle" />
                                                                    </span>

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Mother Phone
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        v-if="detailList.student_guardian && detailList.student_guardian.mother && detailList.student_guardian.mother.mobile != null">{{
                                                                                detailList.student_guardian.mother.mobile
                                                                        }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Mother
                                                                    Occupation
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        v-if="detailList.student_guardian && detailList.student_guardian.mother && detailList.student_guardian.mother.occupation != null">{{
                                                                                detailList.student_guardian.mother.occupation
                                                                        }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Guardian
                                                                    Name
                                                                </td>
                                                                <td>
                                                                    <span v-if="detailList.student_guardian">
                                                                        <span v-if="detailList.student_guardian.other">
                                                                            <span
                                                                                v-if="detailList.student_guardian.other.first_name != null">{{
                                                                                        detailList.student_guardian.other.first_name
                                                                                }}</span>
                                                                            <span
                                                                                v-if="detailList.student_guardian.other.middle_name != null">{{
                                                                                        detailList.student_guardian.other.middle_name
                                                                                }}</span>
                                                                            <span
                                                                                v-if="detailList.student_guardian.other.last_name != null">{{
                                                                                        detailList.student_guardian.other.last_name
                                                                                }}</span>
                                                                        </span>
                                                                    </span>

                                                                </td>

                                                                <td rowspan="3">
                                                                    <span
                                                                        v-if="detailList.student_guardian && detailList.student_guardian.other && detailList.student_guardian.other.photo != null">
                                                                        <img :src="detailList.student_guardian.other.photo"
                                                                            class="profile-user-img img-responsive img-circle" />
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Guardian
                                                                    Email
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        v-if="detailList.student_guardian && detailList.student_guardian.other && detailList.student_guardian.other.email != null">
                                                                        {{ detailList.student_guardian.other.email }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Guardian
                                                                    Relation
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        v-if="detailList.student_guardian && detailList.student_guardian.other && detailList.student_guardian.other.relation != null">
                                                                        {{ detailList.student_guardian.other.relation }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Guardian
                                                                    Phone
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        v-if="detailList.student_guardian && detailList.student_guardian.other && detailList.student_guardian.other.mobile != null">
                                                                        {{ detailList.student_guardian.other.mobile }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Guardian
                                                                    Occupation
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        v-if="detailList.student_guardian && detailList.student_guardian.other && detailList.student_guardian.other.occupation != null">
                                                                        {{ detailList.student_guardian.other.occupation
                                                                        }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Guardian
                                                                    Address
                                                                </td>
                                                                <td>
                                                                    <span v-if="detailList.student_guardian != null">
                                                                        <span
                                                                            v-if="detailList.student_guardian.address_line1 != null">
                                                                            {{ detailList.student_guardian.address_line1
                                                                            }}
                                                                        </span>
                                                                        <span
                                                                            v-if="detailList.student_guardian.address_line2 != null">
                                                                            {{ detailList.student_guardian.address_line2
                                                                            }}
                                                                        </span>
                                                                        <span
                                                                            v-if="detailList.student_guardian.city != null">
                                                                            {{ detailList.student_guardian.city }}
                                                                        </span>
                                                                        <span
                                                                            v-if="detailList.student_guardian.pincode != null">
                                                                            {{ detailList.student_guardian.pincode }}
                                                                        </span>
                                                                        <span
                                                                            v-if="detailList.student_guardian.state != null">
                                                                            {{ detailList.student_guardian.state }}
                                                                        </span>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tshadow mb25 bozero">
                                                <h3 class="pagetitleh2">
                                                    Hostel Details
                                                </h3>
                                                <div class="table-responsive around10 pt0">
                                                    <table class="table table-hover table-striped tmb0">
                                                        <tbody>

                                                            <tr>
                                                                <td>
                                                                    Hostel Name
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        v-if="detailList.student_hostel && detailList.student_hostel.student_hostel_name != null">
                                                                        {{ detailList.student_hostel.student_hostel_name
                                                                        }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td> Bed Number</td>
                                                                <td>
                                                                    <span
                                                                        v-if="detailList.student_hostel && detailList.student_hostel.student_bed_number != null">
                                                                        {{ detailList.student_hostel.student_bed_number
                                                                        }}</span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tshadow mb25 bozero">
                                                <h3 class="pagetitleh2">
                                                    Transport Details
                                                </h3>
                                                <div class="table-responsive around10 pt0">
                                                    <table class="table table-hover table-striped tmb0">
                                                        <tr>
                                                            <td>
                                                                Route Name
                                                            </td>
                                                            <td class="col-md-5">
                                                                <span
                                                                    v-if="detailList.student_transport && detailList.student_transport.transport_details && detailList.student_transport.transport_details.route_name != null">
                                                                    {{
                                                                            detailList.student_transport.transport_details.route_name
                                                                    }}</span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="tshadow mb25 bozero">
                                                <h3 class="pagetitleh2">
                                                    Other Details
                                                </h3>
                                                <div class="table-responsive around10 pt0">
                                                    <table class="table table-hover table-striped tmb0">
                                                        <tbody>

                                                            <tr>
                                                                <td class="col-md-4">
                                                                    Student
                                                                    House
                                                                </td>
                                                                <td class="col-md-5">
                                                                    <span
                                                                        v-if="detailList.student_house && detailList.student_house.name != null">
                                                                        {{ detailList.student_house.name }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="col-md-4">
                                                                    Student Height
                                                                </td>
                                                                <td class="col-md-5">
                                                                    <span
                                                                        v-if="detailList.student_height && detailList.student_height != null">
                                                                        {{ detailList.student_height }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="col-md-4">
                                                                    Student Weight
                                                                </td>
                                                                <td class="col-md-5">
                                                                    <span
                                                                        v-if="detailList.student_weight && detailList.student_weight != null">
                                                                        {{ detailList.student_weight }}</span>
                                                                </td>
                                                            </tr>


                                                            <tr>
                                                                <td class="col-md-4">
                                                                    Previous
                                                                    School
                                                                    Details
                                                                </td>
                                                                <td class="col-md-5">
                                                                    <span
                                                                        v-if="detailList.previous_school && detailList.student_other_detail.previous_school != null">
                                                                        {{
                                                                                detailList.student_other_detail.previous_school
                                                                        }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="col-md-4">
                                                                    National
                                                                    Identification
                                                                    Number
                                                                </td>
                                                                <td class="col-md-5">
                                                                    <span
                                                                        v-if="detailList.student_other_detail && detailList.student_other_detail.national_identification_number != null">
                                                                        {{
                                                                                detailList.student_other_detail.national_identification_number
                                                                        }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Local
                                                                    Identification
                                                                    Number
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        v-if="detailList.student_other_detail && detailList.student_other_detail.local_identification_number != null">
                                                                        {{
                                                                                detailList.student_other_detail.local_identification_number
                                                                        }}
                                                                    </span>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>
                                                                    Note
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        v-if="detailList.student_other_detail && detailList.student_other_detail.note != null">
                                                                        {{ detailList.student_other_detail.note }}
                                                                    </span>
                                                                </td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="fee">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Fees Group</th>
                                                            <th>Fees Code</th>
                                                            <th class="text text-left">Due Date</th>
                                                            <th class="text text-left">Status</th>
                                                            <th class="text text-right">Amount <span>(₹)</span></th>
                                                            <th class="text text-left">Payment Id</th>
                                                            <th class="text text-left">Mode</th>
                                                            <th class="text text-left">Date</th>
                                                            <th class="text text-right">Discount <span>(₹)</span></th>
                                                            <th class="text text-right">Fine <span>(₹)</span></th>
                                                            <th class="text text-right">Paid <span>(₹)</span></th>
                                                            <th class="text text-right">Balance</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="danger font12">
                                                            <td>
                                                                <span v-if = "studentFees && studentFees.fees_master_fees_group && studentFees.fees_master_fees_group.name != null">
                                                                    {{studentFees.fees_master_fees_group.name}}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span v-if = "studentFees && studentFees.fees_master_fees_type && studentFees.fees_master_fees_type.code != null">
                                                                    {{studentFees.fees_master_fees_type.code}}
                                                                </span>
                                                            </td>
                                                            <td class="text text-left">
                                                                <span v-if = "studentFees && studentFees.fees_master_due_date != null">
                                                                    {{studentFees.fees_master_due_date}}
                                                                </span>
                                                            </td>
                                                            <td class="text text-left">
                                                                <span class="label label-danger">
                                                                   <span v-if = "studentFees && studentFees.fees_status != null">
                                                                    {{studentFees.fees_status}}
                                                                </span>
                                                                </span>
                                                            </td>
                                                            <td class="text text-right">
                                                                <span v-if = "studentFees && studentFees.fees_amount != null">
                                                                    {{studentFees.fees_amount}}
                                                                </span>
                                                            </td>

                                                            <td class="text text-left">

                                                            </td>
                                                            <td class="text text-left">
                                                                <span v-if = "studentFees && studentFees.fees_payment_mode != null">
                                                                    {{studentFees.fees_payment_mode}}
                                                                </span>
                                                            </td>
                                                            <td class="text text-left">
                                                                <span v-if = "studentFees && studentFees.fees_date != null">
                                                                    {{studentFees.fees_date}}
                                                                </span>
                                                            </td>

                                                            <td class="text text-right">
                                                                <span v-if = "studentFees && studentFees.fees_discount_amount != null">
                                                                    {{studentFees.fees_discount_amount}}
                                                                </span>
                                                            </td>
                                                            <td class="text text-right"><span v-if = "studentFees && studentFees.fees_fine_amount != null">
                                                                    {{studentFees.fees_fine_amount}}
                                                                </span></td>
                                                            <td class="text text-right">0.00</td>

                                                                <td class="text text-right">
                                                                    <span v-if = "studentFees && studentFees.fees_fine_amount != null">
                                                                    {{studentFees.fees_fine_amount}}
                                                                    </span>
                                                            </td>
                                                        </tr>


                                                        <tr class="box box-solid total-bg">
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text text-right"> </td>
                                                            <td class="text text-right">{{studentFees.fees_amount}}
                                                            <span class="text text-danger">+0.00</span></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text text-right">{{studentFees.fees_discount_amount}}</td>
                                                            <td class="text text-right">{{studentFees.fees_fine_amount}}</td>
                                                            <td class="text text-right">₹0.00</td>
                                                            <td class="text text-right">{{studentFees.fees_amount}}</td>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="documents">
                                            <div class="timeline-header no-border">

                                                <div class="table-responsive" style="clear: both;">
                                                    <div class="row">
                                                    </div>
                                                    <table class="table table-striped table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    Sr.No.
                                                                </th>
                                                                <th>
                                                                    Title
                                                                </th>
                                                                <th>
                                                                Document
                                                                </th>

                                                            </tr>
                                                        </thead>
                                                        <tbody span v-for="Number in Number.length" :key="Number" :value="Number">

                                                            <tr v-for="item in detailList.student_document"
                                                            :key="item.document_id">
                                                                <td>

                                                                    {{Number}}

                                                                </td>
                                                                <td class="col-4">
                                                                        {{item.title}}
                                                                </td>
                                                                <td class="col-4">
                                                                   <img :src="item.document">
                                                                </td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="exam">
                                            <div class="download_label">
                                                Exam Result
                                            </div>
                                            <div class="dt-buttons btn-group pull-right miusDM40">
                                                <a class="btn btn-default btn-xs dt-button no_print" id="print"
                                                    onclick="printDiv()"><i class="fa fa-print"></i></a>
                                            </div>
                                            <div class="tshadow mb25">
                                                <h4 class="pagetitleh">
                                                    Final Year </h4>
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover ptt10"
                                                        id="headerTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Subject</th>
                                                                <th>Max. Marks</th>
                                                                <th>Min. Marks</th>
                                                                <th>Marks Obtained</th>
                                                                <th>Grade </th>
                                                                <th>Note</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Hindi</td>
                                                                <td>100.00</td>
                                                                <td>33.00</td>
                                                                <td>
                                                                    60.00 </td>

                                                                <td>B+</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>English</td>
                                                                <td>100.00</td>
                                                                <td>33.00</td>
                                                                <td>
                                                                    90.00 </td>

                                                                <td>A+</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Maths</td>
                                                                <td>100.00</td>
                                                                <td>33.00</td>
                                                                <td>
                                                                    75.00 </td>

                                                                <td>A</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>SSC</td>
                                                                <td>100.00</td>
                                                                <td>33.00</td>
                                                                <td>
                                                                    50.00 </td>

                                                                <td>B</td>
                                                                <td>SASDSDS</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Science</td>
                                                                <td>100.00</td>
                                                                <td>33.00</td>
                                                                <td>
                                                                    45.00 </td>

                                                                <td>B</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Computer Theory</td>
                                                                <td>100.00</td>
                                                                <td>33.00</td>
                                                                <td>
                                                                    85.00 </td>

                                                                <td>A+</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Computer Practical</td>
                                                                <td>100.00</td>
                                                                <td>33.00</td>
                                                                <td>
                                                                    85.00 </td>

                                                                <td>A+</td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="bgtgray">
                                                            <div class="col-sm-3 col-lg-3 col-md-3">
                                                                <div class="description-block">
                                                                    <h5 class="description-header">Percentage : <span
                                                                            class="description-text">70.00</span></h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4 col-lg-4 col-md-4 border-right">
                                                                <div class="description-block">
                                                                    <h5 class="description-header">Result :<span
                                                                            class="description-text">
                                                                            <span class="label bg-green"
                                                                                style="margin-right: 5px;">
                                                                                Pass </span> Division : First </span>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2 col-lg-2 col-md-2 border-right">
                                                                <div class="description-block">
                                                                    <h5 class="description-header">Grand Total : <span
                                                                            class="description-text">700</span></h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3 col-lg-3 col-md-3 border-right">
                                                                <div class="description-block">
                                                                    <h5 class="description-header">Total Obtain Marks :
                                                                        <span class="description-text">490</span></h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tshadow mb25">
                                                <h4 class="pagetitleh">
                                                    Mid Term Examination </h4>
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover ptt10"
                                                        id="headerTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Subject</th>
                                                                <th>Max. Marks</th>
                                                                <th>Min. Marks</th>
                                                                <th>Marks Obtained</th>
                                                                <th>Grade </th>
                                                                <th>Note</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>SSC</td>
                                                                <td>100.00</td>
                                                                <td>33.00</td>
                                                                <td>
                                                                    95.00 </td>

                                                                <td>A++</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Maths</td>
                                                                <td>100.00</td>
                                                                <td>33.00</td>
                                                                <td>
                                                                    75.00 </td>

                                                                <td>A</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Hindi</td>
                                                                <td>100.00</td>
                                                                <td>33.00</td>
                                                                <td>
                                                                    45.00 </td>

                                                                <td>B</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>English</td>
                                                                <td>100.00</td>
                                                                <td>33.00</td>
                                                                <td>
                                                                    45.00 </td>

                                                                <td>B</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Science</td>
                                                                <td>100.00</td>
                                                                <td>33.00</td>
                                                                <td>
                                                                    36.00 </td>

                                                                <td>B-</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Computer Practical</td>
                                                                <td>100.00</td>
                                                                <td>33.00</td>
                                                                <td>
                                                                    32.00 </td>

                                                                <td>B-</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Computer Theory</td>
                                                                <td>100.00</td>
                                                                <td>33.00</td>
                                                                <td>
                                                                    &nbsp;ABS </td>

                                                                <td>B-</td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="bgtgray">
                                                            <div class="col-sm-3 col-lg-3 col-md-3">
                                                                <div class="description-block">
                                                                    <h5 class="description-header">Percentage : <span
                                                                            class="description-text">46.86</span></h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4 col-lg-4 col-md-4 border-right">
                                                                <div class="description-block">
                                                                    <h5 class="description-header">Result :<span
                                                                            class="description-text">
                                                                            <span class="label label-danger">
                                                                                Fail </span>
                                                                        </span></h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2 col-lg-2 col-md-2 border-right">
                                                                <div class="description-block">
                                                                    <h5 class="description-header">Grand Total : <span
                                                                            class="description-text">700</span></h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3 col-lg-3 col-md-3 border-right">
                                                                <div class="description-block">
                                                                    <h5 class="description-header">Total Obtain Marks :
                                                                        <span class="description-text">328</span></h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tshadow mb25">
                                                <h4 class="pagetitleh">
                                                    Monthly Test </h4>
                                                <table class="table table-striped ">
                                                    <thead>
                                                        <tr>
                                                            <th>Subject</th>
                                                            <th>Max. Marks</th>
                                                            <th>Min. Marks</th>
                                                            <th>Marks Obtained </th>
                                                            <th>Grade</th>
                                                            <th>Remark</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Hindi</td>
                                                            <td>100.00</td>
                                                            <td>33.00</td>
                                                            <td>
                                                                89.00 </td>
                                                            <td>A+</td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>English</td>
                                                            <td>100.00</td>
                                                            <td>33.00</td>
                                                            <td>
                                                                65.00 </td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Maths</td>
                                                            <td>100.00</td>
                                                            <td>33.00</td>
                                                            <td>
                                                                85.00 </td>
                                                            <td>A+</td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>SSC</td>
                                                            <td>100.00</td>
                                                            <td>33.00</td>
                                                            <td>
                                                                35.00 </td>
                                                            <td>B-</td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Science</td>
                                                            <td>100.00</td>
                                                            <td>33.00</td>
                                                            <td>
                                                                85.00 </td>
                                                            <td>A+</td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Computer Practical</td>
                                                            <td>100.00</td>
                                                            <td>33.00</td>
                                                            <td>
                                                                65.00 </td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Computer Theory</td>
                                                            <td>100.00</td>
                                                            <td>33.00</td>
                                                            <td>
                                                                75.00 </td>
                                                            <td>A</td>
                                                            <td></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="bgtgray">
                                                            <div class="col-sm-3 col-lg-3 col-md-3 pull no-print">
                                                                <div class="description-block">
                                                                    <h5 class="description-header"> Percentage : <span
                                                                            class="description-text">
                                                                            71.29 </span></h5>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="col-sm-4 col-lg-4 col-md-4 border-right no-print">
                                                                <div class="description-block">
                                                                    <h5 class="description-header">Result :<span
                                                                            class="description-text">
                                                                            <span class="label bg-green"
                                                                                style="margin-right: 5px;">
                                                                                Pass </span>
                                                                            Division : First </span></h5>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="col-sm-2 col-lg-2 col-md-2 border-right no-print">
                                                                <div class="description-block">
                                                                    <h5 class="description-header">Grand Total : <span
                                                                            class="description-text">700</span></h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3 border-right no-print">
                                                                <div class="description-block">
                                                                    <h5 class="description-header">Total Obtain Marks :
                                                                        <span class="description-text">499</span></h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tshadow mb25">
                                                <h4 class="pagetitleh">
                                                    Consolidated Marksheet </h4>
                                                <table class="table table-striped ">
                                                    <thead>
                                                        <tr>
                                                            <th>Exam</th>
                                                            <th>
                                                                Final Year </th>
                                                            <th>
                                                                Mid Term Examination </th>
                                                            <th>
                                                                Monthly Test </th>
                                                            <th>Consolidate</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Marks Obtained</td>
                                                            <td>
                                                                161.7 </td>
                                                            <td>
                                                                108.24 </td>
                                                            <td>
                                                                164.67 </td>
                                                            <td>
                                                                434.61/2100 [B-]</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="bgtgray">
                                                            <div class="col-sm-3 pull no-print">
                                                                <div class="description-block">
                                                                    <h5 class="description-header">Result :
                                                                        <span class="description-text">
                                                                            <span class="label label-danger"
                                                                                style="margin-right: 5px;">
                                                                                Fail </span>
                                                                        </span>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3 border-right no-print">
                                                                <div class="description-block">
                                                                    <h5 class="description-header">Division :<span
                                                                            class="description-text">
                                                                            Third </span></h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
var toast;
export default {
    data() {
        return {
            isShow: false,
            student_admission_id: -1,
            detailList: {
                student_guardian: {},
                student_address: {
                    permanent: {},
                    current: {},
                },
                student_sibling: [],
                student_document:[],
            },
            school_class: {},
            school_section: {},
            class_id: -1,
            section_id: -1,
            studentFees:{
                fees_master_fees_type : {},
            }
        };
    },
    mounted() {
        this.$parent.loadOtherScript();
        this.student_admission_id = this.$route.params.student_admission_id;
        // console.log("Admission Id", this.student_admission_id);
        this.showData();
        this.showFees();
    },
    methods: {
        async showData() {
            this.isLoaded = false;
            const res = await this.callApi(
                "get",
                `/api/school/students/student_details/${this.student_admission_id}`,
                null
            );
            this.log(res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.detailList = data.detailList;
                } else if (data.status_code == 300) {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                    this.noData = true;
                }
            }
            this.isLoaded = true;
        },
        async showFees() {
            this.isLoaded = false;
            const res = await this.callApi(
            "get",
            `/api/school/fees_collection/collect_fees/student_fees/${this.student_admission_id}`,
            null
            );
            if (res.status == 200) {
            var data = res.data;
            console.log('ewfgyuuygfhyu',res);
            if (data.status == "success") {
                this.student = data.student_admissions;
                this.studentFees = data.student_fees;
                this.addFees = data.add_fees;
            }
            }
        },
    },
};
</script>
<style >
.center-cropped {
    object-fit: none;
    /* Do not scale the image */
    object-position: center;
    /* Center the image within the element */
    height: 250px;
    width: 350px;
}

.pd-style {
    padding-right: 25px;
}

.theme-shadow {
    box-shadow: 0 1px 3px rgb(0 0 0 / 12%), 0 1px 2px rgb(0 0 0 / 24%) !important;
}

.nav-tabs-custom {
    margin-bottom: 20px !important;
    margin-right: 10px;
    background: #fff !important;
    box-shadow: 0 0 0 0 rgb(90 113 208 / 11%), 0 4px 16px 0 rgb(167 175 183 / 33%) !important;
    border-radius: 3px !important;
}

.nav-tabs-custom>.nav-tabs {
    margin: 0;
    border-bottom-color: #f4f4f4;
    border-top-right-radius: 3px;
    border-top-left-radius: 3px;
}

.nav-tabs-custom>.nav-tabs {
    margin: 0;
    border-bottom-color: #f4f4f4;
    border-top-right-radius: 3px;
    border-top-left-radius: 3px;
}

.nav-tabs {
    border-bottom: 1px solid #ddd;
}

ul {
    display: block;
    list-style-type: disc;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    padding-inline-start: 40px;
}

.mb25 {
    margin-bottom: 25px;
}
*{
    box-sizing: border-box;
}
.tab-content>.active{
    display: block;
}
.page-title{
    text-shadow:  rgb(255, 0, 85) 2px 0;
    text-align: center;
}
</style>
