<?php

namespace App\Domain\Implementation\Action;

use App\Domain\Contract;
use App\Domain\Implementation;

class Factory implements Contract\Action\Factory
{
    public function createReviewCreated(string $reviewId, string $branch): ReviewCreated
    {
        return new ReviewCreated($reviewId, $branch);
    }

    public function createReviewLabelChanged(string $reviewId, string $labelId, bool $isWasChanged): Implementation\Action\ReviewLabelChanged
    {
        return new ReviewLabelChanged($reviewId, $labelId, $isWasChanged);
    }
}