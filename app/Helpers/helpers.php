<?php
use Carbon\Carbon;
use App\Models\SimpleSliders;
use App\Models\SimpleSliderItems;
use App\Models\FeeHeadSetups;
use App\Models\FeeAmountSetups;
use App\Models\FeeCollections;
use App\Models\Invoices;
use App\Models\Designations;
use App\Models\Departments;
use App\Models\Religions;
use App\Models\NewsEvents;
use App\Models\EventsCategories;
use App\Models\SubjectSetups;
use App\Models\Blog;
use App\Models\Testimonals;
use App\Models\Menu;
use App\Models\ClassSetups;
use App\Models\SessionSetups;
use App\Models\CastCategorySetups;
use App\Models\StudentClassAllotments;
use App\Models\Students;
use App\Models\Employees;
use App\Models\DocumentsSetups;
use App\Models\Menuitems;
use App\Models\Blocks;
use App\Models\Settings;
use App\Models\MediaGalleries;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\DB;


    function setEnvValue(array $values){
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);
        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {
    
                $str .= "\n"; // In case the searched variable is in the last line without \n
                $keyPosition = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
    
                // If key does not exist, add it
                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}={$envValue}\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                }
            }
        }
    
        $str = substr($str, 0, -1);
        if (!file_put_contents($envFile, $str)) return false;
        return true;
    }
    
     if (! function_exists('amountToWord')) {
        function amountToWord($amount)
        {
                $number = $amount;
               $no = floor($number);
               $point = round($number - $no, 2) * 100;
               $hundred = null;
               $digits_1 = strlen($no);
               $i = 0;
               $str = array();
               $words = array('0' => '', '1' => 'one', '2' => 'two',
                '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
                '7' => 'seven', '8' => 'eight', '9' => 'nine',
                '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
                '13' => 'thirteen', '14' => 'fourteen',
                '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
                '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
                '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
                '60' => 'sixty', '70' => 'seventy',
                '80' => 'eighty', '90' => 'ninety');
               $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
               while ($i < $digits_1) {
                 $divider = ($i == 2) ? 10 : 100;
                 $number = floor($no % $divider);
                 $no = floor($no / $divider);
                 $i += ($divider == 10) ? 1 : 2;
                 if ($number) {
                    $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                    $str [] = ($number < 21) ? $words[$number] .
                        " " . $digits[$counter] . $plural . " " . $hundred
                        :
                        $words[floor($number / 10) * 10]
                        . " " . $words[$number % 10] . " "
                        . $digits[$counter] . $plural . " " . $hundred;
                 } else $str[] = null;
              }
              $str = array_reverse($str);
              $result = implode('', $str);
              $points = ($point) ?
                "." . $words[$point / 10] . " " . 
                      $words[$point = $point % 10] : '';
              //echo strtoupper($result) . "Rupees  " . strtoupper($points) . " Paise";
              echo strtoupper($result) . "Rupees  " . strtoupper($points);
        }
    }
    
    if (! function_exists('amountToWordCopy')) {
        function amountToWordCopy($amount)
        {
                $number = $amount;
               $no = floor($number);
               $point = round($number - $no, 2) * 100;
               $hundred = null;
               $digits_1 = strlen($no);
               $i = 0;
               $str = array();
               $words = array('0' => '', '1' => 'one', '2' => 'two',
                '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
                '7' => 'seven', '8' => 'eight', '9' => 'nine',
                '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
                '13' => 'thirteen', '14' => 'fourteen',
                '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
                '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
                '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
                '60' => 'sixty', '70' => 'seventy',
                '80' => 'eighty', '90' => 'ninety');
               $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
               while ($i < $digits_1) {
                 $divider = ($i == 2) ? 10 : 100;
                 $number = floor($no % $divider);
                 $no = floor($no / $divider);
                 $i += ($divider == 10) ? 1 : 2;
                 if ($number) {
                    $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                    $str [] = ($number < 21) ? $words[$number] .
                        " " . $digits[$counter] . $plural . " " . $hundred
                        :
                        $words[floor($number / 10) * 10]
                        . " " . $words[$number % 10] . " "
                        . $digits[$counter] . $plural . " " . $hundred;
                 } else $str[] = null;
              }
              $str = array_reverse($str);
              $result = implode('', $str);
              $points = ($point) ?
                "." . $words[$point / 10] . " " . 
                      $words[$point = $point % 10] : '';
              //echo strtoupper($result) . "Rupees  " . strtoupper($points) . " Paise";
              return strtoupper($result) . "Rupees  " . strtoupper($points);
        }
    }
    
    if (! function_exists('formatCurrency')) {
        function formatCurrency($amount, $currency)
        {
            $fmt = new NumberFormatter( app()->getLocale(), NumberFormatter::CURRENCY );
            return $fmt->formatCurrency($amount, $currency);
        }
    }
    
    
    function sanitize_html($value){
        return htmlspecialchars(strip_tags($value));
    }
    
   if (! function_exists('getsiteTitle')) {
        function getsiteTitle() {
            return Settings::getSettingValue('website_title');
        }
    }
    
    if (! function_exists('getaddress')) {
        function getaddress() {
            return Settings::getSettingValue('address');
        }
    }
    if (! function_exists('getMobile')) {
        function getMobile() {
            return Settings::getSettingValue('mobile');
        }
    }
    
    if (! function_exists('getPhone')) {
        function getPhone() {
            return Settings::getSettingValue('phone');
        }
    }
    
    if (! function_exists('getEmail')) {
        function getEmail() {
            return Settings::getSettingValue('email1');
        }
    }
    
    if (! function_exists('getSiteLogo')) {
        function getSiteLogo() {
            return Settings::getSettingValue('logo');
        }
    }
    
    if (! function_exists('getSocialLink')) {
        function getSocialLink($social) {
            return Settings::getSettingValue($social);
        }
    }
    
    if (! function_exists('getSettingValueByName')) {
        function getSettingValueByName($social) {
            return Settings::getSettingValue($social);
        }
    }
    
    if (! function_exists('getMap')) {
        function getMap() {
            return Settings::getSettingValue("map");
        }
    }
    
    if (! function_exists('getSliderId')) {
        function getSliderId($getSliderID) {
            return Settings::getSettingValue($getSliderID);
        }
    }
    
    if (! function_exists('getSettings')) {
        function getSettings($setting) {
            return Settings::getSettingValue($setting);
        }
    }
    
    if (! function_exists('getBlock')) {
        function getBlock($setting) {
            return Blocks::getBlockValue($setting);
        }
    }
    
   
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    if (! function_exists('convertMdyToYmd')) {
        function convertMdyToYmd($date)
        {
            return Carbon::createFromFormat('m-d-Y', $date)->format('Y-m-d');
        }
    }

    //Home Page //


