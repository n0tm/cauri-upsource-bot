<?php

namespace Tests\Unit\Http\Request\Upsource\Model;

use App\Http\Request\Upsource\Model\AbstractRequest;

abstract class AbstractReviewTest extends AbstractRequestTest
{
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
}