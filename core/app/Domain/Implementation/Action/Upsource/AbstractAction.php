<?php

namespace App\Domain\Implementation\Action\Upsource;

use App\Domain\Contract;

abstract class AbstractAction
{
    /**
     * @var Contract\Repository\Upsource\Factory
     */
    protected $repositoryFactory;

    public function __construct(Contract\Repository\Upsource\Factory $repositoryFactory)
    {
        $this->repositoryFactory = $repositoryFactory;
    }
}