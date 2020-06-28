<?php

namespace App\Domain\Contract\Action;

use App\Domain\Implementation\Action\ReviewCreated;

interface Factory
{
    public function createNewReview(string $id, string $branch): ReviewCreated;
}