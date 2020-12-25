<?php

namespace Tests\Unit\Api\Upsource\Response;

use App\Api\Upsource\Response\GetUsersInfo;
use App\Domain\Contract\Api\Upsource\Response\Object\FullUserInfo;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetUsersInfoTest extends TestCase
{
	use WithFaker;

	public function testGetInfos()
	{
		$response = [
			'result' => [
				'infos' => [
					['name' => $this->faker->text],
					['name' => $this->faker->text],
					['name' => $this->faker->text],
				],
			],
		];

		$usersInfoResponse = new GetUsersInfo($response);
		$infos = $usersInfoResponse->getInfos();
		$this->assertCount(3, $infos);
		$this->assertContainsOnlyInstancesOf(FullUserInfo::class, $infos);
	}
}
