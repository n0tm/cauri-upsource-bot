<?php

namespace App\Domain\Implementation\Repository\Upsource;

use App\Domain\Contract;

class Factory implements Contract\Repository\Upsource\Factory
{
    public function createReview(): Contract\Repository\Upsource\Review
    {
        return new Review();
    }
}