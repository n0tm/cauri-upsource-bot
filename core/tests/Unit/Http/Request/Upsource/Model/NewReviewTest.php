<?php

namespace Tests\Unit\Http\Request\Upsource\Model;

use App\Http\Request\Upsource\Model\AbstractRequest;
use App\Http\Request\Upsource\Model\NewReview;

class NewReviewTest extends AbstractRequestTest
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

    /**
     * @param int $majorVersion
     * @param int $minorVersion
     * @param string $projectId
     * @param array $data
     * @return NewReview
     */
    protected function getRequest(int $majorVersion, int $minorVersion, string $projectId, array $data): AbstractRequest
    {
        return new NewReview($majorVersion, $minorVersion, $projectId, $data);
    }
}