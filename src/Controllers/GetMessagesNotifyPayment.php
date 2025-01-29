<?php 

namespace App\Controllers;

use App\Repositories\MessagesRepositoryRDS;
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
        $messageList[] = $messagesRopositoryRSD->getMsgOfRDS();

        if (!empty($messageList)) {

            // MANDA OS DADOS PARA ENVIO ::: 

            // APÓS ENVIADO EXCLUI A LISTA :::

        } 

        var_dump('Inside', $messageList);die();



        // if ($this->connection->exists('has_message')) {
        //     var_dump('Dentro');die();

        //     $list[] = $this->connection->lrange($queueList, 0, -1);

        //     $this->envio($list);
        // } else {
        //     var_dump('fORA');die();
        // }
        

    }


    private function envio($ar) {

        var_dump('Conteuod:', $ar);die();

    }


     


    // Vai fazer uma requisição ao 

    // Fazer acesso ao redis ::: 

    // Pegar as mensagens da fila :::: 

    // Enviar as mensagens :::: 

    // Apaga-las da fila 





}