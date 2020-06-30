<?php

namespace App\Domain\Contract\Repository\Upsource;

interface Factory
{
    public function createReview(): Review;
}