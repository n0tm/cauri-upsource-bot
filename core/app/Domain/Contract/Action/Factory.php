<?php

namespace App\Domain\Contract\Action;

interface Factory
{
    public function createUpsource(): Upsource\Factory;
}