<?php

namespace App\Domain\Implementation;

use App\Domain\Contract;
use Illuminate\Support\Facades\Log;

class Processor implements Contract\Processor
{
    public function process(Contract\Action\AbstractAction $action): void
    {
        Log::info("Starting processing {$action->getType()} action with id:{$action->getId()}");
        try {
            $action->handle();
        } catch (\Exception $exception) {
            Log::critical("Error occurred, during action processing, id:{$action->getId()}");
        }
    }
}