<?php

namespace Tests\Integration\Repository\Upsource;

use App\Domain\Implementation;
use Illuminate\Support\Str;
use Tests\TestCase;

class Review extends TestCase
{
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new Implementation\Repository\Upsource\Review();
    }

    public function testCreate(): void
    {
        $id        = Str::random();
        $creatorId = Str::random();
        $branch    = Str::random();

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

        $this->assertEquals($expectedReview->id, $actualReview->id);
        $this->assertEquals($expectedReview->creator_upsource_user_id, $actualReview->creator_upsource_user_id);
        $this->assertEquals($expectedReview->branch, $actualReview->branch);
    }
}