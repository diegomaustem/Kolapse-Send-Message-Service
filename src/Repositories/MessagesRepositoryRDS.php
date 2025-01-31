<?php 
declare(strict_types=1);

namespace App\Repositories;

use Config\ConnectionRDS;

class MessagesRepositoryRDS implements MessagesRepositoryInterface
{
    private $connectionRedis;

    public function __construct(ConnectionRDS $connection)
    {
        $this->connectionRedis = $connection->getConnectionRDS();
    }

    public function getMsgOfRDS(string $queue): array {
        try {
            return $this->connectionRedis->lrange($queue, 0, -1);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function deleteRDSLists(string $queue): string
    {
        try {
            $this->connectionRedis->del($queue);
            $this->connectionRedis->del('has_message');
            return json_encode(['message' => 'Excluded lists', 'code' => 200]);
        }catch (\Throwable $th) {
            return $th;
        }
    }
}