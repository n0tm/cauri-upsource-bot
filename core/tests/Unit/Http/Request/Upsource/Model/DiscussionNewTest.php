<?php

namespace Tests\Unit\Http\Request\Upsource\Model;

use App\Http\Request\Upsource\Model;
use Illuminate\Foundation\Testing\WithFaker;

class DiscussionNewTest extends AbstractRequestTest
{
	use WithFaker;

	public function testGetReviewId(): void
	{
		$reviewId = $this->faker->text;
		$request = $this->getRequest(
			self::TEST_MAJOR_VERSION,
			self::TEST_MINOR_VERSION,
			self::TEST_PROJECT_ID,
			[
				'base' => ['reviewId' => $reviewId]
			]
		);

		self::assertSame(
			$reviewId,
			$request->getReviewId()
		);
	}

	/**
	 * @param int $majorVersion
	 * @param int $minorVersion
	 * @param string $projectId
	 * @param array $data
	 * @return Model\AbstractRequest|Model\DiscussionNew
	 */
	protected function getRequest(int $majorVersion, int $minorVersion, string $projectId, array $data): Model\AbstractRequest
	{
		return new Model\DiscussionNew($majorVersion, $minorVersion, $projectId, $data);
	}
}
