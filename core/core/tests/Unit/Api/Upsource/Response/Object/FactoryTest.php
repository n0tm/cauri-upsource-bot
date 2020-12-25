<?php

namespace Tests\Unit\Api\Upsource\Response\Object;

use App\Api\Upsource\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FactoryTest extends TestCase
{
	use WithFaker;

	public function testParticipantInReview()
	{
		$id    = $this->faker->text;
		$role  = $this->faker->randomNumber();
		$state = $this->faker->randomNumber();

		$this->assertEquals(
			new Response\Object\ParticipantInReview($id, $role, $state),
			Response\Object\Factory::participantInReview($id, $role, $state)
		);
	}
}
