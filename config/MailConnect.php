<?php
require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class MailConnect
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
    }

    public function getConnection()
    {
        try {
            $this->mail->isSMTP();
            $this->mail->Host = 'smtp.mailtrap.io';
            $this->mail->SMTPAuth = true;
            $this->mail->Port = 2525;
            $this->mail->Username = '5751a43d1e797a';
            $this->mail->Password = '70fc98268195c6';
            return $this->mail;
        } catch (\Exception $th) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }

    public function sendMail($data)
    {
        $this->getConnection();
        $this->mail->setFrom('admin@send-mail.test', 'Admin Sending');
        $this->mail->addAddress($data['email'], $data['name']);

        //Content
        $this->mail->isHTML(true);                                  //Set email format to HTML
        $this->mail->Subject = $data['subject'];
        $this->mail->Body    = $data['message'];
        // $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $this->mail->send();
        echo 'Message has been sent';
    }
}
