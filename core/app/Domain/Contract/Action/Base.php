<?php

namespace App\Domain\Contract\Action;

interface Base
{
    public function process(): void;
    public function getType(): string;
}