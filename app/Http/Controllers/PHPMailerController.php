<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class PHPMailerController extends Controller
{
    public function composeEmail(Request $request) {
        require 'vendor/autoload.php';

        $mail = new PHPMailer(true);   // Passing `true` enables exceptions
        try {
            // Email server settings
             $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP(); 
            $mail->Host = 'mail.mdisdo.org';             //  smtp host
            $mail->SMTPAuth = true;
            $mail->Username = 'info@shop.mdisdo.org';   //  sender username
            $mail->Password = 'WM}Hq[6pFJEP';       // sender password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port = 465;                          // port - 587/465
 
            $mail->setFrom('info@shop.mdisdo.org', 'onlineshop');
            $mail->addAddress("jafarkhanphp@gmail.com");
            //$mail->addCC($request->emailCc);
            //$mail->addBCC($request->emailBcc);
 
            $mail->addReplyTo('info@shop.mdisdo.org', 'onlineshop');
 
            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
 
 
            $data=[
                'subject' =>'Here is the subject',
                'form_message' =>'This is the body in plain text for non-HTML mail clients'
            ];
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body    = view('mail.basic-mail-template')->with('data',$data);
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
 
            $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
 
        
    }
}
