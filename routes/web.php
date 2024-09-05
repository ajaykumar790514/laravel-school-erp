<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ProgressBarController;
use App\Http\Controllers\MenuesController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\NewsEventsController;
use App\Http\Controllers\TestimonalsController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SimpleSlidersController;
use App\Http\Controllers\BlocksController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\DropzoneController;
use App\Http\Controllers\GeneralSettingsController;
use App\Http\Controllers\backend\SessionSetupsController;
use App\Http\Controllers\backend\ClassSetupsController;
use App\Http\Controllers\backend\SectionSetupsController;
use App\Http\Controllers\backend\SubjectsSetupsController;
use App\Http\Controllers\backend\ClassSectionMappingsController;
use App\Http\Controllers\backend\FeeHeadSetupsController;
use App\Http\Controllers\backend\FeeAmountSetupsController;
use App\Http\Controllers\backend\FeeCollectionsController;
use App\Http\Controllers\backend\InvoicesController;
use App\Http\Controllers\backend\StudentsController; 
use App\Http\Controllers\backend\StudentReportsController;
use App\Http\Controllers\backend\StudentClassAllotmentsController; 
use App\Http\Controllers\backend\DesignationsController; 
use App\Http\Controllers\backend\DepartmentsController; 
use App\Http\Controllers\backend\EmployeesController;
use App\Http\Controllers\PHPMailerController;
use App\Http\Controllers\backend\ForgetController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\backend\ClassTeacherSetupsController;
use App\Http\Controllers\backend\TeacherSubjectMapingsController;
use App\Http\Controllers\backend\SubjectClassMappingsController;
use App\Http\Controllers\backend\DailyDiariesController;
use App\Http\Controllers\backend\AssignmentHolidaysController;
use App\Http\Controllers\backend\NoticeController;
use App\Http\Controllers\backend\EventsController;
use App\Http\Controllers\backend\StudentAttendancesController;
use App\Http\Controllers\backend\EmployeeAttendancesController;
use App\Http\Controllers\backend\MediaCategoriesController;
use App\Http\Controllers\backend\MediaGalleriesController;
use App\Http\Controllers\parents\ParentsController;
use App\Http\Controllers\backend\AnnouncementsController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::controller(LoginController::class)->group(function () {
        //Route::match(array('GET', 'POST'), '/', 'login');
        //Route::match(array('GET', 'POST'), 'login', 'login');
        //Route::match(array('GET', 'POST'), '/', 'login');
       // Route::match(array('GET', 'POST'), 'home', 'login');
       //Route::match(array('GET', 'POST'), 'index', 'login');
    });

// Role Managment 
    Route::controller(HomeController::class)->group(function () {
       Route::match(array('GET', 'POST'), '/', 'index');
       Route::match(array('GET', 'POST'), 'home', 'index');
       Route::match(array('GET', 'POST'), 'index', 'index');
        Route::match(array('GET', 'POST'), 'getSectionByClassId', 'getSectionByClassId');
        Route::match(array('GET', 'POST'), 'photo-gallery', 'photo_gallery');
        Route::match(array('GET', 'POST'), 'photo-gallery-list/{slug}', 'photo_gallery_list');
        Route::match(array('GET', 'POST'), 'video-gallery', 'video_gallery');
        Route::match(array('GET', 'POST'), 'video-gallery-list/{slug}', 'video_gallery_list');
        Route::match(array('GET','POST'),'contact','contact');
        Route::get('/notice-board', 'notice_board');
        Route::get('/notice-board-details/{slug}', 'notice_board_details');
        Route::get('/news-events', 'news_events');
        Route::get('events/{slug}', 'events_details');
        Route::get('dailydiares ', 'dailydiares');
        Route::get('assignments ', 'assignments');
        Route::match(array('GET', 'POST'), 'pages/{slug}', 'pages');
        Route::match(array('GET', 'POST'), 'blog/', 'blog');
        Route::match(array('GET', 'POST'), 'blog/{slug}', 'blog_details');
        Route::match(array('GET', 'POST'), 'testimonal', 'testimonal');
        Route::match(array('GET', 'POST'), 'getcity', 'getCity');
        Route::get('get-section','get_section');
        
        Route::match(array('GET', 'POST'), 'players', 'players');
            
    });
    
    Route::controller(ForgetController::class)->group(function () {
        Route::match(array('GET', 'POST'), 'forgotpassword', 'forgotpassword');
        Route::match(array('GET', 'POST'), 'resetpassword/{id}', 'passwordreset');
         Route::match(array('GET', 'POST'), 'changepassworddirect', 'changepassworddirect');
    });
    
    Route::controller(CartsController::class)->group(function () {
        Route::match(array('GET', 'POST'), 'cart', 'cart');
        Route::match(array('GET', 'POST'), 'checkout', 'checkout');
        Route::match(array('GET', 'POST'), 'update-cart', 'updateToCart');
        Route::match(array('GET', 'POST'), 'single-update-cart', 'updateSingleToCart');
         Route::match(array('GET', 'POST'), 'apply-coupon', 'apply_coupon');
        Route::match(array('GET', 'POST'), 'order-confirmation/{id}', 'order_confirmation');
        Route::match(array('GET', 'POST'), 'add-to-cart/{id}', 'addToCart'); 
        Route::match(array('GET', 'POST', 'delete'), 'remove-from-cart/{id}', 'remove');
        Route::match(array('GET', 'POST', 'delete'), 'clear-cart', 'clearcart');
    });
    
    Route::controller(CustomersController::class)->group(function () {
        Route::match(array('GET', 'POST'), 'customer', 'create');
        Route::match(array('GET', 'POST'), 'customer/login', 'login');
    });
    
    Route::controller(WishlistController::class)->group(function () {
        Route::match(array('GET', 'POST'), 'wishlist', 'wishlist');
        Route::match(array('GET', 'POST'), 'add-to-wishlist/{id}', 'addToWishlist');
         Route::match(array('GET', 'POST'), 'wishlist-remove/{id}', 'remove'); 
    });
    
    Route::group(['middleware' => ['customer']], function () {
          Route::group(['prefix'=>'customer'], function() {
              Route::controller(CustomersController::class)->group(function () {
                    Route::match(array('GET', 'POST'), 'customer-logout', 'logout');
                });
                    Route::match(array('GET', 'POST'), 'dashboard', 'App\Http\Controllers\Exam\LoginController@dashboard');
                    Route::match(array('GET', 'POST'), 'save-exam-data', 'App\Http\Controllers\Exam\ExamResultsController@savedata');
                
         });
        
    });
   
    
    

