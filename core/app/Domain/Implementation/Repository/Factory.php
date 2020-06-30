<?php

namespace App\Domain\Implementation\Repository;

use App\Domain\Contract;

class Factory implements Contract\Repository\Factory
{
    public function createUpsource(): Contract\Repository\Upsource\Factory
    {
        return new Upsource\Factory();
    }
}