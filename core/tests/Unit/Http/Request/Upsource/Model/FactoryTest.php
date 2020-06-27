<?php

namespace Tests\Unit\Http\Request\Upsource\Model;

use App\Http\Request\Upsource\Model\Factory;
use App\Http\Request\Upsource\Model\NewReview;
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

        $expectedNewReview = new NewReview($majorVersion, $minorVersion, $projectId, $data);
        $actualNewReview   = Factory::createNewReview($majorVersion, $minorVersion, $projectId, $data);

        $this->assertEquals($expectedNewReview, $actualNewReview);
    }
}