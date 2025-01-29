<?php 

namespace App\Controllers;

use App\Repositories\MessagesRepositoryRDS;
use App\Services\SendEmails;
use Config\ConnectionRDS;
use Predis\Client;

class GetMessagesNotifyPayment
{
    private $connenctionRedis;
    private $connection;

    public function __construct()
    {
        $this->connenctionRedis = new ConnectionRDS(new Client());
  
        $this->connection = $this->connenctionRedis->getConnectionRDS();

        $this->getMessagesQueueRDS();
    }

    public function getMessagesQueueRDS()
    {     
        $queue = 'queue_notify_payment';

        $messagesRopositoryRSD = new MessagesRepositoryRDS($this->connection, $queue);
        $messageList[]= $messagesRopositoryRSD->getMsgOfRDS();

        if (!empty($messageList)) {
            $this->sendEmails($messageList);
            // APÓS ENVIADO EXCLUI A LISTA :::
        } 
    }

    private function sendEmails($messageList)
    {
        foreach ($messageList[0] as $message) {
            $sendEmails = new SendEmails(json_decode($message));
        }
    }
}