<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "PHPMailer/src/Exception.php";
require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/SMTP.php";

function send_email($toAddress, $subject, $body) {

    $phpmailer = new PHPMailer(TRUE);
    $phpmailer->isSMTP();
    $phpmailer->Host = "sv14.firebird.netowl.jp";
    $phpmailer->SMTPAuth = TRUE;
    $phpmailer->Port = 587;
    $phpmailer->Username = "customer@keanhealth.co.jp";
    $phpmailer->Password = "bB7yeSDk";
    //$phpmailer->SMTPSecure = SMTP_SecureMode;

    $phpmailer->setFrom("customer@keanhealth.co.jp");
    $phpmailer->addReplyTo("customer@keanhealth.co.jp");
    $phpmailer->addAddress($toAddress);

    $phpmailer->Subject = $subject;
    $phpmailer->isHTML = false;
    $phpmailer->Body = $body;

    if($phpmailer->send()){
        return 0;
    }else{
        $error = 'Message could not be sent. Mailer Error: ' . $phpmailer->ErrorInfo;
        error_log($error);

    }
}

send_email('qbxlrudgk1@gmail.com','test','test');
?>
