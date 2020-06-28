<?php

namespace App\Domain\Contract\Action;

use App\Domain\Implementation;

interface Factory
{
    public function createReviewCreated(string $reviewId, string $branch): Implementation\Action\ReviewCreated;
    public function createReviewLabelChanged(string $reviewId, string $labelId, bool $isWasChanged): Implementation\Action\ReviewLabelChanged;
}