if (! function_exists('getSlider')) {
    function getSlider($sliderKey){
        $sliderID=SimpleSliders::where('key', '=', $sliderKey)->value('id');
        $sliderItemData=SimpleSliderItems::where('simple_slider_id', $sliderID)->get();
        //return $sliderItemData; 
        return view ('helper.slider', compact('sliderItemData'));
    }
}
    if (! function_exists('homeNoticeboard')) {
        function homeNoticeboard(){
            $dataArray=DB::table('notices')
                        ->join('session_setups', 'notices.session_id', '=', 'session_setups.id')
                        ->select('notices.*', 'session_setups.session_name')
                        ->where(['notices.status'=>0])->orderBy('notices.id', 'desc')->take(3)->get();
            return view ('helper.home_notice_board', compact('dataArray'));
        }
    }

    if (! function_exists('getMarquee')) {
        function getMarquee(){
            $data=DB::table('announcements')->select('*')->where(['status'=>0])->orderBy('id', 'desc')->take(1)->first();
            return $data;
        }
    }




if (! function_exists('getNewsEvents')) {
    function getNewsEvents(){
        $newsEventsData=DB::table('events')
                        ->join('session_setups', 'events.session_id', '=', 'session_setups.id')
                        ->join('events_categories', 'events.events_category_id', '=', 'events_categories.id')
                        ->select('events.*', 'session_setups.session_name',  'events_categories.name as catName')
                        ->where(['events.status'=>0])->orderBy('events.id', 'desc')->take(3)->get();
        return view ('helper.news_events', compact('newsEventsData'));
    }
}

    if (! function_exists('getTestimonals')) {
        function getTestimonals(){
            $testtimonalArray=DB::table('testimonals')
                        ->select('testimonals.*')
                        ->where(['testimonals.status'=>0])->orderBy('testimonals.id', 'desc')->take(4)->get();
            return view ('helper.testimonals', ['testtimonalArray'=>$testtimonalArray]);
        }
    }
    
    if (! function_exists('homeGallery')) {
        function homeGallery(){
            $galleryData=DB::table('media_galleries')
                        ->join('media_categories', 'media_galleries.media_categories_id', '=', 'media_categories.id')
                        ->select('media_galleries.*', 'media_categories.title')
                        ->where(['media_galleries.status'=>0, 'media_galleries.media_type'=>0])->orderBy('media_galleries.id', 'desc')->take(6)->get();
            return view ('helper.home_gallery', compact('galleryData'));
        }
    }


    if (! function_exists('getBlock')) {
        function getBlock(){
            $blogsData=Blog::where('status', 0)->take(3)->get();
            return view ('helper.blogs', compact('blogsData'));
        }
    }
    
    
    if (! function_exists('getBlogs')) {
        function getBlogs(){
            $blogsData=Blog::where('status', 0)->take(3)->get();
            return view ('helper.blogs', compact('blogsData'));
        }
    }
    
    if (! function_exists('getSidebarBlogs')) {
        function getSidebarBlogs(){
            $blogsData=Blog::where('status', 0)->take(3)->get();
            return $blogsData;
        }
    }
    
    if (!function_exists('getEventCatByID')) {
        function getEventCatByID($id){    
            $data =DB::table('events')->where(['events_category_id'=>$id])->count();
            return $data;
        }
    }


