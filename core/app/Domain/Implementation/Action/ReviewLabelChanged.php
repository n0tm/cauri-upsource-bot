<?php

namespace App\Domain\Implementation\Action;

use Illuminate\Support\Facades\Log;

class ReviewLabelChanged extends AbstractReviewAction
{
    /**
     * @var string
     */
    private $labelId;

    /**
     * @var bool
     */
    private $isWasAdded;

    public function __construct(string $reviewId, string $labelId, bool $isWasAdded)
    {
        parent::__construct($reviewId);

        $this->labelId    = $labelId;
        $this->isWasAdded = $isWasAdded;
    }

    public function process(): void
    {
        // @todo: Добавить обработку
        Log::info("Some review label was changed!\nID: {$this->reviewId}\nIsWasAdded: {$this->isWasAdded}");
    }
}