Auth::routes();
Route::group(['middleware' => ['auth']], function() {
    Route::get('dashboard',[AdminController::class, 'dashboard']);
    
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);

    // Role Managment 
    Route::controller(RoleController::class)->group(function () {
            Route::match(array('GET', 'POST'), 'role-list', 'index');
            Route::match(array('GET', 'POST'), 'role-create', 'create');
            Route::match(array('GET', 'POST'), 'load-edit/{id}', 'loadedit');
            Route::match(array('GET', 'POST'), 'role-edit', 'edit');
            Route::match(array('GET', 'POST'), 'rolesdatatable', 'rolesdatatable');
            Route::match(array('GET', 'POST'), 'role-delete/{id}', 'destroy');
    });

    // User Managment 
    Route::controller(UserController::class)->group(function () {
        Route::match(array('GET', 'POST'), 'user-list', 'index');
        Route::match(array('GET', 'POST'), 'user-create', 'create');
        Route::match(array('GET', 'POST'), 'user-loaddata/{id}', 'showdata');
        Route::match(array('GET', 'POST'), 'user-edit', 'edit');
        Route::match(array('GET', 'POST'), 'userdatatable', 'userdatatable');
        Route::match(array('GET', 'POST'), 'user-delete/{id}', 'destroy');
        Route::match(array('GET', 'POST'), 'changepassword', 'resetpassword');
        
        Route::get('teacher-login-list', 'teacher_login_list');
        Route::match(array('GET','POST'),'teacher-login-create','teacher_login_create');
        Route::match(array('GET','POST'),'teacher-login-edit/{id}', 'teacher_login_edit');
        Route::match(array('GET','POST'),'teacher-login-delete/{id}','teacherlogindelete');
        Route::get('teacherlogindata', 'teacherlogindata');
        
        
    });
    
    // Menu Managment 
    Route::controller(MenuController::class)->group(function () {
        Route::match(array('GET', 'POST'), 'manage-menus/{id?}', 'index');
        Route::match(array('GET', 'POST'), 'create-menu', 'store');
        Route::match(array('GET', 'POST'), 'add-pages-to-menu', 'addPageToMenu');
        Route::match(array('GET', 'POST'), 'add-event-to-menu', 'addEventToMenu');
        Route::match(array('GET', 'POST'), 'add-notice-to-menu', 'addNoticeToMenu');
        Route::match(array('GET', 'POST'), 'add-custom-link', 'addCustomLink');
        Route::match(array('GET', 'POST'), 'update-menu', 'updateMenu');
        Route::match(array('GET', 'POST'), 'menu-delete/{id}', 'destroy');
        Route::match(array('GET', 'POST'), 'update-menuitem/{id}', 'updateMenuItem');
        Route::match(array('GET', 'POST'), 'delete-menuitem/{id}/{key}/{in?}', 'deleteMenuItem');
        Route::match(array('GET', 'POST'), 'delete-menu/{id}', 'destroy');
    });
    
    
    // Pages Managment 
    Route::controller(PagesController::class)->group(function () {
        Route::match(array('GET', 'POST'), 'cms-list', 'index');
        Route::match(array('GET', 'POST'), 'cms-create', 'create');
        Route::match(array('GET', 'POST'), 'cms-edit/{id}', 'edit');
        Route::match(array('GET', 'POST'), 'cms-view/{id}', 'show');
        Route::match(array('GET', 'POST'), 'cmsdatatable', 'datatable');
        Route::match(array('GET', 'POST'), 'cms-delete/{id}', 'destroy');
    });
    
    // Blog Managment 
    Route::controller(BlogController::class)->group(function () {
        Route::match(array('GET', 'POST'), 'blog-list', 'index');
        Route::match(array('GET', 'POST'), 'blog-create', 'create');
        Route::match(array('GET', 'POST'), 'blog-edit/{id}', 'edit');
        Route::match(array('GET', 'POST'), 'blog-view/{id}', 'show');
        Route::match(array('GET', 'POST'), 'blogdatatable', 'datatable');
        Route::match(array('GET', 'POST'), 'blog-delete/{id}', 'destroy');
    });
    
     // News Events Managment 
    Route::controller(NewsEventsController::class)->group(function () {
        Route::match(array('GET', 'POST'), 'newsevents-list', 'index');
        Route::match(array('GET', 'POST'), 'newsevents-create', 'create');
        Route::match(array('GET', 'POST'), 'newsevents-edit/{id}', 'edit');
        Route::match(array('GET', 'POST'), 'newsevents-view/{id}', 'show');
        Route::match(array('GET', 'POST'), 'newseventsdatatable', 'datatable');
        Route::match(array('GET', 'POST'), 'newsevents-delete/{id}', 'destroy');
    });
    

    
    
    
    // Testimonals Managment 
    Route::controller(TestimonalsController::class)->group(function () {
        Route::match(array('GET', 'POST'), 'testimonals', 'index');
        Route::match(array('GET', 'POST'), 'testimonals-create', 'create');
        Route::match(array('GET', 'POST'), 'testimonals-loaddata/{id}', 'showdata');
        Route::match(array('GET', 'POST'), 'testimonals-edit', 'edit');
        Route::match(array('GET', 'POST'), 'testimonalsdatatable', 'userdatatable');
        Route::match(array('GET', 'POST'), 'testimonals-delete/{id}', 'destroy');
    });
    
     Route::controller(AnnouncementsController::class)->group(function () {
        Route::match(array('GET', 'POST'), 'announcements', 'index');
        Route::match(array('GET', 'POST'), 'announcements-create', 'create');
        Route::match(array('GET', 'POST'), 'announcements-loaddata/{id}', 'showdata');
        Route::match(array('GET', 'POST'), 'announcements-edit', 'edit');
        Route::match(array('GET', 'POST'), 'announcementsdatatable', 'userdatatable');
        Route::match(array('GET', 'POST'), 'announcements-delete/{id}', 'destroy');
    });
    
    // simple-sliders Managment 
    Route::controller(SimpleSlidersController::class)->group(function () {
        Route::match(array('GET', 'POST'), 'simple-sliders', 'index');
        Route::match(array('GET', 'POST'), 'simple-sliders-create', 'create');
        Route::match(array('GET', 'POST'), 'simple-sliders-edit/{id}', 'edit');
        Route::match(array('GET', 'POST'), 'simpleslidersdatatable', 'datatable');
        Route::match(array('GET', 'POST'), 'simple-sliders-delete/{id}', 'destroy');
        Route::match(array('GET', 'POST'), 'simple-sliders-item', 'sliderItem');
        Route::match(array('GET', 'POST'), 'simple-sliders-item-create', 'sliderItemCreate');
        Route::match(array('GET', 'POST'), 'simple-sliders-item-loaddata/{id}', 'showdata');
        Route::match(array('GET', 'POST'), 'simple-sliders-item-edit', 'sliderItemEdit');
        Route::match(array('GET', 'POST'), 'simple-sliders-item-delete/{id}', 'sliderItemdelete');
    });
    
    // blocks Managment 
    Route::controller(BlocksController::class)->group(function () {
        Route::match(array('GET', 'POST'), 'blocks', 'index');
        Route::match(array('GET', 'POST'), 'blocks-edit/{id}', 'edit');
        Route::match(array('GET', 'POST'), 'blocksdatatable', 'userdatatable');
        //Route::match(array('GET', 'POST'), 'blocks-delete/{id}', 'destroy');
    });
    
    // Contact Managment 
    Route::controller(ContactsController::class)->group(function () {
        Route::match(array('GET', 'POST'), 'contact-list', 'index');
        Route::match(array('GET', 'POST'), 'contactdatatable', 'datatable');
        Route::match(array('GET', 'POST'), 'contact-delete/{id}', 'destroy');
    });
    
    // Media Category Managment 
    Route::controller(MediaCategoriesController::class)->group(function () {
        Route::match(array('GET', 'POST'), 'media-category-list', 'index');
        Route::match(array('GET', 'POST'), 'media-category-create', 'create');
        Route::match(array('GET', 'POST'), 'media-category-edit/{id}', 'edit');
        Route::match(array('GET', 'POST'), 'mediacategorydatatable', 'datatable');
        Route::match(array('GET', 'POST'), 'media-category-delete/{id}', 'destroy');
    });
    
    // Media Gallery Managment 
    Route::controller(MediaGalleriesController::class)->group(function () {
        Route::match(array('GET', 'POST'), 'media-gallery-list', 'index');
        Route::match(array('GET', 'POST'), 'media-gallery-create', 'create');
        Route::match(array('GET', 'POST'), 'media-gallery-edit/{id}', 'edit');
        Route::match(array('GET', 'POST'), 'mediagallerydatatable', 'datatable');
        Route::match(array('GET', 'POST'), 'media-gallery-delete/{id}', 'destroy');
        
        // Vedio Gallery Managment
        Route::match(array('GET', 'POST'), 'video-gallery-list', 'videoindex');
        Route::match(array('GET', 'POST'), 'video-gallery-create', 'videocreate');
        Route::match(array('GET', 'POST'), 'video-gallery-edit/{id}', 'videoedit');
        Route::match(array('GET', 'POST'), 'videogallerydatatable', 'videodatatable');
        Route::match(array('GET', 'POST'), 'video-gallery-delete/{id}', 'videodestroy');
    });
    
    
    


    Route::get('uploadfile', [ProgressBarController::class, 'index']);
    Route::post('/upload-doc-file', [ProgressBarController::class, 'uploadToServer']);

    Route::controller(FileController::class)->group(function(){
        Route::get('file-upload', 'index');
        Route::post('file-upload', 'store')->name('file.upload');
    });
    
    

    /*Settings*/
    Route::controller(SettingController::class)->group(function () {
        Route::match(array('GET', 'POST'), 'settings', 'settings');
        Route::match(array('GET', 'POST'), 'updatefavicon', 'updatefavicon');
        Route::match(array('GET', 'POST'), 'updatelogo', 'updatelogo');
        Route::match(array('GET', 'POST'), 'updatesettings', 'updatesettings');
        // Route::match(array('GET', 'POST'), 'changepassword', 'resetpassword');
        Route::match(array('GET', 'POST'), 'update_slider', 'update_slider');
    });
    
    /*Settings*/
    Route::controller(PHPMailerController::class)->group(function () {
        Route::match(array('GET', 'POST'), 'sendemail', 'composeEmail');
    });
    
    Route::controller(GeneralSettingsController::class)->group(function () {
        Route::match(array('GET', 'POST'), 'smtp-settings', 'smtp_settings');
        Route::match(array('GET', 'POST'), 'update-smtp-settings', 'update_smtp_settings');
        Route::match(array('GET', 'POST'), 'mail-test', 'test_smtp_settings');
    });
    
    /*------------------------------------------
        Admission MODULES
     ------------------------------------------*/
    Route::controller(SessionSetupsController::class)->group(function(){
            Route::match(array('GET', 'POST'), 'session-list', 'index');
            Route::match(array('GET','POST'),'session-create', 'create');
            Route::match(array('GET','POST'),'session-edit/{id}', 'edit');
            Route::match(array('GET','POST'),'session-delete/{id}', 'sesssiondelete');
            Route::get('sessiondatatable', 'sessiondatatable');
    });
    Route::controller(ClassSetupsController::class)->group(function(){
        Route::get('classsetup-list', 'index');
        Route::match(array('GET','POST'),'classsetup-create', 'create');
        Route::match(array('GET','POST'),'classsetup-edit/{id}', 'edit');
        Route::match(array('GET','POST'),'classsetup-delete/{id}', 'classsetupdelete');
        Route::get('classsetupdatatable', 'classsetupdatatable');
    });
    
    Route::controller(SectionSetupsController::class)->group(function(){
        Route::get('sectionsetup-list', 'index');
        Route::match(array('GET','POST'),'sectionsetup-create', 'create');
        Route::match(array('GET','POST'),'sectionsetup-edit/{id}', 'edit');
        Route::match(array('GET','POST'),'sectionsetup-delete/{id}', 'delete');
        Route::get('sectionsetupdatatable', 'sectionsetupdatatable');
    });
    
    Route::controller(SubjectsSetupsController::class)->group(function(){
        Route::get('subjectssetup-list', 'index');
        Route::match(array('GET','POST'),'subjectssetup-create', 'create');
        Route::match(array('GET','POST'),'subjectssetup-edit/{id}', 'edit');
        Route::match(array('GET','POST'),'subjectssetup-delete/{id}', 'delete');
        Route::get('subjectsetupdatatable', 'subjectsetupdatatable');
    });
    
    Route::controller(ClassSectionMappingsController::class)->group(function(){
        Route::match(array('GET','POST'),'classsectionmaping-list','index');
        Route::match(array('GET','POST'),'classsectionmaping-edit/{id}','edit');
        Route::match(array('GET','POST'),'classsectionmaping-create','create');
        Route::match(array('GET','POST'),'classsectionmaping-delete/{id}','delete');
        Route::get('classsectionmapingdatatable', 'classsectionmapingdatatable');
    });
    
    Route::controller(StudentsController::class)->group(function(){
        Route::match(array('GET','POST'),'importexcel','importexcel');
        Route::match(array('GET','POST'),'student-list','index');
        Route::match(array('GET','POST'),'student-edit/{id}','edit');
        Route::match(array('GET','POST'),'add-more-student/{parentId}','add_more_student');
        Route::match(array('GET','POST'),'parents-edit/{parentid}/{studentid}','parents_edit');
        Route::match(array('GET','POST'),'student-create','create');
        Route::match(array('GET','POST'),'student-upload-documents/{id}','upload_documents');
        Route::match(array('GET','POST'),'student-delete-documents/{id}','documentsdelete');
        Route::match(array('GET','POST'),'student-view/{id}','view');
        Route::match(array('GET','POST'),'student-delete/{id}','studentsdelete');
        Route::get('studentdatatable', 'datatable');
        Route::match(array('GET','POST'),'parents-list','parents_list');
        Route::get('parentdatatable', 'parentdatatable');
         Route::match(array('GET','POST'),'parent-delete/{id}','parentdelete');
    }); 
    //Student Reporting
    Route::controller(StudentReportsController::class)->group(function(){
         Route::match(array('GET','POST'),'classes-register','classes_register');
         Route::match(array('GET','POST'),'student-register/{id}/{ids}/{sectionId}','student_register');
         Route::match(array('GET','POST'),'studentregisterdata/{id}/{ids}/{sectionID}','studentregisterdata');
         Route::match(array('GET','POST'),'export-student-class-wise/{id}/{ids}/{sectionID}','export_student_class_wise');
         Route::match(array('GET','POST'),'export-student-all-data','export_student_all_data');
         Route::match(array('GET','POST'),'student-search','student_search');
         Route::match(array('GET','POST'),'student-records/{id}','student_records');
         Route::match(array('GET','POST'),'not-enrolled-students','not_enrolled_students');
    });
    
     Route::controller(StudentClassAllotmentsController::class)->group(function(){
        Route::match(array('GET','POST'),'student-class-allotment','classallotment');
        Route::match(array('GET','POST'),'allotment-list','allotment_list');
        Route::match(array('GET','POST'),'/allotment/{id}', 'allotment');
        Route::match(array('GET','POST'),'students-class-allotment-list/{id}/{ids}','students_class_allotment_list');
        Route::match(array('GET','POST'),'studentClassAllotmentDatatable/{id}/{ids}','student_class_allotment_datatable');
        Route::match(array('GET','POST'),'unalloted/{id}','unalloted');
        Route::match(array('GET','POST'),'roll-number-allotment-list','roll_number_allotment_list');
        Route::match(array('GET','POST'),'student-roll-number-allotment','allotment_rollnumber');
        Route::match(array('GET','POST'),'rollnumber', 'rollnumber');
        Route::match(array('GET','POST'),'students-rollnumber-alloted-list/{id}/{ids}','students_rollnumber_alloted_list');
        Route::match(array('GET','POST'),'student-list-datatable/{id}/{ids}','student_list_datatable');
        Route::match(array('GET','POST'),'released/{id}','released');
        Route::match(array('GET','POST'),'student-promotion-list','promotion_list');
        Route::match(array('GET','POST'),'student-class-promotion','promotion');
        Route::match(array('GET','POST'),'promoted-students/{sessionId}/{classId}/{sectionId}','promoted_student');
        Route::match(array('GET','POST'),'promotedstudentdatatable/{sessionId}/{classId}/{sectionId}', 'promotedstudentdatatable');
        Route::match(array('GET','POST'),'promoted-update/{sessionId}/{classId}','promoted_update');
         
    });
    
    /*------------------------------------------
        Fee MODULES
     ------------------------------------------*/
    Route::controller(FeeHeadSetupsController::class)->group(function(){
            Route::match(array('GET', 'POST'), 'fee-head-setup-list', 'index');
            Route::match(array('GET','POST'),'fee-head-setup-create', 'create');
            Route::match(array('GET','POST'),'fee-head-setup-edit', 'edit');
            Route::match(array('GET', 'POST'), 'fee-head-setup-loaddata/{id}', 'showdata');
            Route::match(array('GET','POST'),'fee-head-setup-delete/{id}', 'delete');
            Route::get('feeheadsetupdatatable', 'datatable');
    });
    
    Route::controller(FeeAmountSetupsController::class)->group(function(){
            Route::match(array('GET', 'POST'), 'fee-amount-setup-list', 'index');
            Route::match(array('GET','POST'),'fee-amount-setup-create', 'create');
            Route::match(array('GET','POST'),'fee-amount-setup-edit', 'edit');
            Route::match(array('GET', 'POST'), 'fee-amount-setup-loaddata/{id}', 'showdata');
            Route::match(array('GET','POST'),'fee-amount-setup-delete/{id}', 'delete');
            Route::get('feeamountsetupdatatable', 'datatable');
    });
    
    Route::controller(FeeCollectionsController::class)->group(function(){
        Route::match(array('GET','POST'),'student-list-for-fee-collection','studentlistforcollection');
        Route::match(array('GET','POST'),'fee-collection/{id}','feecollections');
        Route::match(array('GET','POST'),'addCollectionInInvoice','addCollectionInInvoice');
        Route::match(array('GET','POST'),'fee-invoice/{id}','fee_invoice');
        Route::match(array('GET','POST'),'removeFeeSession/{student}/{month}/{session}','removeFeeSession');
        Route::match(array('GET','POST'),'generateinvoice/{id}','generateinvoice');
        Route::match(array('GET','POST'),'recived-invoice/{id}','recived_invoice');
        Route::match(array('GET','POST'),'fee-invoice-pdf/{id}','fee_invoice_pdf');
        Route::match(array('GET','POST'),'fee-invoice-download/{id}','fee_invoice_download');
        Route::match(array('GET', 'POST'), 'fee-invoice-list', 'fee_invoice_list');
        Route::match(array('GET', 'POST'), 'feeinvoicelistdatatable', 'feeinvoicelistdatatable');
        Route::match(array('GET','POST'),'removeInvoice/{id}','removeInvoice');
        
        
    });
    
    Route::controller(InvoicesController::class)->group(function(){
        Route::match(array('GET','POST'),'day-wise-invoice','day_wise_invoice');
        Route::match(array('GET','POST'),'export-day-wise-collection/{fromDate}/{toDate}/{classID?}','export_day_wise_collection');
        Route::match(array('GET','POST'),'export-head-wise-collection/{fromDate}/{toDate}/{classID?}','export_head_wise_collection');
        Route::match(array('GET','POST'),'class-wise-collection','class_wise_collection');
        Route::match(array('GET','POST'),'export-class-wise-collection-report/{SessionId}/{classID}/{sectionID}','export_class_wise_collection_report');
        Route::match(array('GET','POST'),'curent-month-balance-fee','curent_month_balance_fee');
        Route::match(array('GET','POST'),'month-wise-pending-fee','month_wise_pending_fee');
        Route::match(array('GET','POST'),'export_month-wise-pending-fee/{month}/{sessionId}/{classID}','export_month_wise_pending_fee');
        Route::match(array('GET','POST'),'fee-register/{studentId}','fee_register');
    });
    
    
      /*------------------------------------------
        Academic Module
     ------------------------------------------*/
     Route::group(['prefix'=>'academics'], function() {
        Route::controller(ClassTeacherSetupsController::class)->group(function(){
            Route::get('class-teacher-list', 'index');
            Route::match(array('GET','POST'),'class-teacher-create','create');
            Route::match(array('GET','POST'),'class-teacher-edit/{id}', 'edit');
            Route::match(array('GET','POST'),'class-teacher-delete/{id}','teacherlogindelete');
            Route::get('classteacherdata', 'classteacherdata');
        });
        
        Route::controller(TeacherSubjectMapingsController::class)->group(function(){
            Route::get('teacher-subject-maping-list', 'index');
            Route::match(array('GET','POST'),'teacher-subject-maping-create','create');
            Route::match(array('GET','POST'),'teacher-subject-maping-edit/{id}', 'edit');
            Route::match(array('GET','POST'),'teacher-subject-maping-delete/{id}','teacherlogindelete');
            Route::get('teachersubjectmapingsdata', 'teachersubjectmapingsdata');
        });
         
        Route::controller(SubjectClassMappingsController::class)->group(function(){
            Route::get('subject-class-maping-list', 'index');
            Route::match(array('GET','POST'),'subject-class-maping-create','create');
            Route::match(array('GET','POST'),'subject-class-maping-edit/{id}', 'edit');
            Route::match(array('GET','POST'),'subject-class-maping-delete/{id}','delete');
            Route::get('subjectclassmappingdata', 'subjectclassmappingdata');
        }); 
        
        Route::controller(DailyDiariesController::class)->group(function(){
            Route::get('dailydiaries-list', 'index');
            Route::match(array('GET','POST'),'dailydiaries-create','create');
            Route::match(array('GET','POST'),'dailydiaries-edit/{id}', 'edit');
            Route::match(array('GET','POST'),'dailydiaries-view/{id}', 'view');
            Route::match(array('GET','POST'),'dailydiaries-delete/{id}','delete');
            Route::get('dailydiariesdata', 'dailydiariesdata');
            Route::get('dailydiary-get-section','get_section');
        }); 
        
        Route::controller(AssignmentHolidaysController::class)->group(function(){
            Route::get('assignment-holidays-list', 'index');
            Route::match(array('GET','POST'),'assignment-holidays-create','create');
            Route::match(array('GET','POST'),'assignment-holidays-edit/{id}', 'edit');
            Route::match(array('GET','POST'),'assignment-holidays-view/{id}', 'view');
            Route::match(array('GET','POST'),'assignment-holidays-delete/{id}','delete');
             Route::get('assignmentholidaysdata', 'assignmentholidaysdata');
        }); 

        Route::controller(NoticeController::class)->group(function(){
           Route::get('notice-list', 'index');
            Route::match(array('GET','POST'),'notice-create','create');
            Route::match(array('GET','POST'),'notice-edit/{id}', 'edit');
            Route::match(array('GET','POST'),'notice-view/{id}', 'view');
            Route::match(array('GET','POST'),'notice-delete/{id}','delete');
            Route::get('noticedata', 'noticedata');
        }); 

        Route::controller(EventsController::class)->group(function(){
           Route::get('events-list', 'index');
            Route::match(array('GET','POST'),'events-create','create');
            Route::match(array('GET','POST'),'events-edit/{id}', 'edit');
            Route::match(array('GET','POST'),'events-view/{id}', 'view');
            Route::match(array('GET','POST'),'events-delete/{id}','delete');
            Route::get('eventdata', 'eventdata');
        });
    });
     /*------------------------------------------
        Attendance Module
     ------------------------------------------*/

    Route::group(['prefix'=>'attendance'], function() {
         Route::controller(StudentAttendancesController::class)->group(function(){
            Route::match(array('GET','POST'),'classes-attendance','class_attendance');
            Route::match(array('GET','POST'),'take-attendance/{id}/{ids}/{section}','take_attendance');
            Route::match(array('GET','POST'),'student-attendance/{id}/{classId}/{section}','attendance_register');
            Route::match(array('GET','POST'),'student-attendance-list/{id}/{ids}/{idss}/{section}','student_attendance_list');
            Route::match(array('GET','POST'),'update_attendance/{id}/{ids}','update_attendance');
            Route::match(array('GET','POST'),'studentattendanceregisterdata/{id}/{ids}/{section}','studentattendanceregisterdata');
            Route::match(array('GET','POST'),'studentattendancelistdata/{id}','studentattendancelistdata');
        });
        
         Route::match(array('GET','POST'),'student-list-for-attendance/{id}/{ids}/{sectionID}','App\Http\Controllers\backend\StudentClassAllotmentsController@student_list_for_attendance');
        
        Route::controller(EmployeeAttendancesController::class)->group(function(){
            Route::match(array('GET','POST'),'employee-attendance','employee_attendance');
            Route::match(array('GET','POST'),'employee_take_attendance','employee_take_attendance');
            Route::match(array('GET','POST'),'employee-attendance-register','employee_attendance_register');
            Route::match(array('GET','POST'),'employee-attendance-list/{id}','employee_attendance_list');
            Route::match(array('GET','POST'),'update_employee_attendance/{id}/{ids}','update_employee_attendance');
            Route::match(array('GET','POST'),'employeeattendanceregisterdata','employeeattendanceregisterdata');
            Route::match(array('GET','POST'),'employeeattendancelistdata/{id}','employeeattendancelistdata');
        });

    });
    
    /*------------------------------------------
       Parents
     ------------------------------------------*/
    Route::group(['prefix'=>'parents'], function() {
        Route::controller(EmployeeAttendancesController::class)->group(function(){
            Route::match(array('GET','POST'), 'daily-diary','dailydiaryforparents');
            
            Route::match(array('GET','POST'), 'notice-for-parents','notice_for_parent');
            Route::match(array('GET','POST'), 'events-for-parents','events_for_parent');
        });
        Route::match(array('GET','POST'),'parents-login-list','App\Http\Controllers\UserController@parents_login_list');
        Route::get('parentslogindata', 'App\Http\Controllers\UserController@parentslogindata');    
        Route::match(array('GET','POST'),'parent-login-create','App\Http\Controllers\UserController@parent_login_create');
        Route::match(array('GET','POST'),'parentlogindelete/{id}','App\Http\Controllers\UserController@parentlogindelete');
        Route::match(array('GET','POST'),'getParentsDetails','App\Http\Controllers\UserController@getParentsDetails');
        Route::match(array('GET','POST'),'parents-password-change/{id}', 'App\Http\Controllers\UserController@parents_password_change');
        
        
        
        
        
    });
    
     /*------------------------------------------
        Employee Module
     ------------------------------------------*/
    Route::controller(DesignationsController::class)->group(function(){
        Route::get('designation-list', 'index');
        Route::match(array('GET','POST'),'designation-create', 'create');
        Route::match(array('GET','POST'),'designation-edit/{id}', 'edit');
        Route::match(array('GET','POST'),'designation-delete/{id}', 'designationdelete');
        Route::get('designationdatatable', 'designationdatatable');
    });
    
    Route::controller(DepartmentsController::class)->group(function(){
        Route::get('department-list', 'index');
        Route::match(array('GET','POST'),'department-create', 'create');
        Route::match(array('GET','POST'),'department-edit/{id}', 'edit');
        Route::match(array('GET','POST'),'department-delete/{id}', 'delete');
        Route::get('departmentdatatable', 'departmentdatatable');
    });
    
    Route::controller(EmployeesController::class)->group(function(){
        Route::get('employees-list', 'index');
        Route::match(array('GET','POST'),'employees-create', 'create');
        Route::match(array('GET','POST'),'employees-edit/{id}', 'edit');
        Route::match(array('GET','POST'),'employees-delete/{id}', 'employeedelete');
        Route::match(array('GET','POST'),'employees-upload-documents/{id}','upload_documents');
        Route::match(array('GET','POST'),'employees-delete-documents/{id}','documentsdelete');
        Route::match(array('GET','POST'),'employees-view/{id}','view');
        Route::get('employeesdatatable', 'employeesdatatable');
    });
   
    
    /*Help*/
    Route::controller(HelpController::class)->group(function () {
        Route::match(array('GET', 'POST'), 'menu-help', 'menu_help');
        Route::match(array('GET', 'POST'), 'blocks-help', 'blocks_help');
        Route::match(array('GET', 'POST'), 'pages_help', 'pages-help');
    });
    
    Route::controller(DropzoneController::class)->group(function () {
        Route::match(array('GET', 'POST'), 'uploadDocuments', 'uploadDocuments');
        
        Route::match(array('GET', 'POST'), 'mediacategory', 'mediacategory');
        Route::match(array('GET', 'POST'), 'gallerymultipal', 'gallerymultipal');
        
        Route::match(array('GET', 'POST'), 'categoryimg', 'categoryimg');

        Route::match(array('GET', 'POST'), 'blogBanner', 'blogBanner');
        
        Route::match(array('GET', 'POST'), 'cmsBanner', 'cmsBanner');
        
        Route::match(array('GET', 'POST'), 'sliderImage', 'sliderImage');
        
        Route::match(array('GET', 'POST'), 'logo', 'logo');
        Route::match(array('GET', 'POST'), 'feviconImage', 'feviconImage');
        Route::match(array('GET', 'POST'), 'testimonalAvtar', 'testimonalAvtar');
        
        Route::match(array('GET', 'POST'), 'dailydiary', 'dailydiary');
        Route::match(array('GET', 'POST'), 'homework', 'homework');
        Route::match(array('GET', 'POST'), 'notice', 'notice');
        Route::match(array('GET', 'POST'), 'events', 'events');
        //Route::match(array('GET', 'POST'), 'ckeditor-image', 'ckeditor_image');
        
       
    });
    Route::post('image-upload', [DropzoneController::class, 'ckeditor_image'])->name('image.upload');
   
    
});
Route::middleware(['parent'])->group(function () {
    Route::group(['prefix'=>'parents'], function() {
        Route::controller(ParentsController::class)->group(function(){
               Route::match(array('GET','POST'), 'dashboard','dashboard');
               Route::match(array('GET','POST'), 'daily-diary-view/{id}','daily_diary_view');
               Route::match(array('GET','POST'), 'daily-diary-list','daily_diary_list');
               Route::match(array('GET','POST'), 'assignment-for-parents','assignment_for_parents');
               Route::get('studentlist', 'studentlist');
               Route::match(array('GET','POST'),'student-view/{id}','student_view');
               Route::match(array('GET','POST'),'parent-profile/{id}','parent_edit');
               Route::match(array('GET','POST'),'invoicelist','invoicelist');
               Route::match(array('GET','POST'),'parent-profile','parentprofile');
        });
        Route::controller(FeeCollectionsController::class)->group(function(){
            Route::match(array('GET','POST'),'fee-invoice-for-parents-pdf/{id}','fee_invoice_for_parents');
        });
    });
        
});
