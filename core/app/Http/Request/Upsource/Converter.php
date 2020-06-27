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
        $dataType     = $request->post(self::KEY_DATA_TYPE);
        $majorVersion = $request->post(self::KEY_MAJOR_VERSION);
        $minorVersion = $request->post(self::KEY_MINOR_VERSION);
        $projectId    = $request->post(self::KEY_PROJECT_ID);
        $data         = $request->post(self::KEY_DATA);

        switch ($dataType) {
            case self::DATA_TYPE_NEW_REVIEW:
                return Model\Factory::createNewReview($majorVersion, $minorVersion, $projectId, $dataType, $data);
            default:
                throw new UnknownRequest("Request with dataType \"{$dataType}\" not found");
        }
    }
}