<?php

namespace App\Http\Request\Upsource;

use App\Http\Request\Exception\UnknownRequest;
use App\Http\Request\Upsource\Model\AbstractRequest;
use Illuminate\Http\Request;

class Converter implements ConverterInterface
{
	/**
	 * @var Model\Factory
	 */
	private $factory;

	public function __construct(Model\Factory $factory)
	{
		$this->factory = $factory;
	}

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
                return $this->factory->createReviewCreated($majorVersion, $minorVersion, $projectId, $data);
            case self::DATA_TYPE_REVIEW_LABEL_CHANGED:
                return $this->factory->createReviewLabelChanged($majorVersion, $minorVersion, $projectId, $data);
	        case self::DATA_TYPE_REVIEW_STATE_CHANGED:
	        	return $this->factory->createReviewClosedOrReopened($majorVersion, $minorVersion, $projectId, $data);
	        case self::DATA_TYPE_DISCUSSION_NEW:
	        	return $this->factory->createDiscussionNew($majorVersion, $minorVersion, $projectId, $data);
            default:
                throw new UnknownRequest("Request with dataType \"{$dataType}\" not found");
        }
    }
}