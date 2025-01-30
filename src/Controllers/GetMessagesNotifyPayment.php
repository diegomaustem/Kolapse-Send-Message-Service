<?php 

namespace App\Controllers;

use App\Repositories\MessagesRepositoryRDS;
use App\Services\SendEmails;
use Config\ConnectionRDS;
use Exception;
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
            $returnEmail = json_decode($this->sendEmails($messageList));
            
            if ($returnEmail->code == 250) {
                $messagesRopositoryRSD->deleteRDSLists($queue);
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