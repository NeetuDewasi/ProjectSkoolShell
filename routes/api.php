<?php

use App\Http\Controllers\Admin\Backend\SampleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SampleDateDemoController;
use App\Http\Controllers\Admin\Backend\SchoolGroupController;
use App\Http\Controllers\Admin\Backend\SchoolController;
use App\Http\Controllers\Admin\Backend\SchoolDocController;
use App\Http\Controllers\Admin\Backend\Categories\CategoryController;
use App\Http\Controllers\Admin\Backend\Compoonent\ComponentController;
use App\Http\Controllers\Admin\Backend\Assign\AssignController;
use App\Http\Controllers\School\Academics\ClassPeriodsController;
use App\Http\Controllers\School\Academics\SchoolSectionController;
use App\Http\Controllers\School\Common\GeneralController;
use App\Http\Controllers\School\Academics\SchoolClassController;
use App\Http\Controllers\School\Academics\AcademicAssignController;
use App\Http\Controllers\School\Academics\SchoolSubjectController;
use App\Http\Controllers\School\Academics\SchoolTeacherController;
use App\Http\Controllers\School\Attendance\EmployeeAttendanceController;
use App\Http\Controllers\School\Attendance\StudentAttendanceController;
use App\Http\Controllers\School\Certificate\StudentCertificateController;
use App\Http\Controllers\School\Communicate\MessageController;
use App\Http\Controllers\School\Communicate\NoticeBoardController;
use App\Http\Controllers\School\Communicate\EmailSMSController;
use App\Http\Controllers\School\DownloadCenter\UploadContentController;
use App\Http\Controllers\School\Student\StudentAdmissionController;
use App\Http\Controllers\School\Student\StudentCategoryController;
use App\Http\Controllers\School\Student\StudentHouseController;
use App\Http\Controllers\School\Expenses\ExpenseController;
use App\Http\Controllers\School\Expenses\ExpenseHeadController;
use App\Http\Controllers\School\FeeCollection\AddFeesController;
use App\Http\Controllers\School\FeeCollection\FeesDiscountController;
use App\Http\Controllers\School\FeeCollection\FeesGroupController;
use App\Http\Controllers\School\FeeCollection\FeesMasterController;
use App\Http\Controllers\School\FeeCollection\FeesTypeController;
use App\Http\Controllers\School\FrontOffice\AdmissionEnquiryController;
use App\Http\Controllers\School\FrontOffice\ComplainController;
use App\Http\Controllers\School\FrontOffice\ComplainTypeController;
use App\Http\Controllers\School\FrontOffice\PhoneCallController;
use App\Http\Controllers\School\FrontOffice\PostalController;
use App\Http\Controllers\School\FrontOffice\PurposeController;
use App\Http\Controllers\School\FrontOffice\ReferenceController;
use App\Http\Controllers\School\FrontOffice\SourceController;
use App\Http\Controllers\School\FrontOffice\VisitorController;
use App\Http\Controllers\School\Homework\HomeworkController;
use App\Http\Controllers\School\Hostel\HostelController;
use App\Http\Controllers\School\Hostel\HostelRoomController;
use App\Http\Controllers\School\Hostel\RoomTypeController;
use App\Http\Controllers\School\Human_Resource\DepartmentController;
use App\Http\Controllers\School\Human_Resource\DesignationController;
use App\Http\Controllers\School\Human_Resource\EmployeeController;
use App\Http\Controllers\School\Human_Resource\LeaveController;
use App\Http\Controllers\School\Human_Resource\LeaveGroupController;
use App\Http\Controllers\School\Human_Resource\LeaveTypeController;
use App\Http\Controllers\School\Human_Resource\PayrollController;
use App\Http\Controllers\School\Income\IncomeHeadController;
use App\Http\Controllers\School\Income\AddIncomeInfoController;
use App\Http\Controllers\School\Income\SearchIncomeInfoController;
use App\Http\Controllers\School\Inventory\ItemCategoryController;
use App\Http\Controllers\School\Inventory\ItemStoreController;
use App\Http\Controllers\School\Inventory\ItemSupplierController;
use App\Http\Controllers\School\Inventory\InventoryItemController;
use App\Http\Controllers\School\Student\StudentGuardianController;
use App\Http\Controllers\School\Student\StudentAddressController;
use App\Http\Controllers\School\Student\StudentDocumentController;
use App\Http\Controllers\School\Inventory\ItemStockController;
use App\Http\Controllers\School\Inventory\ItemIssueController;
use App\Http\Controllers\School\Certificate\StudentIdCardController;

use App\Http\Controllers\School\Income\IncomeController;
use App\Http\Controllers\School\library\BookController;
use App\Http\Controllers\School\library\CategoryController as LibraryCategoryController;
use App\Http\Controllers\School\library\ReckController;
use App\Http\Controllers\School\Student\StudentHostelController;
use App\Http\Controllers\School\Student\StudentOtherDetailController;
use App\Http\Controllers\School\Student\StudentDetailController;
use App\Http\Controllers\School\Student\StudentTransportController;
use App\Http\Controllers\School\Transport\RouteController;
use App\Http\Controllers\School\Transport\VechiclesAssignController;
use App\Http\Controllers\School\Transport\VechiclesController;
use App\Http\Controllers\School\Examinations\ExamController;
use App\Http\Controllers\School\Examinations\ExamGroupController;
use App\Http\Controllers\School\Examinations\ExamScheduleController;
use App\Http\Controllers\School\Examinations\ExamTypesController;
use App\Http\Controllers\School\Examinations\AssignStudentController;
use App\Http\Controllers\School\Examinations\AddExamSubjectController;
use App\Http\Controllers\School\Examinations\AssignMarksController;
use App\Http\Controllers\School\Examinations\TeacherReMarksController;
use App\Http\Controllers\School\Examinations\DemoScheduleController;
use App\Http\Controllers\School\Examinations\AdmitCardController;
use App\Http\Controllers\School\Examinations\DesignMarksheetController;
use App\Http\Controllers\School\Examinations\PrintAdmitCardController;
use App\Http\Controllers\School\Examinations\MarksGradeController;
use App\Http\Controllers\School\Library\AddStudentController;
use App\Models\Expense;
use App\Models\FeeType;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/school/general/get_class_list', [GeneralController::class, 'getSchoolClasses']);
Route::get('/school/general/get_section_list/{school_class}', [GeneralController::class, 'getSchoolClassSections']);
Route::post('/school/general/get_subject_list', [GeneralController::class, 'getSchoolSubjects']);
Route::get('/school/general/get_department_list', [GeneralController::class, 'getSchoolDepartments']);
Route::get('/all_schools', [GeneralController::class, 'getSchools']);
Route::get('/menus/{school}', [GeneralController::class, 'getMenus']);
Route::post('/this_schools/selected', [GeneralController::class, 'setActiveSchool']);
Route::post('/this_school/activation', [GeneralController::class, 'addActivation']);
Route::get('/school/class/sections/{school_class}', [GeneralController::class, 'getClassSections']);


