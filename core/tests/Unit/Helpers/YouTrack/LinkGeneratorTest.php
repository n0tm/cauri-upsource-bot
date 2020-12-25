<?php

namespace Tests\Unit\Helpers\YouTrack;

use App\Helpers\YouTrack\LinkGenerator;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LinkGeneratorTest extends TestCase
{
	use WithFaker;

	public function testGetTask(): void
	{
		$baseUrl = $this->faker->text;
		$taskId = $this->faker->text;

		$expectedUrl = "$baseUrl/issue/$taskId";
		$linkGenerator = new LinkGenerator();
		$this->assertSame($expectedUrl, $linkGenerator->getTask($baseUrl, $taskId));
	}
}