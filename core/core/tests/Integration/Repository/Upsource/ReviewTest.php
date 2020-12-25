<?php

namespace Tests\Integration\Repository\Upsource;

use App\Repository;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReviewTest extends TestCase
{
	use WithFaker;

	/**
	 * @var Repository\Upsource\Review
	 */
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new Repository\Upsource\Review();
    }

    public function testCreate(): void
    {
        $id        = $this->faker->text;
        $creatorId = $this->faker->text;
        $branch    = $this->faker->text;

        $this->assertDatabaseMissing('upsource_reviews', [
            'id'                       => $id,
            'creator_upsource_user_id' => $creatorId,
            'branch'                   => $branch,
        ]);

        $this->repository->create($id, $creatorId, $branch);

        $this->assertDatabaseHas('upsource_reviews', [
            'id'                       => $id,
            'creator_upsource_user_id' => $creatorId,
            'branch'                   => $branch,
        ]);
    }

    public function testGetById(): void
    {
        /** @var \App\Model\Upsource\Review $review */
        $expectedReview = factory(\App\Model\Upsource\Review::class)->create();
        $actualReview = $this->repository->getById($expectedReview->id);

        $this->assertEquals($expectedReview->id, $actualReview->getId());
        $this->assertEquals($expectedReview->creator_upsource_user_id, $actualReview->getCreatorUpsourceUserId());
        $this->assertEquals($expectedReview->branch, $actualReview->getBranch());
    }
}