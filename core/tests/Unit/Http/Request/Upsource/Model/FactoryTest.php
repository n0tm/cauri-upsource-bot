<?php

namespace Tests\Unit\Http\Request\Upsource\Model;

use App\Http\Request\Upsource\Model\Factory;
use App\Http\Request\Upsource\Model\ReviewCreated;
use App\Http\Request\Upsource\Model\ReviewLabelChanged;
use Illuminate\Foundation\Testing\WithFaker;

class FactoryTest extends \Tests\TestCase
{
    use WithFaker;

    public function testCreateReviewCreated(): void
    {
        $majorVersion = $this->faker->randomDigit;
        $minorVersion = $this->faker->randomDigit;
        $projectId    = '::project id::';
        $data         = [];

        $expectedReviewCreated = new ReviewCreated($majorVersion, $minorVersion, $projectId, $data);
        $actualReviewCreated   = Factory::createReviewCreated($majorVersion, $minorVersion, $projectId, $data);

        $this->assertEquals($expectedReviewCreated, $actualReviewCreated);
    }

    public function testCreateReviewLabelChanged(): void
    {
        $majorVersion = $this->faker->randomDigit;
        $minorVersion = $this->faker->randomDigit;
        $projectId    = '::project id::';
        $data         = [];

        $expectedReviewLabelChanged = new ReviewLabelChanged($majorVersion, $minorVersion, $projectId, $data);
        $actualReviewLabelChanged   = Factory::createReviewLabelChanged($majorVersion, $minorVersion, $projectId, $data);

        $this->assertEquals($expectedReviewLabelChanged, $actualReviewLabelChanged);
    }
}