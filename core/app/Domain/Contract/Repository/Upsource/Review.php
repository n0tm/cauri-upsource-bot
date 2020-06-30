<?php

namespace App\Domain\Contract\Repository\Upsource;

use App\Model;

interface Review
{
    public function create(string $id, string $creatorId, string $branch): bool;
    public function getById(string $id): Model\Upsource\Review;
}