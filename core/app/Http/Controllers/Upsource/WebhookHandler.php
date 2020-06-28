<?php

namespace App\Http\Controllers\Upsource;

use App\Domain\Contract;
use App\Http\Controllers\Controller;
use App\Http\Request\Upsource;
use Illuminate\Http\Request;
use Telegram\Bot\Api;

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
        $convertedRequest = $this->requestConverter->convert($request);
        $this->actionProcessor->process($convertedRequest);
    }
}
