<?php

namespace Tests\Unit\Api\Upsource\Response;

use App\Api\Upsource\Response\GetReviewDetails;
use App\Domain\Contract\Api\Upsource\Response\Object\ParticipantInReview;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetReviewDetailsTest extends TestCase
{
	use WithFaker;

	public function testGetDiscussionsCount(): void
	{
		$discussionsCount = $this->faker->randomNumber();
		$response = [
			'result' => [
				'discussionCounter' => [
					'count' => $discussionsCount,
				],
			],
		];

		$reviewDetails = new GetReviewDetails($response);
		self::assertSame(
			$discussionsCount,
			$reviewDetails->getDiscussionsCount()
		);
	}

	public function testGetResolvedDiscussionsCount(): void
	{
		$resolvedDiscussionCount = $this->faker->randomNumber();
		$response = [
			'result' => [
				'discussionCounter' => [
					'resolvedCount' => $resolvedDiscussionCount,
				],
			],
		];

		$reviewDetails = new GetReviewDetails($response);
		self::assertSame(
			$resolvedDiscussionCount,
			$reviewDetails->getResolvedDiscussionsCount()
		);
	}

	public function testGetDescriptionWhenExists(): void
	{
		$description = $this->faker->text;
		$response = [
			'result' => [
				'description' => $description,
			],
		];

		$reviewDetails = new GetReviewDetails($response);
		self::assertSame(
			$description,
			$reviewDetails->getDescription()
		);
	}

	public function testGetDescriptionWhenNotExists(): void
	{
		$reviewDetails = new GetReviewDetails(['result' => []]);
		self::assertNull($reviewDetails->getDescription());
	}

	public function testIsReadyToClose(): void
	{
		$isReadyToClose = $this->faker->boolean;
		$response = [
			'result' => [
				'isReadyToClose' => $isReadyToClose,
			],
		];

		$reviewDetails = new GetReviewDetails($response);
		self::assertSame(
			$isReadyToClose,
			$reviewDetails->isReadyToClose()
		);
	}

	public function testGetParticipants(): void
	{
		$response = [
			'result' => [
				'participants' => [
					[
						'userId' => $this->faker->text,
						'state' => $this->faker->randomNumber(),
						'role' => $this->faker->randomNumber(),
					],
					[
						'userId' => $this->faker->text,
						'state' => $this->faker->randomNumber(),
						'role' => $this->faker->randomNumber(),
					],
				],
			],
		];

		$reviewDetails = new GetReviewDetails($response);
		$participants = $reviewDetails->getParticipants();
		self::assertCount(2, $participants);
		self::assertContainsOnlyInstancesOf(ParticipantInReview::class, $participants);
	}

	/**
	 * @param int $state
	 * @param bool $isOpen
	 * @dataProvider stateDataProvider
	 */
	public function testIsOpen(int $state, bool $isOpen): void
	{
		$response = [
			'result' => ['state' => $state]
		];

		$reviewDetail = new GetReviewDetails($response);
		self::assertSame($isOpen, $reviewDetail->isOpen());
	}

	public function stateDataProvider(): array
	{
		return [
			'When review open' => [1, true],
			'When review closed' => [2, false],
		];
	}

}
