<?php

namespace App\Domain\Implementation\Action;

use App\Domain\Contract;
use Illuminate\Support\Facades\Log;

class ReviewCreated extends AbstractReviewAction
{
    /**
     * @var string
     */
    private $branch;

    public function __construct(string $reviewId, string $branch)
    {
        parent::__construct($reviewId);
        $this->branch = $branch;
    }

    public function process(): void
    {
        // @todo: Добавить обработку
        Log::info("New Review created!\nID: {$this->reviewId}\nBranch: {$this->branch}");
    }
}