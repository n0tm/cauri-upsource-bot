<?php

namespace App\Domain\Implementation\Action;

use App\Domain\Contract;

class Factory implements Contract\Action\Factory
{
    public function createNewReview(string $id, string $branch): ReviewCreated
    {
        return new ReviewCreated($id, $branch);
    }
}