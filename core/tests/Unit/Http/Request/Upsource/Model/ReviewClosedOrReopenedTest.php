<?php

namespace Tests\Unit\Http\Request\Upsource\Model;

use App\Http\Request\Upsource\Model\AbstractRequest;
use App\Http\Request\Upsource\Model\ReviewClosedOrReopened;
use Illuminate\Foundation\Testing\WithFaker;

class ReviewClosedOrReopenedTest extends AbstractRequestTest
{
	use WithFaker;

	public function testIsClosed(): void
	{
		$isClosed = $this->faker->boolean;
		$request = $this->getRequest(
			self::TEST_MAJOR_VERSION,
			self::TEST_MINOR_VERSION,
			self::TEST_PROJECT_ID,
			['newState' => $isClosed]
		);

		self::assertSame($isClosed, $request->isClosed());
	}

	public function testGetReviewId(): void
	{
		$reviewId = $this->faker->text;
		$request = $this->getRequest(
			self::TEST_MAJOR_VERSION,
			self::TEST_MINOR_VERSION,
			self::TEST_PROJECT_ID,
			['base' => ['reviewId' => $reviewId]]
		);

		self::assertSame($reviewId, $request->getReviewId());
	}

	/**
	 * @param int $majorVersion
	 * @param int $minorVersion
	 * @param string $projectId
	 * @param array $data
	 * @return ReviewClosedOrReopened
	 */
	protected function getRequest(int $majorVersion, int $minorVersion, string $projectId, array $data): AbstractRequest
	{
		return new ReviewClosedOrReopened($majorVersion, $minorVersion, $projectId, $data);
	}
}
