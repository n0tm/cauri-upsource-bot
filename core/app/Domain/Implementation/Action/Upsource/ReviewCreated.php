<?php

namespace App\Domain\Implementation\Action\Upsource;

use App\Domain\Contract;

class ReviewCreated extends AbstractReview
{
    /**
     * @var string
     */
    private $branch;

    /**
     * @var string
     */
    private $creatorId;

    public function __construct(
        Contract\Repository\Upsource\Factory $repository,
        string $reviewId,
        string $creatorId,
        string $branch
    ) {
        parent::__construct($repository, $reviewId);

        $this->branch = $branch;
        $this->creatorId = $creatorId;
    }

    public function process(): void
    {
        $reviewRepository = $this->repositoryFactory->createReview();
        $reviewRepository->create($this->reviewId, $this->creatorId, $this->branch);
    }
}