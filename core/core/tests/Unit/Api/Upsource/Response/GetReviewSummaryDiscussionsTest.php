<?php

namespace Tests\Unit\Api\Upsource\Response;

use App\Api\Upsource\Response\GetReviewSummaryDiscussions;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\TestCase;

class GetReviewSummaryDiscussionsTest extends TestCase
{
	use WithFaker;

	/**
	 * @dataProvider discussionsDataProvider
	 * @param array $data
	 * @param bool $isAllWithLabelDone
	 */
	public function testIsAllWithLabelDone(array $data, bool $isAllWithLabelDone): void
	{
		$response = new GetReviewSummaryDiscussions($data);
		self::assertSame($isAllWithLabelDone, $response->isAllWithLabelDone());
	}

	public function discussionsDataProvider(): array
	{
		return [
			'When all with label done' => [
				[
					'result' => [
						'discussions' => [
							[
								'discussionInFile' => [
									'labels' => [
										[
											'name' => 'info'
										],
										[
											'name' => 'done'
										],
									],
								]
							],
							[
								'discussionInFile' => [
									'labels' => [
										[
											'name' => 'explanation'
										],
										[
											'name' => 'done'
										],
									],
								]
							]
						],
					],
				],
				true,
			],
			'When not all with label done' => [
				[
					'result' => [
						'discussions' => [
							[
								'discussionInFile' => [
									'labels' => [
										[
											'name' => 'info'
										],
									],
								]
							],
							[
								'discussionInFile' => []
							]
						],
					],
				],
				false,
			]
		];
	}
}
