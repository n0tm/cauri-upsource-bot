<?php

namespace App\Domain\Implementation\Repository\Upsource;

use App\Model;
use App\Domain\Contract;

class Review implements Contract\Repository\Upsource\Review
{
    public function create(string $id, string $creatorId, string $branch): bool
    {
        $review = new Model\Upsource\Review();
        $review->id = $id;
        $review->creator_upsource_user_id = $creatorId;
        $review->branch = $branch;
        return $review->save();
    }

    public function getById(string $id): Model\Upsource\Review
    {
        return Model\Upsource\Review::query()->find($id);
    }
}