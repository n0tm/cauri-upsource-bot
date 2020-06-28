<?php

namespace Tests\Unit\Http\Request\Upsource\Model;

use App\Http\Request\Upsource\Model\AbstractRequest;
use App\Http\Request\Upsource\Model\ReviewCreated;

class ReviewCreatedTest extends AbstractReviewTest
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