if (!function_exists('headermenu')) {
    function headermenu(){
        $menuCantent=Menu::where('location', 1)->value('content');
        $mainMenuData=json_decode($menuCantent);
        return $mainMenuData;
        
    }
}
if (!function_exists('mainMenuItem')) {
    function mainMenuItem($id){
        $menuitem=Menuitems::where('id',$id)->first();
        return $menuitem;
    }
}

if (!function_exists('footer_info')) {
    function footer_info(){
        $doctortiming=Blocks::where('name', '=', 'doctors-timetable')->value('content');
        return view ('helper.footer-info', compact('doctortiming'));
    }
}



    if(!function_exists('get_state')) {
        function get_state(){    
        $data = DB::table('states')
                    ->select('id', 'name')
                    ->where(['status'=>0])
                    ->orderBy('name', 'asc')->get();
                    return $data;
        }
    }
    

    if (!function_exists('getSession')) {
        function getSession(){    
            $data = SessionSetups::where(['status'=>0])->orderBy('id', 'desc')->get();
            return $data;
        }
    }
    
    if (!function_exists('getSessionDefault')) {
        function getSessionDefault(){    
            $data = SessionSetups::select('id')->where(['default_session'=>1])->first();
            return $data->id;
        }
    }
    
    if (!function_exists('getClasses')) {
        function getClasses(){    
            $data = ClassSetups::where(['status'=>0])->orderBy('order_by', 'asc')->get();
            return $data;
        }
    }
    
     if (!function_exists('getClassNameByID')) {
        function getClassNameByID($classID){    
            $data = ClassSetups::select('class_name')->where(['id'=>$classID])->first();
            return $data->class_name;
        }
    }
    
    if (!function_exists('getSectionByClassID')) {
        function getSectionByClassID($classID){    
            $data = DB::table('class_section_mappings')->select('section_setups.section_name', 'section_setups.id')
                    ->join('section_setups', 'class_section_mappings.class_setups_id', '=', 'section_setups.id')
                    ->where(['class_section_mappings.status'=>0, 'class_section_mappings.class_setups_id'=>$classID])->orderBy('section_setups.order_by', 'asc')
                   ->get();
            return $data;
        }
    }
    
    if (!function_exists('getFeeHeadName')) {
        function getFeeHeadName($id){   
             $data = DB::table('fee_amount_setups')->select('fee_head_setups.fee_head_name')
                    ->where(['fee_amount_setups.id'=>$id])->join('fee_head_setups', 'fee_amount_setups.fee_head_setup_id', '=', 'fee_head_setups.id')->first();
            return $data->fee_head_name;
        }
    }
    
    
    if (!function_exists('getCategory')) {
        function getCategory(){    
            $data = CastCategorySetups::where(['status'=>0])->orderBy('order_by', 'asc')->get();
            return $data;
        }
    }
    
    if (!function_exists('getReligions')) {
        function getReligions(){    
            $data = Religions::where(['status'=>0])->orderBy('short_name', 'asc')->get();
            return $data;
        }
    }
    
    if (!function_exists('getDocumentsType')) {
        function getDocumentsType(){    
            $data = DocumentsSetups::where(['status'=>0])->orderBy('name', 'asc')->get();
            return $data;
        }
    }
    
    if (!function_exists('getDesig')) {
        function getDesig(){    
            $data = Designations::select('id', 'designation_name')->where(['status'=>0])->orderBy('designation_name', 'asc')->get();
            return $data;
        }
    }
    
    if (!function_exists('getDepartment')) {
        function getDepartment(){    
            $data = Departments::select('id', 'department_name')->where(['status'=>0])->orderBy('department_name', 'asc')->get();
            return $data;
        }
    }
    
     if (!function_exists('getSubjectSetup')) {
        function getSubjectSetup(){    
            $data = SubjectSetups::select('id', 'subject_name')->where(['status'=>0])->orderBy('subject_name', 'asc')->get();
            return $data;
        }
    }
    
    if (!function_exists('getTotalStudent')) {
        function getTotalStudent(){    
            $data = Students::count();
            return $data;
        }
    }
    
    if (!function_exists('getStudentsByParentID')) {
        function getStudentsByParentID($parentID){    
            $data = Students::select('id', 'student_name')->where(['parent_id'=>$parentID])->get();
            return $data;
        }
    }
    
    
    if (!function_exists('getMonths')) {
        function getMonths(){    
            $data = DB::table('month_names')->select('month_names.*')->orderBy('order_by', 'asc')->get();
            return $data;
        }
    }
    
     if (!function_exists('getMonthNameById')) {
        function getMonthNameById($id){    
            $data = DB::table('month_names')->select('month_names.*')->where(['id'=>$id])->first();
            return $data->month_name;
        }
    }
    
     if (!function_exists('countStdNotHaveRoll')) {
        function countStdNotHaveRoll(){    
            $data = StudentClassAllotments::whereNull('roll_no')->count();
            return $data;
        }
    }
    
    if (!function_exists('getStudentName')) {
        function getStudentName($studentID){    
            $data = Students::where(['id'=>$studentID])->first();
            return $data->student_name;
        }
    }
    
    if (!function_exists('getNotEnrolledStudent')) {
        function getNotEnrolledStudent(){    
            $data = DB::table('students')
            ->leftJoin('student_class_allotments', 'students.id', '=', 'student_class_allotments.student_id')
            ->join('session_setups', 'students.session_id', '=', 'session_setups.id')
            ->join('class_setups', 'students.class_id', '=', 'class_setups.id')
            ->join('parents', 'students.parent_id', '=', 'parents.id')
            ->select('students.*', 'session_setups.session_name', 'class_setups.class_name', 'parents.father_name', 'parents.father_mobile_no', 'parents.father_email',  'parents.address')
            ->whereNull('student_class_allotments.student_id')
            ->get();
            return $data;
        }
    }
    
    if (!function_exists('getTodatInvoice')) {
        function getTodatInvoice(){    
            $data = Invoices::where(['receipt_date'=>date('Y-m-d')])->count();
            return $data;
        }
    }
    
    if (!function_exists('getTotalTeacher')) {
        function getTotalTeacher(){    
            $data = Employees::where(['employee_type'=>0])->count();
            return $data;
        }
    }
    
    if (!function_exists('getTotalStaff')) {
        function getTotalStaff(){    
            $data = Employees::count();
            return $data;
        }
    }
    
   
    
    if (!function_exists('getCollectionByMonth')) {
        function getCollectionByMonth(){    
            $month=ltrim(date('m'), '0');
            $data = Invoices::where(['month_id'=>$month])->sum('payed_amt');
            return $data;
        }
    }
    
    if (!function_exists('getGallery')) {
        function getGallery(){    
            $data = MediaGalleries::where(['status'=>0, 'media_type'=>0])->take(3)->get();
            return $data;
        }
    }
    
    if (!function_exists('getCollectionBymonthName')) {
        function getCollectionBymonthName($month){    
            //$month=ltrim(date('m'), '0');
            $data = FeeCollections::where(['month_id'=>$month, 'session_setup_id'=>getSessionDefault()])->sum('amount');
            return $data;
        }
    }
    
    if (!function_exists('countPendingStdentByMonth')) {
        function countPendingStdentByMonth(){    
            $data = DB::table('student_class_allotments')
                    ->where('session_id', getSessionDefault())
                    ->whereNotIn('student_id', function ($query) {
                        $month=ltrim(date('m'), '0');
                        $query->select('student_id')
                            ->from('invoices')
                            ->where('month_id', $month)
                            ->where('status', 1)
                            ->where('session_id', getSessionDefault());
                    })->count();
            return $data;
        }
    }
    
    if (!function_exists('countPendingStdentByMonthName')) {
        function countPendingStdentByMonthName($month){    
            $data = DB::table('student_class_allotments')
                    ->where('session_id', getSessionDefault())
                    ->whereNotIn('student_id', function ($query) use ($month){
                        //$month=ltrim(date('m'), '0');
                        $query->select('student_id')
                            ->from('invoices')
                            ->where('month_id', $month)
                            ->where('status', 1)
                            ->where('session_id', getSessionDefault());
                    })->count();
            return $data;
        }
    }
    
    if (!function_exists('getReceiptNo')) {
        function getReceiptNo(){    
            $data = Invoices::select('receipt_no')->orderBy('id', 'desc')->first();
            if(!empty($data)){
                if($data->receipt_no==""){
                return "000001";
                } else{
                    return "00000".($data->receipt_no)+1;
                }
            } else{
                return "000001";
            }
            
        }
    }
    
    if (!function_exists('getEventsCat')) {
        function getEventsCat(){    
            $data = EventsCategories::select('*')->where(['status'=>0])->orderBy('name', 'asc')->get();
            return $data;
        }
    }
    
    
    if (!function_exists('countAllotedRollNumber')) {
        function countAllotedRollNumber($sessionId, $classMapingId){    
            $data = StudentClassAllotments::where(['session_id'=>$sessionId, 'class_maping_id'=>$classMapingId])
                    ->where('roll_no', '!=', NULL)->count();
            return $data;
        }
    }
    
    if (!function_exists('countNotAllotedRollNumber')) {
        function countNotAllotedRollNumber($sessionId, $classMapingId){    
            $data = StudentClassAllotments::where(['session_id'=>$sessionId, 'class_maping_id'=>$classMapingId])->count();
            return $data;
        }
    }
    
    if (!function_exists('getFeeHeadAmt')) {
        function getFeeHeadAmt($id){    
            $data = FeeAmountSetups::select('fee_amount')->where(['id'=>$id])->first();
            return $data->fee_amount;
        }
    }
    
    if (!function_exists('getStudentIdByClassAllotmentId')) {
        function getStudentIdByClassAllotmentId($id){    
            $data = StudentClassAllotments::select('student_id')->where(['id'=>$id])->first();
            return @$data->student_id;
        }
    }
    
     if (!function_exists('getStudentByID')) {
        function getStudentByID($studentID, $sessionID){    
            $data = StudentClassAllotments::select('class_setups.class_name', 'section_setups.section_name', 'students.admission_no', 'students.reg_date', 'student_class_allotments.roll_no')
                    ->where(['student_class_allotments.student_id'=>$studentID, 'student_class_allotments.session_id'=>$sessionID])
                    ->join('students', 'student_class_allotments.student_id', '=', 'students.id')
                     ->join('class_setups', 'student_class_allotments.classsetup_id', '=', 'class_setups.id')
                     ->join('section_setups', 'student_class_allotments.sectionsetup_id', '=', 'section_setups.id')
                    ->orderBy('student_class_allotments.id', 'desc')->first();
            return $data;
        }
    }
    
    if (!function_exists('getFeeCollection')) {
        function getFeeCollection($student_id , $session_setup_id, $class_setup_id, $section_setup_id){    
            $data = FeeCollections::select('fee_collections.*')
            ->where(['student_id'=>$student_id, 'session_setup_id'=>$session_setup_id, 'class_setup_id'=>$class_setup_id, 'section_setup_id'=>$section_setup_id])->get();
            return $data;
        }
    }
    
     if (!function_exists('getFeeCollectionWithoutPayment')) {
        function getFeeCollectionWithoutPayment($student_id , $session_setup_id, $class_setup_id, $section_setup_id){    
            $data = FeeCollections::select('fee_collections.*')
            ->where(['student_id'=>$student_id, 'session_setup_id'=>$session_setup_id, 'class_setup_id'=>$class_setup_id, 'section_setup_id'=>$section_setup_id, 'payment_status'=>0])->get();
            return $data;
        }
    }
    
    if (!function_exists('getMonthFeeCollection')) {
        function getMonthFeeCollection($student_id , $session_setup_id, $class_setup_id, $section_setup_id){    
            $data = FeeCollections::select('fee_collections.month_id')->where(['student_id'=>$student_id, 
            'session_setup_id'=>$session_setup_id, 'class_setup_id'=>$class_setup_id, 
            'section_setup_id'=>$section_setup_id, 'payment_status'=>0])
            ->groupBy('fee_collections.month_id')
            ->orderBy('fee_collections.month_id', 'asc')->get();
            return $data;
        }
    }
    
    if (!function_exists('getMonthFeeCollectionfinal')) {
        function getMonthFeeCollectionfinal($student_id , $session_setup_id, $class_setup_id, $section_setup_id){    
            $data = FeeCollections::select('fee_collections.month_id')->where(['student_id'=>$student_id, 
            'session_setup_id'=>$session_setup_id, 'class_setup_id'=>$class_setup_id, 
            'section_setup_id'=>$section_setup_id])
            ->groupBy('fee_collections.month_id')
            ->orderBy('fee_collections.month_id', 'asc')->get();
            return $data;
        }
    }
    if (!function_exists('getMonthFeeCollectionforPDF')) {
        function getMonthFeeCollectionforPDF($student_id , $session_setup_id, $class_setup_id, $section_setup_id, $invoiceNo){    
            $data = FeeCollections::select('fee_collections.month_id')
                    ->join('month_names', 'fee_collections.month_id', '=', 'month_names.id')
                    ->where(['student_id'=>$student_id, 
                    'session_setup_id'=>$session_setup_id, 'class_setup_id'=>$class_setup_id, 
                    'section_setup_id'=>$section_setup_id, 'unique_invoice_no'=>$invoiceNo])
                    ->groupBy('fee_collections.month_id')
                    ->orderBy('month_names.order_by', 'asc')->get();
            return $data;
        }
    }
    
    if (!function_exists('checkMonthlyPayment')) {
        function checkMonthlyPayment($student_id , $session_setup_id, $class_setup_id, $section_setup_id, $month){    
            $data = FeeCollections::select('fee_collections.*')->where(['student_id'=>$student_id, 
            'session_setup_id'=>$session_setup_id, 'class_setup_id'=>$class_setup_id, 
             'month_id'=>$month])
            //->where(['section_setup_id'=>$section_setup_id])
            ->first();
           // print_r("dfgfdgdf".$data); exit;
            return $data;
        }
    }
    
    if (!function_exists('getFeeCollectionByFeeHead')) {
        function getFeeCollectionByFeeHead($session_setup_id, $class_setup_id, $section_setup_id, $feeHeadID, $invoiceNo){    
            $data = FeeCollections::select('fee_collections.*')
            ->where(['fee_collections.session_setup_id'=>$session_setup_id, 'fee_collections.class_setup_id'=>$class_setup_id, 
               'fee_collections.unique_invoice_no'=>$invoiceNo,  'fee_collections.unique_invoice_no'=>$invoiceNo, 'fee_head_setups.id'=>$feeHeadID,])
             //->whereBetween('invoices.receipt_date', [$this->fromDate, $this->toDate])
            ->join('fee_amount_setups', 'fee_collections.fee_amount_setup_id', '=', 'fee_amount_setups.id')
            ->join('fee_head_setups', 'fee_amount_setups.fee_head_setup_id', '=', 'fee_head_setups.id')
            ->sum('amount');
            if(!empty($data)){
                return $data;
            } else{
                return 0;
            }
            
        }
    }
    
    if (!function_exists('getFeeCollectionByMonth')) {
        function getFeeCollectionByMonth($session_setup_id, $class_setup_id, $sectionID, $studentID, $month){    
            $data = DB::table('invoices')->select('invoices.payed_amt')
                    ->where('invoices.month_id', '=', $month)
                    ->where('invoices.session_id', '=', $session_setup_id)
                    ->where('invoices.class_id', '=', $class_setup_id)
                    ->where('invoices.section_id', '=', $sectionID)
                    ->where('invoices.student_id', '=', $studentID)
                    ->first();
            if(!empty($data)){
                return $data->payed_amt;
            } else{
                return 0;
            }
            
        }
    }
    
    if (!function_exists('getTotalBalance')) {
        function getTotalBalance($session_setup_id, $class_setup_id, $sectionID, $studentID){    
            $data = DB::table('invoices')
                    ->where('invoices.session_id', '=', $session_setup_id)
                    ->where('invoices.class_id', '=', $class_setup_id)
                    //->where('invoices.section_id', '=', $sectionID)
                    ->where('invoices.student_id', '=', $studentID)
                    ->sum('curent_balance');
            return $data;
        }
    }
    
    if (!function_exists('getTotaldiscount')) {
        function getTotaldiscount($session_setup_id, $class_setup_id, $sectionID, $studentID){    
            $data = DB::table('invoices')
                    ->where('invoices.session_id', '=', $session_setup_id)
                    ->where('invoices.class_id', '=', $class_setup_id)
                    //->where('invoices.section_id', '=', $sectionID)
                    ->where('invoices.student_id', '=', $studentID)
                    ->sum('discount');
            return $data;
        }
    }
    
    if (!function_exists('getFeeCollectionByMonthStudent')) {
        function getFeeCollectionByMonthStudent($session_setup_id, $class_setup_id, $sectionID, $studentID, $month){    
            
            $data = DB::table('fee_collections')
                ->where('month_id', '=', $month)
                ->where('session_setup_id', '=', $session_setup_id)
                ->where('class_setup_id', '=', $class_setup_id)
                //->where('section_setup_id', '=', $sectionID)
                ->where('student_id', '=', $studentID)
                ->where('payment_status', '=', 1)
                ->sum('amount');
            
            
            if(!empty($data)){
                $details = DB::table('fee_collections')->select('unique_invoice_no')
                ->where('month_id', '=', $month)
                ->where('session_setup_id', '=', $session_setup_id)
                ->where('class_setup_id', '=', $class_setup_id)
                //->where('section_setup_id', '=', $sectionID)
                ->where('student_id', '=', $studentID)
                ->where('payment_status', '=', 1)
                 ->orderBy('fee_collections.id', 'desc')->first();
                 
                 $invoice = DB::table('invoices')->select('invoices.curent_balance', 'invoices.old_balance', 'invoices.payed_amt')
                    ->where('invoices.invoice_no', '=', $details->unique_invoice_no)
                    ->where('invoices.student_id', '=', $studentID)
                    ->first();
                 
               // return $data-$invoice->curent_balance;
                // return $data+$invoice->old_balance;
                 //return $invoice->payed_amt+$invoice->old_balance;
                 return $data;
            } else{
                return 0;
            }
            
        }
    }
    
    if (!function_exists('getFeeOldBalanceStudent')) {
        function getFeeOldBalanceStudent($session_setup_id, $class_setup_id, $studentID){    
            
             $data= DB::table('invoices')->where('student_id', '=', $studentID)
                    ->where('session_id', '=', $session_setup_id)
                    ->where('class_id', '=', $class_setup_id)
                    ->sum('old_balance');

            if(!empty($data)){
                return $data;
            } else{
                return 0;
            }
            
        }
    }
    
    if (!function_exists('getDiscountByStudent')) {
        function getDiscountByStudent($session_setup_id, $class_setup_id, $studentID){    
            
             $data= DB::table('invoices')->where('student_id', '=', $studentID)
                    ->where('session_id', '=', $session_setup_id)
                    ->where('class_id', '=', $class_setup_id)
                    ->sum('discount');

            if(!empty($data)){
                return $data;
            } else{
                return 0;
            }
            
        }
    }
    
    if (!function_exists('getPaidAmtByStudent')) {
        function getPaidAmtByStudent($session_setup_id, $class_setup_id, $studentID){    
             $data= DB::table('invoices')->where('student_id', '=', $studentID)
                    ->where('session_id', '=', $session_setup_id)
                    ->where('class_id', '=', $class_setup_id)
                    ->sum('payed_amt');

            if(!empty($data)){
                return $data;
            } else{
                return 0;
            }
        }
    }
    
    if (!function_exists('getSectionByMonthStudent')) {
        function getSectionByMonthStudent($session_setup_id, $class_setup_id, $studentID, $month){    
            
            
                $details = DB::table('fee_collections')->select('unique_invoice_no')
                ->where('month_id', '=', $month)
                ->where('session_setup_id', '=', $session_setup_id)
                ->where('class_setup_id', '=', $class_setup_id)
                ->where('student_id', '=', $studentID)
                ->where('payment_status', '=', 1)
                 ->orderBy('fee_collections.id', 'desc')->first();
                 
                 $invoice = DB::table('invoices')->select('section_setups.section_name')
                        ->join('section_setups', 'invoices.section_id', '=', 'section_setups.id')
                    ->where('invoices.invoice_no', '=', $details->unique_invoice_no)
                    ->where('invoices.student_id', '=', $studentID)
                    ->first();
                 
                return $invoice->section_name;
           
        }
    }
    
    if (!function_exists('getLastInvoiceByStudentID')) {
        function getLastInvoiceByStudentID($session_setup_id, $studentID){    
            $data = DB::table('invoices')->select('invoices.payed_amt', 'invoices.receipt_no', 'invoices.receipt_date')
                    ->where('invoices.session_id', '=', $session_setup_id)
                    ->where('invoices.student_id', '=', $studentID)
                    ->first();
            return $data;
        }
    }
    
    if (!function_exists('getFeeCollectionMonth')) {
        function getFeeCollectionMonth($student_id , $session_setup_id, $class_setup_id, $section_setup_id, $Month){    
            $data = FeeCollections::where(['student_id'=>$student_id, 
            'session_setup_id'=>$session_setup_id, 
            'class_setup_id'=>$class_setup_id, 
            'month_id'=>$Month])
            //->where(['section_setup_id'=>$section_setup_id])
            ->count();
            //print_r($data); exit;
            return $data;
        }
    }
    
     if (!function_exists('getFeeCollectionFeeHeadAmtId')) {
        function getFeeCollectionFeeHeadAmtId($student_id , $session_setup_id, $class_setup_id, $section_setup_id, $Month, $feeHeadAmtId){    
            $data = FeeCollections::where(['student_id'=>$student_id, 
            'session_setup_id'=>$session_setup_id, 
            'class_setup_id'=>$class_setup_id, 
            'month_id'=>$Month,
            'fee_amount_setup_id'=>$feeHeadAmtId])
            //->where(['section_setup_id'=>$section_setup_id])
            ->count();
            return $data;
        }
    }
    
    if (!function_exists('getOldBalance')) {
        function getOldBalance($student_id , $session_setup_id, $class_setup_id, $section_setup_id){    
            $data = Invoices::where(['student_id'=>$student_id, 
            'session_id'=>$session_setup_id, 'class_id'=>$class_setup_id, 'status'=>1, 'section_id'=>$section_setup_id])
            ->where('curent_balance', '!=' , 0)->sum('curent_balance');
            return $data;
        }
    }
    
    if (!function_exists('getStdCat')) {
        function getStdCat($id){    
            $data = CastCategorySetups::select('category_name')->where(['id'=>$id])->first();
            return @$data->category_name;
        }
    }
    
     if (!function_exists('getPlayers')) {
        function getPlayers($limit){    
            $data= DB::table('players')->select('name', 'cpaton')->distinct()->groupBy('name', 'cpaton')->orderByRaw('RAND()')->take($limit)->get();
            return $data;
        }
    }
    
    if (!function_exists('sendGeneralMail')) {
    function sendGeneralMail($email, $subject, $data, $templateName){
        require 'vendor/autoload.php';
         $senderEamil=Settings::where(['settingname'=>'mail_user'])->value('settingvalue');

        $mail = new PHPMailer(true);   // Passing `true` enables exceptions
        try {
            // Email server settings
           
            $mail->SMTPDebug =SMTP::DEBUG_OFF;///SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP(); 
            $mail->Host = Settings::where(['settingname'=>'mail_host'])->value('settingvalue');             //  smtp host
            $mail->SMTPAuth = $senderEamil;
            $mail->Username = $senderEamil;  //  sender username
            $mail->Password = Settings::where(['settingname'=>'mail_password'])->value('settingvalue');      // sender password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port = Settings::where(['settingname'=>'mail_port'])->value('settingvalue');                         // port - 587/465
 
            $mail->setFrom($senderEamil, 'onlineshop');
            $mail->addAddress($email);
            //$mail->addCC($request->emailCc);
            //$mail->addBCC($request->emailBcc);
 
            $mail->addReplyTo($senderEamil, 'onlineshop');
 
            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
 
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = view($templateName)->with('data',$data);
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
 
            $mail->send();
                //echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
    }
    
   
  
}

