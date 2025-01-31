<?php 

namespace App\Repositories;

interface MessagesRepositoryInterface {
    public function getMsgOfRDS(string $queue): array;
    public function deleteRDSLists(string $queue): string;
}