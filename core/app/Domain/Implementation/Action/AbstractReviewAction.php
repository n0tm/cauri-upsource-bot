<?php

namespace App\Domain\Implementation\Action;

abstract class AbstractReviewAction implements \App\Domain\Contract\Action\Base
{
    /**
     * @var string
     */
    protected $reviewId;

    public function __construct(string $reviewId)
    {
        $this->reviewId = $reviewId;
    }
}