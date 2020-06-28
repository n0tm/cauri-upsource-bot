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

    protected function setUp(): void
    {
        parent::setUp();

        $this->request   = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $this->converter = new Upsource\Converter();
    }

    public function testConvertWhenDataTypeReviewCreated(): void
    {
        $this->request->dataType     = Upsource\ConverterInterface::DATA_TYPE_REVIEW_CREATED;
        $this->request->majorVersion = $this->faker->randomDigit;
        $this->request->minorVersion = $this->faker->randomDigit;
        $this->request->projectId    = '::project id::';
        $this->request->data         = $this->faker->randomElements();

        $expectedReviewCreatedRequest = Upsource\Model\Factory::createReviewCreated(
            $this->request->majorVersion,
            $this->request->minorVersion,
            $this->request->projectId,
            $this->request->data
        );

        $actualReviewCreatedRequest = $this->converter->convert($this->request);

        $this->assertEquals($expectedReviewCreatedRequest, $actualReviewCreatedRequest);
    }

    public function testConvertWhenDataTypeReviewLabelChanged(): void
    {
        $this->request->dataType     = Upsource\ConverterInterface::DATA_TYPE_REVIEW_LABEL_CHANGED;
        $this->request->majorVersion = $this->faker->randomDigit;
        $this->request->minorVersion = $this->faker->randomDigit;
        $this->request->projectId    = '::project id::';
        $this->request->data         = $this->faker->randomElements();

        $expectedReviewLabelChangedRequest = Upsource\Model\Factory::createReviewLabelChanged(
            $this->request->majorVersion,
            $this->request->minorVersion,
            $this->request->projectId,
            $this->request->data
        );

        $actualReviewLabelChangedRequest = $this->converter->convert($this->request);

        $this->assertEquals($expectedReviewLabelChangedRequest, $actualReviewLabelChangedRequest);
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