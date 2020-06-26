<?php

namespace App\Domain\Contract\Action;

interface Base
{
    public function handle(): void;
    public function getType(): string;
}