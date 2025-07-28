<?php
require_once 'confg.php';

use PHPMailer\PHPMailer\PHPMailer;



class Mailer
{
    public function send($address, $body, $subject)
    {
        try {
            $mail = new PHPMailer;

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->CharSet = 'UTF-8';
            $mail->IsSMTP();                                   // SMTP-n keresztüli küldés  
            $mail->SMTPAuth = false;
            //$mail->SMTPDebug = 3;

            $mail->Host = "owa.rufusz.hu";

            $mail->setFrom(MAILER_CONFIG["setForm"]["from"], MAILER_CONFIG["setForm"]["to"]);
            $mail->addAddress($address, $address);     //Add a recipient

            //Content
            $mail->isHTML(true); //Set email format to HTML
            $mail->WordWrap = 50;

            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AltBody = strip_tags($body);

            $mail->Send();
        } catch (Exception $e) {
            var_dump($e);
            return false;
        }
    }
}
