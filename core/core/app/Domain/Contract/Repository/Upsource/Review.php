<?php

namespace App\Domain\Contract\Repository\Upsource;

use App\Domain\Contract;

interface Review
{
    public function create(string $id, string $creatorId, string $branch): bool;
    public function getById(string $id): ?Contract\Entity\Upsource\Review;
}