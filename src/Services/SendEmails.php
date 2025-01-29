<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SendEmails
{
    private $message;
    private $mail;

    public function __construct($message)
    {
        $this->message = $message;
        $this->mail = new PHPMailer(true);

        $this->dispache();
    }

    public function dispache()
    {
        $serverSMTP = $this->verifySmtpServer($this->message->email);

        var_dump('Retorno', $serverSMTP);die();

        try {
            $this->mail->isSMTP();

        } catch (Exception $e){
            return 'Error';
        }




    }

    private function verifySmtpServer($email)
    {
        $serverSmtp = explode('@', $email);
        $serverSmtp[1];

        switch ($serverSmtp[1]) {
            case 'gmail.com':
                return 'smtp.gmail.com';
                break;
            case 'outlook.com':
                return 'smtp-mail.outlook.com';
                break;
            case 'yahoo.com':
                return 'smtp.mail.yahoo.com';
                break;
            case 'mailgun.org':
                return 'smtp.mailgun.org';
                break;
            default:
                break;
                return 'Not Found.';
        }
    }
}