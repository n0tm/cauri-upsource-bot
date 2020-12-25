<?php

namespace Tests\Unit\Api\Upsource\Response\Object;

use App\Api\Upsource\Response\Object\ParticipantInReview;
use Tests\TestCase;

class ParticipantInReviewTest extends TestCase
{
	private const TEST_ID    = '::id::';
	private const TEST_ROLE  = 0;
	private const TEST_STATE = 1;

	/**
	 * @var ParticipantInReview
	 */
	private $participantInReview;

	public function setUp(): void
	{
		parent::setUp();

		$this->participantInReview = new ParticipantInReview(self::TEST_ID, self::TEST_ROLE, self::TEST_STATE);
	}

	public function testGetId(): void
	{
		self::assertSame(
			self::TEST_ID,
			$this->participantInReview->getId()
		);
	}

	public function testGetRole(): void
	{
		self::assertSame(
			self::TEST_ROLE,
			$this->participantInReview->getRole()
		);
	}

	public function testGetState(): void
	{
		self::assertSame(
			self::TEST_STATE,
			$this->participantInReview->getState()
		);
	}

	/**
	 * @dataProvider isReviewerDataProvider
	 * @param int $role
	 * @param bool $isReviewer
	 */
	public function testIsReviewer(int $role, bool $isReviewer): void
	{
		$participant = new ParticipantInReview(self::TEST_ID, $role, self::TEST_STATE);
		self::assertSame($isReviewer, $participant->isReviewer());
	}

	public function isReviewerDataProvider(): array
	{
		return [
			[1, false],
			[2, true],
			[3, false],
		];
	}
}
