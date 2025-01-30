<?php

namespace App\Services;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();
class SendEmails
{
    private $message;
    private $mail;

    public function __construct($message)
    {
        $this->message = $message;
        $this->mail = new PHPMailer(true);
    }

    public function dispache()
    {
        $this->emailSettings();

        try {
            $this->mail->send();
            return json_encode(['message' => 'Email sent successfully', 'code' => 250]);
        } catch (Exception $e){
            return json_encode(['error' => $e->getMessage(), 'code' => 421]);
        }
    }

    private function emailSettings()
    {
        $this->mail->isSMTP();
        $this->mail->Host = $_ENV['HOST'];
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $_ENV['USERNAME'];
        $this->mail->Password = $_ENV['PASSWORD'];
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $this->mail->Port = $_ENV['PORT'];
            
        $this->mail->setFrom('kolapse.notify@gmail.com', 'Notify');
        $this->mail->addAddress($this->message->email, $this->message->name);

        $this->mail->isHTML(true);
        $this->mail->Subject = 'Payment confirmation Kolapse';
        $this->mail->Body = "We received your payment";
    }
}