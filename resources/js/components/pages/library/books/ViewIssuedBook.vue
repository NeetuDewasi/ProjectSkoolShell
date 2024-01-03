<template>
    <div>
        <div class="row">
            <div class="col-md-3">

<div class="box box-primary">
    <div class="box-body box-profile">
        <img class="profile-user-img img-responsive img-circle" src="https://smart.ezyschool.in/uploads/student_images/42.jpg" alt="User profile picture">
        <h3 class="profile-username text-center">Sheetal Choudhary</h3>
        <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
                <b>Member Id</b> <a class="pull-right text-aqua">14</a>
            </li>
            <li class="list-group-item">
                <b>Library Card No</b> <a class="pull-right text-aqua"></a>
            </li>
            <li class="list-group-item">
                <b>Admission No</b> <a class="pull-right text-aqua">EZY-STD-00004</a>
            </li>

            <li class="list-group-item">
                <b>Gender</b> <a class="pull-right text-aqua">Female</a>
            </li>

            <li class="list-group-item">
                <b>Member Type</b> <a class="pull-right text-aqua">Student</a>
            </li>
            <li class="list-group-item">
                <b>Mobile Number</b> <a class="pull-right text-aqua">9867767655</a>
            </li>

        </ul>
    </div>
</div>
            </div>
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Issue Book</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->

                    <form id="form1" action="https://smart.ezyschool.in/admin/member/issue/14" name="employeeform" method="post" accept-charset="utf-8">

                        <div class="box-body">

                            <input type="hidden" name="ci_csrf_token" value="">
                            <input id="member_id" name="member_id" type="hidden" class="form-control date" value="14">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Books  <small class="req"> *</small></label>
                                <select autofocus="" id="book_id" name="book_id" class="form-control js-example-basic-single select2-hidden-accessible" autocomplete="off" tabindex="-1" aria-hidden="true">
                                    <option value="">Select</option>
                                                                            <option value="1">
                                            The Science Book: Big Ideas Simply Explained1</option>
                                                                                <option value="2">
                                            Math Magic Book I</option>
                                                                                <option value="3">
                                            NCRT Solutions</option>
                                                                                <option value="4">
                                            The Jungle Book</option>
                                                                                <option value="5">
                                            मन के भोले -भाले बादल</option>
                                                                                <option value="6">
                                            The Wonderful Words</option>
                                                                                <option value="7">
                                            Going to School</option>
                                                                                <option value="8">
                                            The Sound of Music</option>
                                                                                <option value="9">
                                            Pani ki Kahani</option>
                                                                                <option value="10">
                                            History of Computer</option>
                                                                                <option value="11">
                                            Environment</option>
                                                                        </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 824px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-autocomplete="list" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-book_id-container"><span class="select2-selection__rendered" id="select2-book_id-container" title="Select">Select</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                <span class="text-danger"></span>
                                <span class="text text-danger qty_error"><b>Available Quantity</b>: <span class="ava_quantity">0</span></span>
                            </div>
                            <div class="form-group">
                                <label>Return Date</label>
                                <input id="dateto" name="return_date" type="text" class="form-control date" value="28-10-2022">
                                <span class="text-danger"></span>
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right">Save</button>
                        </div>
                    </form>
                </div>
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix">Book Issued</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->

                    <div class="box-body">
                        <div class="table-responsive mailbox-messages">
                            <div class="download_label">Book Issued</div>
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer"><div class="dt-buttons btn-group btn-group2">               <a class="btn btn-default dt-button buttons-copy buttons-html5" tabindex="0" aria-controls="DataTables_Table_0" href="#" title="Copy"><span><i class="fa fa-files-o"></i></span></a> <a class="btn btn-default dt-button buttons-excel buttons-html5" tabindex="0" aria-controls="DataTables_Table_0" href="#" title="Excel"><span><i class="fa fa-file-excel-o"></i></span></a> <a class="btn btn-default dt-button buttons-csv buttons-html5" tabindex="0" aria-controls="DataTables_Table_0" href="#" title="CSV"><span><i class="fa fa-file-text-o"></i></span></a> <a class="btn btn-default dt-button buttons-pdf buttons-html5" tabindex="0" aria-controls="DataTables_Table_0" href="#" title="PDF"><span><i class="fa fa-file-pdf-o"></i></span></a> <a class="btn btn-default dt-button buttons-print" tabindex="0" aria-controls="DataTables_Table_0" href="#" title="Print"><span><i class="fa fa-print"></i></span></a> <a class="btn btn-default dt-button buttons-collection buttons-colvis" tabindex="0" aria-controls="DataTables_Table_0" href="#" title="Columns"><span><i class="fa fa-columns"></i></span></a> </div><div id="DataTables_Table_0_filter" class="dataTables_filter"><label><input type="search" class="" placeholder="Search..." aria-controls="DataTables_Table_0"></label></div><table class="table table-striped table-bordered table-hover example dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                    <tr role="row"><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Book Title: activate to sort column ascending" style="width: 115px;">Book Title</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Book Number: activate to sort column ascending" style="width: 147px;">Book Number</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Issue Date: activate to sort column ascending" style="width: 119px;">Issue Date</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Due Return Date: activate to sort column ascending" style="width: 170px;">Due Return Date</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Return Date: activate to sort column ascending" style="width: 131px;">Return Date</th><th class="text-right sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 64px;">Action</th></tr>
                                </thead>
                                <tbody>

                                <tr class="odd"><td valign="top" colspan="6" class="dataTables_empty"><div align="center">No data available in table <br> <br><img src="https://smart-school.in/ssappresource/images/addnewitem.svg" width="150"><br><br> <span class="text-success bolds"><i class="fa fa-arrow-left"></i> Add new record or search with different criteria.</span><div></div></div></td></tr></tbody>
                            </table><div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Records: 0 to 0 of 0</div><div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate"><a class="paginate_button previous disabled" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" id="DataTables_Table_0_previous"><i class="fa fa-angle-left"></i></a><span></span><a class="paginate_button next disabled" aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0" id="DataTables_Table_0_next"><i class="fa fa-angle-right"></i></a></div></div><!-- /.table -->
                        </div><!-- /.mail-box-messages -->

                    </div><!-- /.box-body -->


                </div>
            </div>
        </div>
    </div>
</template>
