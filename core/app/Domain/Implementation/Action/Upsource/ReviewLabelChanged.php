<?php

namespace App\Domain\Implementation\Action\Upsource;

use App\Notifications\ReviewReadyForReview;
use App\Domain\Contract;

class ReviewLabelChanged extends AbstractReview
{
    private const LABEL_ID_READY_FOR_REVIEW = 'ready';

    /**
     * @var string
     */
    private $projectId;

    /**
     * @var string
     */
    private $userNameWhoChangedLabel;

    /**
     * @var string
     */
    private $labelId;

    /**
     * @var bool
     */
    private $isWasAdded;

    public function __construct(
        Contract\Repository\Upsource\Factory $repository,
        string $reviewId,
        string $projectId,
        string $userNameWhoChangedLabel,
        string $labelId,
        bool $isWasAdded)
    {
        parent::__construct($repository, $reviewId);

        $this->labelId                 = $labelId;
        $this->isWasAdded              = $isWasAdded;
        $this->projectId               = $projectId;
        $this->userNameWhoChangedLabel = $userNameWhoChangedLabel;
    }

    public function process(): void
    {
        switch ($this->labelId) {
            case self::LABEL_ID_READY_FOR_REVIEW:
                $this->handleReadyLabel();
                return;
        }
    }

    private function handleReadyLabel(): void
    {
        if (!$this->isWasAdded) {
            return;
        }

        $reviewRepository = $this->repositoryFactory->createReview();
        $review = $reviewRepository->getById($this->reviewId);
        $branch = $review->branch;
        $telegramUser = $review->upsourceUser->user->telegram;
        $telegramUser->notify(new ReviewReadyForReview(
            $this->projectId,
            $this->reviewId,
            $branch,
            $this->userNameWhoChangedLabel
        ));
    }
}