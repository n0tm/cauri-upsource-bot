<?php

namespace Tests\Unit\Api\Upsource\Response\Object;

use App\Api\Upsource\Response\Object\FullUserInfo;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FullUserInfoTest extends TestCase
{
	use WithFaker;

	public function testGetName(): void
	{
		$name = $this->faker->text;
		$fullUserInfo = new FullUserInfo($name);
		$this->assertSame($name, $fullUserInfo->getName());
	}
}
