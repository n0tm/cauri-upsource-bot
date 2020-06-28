<?php

namespace Tests\Unit\Http\Request\Upsource\Model;

use App\Http\Request\Upsource\Model\Factory;
use App\Http\Request\Upsource\Model\ReviewCreated;
use Illuminate\Foundation\Testing\WithFaker;

class FactoryTest extends \Tests\TestCase
{
    use WithFaker;

    public function testCreateNewReview(): void
    {
        $majorVersion = $this->faker->randomDigit;
        $minorVersion = $this->faker->randomDigit;
        $projectId    = '::project id::';
        $data         = [];

        $expectedNewReview = new ReviewCreated($majorVersion, $minorVersion, $projectId, $data);
        $actualNewReview   = Factory::createReviewCreated($majorVersion, $minorVersion, $projectId, $data);

        $this->assertEquals($expectedNewReview, $actualNewReview);
    }
}