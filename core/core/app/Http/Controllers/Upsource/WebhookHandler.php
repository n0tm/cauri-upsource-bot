<?php

namespace App\Http\Controllers\Upsource;

use App\Domain\Contract;
use App\Http\Controllers\Controller;
use App\Http\Request\Upsource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Request\Exception\UnknownRequest;

class WebhookHandler extends Controller
{
    /**
     * @var Upsource\ConverterInterface
     */
    private $requestConverter;

    /**
     * @var ActionProcessor
     */
    private $actionProcessor;

    public function __construct(
        Upsource\ConverterInterface $requestConverter,
        ActionProcessor $actionProcessor
    ) {
        $this->requestConverter = $requestConverter;
        $this->actionProcessor  = $actionProcessor;
    }

    public function handle(Request $request)
    {
        Log::info("New Upsource Request");
        Log::info($request);
        try {
            $convertedRequest = $this->requestConverter->convert($request);
        } catch (UnknownRequest $e) {
            Log::critical("Failed to convert upsource request\n[Error] {$e->getMessage()}");
            return;
        }

        $this->actionProcessor->process($convertedRequest);
    }
}
