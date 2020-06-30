<?php

namespace App\Domain\Implementation\Action;

use App\Domain\Contract;

class Factory implements Contract\Action\Factory
{
    public function createUpsource(): Contract\Action\Upsource\Factory
    {
        return new Upsource\Factory();
    }
}