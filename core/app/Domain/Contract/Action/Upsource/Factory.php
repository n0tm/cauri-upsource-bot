<?php

namespace App\Domain\Contract\Action\Upsource;

use App\Domain\Contract;
use App\Domain\Implementation;

interface Factory
{
    public function createReviewCreated(
        Contract\Repository\Upsource\Factory $repository,
        string $reviewId,
        string $creatorId,
        string $branch
    ): Contract\Action\Base;

    public function createReviewLabelChanged(
        Contract\Repository\Upsource\Factory $repository,
        string $reviewId,
        string $projectId,
        string $userNameWhoChangedLabel,
        string $labelId,
        bool $isWasChanged
    ): Contract\Action\Base;
}