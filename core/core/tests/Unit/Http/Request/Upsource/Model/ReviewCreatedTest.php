<?php

namespace Tests\Unit\Http\Request\Upsource\Model;

use App\Http\Request\Upsource\Model\AbstractRequest;
use App\Http\Request\Upsource\Model\ReviewCreated;

class ReviewCreatedTest extends AbstractRequestTest
{
    public function testGetBranch(): void
    {
        $branch = '::branch::';
        $request = $this->getRequest(
            self::TEST_MAJOR_VERSION,
            self::TEST_MINOR_VERSION,
            self::TEST_PROJECT_ID,
            ['branch' => $branch]
        );

        $this->assertSame($branch, $request->getBranch());
    }

    public function testGetReviewId(): void
    {
        $reviewId = '::review id::';
        $request = $this->getRequest(
            self::TEST_MAJOR_VERSION,
            self::TEST_MINOR_VERSION,
            self::TEST_PROJECT_ID,
            ['base' => ['reviewId' => $reviewId]]
        );

        $this->assertSame($reviewId, $request->getReviewId());
    }

    public function testGetActorId(): void
    {
        $actorId = '::actor id::';
        $request = $this->getRequest(
            self::TEST_MAJOR_VERSION,
            self::TEST_MINOR_VERSION,
            self::TEST_PROJECT_ID,
            ['base' => ['actor' => ['userId' => $actorId]]]
        );

        $this->assertSame($actorId, $request->getActorId());
    }

    public function testGetActorName(): void
    {
        $actorName = '::actor id::';
        $request = $this->getRequest(
            self::TEST_MAJOR_VERSION,
            self::TEST_MINOR_VERSION,
            self::TEST_PROJECT_ID,
            ['base' => ['actor' => ['userName' => $actorName]]]
        );

        $this->assertSame($actorName, $request->getActorName());
    }

    /**
     * @param int $majorVersion
     * @param int $minorVersion
     * @param string $projectId
     * @param array $data
     * @return ReviewCreated
     */
    protected function getRequest(int $majorVersion, int $minorVersion, string $projectId, array $data): AbstractRequest
    {
        return new ReviewCreated($majorVersion, $minorVersion, $projectId, $data);
    }
}