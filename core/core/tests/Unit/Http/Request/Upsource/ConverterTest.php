<?php

namespace Tests\Unit\Http\Request\Upsource;

use App\Http\Request\Exception\UnknownRequest;
use App\Http\Request\Upsource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class ConverterTest extends TestCase
{
    use WithFaker;

    /**
     * @var Request|\PHPUnit\Framework\MockObject\MockObject
     */
    private $request;

    /**
     * @var Upsource\Converter
     */
    private $converter;

	/**
	 * @var Upsource\Model\Factory|\PHPUnit\Framework\MockObject\MockObject
	 */
    private $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request   = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $this->factory   = $this->createMock(Upsource\Model\Factory::class);
        $this->converter = new Upsource\Converter($this->factory);
    }

    public function testConvertWhenDataTypeReviewCreated(): void
    {
        $this->request->dataType     = Upsource\ConverterInterface::DATA_TYPE_REVIEW_CREATED;
        $this->request->majorVersion = $this->faker->randomDigit;
        $this->request->minorVersion = $this->faker->randomDigit;
        $this->request->projectId    = '::project id::';
        $this->request->data         = $this->faker->randomElements();

        $reviewCreatedRequest = $this->createMock(Upsource\Model\ReviewCreated::class);
        $this->factory->expects(self::once())
	        ->method('createReviewCreated')
	        ->with(
	        	$this->request->majorVersion,
		        $this->request->minorVersion,
		        $this->request->projectId,
		        $this->request->data
	        )->willReturn($reviewCreatedRequest);

        self::assertEquals($reviewCreatedRequest, $this->converter->convert($this->request));
    }

    public function testConvertWhenDataTypeReviewLabelChanged(): void
    {
        $this->request->dataType     = Upsource\ConverterInterface::DATA_TYPE_REVIEW_LABEL_CHANGED;
        $this->request->majorVersion = $this->faker->randomDigit;
        $this->request->minorVersion = $this->faker->randomDigit;
        $this->request->projectId    = '::project id::';
        $this->request->data         = $this->faker->randomElements();

	    $reviewLabelChangedRequest = $this->createMock(Upsource\Model\ReviewLabelChanged::class);
	    $this->factory->expects(self::once())
		    ->method('createReviewLabelChanged')
		    ->with(
			    $this->request->majorVersion,
			    $this->request->minorVersion,
			    $this->request->projectId,
			    $this->request->data
		    )->willReturn($reviewLabelChangedRequest);

	    self::assertEquals($reviewLabelChangedRequest, $this->converter->convert($this->request));
    }

	public function testConvertWhenDataTypeReviewClosedOrReopened(): void
	{
		$this->request->dataType     = Upsource\ConverterInterface::DATA_TYPE_REVIEW_STATE_CHANGED;
		$this->request->majorVersion = $this->faker->randomDigit;
		$this->request->minorVersion = $this->faker->randomDigit;
		$this->request->projectId    = '::project id::';
		$this->request->data         = $this->faker->randomElements();

		$reviewClosedOrReopenedRequest = $this->createMock(Upsource\Model\ReviewClosedOrReopened::class);
		$this->factory->expects(self::once())
			->method('createReviewClosedOrReopened')
			->with(
				$this->request->majorVersion,
				$this->request->minorVersion,
				$this->request->projectId,
				$this->request->data
			)->willReturn($reviewClosedOrReopenedRequest);

		self::assertEquals($reviewClosedOrReopenedRequest, $this->converter->convert($this->request));
	}

	public function testConvertWhenDataTypeDiscussionNew(): void
	{
		$this->request->dataType     = Upsource\ConverterInterface::DATA_TYPE_DISCUSSION_NEW;
		$this->request->majorVersion = $this->faker->randomDigit;
		$this->request->minorVersion = $this->faker->randomDigit;
		$this->request->projectId    = '::project id::';
		$this->request->data         = $this->faker->randomElements();

		$discussionNewRequest = $this->createMock(Upsource\Model\DiscussionNew::class);
		$this->factory->expects(self::once())
			->method('createDiscussionNew')
			->with(
				$this->request->majorVersion,
				$this->request->minorVersion,
				$this->request->projectId,
				$this->request->data
			)->willReturn($discussionNewRequest);

		self::assertEquals($discussionNewRequest, $this->converter->convert($this->request));
	}

    public function testConvertWhenDataTypeNotExist(): void
    {
        $this->request->dataType     = '::not existing data type::';
        $this->request->majorVersion = $this->faker->randomDigit;
        $this->request->minorVersion = $this->faker->randomDigit;
        $this->request->projectId    = '::project id::';
        $this->request->data         = $this->faker->randomElements();

        $this->expectException(UnknownRequest::class);

        $this->converter->convert($this->request);
    }
}