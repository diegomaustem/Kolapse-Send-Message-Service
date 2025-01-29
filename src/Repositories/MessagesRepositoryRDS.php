<?php 

namespace App\Repositories;


class MessagesRepositoryRDS 
{
    private $connectionRedis;
    private $storage_queue;

    public function __construct($connection, $storage_queue)
    {
        $this->connectionRedis = $connection;
        $this->storage_queue   = $storage_queue;
    }

    public function getMsgOfRDS()
    {
        try {
            return $this->connectionRedis->lrange($this->storage_queue, 0, -1);
        } catch (\Throwable $th) {
            return $th;
        }
    }
}