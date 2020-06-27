<?php

namespace App\Domain\Implementation\Action;

use App\Domain\Contract;

class Factory implements Contract\Action\Factory
{
    public function createNewReview(string $id, string $branch): NewReview
    {
        return new NewReview($id, $branch);
    }
}