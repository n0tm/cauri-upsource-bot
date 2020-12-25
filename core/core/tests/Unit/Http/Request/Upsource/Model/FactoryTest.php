<?php

namespace Tests\Unit\Http\Request\Upsource\Model;

use App\Http\Request\Upsource\Model;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FactoryTest extends TestCase
{
    use WithFaker;

	/**
	 * @var Model\Factory
	 */
    private $factory;

    protected function setUp(): void
    {
	    parent::setUp();

	    $this->factory = new Model\Factory();
    }

	public function testCreateReviewCreated(): void
    {
        $majorVersion = $this->faker->randomDigit;
        $minorVersion = $this->faker->randomDigit;
        $projectId    = '::project id::';
        $data         = [];

        $expectedReviewCreated = new Model\ReviewCreated($majorVersion, $minorVersion, $projectId, $data);
        $actualReviewCreated   = $this->factory->createReviewCreated($majorVersion, $minorVersion, $projectId, $data);

        self::assertEquals($expectedReviewCreated, $actualReviewCreated);
    }

    public function testCreateReviewLabelChanged(): void
    {
        $majorVersion = $this->faker->randomDigit;
        $minorVersion = $this->faker->randomDigit;
        $projectId    = '::project id::';
        $data         = [];

        $expectedReviewLabelChanged = new Model\ReviewLabelChanged($majorVersion, $minorVersion, $projectId, $data);
        $actualReviewLabelChanged   = $this->factory->createReviewLabelChanged($majorVersion, $minorVersion, $projectId, $data);

        self::assertEquals($expectedReviewLabelChanged, $actualReviewLabelChanged);
    }

	public function testCreateReviewClosedOrReopened(): void
	{
		$majorVersion = $this->faker->randomDigit;
		$minorVersion = $this->faker->randomDigit;
		$projectId    = '::project id::';
		$data         = [];

		$expectedReviewLabelChanged = new Model\ReviewClosedOrReopened($majorVersion, $minorVersion, $projectId, $data);
		$actualReviewLabelChanged   = $this->factory->createReviewClosedOrReopened($majorVersion, $minorVersion, $projectId, $data);

		self::assertEquals($expectedReviewLabelChanged, $actualReviewLabelChanged);
	}

	public function testCreateDiscussionNew(): void
	{
		$majorVersion = $this->faker->randomDigit;
		$minorVersion = $this->faker->randomDigit;
		$projectId    = '::project id::';
		$data         = [];

		$expectedDiscussionNew = new Model\DiscussionNew($majorVersion, $minorVersion, $projectId, $data);
		$actualDiscussionNew   = $this->factory->createDiscussionNew($majorVersion, $minorVersion, $projectId, $data);

		self::assertEquals($expectedDiscussionNew, $actualDiscussionNew);
	}
}