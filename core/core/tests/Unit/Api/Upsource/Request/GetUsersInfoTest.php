<?php

namespace Tests\Unit\Api\Upsource\Request;

use App\Api\Upsource\Request\GetUsersInfo;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetUsersInfoTest extends TestCase
{
	use WithFaker;

	public function  testConvertToArray(): void
	{
		$ids = $this->faker->words;
		$usersInfo = new GetUsersInfo($ids);
		$this->assertSame(
			['ids' => $ids],
			$usersInfo->convertToArray()
		);
	}
}
