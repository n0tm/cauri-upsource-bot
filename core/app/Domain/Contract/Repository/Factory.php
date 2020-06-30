<?php

namespace App\Domain\Contract\Repository;

interface Factory
{
    public function createUpsource(): Upsource\Factory;
}