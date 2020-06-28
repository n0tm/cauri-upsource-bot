<?php

namespace App\Http\Request\Upsource;

use App\Http\Request\Exception\UnknownRequest;
use App\Http\Request\Upsource\Model\AbstractRequest;
use Illuminate\Http\Request;

class Converter implements ConverterInterface
{
    /**
     * @param Request $request
     * @return AbstractRequest
     * @throws UnknownRequest
     */
    public function convert(Request $request)
    {
        $dataType     = $request->dataType;
        $majorVersion = $request->majorVersion;
        $minorVersion = $request->minorVersion;
        $projectId    = $request->projectId;
        $data         = $request->data;

        switch ($dataType) {
            case self::DATA_TYPE_REVIEW_CREATED:
                return Model\Factory::createReviewCreated($majorVersion, $minorVersion, $projectId, $data);
            default:
                throw new UnknownRequest("Request with dataType \"{$dataType}\" not found");
        }
    }
}