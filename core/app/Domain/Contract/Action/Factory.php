<?php

namespace App\Domain\Contract\Action;

use App\Domain\Implementation\Action\NewReview;

interface Factory
{
    public function createNewReview(string $id, string $branch): NewReview;
}