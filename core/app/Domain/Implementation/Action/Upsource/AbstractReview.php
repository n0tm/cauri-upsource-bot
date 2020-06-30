<?php

namespace App\Domain\Implementation\Action\Upsource;

use App\Domain\Contract;

abstract class AbstractReview extends AbstractAction implements Contract\Action\Base
{
    /**
     * @var string
     */
    protected $reviewId;

    public function __construct(Contract\Repository\Upsource\Factory $repositoryFactory, string $reviewId)
    {
        parent::__construct($repositoryFactory);

        $this->reviewId = $reviewId;
    }
}