Route::prefix('school')->group(function () {
    Route::get('/class/{school_class}/section/{school_section}/students', [StudentAdmissionController::class, 'getStudents']);
    Route::prefix('academics')->group(function () {
        Route::prefix('school_classes')->group(function () {
            Route::get('/', [SchoolClassController::class, 'getData'])->name('school-classes.get-data');
            Route::post('/save', [SchoolClassController::class, 'saveData'])->name('school-classes.save-data');
            Route::post('/delete/{school_class}', [SchoolClassController::class, 'changeStatusData'])->name('school-classes.delete-data');
        });
        Route::prefix('school_sections')->group(function () {
            Route::get('/', [SchoolSectionController::class, 'getData'])->name('school-sections.get-data');
            Route::post('/save', [SchoolSectionController::class, 'saveData'])->name('school-sections.save-data');
            Route::post('/delete/{school_section}', [SchoolSectionController::class, 'changeStatusData'])->name('school-sections.delete-data');
            Route::post('/update/{school_section}', [SchoolSectionController::class, 'updateData'])->name('school-sections.update-data');
        });

        Route::prefix('school_subjects')->group(function () {
            Route::get('/get', [SchoolSubjectController::class, 'getData'])->name('school-subjects.get-data');
            Route::get('/', [SchoolSubjectController::class, 'getSubjects']);
            Route::post('/save', [SchoolSubjectController::class, 'saveData'])->name('school-subjects.save-data');
            Route::post('/delete/{subject}', [SchoolSubjectController::class, 'changeStatusData'])->name('school-subjects.delete-data');
            Route::post('/update/{subject}', [SchoolSubjectController::class, 'updateData'])->name('school-subjects.update-data');
        });

        Route::get('assign_class_section', [SchoolClassController::class, 'getClassSections']);
        Route::get('assign_class_section/{school_class}', [SchoolClassController::class, 'getClassSection']);
        Route::prefix('assign')->group(function () {
            Route::get('classes', [AcademicAssignController::class, 'getClassSubject']);
            Route::get('classes/periods', [AcademicAssignController::class, 'getData']);
            Route::post('class_section/period', [AcademicAssignController::class, 'assignPeriod']);
            Route::get('/subjects/teachers', [SchoolTeacherController::class, 'getData']);
            Route::post('/teacher/subjects', [SchoolTeacherController::class, 'getTeacherSubjectData']);
            Route::post('class/time_table', [AcademicAssignController::class, 'assignClassPeriodSubject']);
            Route::post('class/section/periods', [ClassPeriodsController::class, 'getClassSectionperiods']);
            Route::post('/subject/teachers', [SchoolTeacherController::class, 'getSubjctTeacher']);
            Route::post('class_sections/subjects/section/class', [AcademicAssignController::class, 'getClassSectionSubjects']);
            Route::post('/teacher/subjects/{employee}', [SchoolTeacherController::class, 'assignSubjectData']);
            Route::post('class_section/{school_class}', [SchoolClassController::class, 'assignClassSections']);
            Route::post('class_section/subject/{school_class}/{school_section}', [AcademicAssignController::class, 'assignSubject']);
        });
        Route::get('/teachers', [SchoolTeacherController::class, 'getTeacherList']);
        Route::post('/class_period_subjects', [AcademicAssignController::class, 'getTeacherTimeTable']);
        Route::prefix('periods')->group(function () {
            Route::get('/', [ClassPeriodsController::class, 'getData']);
            Route::post('/periods', [ClassPeriodsController::class, 'getPeriodData']);
            Route::post('/save', [ClassPeriodsController::class, 'saveData']);
            Route::post('/update/{class_period}', [ClassPeriodsController::class, 'updateData']);
            Route::post('/delete/{class_period}', [ClassPeriodsController::class, 'changeStatusData']);
            Route::post('class/sections', [ClassPeriodsController::class, 'getSections']);
            Route::get('/', [ClassPeriodsController::class, 'getData']);
        });
    });

    Route::prefix('students')->group(function () {
        Route::prefix('student_admissions')->group(function () {
            Route::post('/', [StudentAdmissionController::class, 'getClassStudentData']);
            Route::post('/students', [StudentAdmissionController::class, 'getData2']);
            // Route::post('/get', [StudentAdmissionController::class, 'getData']);
            Route::get('/house_list', [StudentAdmissionController::class, 'getHouseList']);
            Route::get('/students', [StudentAdmissionController::class, 'getStudentData']);
            Route::post('/save', [StudentAdmissionController::class, 'saveData'])->name('student_admissions.save-data');
            Route::get('/edit/{admission}', [StudentAdmissionController::class, 'getEditItemData']);
            Route::post('/update/{admission}', [StudentAdmissionController::class, 'updateData']);
            Route::post('/delete/{student_admission}', [StudentAdmissionController::class, 'changeStatusData']);
            Route::get('/id_card/{school_class}/{school_section}', [StudentAdmissionController::class, 'getDataCertificate']);
        });
        Route::prefix('student_houses')->group(function () {
            Route::get('/', [StudentHouseController::class, 'getData'])->name('student_houses.get-data');
            Route::post('/save', [StudentHouseController::class, 'saveData'])->name('student_houses.save-data');
            Route::post('/delete/{student_house}', [StudentHouseController::class, 'changeStatusData'])->name('student_houses.delete-data');
            Route::post('/update/{student_house}', [StudentHouseController::class, 'updateData'])->name('student_houses.update-data');
        });
        Route::prefix('student_categories')->group(function () {
            Route::get('/', [StudentCategoryController::class, 'getData'])->name('student_categories.get-data');
            Route::get('/category_list', [StudentCategoryController::class, 'getCategory']);
            Route::post('/save', [StudentCategoryController::class, 'saveData'])->name('student_categories.save-data');
            Route::post('/delete/{student_category}', [StudentCategoryController::class, 'changeStatusData'])->name('student_categories.delete-data');
            Route::post('/update/{student_category}', [StudentCategoryController::class, 'updateData'])->name('student_categories.update-data');
        });
        Route::prefix('student_hostels')->group(function () {
            Route::get('/', [StudentHostelController::class, 'getData'])->name('student_hostels.get-data');
            Route::get('/hostel_list', [StudentHostelController::class, 'getHostelList']);
            Route::post('/edit', [StudentHostelController::class, 'getEditItemData']);
            Route::post('/save', [StudentHostelController::class, 'saveData'])->name('student_hostels.save-data');
            Route::get('/hostel_list/{hostel}', [StudentHostelController::class, 'getRoomType']);
            Route::post('/delete/{student_hostel}', [StudentHostelController::class, 'changeStatusData'])->name('student_hostels.delete-data');
            Route::post('/update/{student_hostel}', [StudentHostelController::class, 'updateData'])->name('student_hostels.update-data');
        });
        Route::prefix('student_guardian_details')->group(function () {
            Route::get('/', [StudentGuardianController::class, 'getData'])->name('student_guardian_details.get-data');
            Route::post('/save', [StudentGuardianController::class, 'saveData']);
            Route::get('/edit/{student_guardian}', [StudentGuardianController::class, 'getEditItemData']);
            Route::post('/update/{student_guardian}', [StudentGuardianController::class, 'updateData'])->name('student_guardian_details.update-data');
            // Route::post('/delete/{student_guardian_detail}', [StudentGuardianController::class, 'changeStatusData'])->name('student_guardian_details.delete-data');
        });
        Route::prefix('student_addresses')->group(function () {
            Route::get('/', [StudentAddressController::class, 'getData'])->name('student_addresses.get-data');
            Route::post('/save', [StudentAddressController::class, 'saveData'])->name('student_addresses.save-data');
            Route::post('/edit', [StudentAddressController::class, 'editItemData']);
            Route::post('/delete/{student_address}', [StudentAddressController::class, 'changeStatusData'])->name('student_addresses.delete-data');
            Route::post('/update/{student_address}', [StudentAddressController::class, 'updateData'])->name('student_addresses.update-data');
            Route::get('/{admission_id}', [StudentAddressController::class, 'getStudentData']);
        });
        Route::prefix('student_transports')->group(function () {
            Route::get('/', [StudentTransportController::class, 'getData'])->name('student_transports.get-data');
            Route::get('/route_list', [StudentTransportController::class, 'getRoute']);
            Route::post('/edit', [StudentTransportController::class, 'getEditItemData']);
            Route::post('/save', [StudentTransportController::class, 'saveData'])->name('student_transports.save-data');
            Route::post('/delete/{student_transport}', [StudentTransportController::class, 'changeStatusData'])->name('student_transports.delete-data');
            Route::post('/update/{student_transport}', [StudentTransportController::class, 'updateData'])->name('student_transports.update-data');
        });
        Route::prefix('student_documents')->group(function () {
            Route::get('/', [StudentDocumentController::class, 'getData'])->name('student_documents.get-data');
            Route::post('/edit', [StudentDocumentController::class, 'getEditData']);
            Route::post('/save', [StudentDocumentController::class, 'saveData'])->name('student_documents.save-data');
            Route::post('/delete/{student_document}', [StudentDocumentController::class, 'changeStatusData'])->name('student_documents.delete-data');
            Route::post('/update', [StudentDocumentController::class, 'updateData']);
        });
        Route::prefix('student_other_details')->group(function () {
            Route::get('/', [StudentOtherDetailController::class, 'getData'])->name('student_other_details.get-data');
            Route::post('/save', [StudentOtherDetailController::class, 'saveData'])->name('student_other_details.save-data');
            Route::post('/edit', [StudentOtherDetailController::class, 'getEditItemData']);
            Route::post('/delete/{student_other_detail}', [StudentOtherDetailController::class, 'changeStatusData'])->name('student_other_details.delete-data');
            Route::post('/update/{student_other_detail}', [StudentOtherDetailController::class, 'updateData'])->name('student_other_details.update-data');
        });
        Route::prefix('/student_details')->group(function () {
            Route::get('/all_students', [StudentDetailController::class, 'getAllStudents']);
            Route::get('/{admission}', [StudentDetailController::class, 'getAdmissionData']);
            Route::post('/delete/{admission}', [StudentDetailController::class, 'changeStatusData']);
            Route::post('/update/{admission}', [StudentDetailController::class, 'updateData']);
            Route::get('/{school_class}/{school_section}', [StudentAdmissionController::class, 'getDataCertificate']);
            // Route::get('/', [StudentDetailController::class, 'getData']);
        });
        Route::post('/ex_student', [StudentDetailController::class, 'getExStudent']);
    });
    Route::prefix('attendance')->group(function () {
        Route::prefix('student_attendance')->group(function () {
            Route::post('/', [StudentAttendanceController::class, 'getData'])->name('student_attendances.get-data');
            Route::post('/save', [StudentAttendanceController::class, 'saveData'])->name('student_attendances.save-data');
            Route::post('/delete/{student_attendance}', [StudentAttendanceController::class, 'changeStatusData'])->name('student_attendances.delete-data');
            Route::post('/update/{student_attendance}', [StudentAttendanceController::class, 'updateData'])->name('student_attendances.update-data');
        });
        Route::prefix('employee_attendance')->group(function () {
            Route::post('/', [EmployeeAttendanceController::class, 'getData']);
            Route::post('/save', [EmployeeAttendanceController::class, 'saveData']);
            Route::post('/delete/{employee_attendance}', [EmployeeAttendanceController::class, 'changeStatusData']);
            Route::post('/update/{employee_attendance}', [EmployeeAttendanceController::class, 'updateData']);
        });
    });

    Route::prefix('certificate')->group(function () {
        Route::prefix('student_certificate')->group(function () {
            Route::get('/show_list', [StudentCertificateController::class, 'getData']);
            Route::get('/certificate_list', [StudentCertificateController::class, 'getCertificateList']);
            Route::get('/{admission}/{certificate}', [StudentCertificateController::class, 'getGeneratedCertificate']);
            Route::post('/save', [StudentCertificateController::class, 'saveData'])->name('student_certificates.save-data');
            Route::get('/edit/{certificate}', [StudentCertificateController::class, 'getEditData']);
            Route::post('/delete/{certificate}', [StudentCertificateController::class, 'changeStatusData'])->name('student_certificates.delete-data');
            Route::post('/update/{certificate}', [StudentCertificateController::class, 'updateData'])->name('student_certificates.update-data');
        });
        Route::prefix('generate_certificate')->group(function () {
            Route::post('/save', [StudentCertificateController::class, 'saveData2']);
        });
        Route::prefix('id_card')->group(function () {
            Route::post('/save', [StudentIdCardController::class, 'saveData']);
            Route::get('/show_list', [StudentIdCardController::class, 'showData']);
            Route::get('/get_idCard_list', [StudentIdCardController::class, 'getIdCardList']);
            Route::post('/update/{student_id_card}', [StudentIdCardController::class, 'updateData']);
            Route::post('/delete/{student_id_card}', [StudentIdCardController::class, 'changeStatusData']);
        });
        Route::prefix('generate_id_card')->group(function () {
            Route::post('/save', [StudentIdCardController::class, 'saveData2']);
            Route::get('/show_list', [StudentIdCardController::class, 'showData']);
            Route::get('/{admission}/{studentIdCard}', [StudentIdCardController::class, 'getGeneratedIdCards']);
        });
    });

    Route::prefix('communicate')->group(function () {
        Route::prefix('notice_board')->group(function () {
            Route::get('/', [NoticeBoardController::class, 'getData']);
            Route::post('/save', [NoticeBoardController::class, 'saveData']);
            Route::get('/{notice_board}', [NoticeBoardController::class, 'viewPageData']);
            Route::get('/edit/{notice_board}', [NoticeBoardController::class, 'getEditItemData']);
            Route::post('/update/{notice_board}', [NoticeBoardController::class, 'updateData']);
            Route::post('/delete/{notice_board}', [NoticeBoardController::class, 'changeStatusData']);
        });
        Route::prefix('send_email')->group(function () {
            Route::post('/', [EmailSMSController::class, 'selectedDepartmentList']);
            Route::get('/department', [EmailSMSController::class, 'getDepartment']);
            Route::get('/', [EmailSMSController::class, 'showData']);
            Route::get('/{message}', [EmailSMSController::class, 'getViewPageData']);
            Route::get('/department', [EmailSMSController::class, 'getDepartmentDropdown']);
            Route::post('/save', [EmailSMSController::class, 'saveData'])->name('send_messages.save-data');
            Route::get('/edit/{message}', [EmailSMSController::class, 'getEditItemData']);
            Route::post('/delete/{message}', [EmailSMSController::class, 'changeStatusData']);
            Route::post('/update/{message}', [EmailSMSController::class, 'updateData']);
        });
    });
    Route::prefix('download_center')->group(function () {
        Route::post('/contents', [UploadContentController::class, 'getData']);
        Route::prefix('upload_content')->group(function () {
            Route::post('/save', [UploadContentController::class, 'saveData'])->name('upload_contents.save-data');
            Route::post('/delete/{content}', [UploadContentController::class, 'changeStatusData'])->name('upload_contents.delete-data');
            Route::post('/update/{content}', [UploadContentController::class, 'updateData'])->name('upload_contents.update-data');
            Route::get('/{content}', [UploadContentController::class, 'getContentData']);
            Route::get('/edit/{content}', [UploadContentController::class, 'getEditItemData']);
            Route::get('/{school_section}/{school_class}', [UploadContentController::class, 'getData']);
        });
    });

    Route::get('/general/class/{school_class}/sections', [GeneralController::class, 'getClassSections']);
    Route::get('/general/session', [GeneralController::class, 'getSession']);

    Route::prefix('expenses')->group(function () {
        Route::prefix('expense_heads')->group(function () {
            Route::get('/', [ExpenseHeadController::class, 'getData'])->name('expense-heads.get-data');
            Route::post('/save', [ExpenseHeadController::class, 'saveData'])->name('expense-heads.save-data');
            Route::get('/edit/{expense_head}', [ExpenseHeadController::class, 'getEditData']);
            Route::post('/update/{expense_head}', [ExpenseHeadController::class, 'updateData'])->name('expense-heads.update-data');
            Route::post('/delete/{expense_head}', [ExpenseHeadController::class, 'changeStatusData'])->name('expense-heads.delete-data');
        });
        Route::prefix('expenses')->group(function () {
            Route::get('/', [ExpenseController::class, 'getData'])->name('expenses.get-data');
            Route::post('/save', [ExpenseController::class, 'saveData'])->name('expenses.save-data');
            Route::get('/expense_head_list', [ExpenseController::class, 'getExpenseHeadData']);
            Route::get('/edit/{expense}', [ExpenseController::class, 'getEditData']);
            Route::post('/update/{expense}', [ExpenseController::class, 'updateData'])->name('expenses.update-data');
            Route::post('/delete/{expense}', [ExpenseController::class, 'changeStatusData'])->name('expenses.delete-data');
        });
    });

    Route::prefix('fees_collection')->group(function () {
        Route::prefix('fees_groups')->group(function () {
            Route::get('/', [FeesGroupController::class, 'getData'])->name('fees_groups.get-data');
            Route::post('/save', [FeesGroupController::class, 'saveData'])->name('fees_groups.save-data');
            Route::get('/edit/{fees_group}', [FeesGroupController::class, 'getEditData']);
            Route::post('/update/{fees_group}', [FeesGroupController::class, 'updateData'])->name('fees_groups.update-data');
            Route::post('/delete/{fees_group}', [FeesGroupController::class, 'changeStatusData'])->name('fees_groups.delete-data');
        });
        Route::prefix('fees_types')->group(function () {
            Route::get('/', [FeesTypeController::class, 'getData'])->name('fees_types.get-data');
            Route::post('/save', [FeesTypeController::class, 'saveData'])->name('fees_types.save-data');
            Route::get('/edit/{fees_type}', [FeesTypeController::class, 'getEditData']);
            Route::post('/update/{fees_type}', [FeesTypeController::class, 'updateData'])->name('fees_types.update-data');
            Route::post('/delete/{fees_type}', [FeesTypeController::class, 'changeStatusData'])->name('fees_types.delete-data');
        });
        Route::prefix('fees_discount')->group(function () {
            Route::get('/', [FeesDiscountController::class, 'getData'])->name('fees_discount.get-data');
            Route::post('/save', [FeesDiscountController::class, 'saveData'])->name('fees_discount.save-data');
            Route::get('/edit/{fees_discount}', [FeesDiscountController::class, 'getEditData']);
            Route::post('/update/{fees_discount}', [FeesDiscountController::class, 'updateData'])->name('fees_discount.update-data');
            Route::post('/delete/{fees_discount}', [FeesDiscountController::class, 'changeStatusData'])->name('fees_discount.delete-data');
        });
        Route::prefix('fees_master')->group(function () {
            Route::get('/', [FeesMasterController::class, 'getData'])->name('fees_master.get-data');
            Route::post('/save', [FeesMasterController::class, 'saveData'])->name('fees_master.save-data');
            Route::get('/data_list', [FeesMasterController::class, 'getClassFeesTypeData']);
            Route::post('/fees_group_list', [FeesMasterController::class, 'getFeesGroupData']);
            Route::get('/edit/{fees_master}', [FeesMasterController::class, 'getEditData']);
            Route::post('/update/{fees_master}', [FeesMasterController::class, 'updateData'])->name('fees_master.update-data');
            Route::post('/delete/{fees_master}', [FeesMasterController::class, 'changeStatusData'])->name('fees_master.delete-data');
        });
        Route::prefix('add_fees')->group(function () {
            Route::get('/', [AddFeesController::class, 'getData'])->name('add_fees.get-data');
            Route::post('/save', [AddFeesController::class, 'saveData'])->name('add_fees.save-data');
            Route::post('/fees_discount_list', [AddFeesController::class, 'getFeesDiscountData']);
            Route::get('/edit/{fee}', [AddFeesController::class, 'getEditData']);
            Route::post('/update/{fee}', [AddFeesController::class, 'updateData'])->name('add_fees.update-data');
            Route::post('/delete/{add_fees}', [AddFeesController::class, 'changeStatusData'])->name('add_fees.delete-data');
        });
        Route::prefix('collect_fees')->group(function () {
            Route::post('/student_collect_fees', [FeesMasterController::class, 'getAdmissionData']);
            Route::get('/student_fees/{admission}', [FeesMasterController::class, 'getAdmissionDetailData']);
            Route::get('/fees_payment/{admission}/{fee_master}', [FeesMasterController::class, 'getFeesPaymentData']);
        });
    });

    Route::prefix('front_office')->group(function () {
        Route::prefix('purpose')->group(function () {
            Route::get('/', [PurposeController::class, 'getData'])->name('purpose.get-data');
            Route::post('/save', [PurposeController::class, 'saveData'])->name('purpose.save-data');
            Route::get('/edit/{purpose}', [PurposeController::class, 'getEditData']);
            Route::post('/update/{purpose}', [PurposeController::class, 'updateData'])->name('purpose.update-data');
            Route::post('/delete/{purpose}', [PurposeController::class, 'changeStatusData'])->name('purpose.delete-data');
        });
        Route::prefix('complain_type')->group(function () {
            Route::get('/', [ComplainTypeController::class, 'getData'])->name('complain_type.get-data');
            Route::post('/save', [ComplainTypeController::class, 'saveData'])->name('complain_type.save-data');
            Route::get('/edit/{complain_type}', [ComplainTypeController::class, 'getEditData']);
            Route::post('/update/{complain_type}', [ComplainTypeController::class, 'updateData'])->name('complain_type.update-data');
            Route::post('/delete/{complain_type}', [ComplainTypeController::class, 'changeStatusData'])->name('complain_type.delete-data');
        });
        Route::prefix('source')->group(function () {
            Route::get('/', [SourceController::class, 'getData'])->name('source.get-data');
            Route::post('/save', [SourceController::class, 'saveData'])->name('source.save-data');
            Route::get('/edit/{source}', [SourceController::class, 'getEditData']);
            Route::post('/update/{source}', [SourceController::class, 'updateData'])->name('source.update-data');
            Route::post('/delete/{source}', [SourceController::class, 'changeStatusData'])->name('source.delete-data');
        });
        Route::prefix('reference')->group(function () {
            Route::get('/', [ReferenceController::class, 'getData'])->name('reference.get-data');
            Route::post('/save', [ReferenceController::class, 'saveData'])->name('reference.save-data');
            Route::get('/edit/{reference}', [ReferenceController::class, 'getEditData']);
            Route::post('/update/{reference}', [ReferenceController::class, 'updateData'])->name('reference.update-data');
            Route::post('/delete/{reference}', [ReferenceController::class, 'changeStatusData'])->name('reference.delete-data');
        });
        Route::prefix('complain')->group(function () {
            Route::get('/', [ComplainController::class, 'getData'])->name('complain.get-data');
            Route::get('/complain_view/{complain}', [ComplainController::class, 'getComplainData']);
            Route::post('/save', [ComplainController::class, 'saveData'])->name('complain.save-data');
            Route::get('/complain_type_list', [ComplainController::class, 'getComplainTypeData']);
            Route::get('/source_list', [ComplainController::class, 'getSourceData']);
            Route::get('/edit/{complain}', [ComplainController::class, 'getEditData']);
            Route::post('/update/{complain}', [ComplainController::class, 'updateData'])->name('complain.update-data');
            Route::post('/delete/{complain}', [ComplainController::class, 'changeStatusData'])->name('complain.delete-data');
        });
        Route::prefix('postal')->group(function () {
            Route::get('/', [PostalController::class, 'getData'])->name('postal.get-data');
            Route::get('/postal_view/{postal}', [PostalController::class, 'getPostalData']);
            Route::post('/save', [PostalController::class, 'saveData'])->name('postal.save-data');
            Route::get('/edit/{postal}', [PostalController::class, 'getEditData']);
            Route::post('/update/{postal}', [PostalController::class, 'updateData'])->name('postal.update-data');
            Route::post('/delete/{postal}', [PostalController::class, 'changeStatusData'])->name('postal.delete-data');
        });
        Route::prefix('phone_call')->group(function () {
            Route::get('/', [PhoneCallController::class, 'getData'])->name('phone_call.get-data');
            Route::get('/phone_call_view/{call_log}', [PhoneCallController::class, 'getCallData']);
            Route::post('/save', [PhoneCallController::class, 'saveData'])->name('phone_call.save-data');
            Route::get('/edit/{call_log}', [PhoneCallController::class, 'getEditData']);
            Route::post('/update/{call_log}', [PhoneCallController::class, 'updateData'])->name('phone_call.update-data');
            Route::post('/delete/{call_log}', [PhoneCallController::class, 'changeStatusData'])->name('phone_call.delete-data');
        });
        Route::prefix('visitors')->group(function () {
            Route::get('/', [VisitorController::class, 'getData'])->name('visitors.get-data');
            Route::get('/visitor_view/{visitor}', [VisitorController::class, 'getVisitorData']);
            Route::post('/save', [VisitorController::class, 'saveData'])->name('visitors.save-data');
            Route::get('/purpose_list', [VisitorController::class, 'getPurposeData']);
            Route::get('/edit/{visitor}', [VisitorController::class, 'getEditData']);
            Route::post('/update/{visitor}', [VisitorController::class, 'updateData'])->name('visitors.update-data');
            Route::post('/delete/{visitor}', [VisitorController::class, 'changeStatusData'])->name('visitors.delete-data');
        });
        Route::prefix('admission_enquiry')->group(function () {
            Route::get('/', [AdmissionEnquiryController::class, 'getData'])->name('admission_enquiry.get-data');
            Route::get('/admission_enquiry_view/{enquiry_student}', [AdmissionEnquiryController::class, 'getAdmissionEnquiryData']);
            Route::post('/save', [AdmissionEnquiryController::class, 'saveData'])->name('admission_enquiry.save-data');
            Route::get('/data_list', [AdmissionEnquiryController::class, 'getClassData']);
            Route::get('/edit/{admission_enquiry}', [AdmissionEnquiryController::class, 'getEditData']);
            Route::post('/update/{admission_enquiry}', [AdmissionEnquiryController::class, 'updateData'])->name('admission_enquiry.update-data');
            Route::post('/delete/{enquiry_student}', [AdmissionEnquiryController::class, 'changeStatusData'])->name('admission_enquiry.delete-data');
            Route::post('/status/{enquiry_student}', [AdmissionEnquiryController::class, 'changeStatusData']);
        });
    });
    Route::prefix('examinations')->group(function () {
        Route::prefix('exam_type')->group(function () {
            Route::get('/', [ExamTypesController::class, 'showData']);
            Route::post('/save', [ExamTypesController::class, 'saveData']);
            Route::post('/update/{exam_type}', [ExamTypesController::class, 'updateData']);
            Route::post('/delete/{exam_type}', [ExamTypesController::class, 'deleteData']);
        });
        Route::prefix('exam_group')->group(function () {
            Route::get('/', [ExamGroupController::class, 'showData']);
            Route::get('/getExamGroup', [ExamGroupController::class, 'getExamGroupList']);
            Route::get('/exam_type_list', [ExamGroupController::class, 'getExamType']);
            Route::post('/save', [ExamGroupController::class, 'saveData']);
            Route::post('/update/{exam_group}', [ExamGroupController::class, 'updateData']);
            Route::post('/delete/{exam_group}', [ExamGroupController::class, 'changeStatusData']);
        });
        Route::prefix('addNew_exam')->group(function () {
            Route::post('/save', [ExamController::class, 'saveData']);
            Route::post('/exams', [ExamController::class, 'getExams']);
            Route::get('/{exam_group}', [ExamController::class, 'getExamNames']);
            Route::get('/edit/{add_new_exam}', [ExamController::class, 'getEditItemData']);
            Route::post('/update/{add_new_exam}', [ExamController::class, 'updateData']);
            Route::post('/delete/{add_new_exam}', [ExamController::class, 'changeStatusData']);
        });
        Route::prefix('addexam_subjects')->group(function () {
            Route::post('/save', [AddExamSubjectController::class, 'saveData']);
            Route::post('/', [AddExamSubjectController::class, 'getExamSubject']);
        });
        Route::prefix('assign_students')->group(function () {
            Route::post('/save', [AssignStudentController::class, 'saveData']);
            Route::post('/get', [StudentAdmissionController::class, 'getClassStudentData']);
        });
        Route::prefix('assign_marks')->group(function () {
            Route::post('/', [AssignMarksController::class, 'getExamSubjectData']);
            Route::post('/save', [AssignMarksController::class, 'saveData']);
            Route::post('/result', [AssignMarksController::class, 'getResult']);
        });

        Route::prefix('teacher_remarks')->group(function () {
            Route::post('/save', [TeacherReMarksController::class, 'saveData']);
            Route::post('/', [TeacherReMarksController::class, 'getStudents']);
        });
        Route::prefix('exam_schedule')->group(function () {
            Route::get('/', [ExamScheduleController::class, 'showData']);
            Route::get('/exam_names', [ExamScheduleController::class, 'getExamName']);
            Route::get('/exam_type_list', [ExamScheduleController::class, 'getExamType']);
            Route::post('/save', [ExamScheduleController::class, 'saveData']);
            Route::get('/edit/{exam_schedule}', [ExamScheduleController::class, 'getEditData']);
            Route::post('/update/{exam_schedule}', [ExamScheduleController::class, 'updateData']);
            Route::post('/delete/{exam_schedule}', [ExamScheduleController::class, 'changeStatusData']);
        });
        Route::prefix('demo_exam_schedule')->group(function () {
            Route::get('/get', [DemoScheduleController::class, 'getData']);
            Route::get('/{exam_group}', [DemoScheduleController::class, 'getExams']);
        });
        Route::prefix('admit_card')->group(function () {
            Route::get('/', [AdmitCardController::class, 'getExams']);
            Route::get('/get', [AdmitCardController::class, 'showData']);
            Route::post('/save', [AdmitCardController::class, 'saveData']);
            Route::post('/update/{admit_card}', [AdmitCardController::class, 'updateData']);
            Route::post('/delete/{admit_card}', [AdmitCardController::class, 'changeStatusData']);
        });
        Route::prefix('print_admit_card')->group(function () {
            Route::get('/templates', [PrintAdmitCardController::class, 'getTemplateList']);
            Route::get('/{school_section}{school_class}', [PrintAdmitCardController::class, 'getStudents']);
            Route::get('/{admission}/{admit_card}', [PrintAdmitCardController::class, 'getGeneratedAdmitCards']);
        });
        Route::prefix('design_marksheet')->group(function () {
            Route::post('/save', [DesignMarksheetController::class, 'saveData']);
            Route::get('/get', [DesignMarksheetController::class, 'showData']);
            Route::get('/templates', [DesignMarksheetController::class, 'getTemplateList']);
            Route::post('/getMarks', [DesignMarksheetController::class, 'getMarks']);
            Route::post('/update/{design_marksheet}', [DesignMarksheetController::class, 'updateData']);
            Route::post('/delete/{design_marksheet}', [DesignMarksheetController::class, 'changeStatusData']);
            Route::get('/{admission}/{design_marksheet}', [DesignMarksheetController::class, 'getGeneratedMarksheet']);
        });
        Route::prefix('marks_grade')->group(function () {
            Route::get('/exam_type_list', [MarksGradeController::class, 'getExamType']);
            Route::post('/save', [MarksGradeController::class, 'saveData']);
            Route::get('/get', [MarksGradeController::class, 'showData']);
            Route::post('/update/{marks_grade}', [MarksGradeController::class, 'updateData']);
            Route::post('/delete/{marks_grade}', [MarksGradeController::class, 'changeStatusData']);
        });
    });

    Route::prefix('hr')->group(function () {
        Route::prefix('employees')->group(function () {
            Route::get('/', [EmployeeController::class, 'getData']);
            Route::post('/basic_information/save', [EmployeeController::class, 'saveBasicInformationData']);
            Route::post('/basic_information/update/{employee}', [EmployeeController::class, 'updateBasicInformationData']);
            Route::post('/address/update/{employee}', [EmployeeController::class, 'updateAddressData']);
            Route::post('/documents/update/{employee}', [EmployeeController::class, 'updateDocumentData']);
            Route::get('/edit/{employee}', [EmployeeController::class, 'getEditData']);
            Route::get('/edit/{employee}/documents', [EmployeeController::class, 'getEmployeeDownloadData']);
            Route::post('/save', [EmployeeController::class, 'saveData'])->name('employee.save-data');
            Route::post('/save_address/{employee}', [EmployeeController::class, 'saveAddressData'])->name('employee.save-address-data');
            Route::get('/data_list', [EmployeeController::class, 'getDesignationDepartmentData']);
            Route::post('/update/{employee}', [EmployeeController::class, 'updateData'])->name('employee.update-data');
            Route::post('/delete/{employee}', [EmployeeController::class, 'changeStatusData'])->name('employee.delete-data');
        });
        Route::prefix('departments')->group(function () {
            Route::get('/', [DepartmentController::class, 'getData']);
            Route::post('/save', [DepartmentController::class, 'saveData']);
            Route::post('/update/{department}', [DepartmentController::class, 'updateData'])->name('department.update-data');
            Route::post('/delete/{department}', [DepartmentController::class, 'changeStatusData'])->name('department.delete-data');
        });
        Route::prefix('designation')->group(function () {
            Route::get('/', [DesignationController::class, 'getData'])->name('designation.get-data');
            Route::post('/save', [DesignationController::class, 'saveData'])->name('designation.save-data');
            Route::post('/update/{designation}', [DesignationController::class, 'updateData'])->name('designation.save_address-data');
            Route::post('/delete/{designation}', [DesignationController::class, 'changeStatusData'])->name('designation.delete-data');
        });
        Route::prefix('pay_roll')->group(function () {
            Route::get('/', [PayrollController::class, 'getData'])->name('pay_roll.get-data');
            Route::post('/save', [PayrollController::class, 'saveData'])->name('pay_roll.save-data');
            Route::get('/edit/{pay_roll}', [PayrollController::class, 'getEditData']);
            Route::post('/update/{pay_roll}', [PayrollController::class, 'updateData'])->name('pay_roll.update-data');
            Route::post('/delete/{pay_roll}', [PayrollController::class, 'changeStatusData'])->name('pay_roll.delete-data');
        });
        Route::prefix('leaves')->group(function () {
            Route::get('/', [LeaveController::class, 'getData']);
            Route::get('/getLeaveType', [LeaveController::class, 'getLeaveTypes']);
            Route::post('/save', [LeaveController::class, 'saveData']);

            Route::prefix('groups')->group(function () {
                Route::get('/', [LeaveGroupController::class, 'getData']);
                Route::post('/save', [LeaveGroupController::class, 'saveData']);
                Route::post('/update/{leave_group}', [LeaveGroupController::class, 'updateData']);
                Route::post('/delete/{leave_group}', [LeaveGroupController::class, 'deleteData']);
                Route::get('/{leave_group}/rules', [LeaveGroupController::class, 'getRuleData']);
                Route::post('/{leave_group}/rules/save', [LeaveGroupController::class, 'saveRuleData']);
            });

            Route::prefix('types')->group(function () {
                Route::get('/', [LeaveTypeController::class, 'getData']);
                Route::post('/save', [LeaveTypeController::class, 'saveData']);
                Route::post('/update/{leave_type}', [LeaveTypeController::class, 'updateData']);
                Route::post('/delete/{leave_type}', [LeaveTypeController::class, 'deleteData']);
            });
        });
    });

    Route::prefix('homework')->group(function () {
        Route::prefix('homework')->group(function () {
            Route::get('/', [HomeworkController::class, 'getData'])->name('homework.get-data');
            Route::get('/homework_view/{homework}', [HomeworkController::class, 'getHomeworkData']);
            Route::post('/save', [HomeworkController::class, 'saveData'])->name('homework.save-data');
            Route::get('/data_list', [HomeworkController::class, 'getClassSectionSubjectData']);
            Route::get('/edit/{homework}', [HomeworkController::class, 'getEditData']);
            Route::post('/update/{homework}', [HomeworkController::class, 'updateData'])->name('homework.update-data');
            Route::post('/delete/{homework}', [HomeworkController::class, 'changeStatusData'])->name('homework.delete-data');
            Route::post('/update_date/{homework}', [HomeworkController::class, 'updateDate']);
            Route::post('/update_evaluaton_date/{homework}', [HomeworkController::class, 'updateEvaluationDate']);
        });
    });

    Route::prefix('hostel')->group(function () {
        Route::prefix('hostel')->group(function () {
            Route::get('/', [HostelController::class, 'getData'])->name('hostel.get-data');
            Route::post('/save', [HostelController::class, 'saveData'])->name('hostel.save-data');
            Route::get('/edit/{hostel}', [HostelController::class, 'getEditData']);
            Route::post('/update/{hostel}', [HostelController::class, 'updateData'])->name('hostel.update-data');
            Route::post('/delete/{hostel}', [HostelController::class, 'changeStatusData'])->name('hostel.delete-data');
        });
        Route::prefix('room_type')->group(function () {
            Route::get('/', [RoomTypeController::class, 'getData'])->name('room_type.get-data');
            Route::post('/save', [RoomTypeController::class, 'saveData'])->name('room_type.save-data');
            Route::get('/hostel_list', [RoomTypeController::class, 'getHostelData']);
            Route::get('/{hostel}', [HostelRoomController::class, 'getHostelRoomTypes']);
            Route::get('/edit/{room_type}', [RoomTypeController::class, 'getEditData']);
            Route::post('/update/{room_type}', [RoomTypeController::class, 'updateData'])->name('room_type.update-data');
            Route::post('/delete/{room_type}', [RoomTypeController::class, 'changeStatusData'])->name('room_type.delete-data');
        });
        Route::prefix('hostel_room')->group(function () {
            Route::get('/', [HostelRoomController::class, 'getData'])->name('hostel_room.get-data');
            Route::post('/save', [HostelRoomController::class, 'saveData'])->name('hostel_room.save-data');
            Route::get('/data_list', [HostelRoomController::class, 'getHostelRoomTypeData']);
            Route::get('/edit/{hostel_room}', [HostelRoomController::class, 'getEditData']);
            Route::post('/update/{hostel_room}', [HostelRoomController::class, 'updateData'])->name('hostel_room.update-data');
            Route::post('/delete/{hostel_room}', [HostelRoomController::class, 'changeStatusData'])->name('hostel_room.delete-data');
        });
    });

    Route::prefix('income')->group(function () {

        Route::prefix('IncomeHead')->group(function () {
            Route::get('/', [IncomeHeadController::class, 'getData']);
            Route::post('/save', [IncomeHeadController::class, 'saveData'])->name('income_heads.save-data');
            Route::get('/editData/{income_head}', [IncomeHeadController::class, 'getEditData'])->name('income_heads.edit-data');
            Route::post('/update/{income_head}', [IncomeHeadController::class, 'updateData'])->name('income_heads.update-data');
            Route::get('/delete/{income_head}', [IncomeHeadController::class, 'deleteData'])->name('income_heads.delete-data');
        });

        Route::prefix('SearchIncome')->group(function () {
            Route::get('/', [SearchIncomeInfoController::class, 'getData']);
            Route::get('/detail/{add_income_info}', [SearchIncomeInfoController::class, 'getDataDetail']);
            Route::get('/income_head_list', [SearchIncomeInfoController::class, 'getIncomeHeadData']);
            Route::get('/{add_income_info}', [SearchIncomeInfoController::class, 'geIncomeData']);
            // Route::post('/save', [SearchIncomeInfoController::class, 'saveData']);
            // Route::get('/editData/{add_income_info}', [SearchIncomeInfoController::class, 'getEditData'])->name('incomes.edit-data');
            // Route::post('/update/{add_income_info}', [SearchIncomeInfoController::class, 'updateData'])->name('incomes.update-data');
            // Route::get('/delete/{add_income_info}', [SearchIncomeInfoController::class, 'deleteData'])->name('incomes.delete-data');
        });

        Route::prefix('AddIncome')->group(function () {
            Route::get('/income_head_list', [AddIncomeInfoController::class, 'getIncomeHeadData']);
            Route::get('/income_item_list', [AddIncomeInfoController::class, 'getIncomeItemData']);
            Route::get('/', [AddIncomeInfoController::class, 'getData']);
            Route::post('/save', [AddIncomeInfoController::class, 'saveData']);
            Route::get('/editData/{add_income_info}', [AddIncomeInfoController::class, 'getEditData'])->name('incomes.edit-data');
            Route::post('/update/{add_income_info}', [AddIncomeInfoController::class, 'updateData'])->name('incomes.update-data');
            Route::get('/delete/{add_income_info}', [AddIncomeInfoController::class, 'deleteData'])->name('incomes.delete-data');
        });

        Route::prefix('AddIncomeStaff')->group(function () {
            Route::get('/', [IncomeController::class, 'getData']);
            Route::post('/save', [IncomeController::class, 'saveData']);
            Route::get('/editData/{income}', [IncomeController::class, 'getEditData']);
            Route::post('/update/{income}', [IncomeController::class, 'updateData']);
            Route::get('/delete/{income}', [IncomeController::class, 'deleteData']);
        });
        Route::prefix('AddIncomeForm')->group(function () {
            Route::get('/', [IncomeController::class, 'getData']);
            Route::post('/save', [IncomeController::class, 'saveData']);
            Route::get('/editData/{income}', [IncomeController::class, 'getEditData']);
            Route::post('/update/{income}', [IncomeController::class, 'updateData']);
            Route::get('/delete/{income}', [IncomeController::class, 'deleteData']);
        });
    });

    Route::prefix('transport')->group(function () {

        Route::prefix('AddTransportRoutes')->group(function () {
            Route::get('/', [RouteController::class, 'getData']);
            Route::post('/save', [RouteController::class, 'saveData'])->name('route_name.save-data');
            Route::get('/editData/{school_route}', [RouteController::class, 'getEditData'])->name('route_name.edit-data');
            Route::post('/update/{school_route}', [RouteController::class, 'updateData'])->name('route_name.update-data');
            Route::post('/delete/{school_route}', [RouteController::class, 'deleteData'])->name('route_name.delete-data');
        });
        Route::prefix('route_points')->group(function () {
        });
        Route::prefix('assign_vehicle')->group(function () {
            Route::get('/', [VechiclesAssignController::class, 'getData']);
            Route::get('/route_list', [VechiclesAssignController::class, 'getRouteData']);
            Route::get('/driver_list', [VechiclesAssignController::class, 'getDriverData']);
            Route::get('/vehicle_list', [VechiclesAssignController::class, 'getVehicleData']);
            Route::post('/save', [VechiclesAssignController::class, 'saveData']);
            Route::post('/update/{assign_route}', [VechiclesAssignController::class, 'updateData']);
            Route::post('/delete/{assign_route}', [VechiclesAssignController::class, 'deleteData']);
        });

        Route::prefix('vehicles')->group(function () {
            Route::get('/', [VechiclesController::class, 'getData']);
            Route::post('/save', [VechiclesController::class, 'saveData']);
            Route::get('/editData/{vehicle}', [VechiclesController::class, 'getEditData']);
            Route::post('/update/{vehicle}', [VechiclesController::class, 'updateData']);
            Route::post('/delete/{vehicle}', [VechiclesController::class, 'deleteData']);
        });
    });

    Route::prefix('inventory')->group(function () {

        Route::get('/itemstore', [ItemStoreController::class, 'getData']);

        Route::prefix('AddItemStore')->group(function () {
            Route::post('/save', [ItemStoreController::class, 'saveData'])->name('item_store.save-data');
            Route::get('/editData/{inventory_item_store}', [ItemStoreController::class, 'getEditData'])->name('item_store.edit-data');
            Route::post('/update/{inventory_item_store}', [ItemStoreController::class, 'updateData'])->name('item_store.update-data');
            Route::get('/delete/{inventory_item_store}', [ItemStoreController::class, 'deleteData']);
        });

        Route::prefix('ItemCategory')->group(function () {
            Route::get('/', [ItemCategoryController::class, 'getData']);
        });

        Route::prefix('ItemCategoryForm')->group(function () {

            Route::post('/save', [ItemCategoryController::class, 'saveData']);
            Route::get('/editData/{inventory_item_category}', [ItemCategoryController::class, 'getEditData']);
            Route::post('/update/{inventory_item_category}', [ItemCategoryController::class, 'updateData']);
            Route::get('/delete/{inventory_item_category}', [ItemCategoryController::class, 'deleteData']);
        });

        Route::get('/ItemSupplier', [ItemSupplierController::class, 'getData']);

        Route::prefix('ItemSupplierForm')->group(function () {
            Route::post('/save', [ItemSupplierController::class, 'saveData'])->name('supplier_name.save-data');
            Route::get('/editData/{inventory_supplier_info}', [ItemSupplierController::class, 'getEditData'])->name('supplier_name.edit-data');
            Route::post('/update/{inventory_supplier_info}', [ItemSupplierController::class, 'updateData'])->name('supplier_name.update-data');
            Route::get('/delete/{inventory_supplier_info}', [ItemSupplierController::class, 'deleteData']);
        });

        Route::get('/AddItem', [InventoryItemController::class, 'getData']);

        Route::prefix('AddItemForm')->group(function () {
            Route::post('/save', [InventoryItemController::class, 'saveData']);
            Route::get('/editData/{inventory_add_item}', [InventoryItemController::class, 'getEditData'])->name('category.edit-data');
            Route::post('/update/{inventory_add_item}', [InventoryItemController::class, 'updateData'])->name('category.update-data');
            Route::get('/delete/{inventory_add_item}', [InventoryItemController::class, 'deleteData'])->name('category.delete-data');
        });


        Route::prefix('AddItemStockInfo')->group(function () {
            Route::get('/AddItemStock', [ItemStockController::class, 'getData']);
            Route::get('/AddItemStock/dropdowndata', [ItemStockController::class, 'getDropdownData']);
            Route::post('/save', [ItemStockController::class, 'saveData']);
            Route::post('/update/{id}', [ItemStockController::class, 'updateData']);
            Route::get('/editData/{inventory_add_item_stock}', [ItemStockController::class, 'getEditData']);
            Route::get('/stock/{inventory_add_item_stock_id}', [ItemStockController::class, 'deleteInventoryData']);
            Route::get('items/{inventory_item_category}', [ItemStockController::class, 'getItems']);
            Route::get('items/suppliers/{inventory_supplier_info}', [ItemStockController::class, 'getItemSuppliers']);
            Route::get('items/stores/{inventory_supplier_info}', [ItemStockController::class, 'getItemStores']);
        });

        Route::prefix('AddIssueItem')->group(function () {
            Route::get('/IssueItem', [ItemIssueController::class, 'getData']);
            Route::get('/AddIssueItem/dropdowndata', [ItemIssueController::class, 'getData']);

            Route::post('/save', [ItemIssueController::class, 'saveData']);
            Route::get('/editData/{inventory_issue_item}', [ItemIssueController::class, 'getEditData']);
            Route::post('/update/{inventory_issue_item}', [ItemIssueController::class, 'updateData']);
            Route::get('/delete/{inventory_issue_item}', [ItemIssueController::class, 'deleteData']);

            Route::get('items/{inventory_item_category}', [ItemIssueController::class, 'getItems']);
            Route::get('items/departments/{department}', [ItemIssueController::class, 'getDepartments']);
            Route::get('/items/employees/{id}', [ItemIssueController::class, 'getEmployees']);
            Route::get('items/stocks/{inventory_add_item_stock}', [ItemIssueController::class, 'getItemStocks']);
        });
    });
    Route::prefix('library')->group(function () {

        Route::prefix('books')->group(function () {
            Route::get('/', [BookController::class, 'getData']);
            Route::get('/get_dropdown_lists', [BookController::class, 'getDropdownListData']);
            Route::post('/save', [BookController::class, 'saveData']);
            Route::post('/update/{libraryBook}', [BookController::class, 'updateData']);
        });

        Route::prefix('categories')->group(function () {
            Route::get('/', [LibraryCategoryController::class, 'getData']);
            Route::post('/save', [LibraryCategoryController::class, 'saveData']);
            Route::post('/update/{libraryBookCategory}', [LibraryCategoryController::class, 'updateData']);
        });

        Route::prefix('recks')->group(function () {
            Route::get('/', [ReckController::class, 'getData']);
            Route::post('/save', [ReckController::class, 'saveData']);
            Route::post('/update/{libraryBookReck}', [ReckController::class, 'updateData']);
        });
        Route::get('/books', [BookController::class, 'getData']);
    });

    Route::post('/add_student_card', [AddStudentController::class, 'saveStudentCard']);
});
Route::prefix('/admin')->middleware(['api'])->group(function () {

    Route::prefix('school_group')->group(function () {
        Route::get('/groups', [SchoolGroupController::class, 'getData']);
        Route::post('/save', [SchoolGroupController::class, 'saveData']);
        Route::post('/update/{school_group}', [SchoolGroupController::class, 'updateGroup']);
        Route::get('/edit/{school_group}', [SchoolGroupController::class, 'getEditItem']);
        Route::post('/delete/{school_group}', [SchoolGroupController::class, 'changeStatusData']);
    });
    Route::prefix('/schools')->group(function () {
        Route::get('/', [SchoolController::class, 'getSchools']);
        Route::get('/group_list', [SchoolController::class, 'getGroups']);
        Route::post('/save', [SchoolController::class, 'saveData']);
        Route::post('/create_schoolDocs', [SchoolController::class, 'saveSchoolDocuments']);
        Route::delete('/deleteSchool/{schoolId}', [SchoolController::class, 'deleteStatusSchool']);
        Route::get('/docs/{school_id}', [SchoolController::class, 'getDocuments']);
        Route::get('/edit/{edit_id}', [SchoolController::class, 'getSchoolEdit']);
        Route::get('/schoolDoc_edit/{edit_id}', [SchoolController::class, 'getItemEdit']);
        Route::post('/update/{school}', [SchoolController::class, 'updateSchool']);
        Route::get('/download_doc/{documentId}', [SchoolController::class, 'downloadDocument'])->name('download.document');
        Route::delete('/delete_doc/{schoolDocument}', [SchoolController::class, 'changeStatusDeleted']);
    });

    Route::prefix('menus')->group(function () {
        Route::get('/', [CategoryController::class, 'getMenus']);
        Route::post('/save', [CategoryController::class, 'saveData']);
        Route::post('/delete/{category}', [CategoryController::class, 'changeStatusData']);
    });
    Route::prefix('assign')->group(function () {
        Route::get('/get', [AssignController::class, 'getData1']);
        Route::get('/menu_list', [AssignController::class, 'getSideMenu']);
        Route::post('/school_list', [AssignController::class, 'getSchools']);
        Route::post('/save', [AssignController::class, 'saveData']);
        Route::post('/update/{assign_module}', [AssignController::class, 'updateData']);
        Route::post('/delete/{assign_module}', [AssignController::class, 'changeStatusData']);
    });

    Route::prefix('/component')->group(function () {
        Route::get('/component_list', [ComponentController::class, 'getComponents']);
        Route::get('/menu_list', [ComponentController::class, 'getMenus']);
        Route::post('/save', [ComponentController::class, 'saveData']);
        Route::post('/comp_update/{id}', [ComponentController::class, 'updateComponent']);
        Route::get('/delete_menu_component/{menu_component}', [ComponentController::class, 'menuComponentDelete']);
    });
});

