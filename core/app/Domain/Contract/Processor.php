<?php

namespace App\Domain\Contract;

interface Processor
{
    public function process(Action\AbstractAction $action): void;
}