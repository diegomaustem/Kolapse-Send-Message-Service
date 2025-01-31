<?php 
declare(strict_types=1);

namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Repositories\MessagesRepositoryInterface;
use App\Services\SendEmails;

class GetMessagesNotifyPayment
{
    private $messagesRepositoryRDS;

    public function __construct(MessagesRepositoryInterface $messagesRepositoryRDS)
    {
        $this->messagesRepositoryRDS = $messagesRepositoryRDS;
        $this->getMessagesQueueRDS();
    }

    public function getMessagesQueueRDS(): string
    {     
        $queue = 'queue_notify_payment';

        $messageList[] = $this->messagesRepositoryRDS->getMsgOfRDS($queue);

        if (!empty($messageList)) {

            try {
                $returnEmail = json_decode($this->sendEmails($messageList));
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
            
            
            if ($returnEmail->code == 250) {
                $this->messagesRepositoryRDS->deleteRDSLists($queue);
            }
            
        } else {
            return json_encode(['error' => 'There are no lists', 'code' => 404]);
        }
    }

    private function sendEmails($messageList)
    {
        foreach ($messageList[0] as $message) {
            $sendEmails = new SendEmails(json_decode($message));
            return $sendEmails->dispache();
        }
    }
}