<?php

namespace App\Domain\Implementation\Action\Upsource;

use App\Domain\Contract;
use App\Domain\Implementation;

class Factory implements Contract\Action\Upsource\Factory
{
    public function createReviewCreated(
        Contract\Repository\Upsource\Factory $repository,
        string $reviewId,
        string $creatorId,
        string $branch
    ): Contract\Action\Base {
        return new ReviewCreated($repository, $reviewId, $creatorId, $branch);
    }

    public function createReviewLabelChanged(
        Contract\Repository\Upsource\Factory $repository,
        string $reviewId,
        string $projectId,
        string $userNameWhoChangedLabel,
        string $labelId,
        bool $isWasChanged
    ): Contract\Action\Base {
        return new ReviewLabelChanged(
            $repository,
            $reviewId,
            $projectId,
            $userNameWhoChangedLabel,
            $labelId,
            $isWasChanged
        );
    }
}