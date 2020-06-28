<?php

namespace Tests\Unit\Http\Request\Upsource\Model;

use App\Http\Request\Upsource\Model\AbstractRequest;
use App\Http\Request\Upsource\Model\ReviewLabelChanged;

class ReviewLabelChangedTest extends AbstractReviewTest
{

    public function testGetLabelId(): void
    {
        $labelId = '::label id::';
        $request = $this->getRequest(
            self::TEST_MAJOR_VERSION,
            self::TEST_MINOR_VERSION,
            self::TEST_PROJECT_ID,
            ['labelId' => $labelId]
        );

        $this->assertSame($labelId, $request->getLabelId());
    }

    /**
     * @dataProvider isWasAddedProvider
     * @param bool $isWasAdded
     */
    public function testIsWasAdded(bool $isWasAdded): void
    {
        $request = $this->getRequest(
            self::TEST_MAJOR_VERSION,
            self::TEST_MINOR_VERSION,
            self::TEST_PROJECT_ID,
            ['wasAdded' => $isWasAdded]
        );

        $this->assertSame($isWasAdded, $request->isWasAdded());
    }

    public function isWasAddedProvider(): array
    {
        return [
            [true],
            [false],
        ];
    }

    /**
     * @param int $majorVersion
     * @param int $minorVersion
     * @param string $projectId
     * @param array $data
     * @return ReviewLabelChanged
     */
    protected function getRequest(int $majorVersion, int $minorVersion, string $projectId, array $data): AbstractRequest
    {
        return new ReviewLabelChanged($majorVersion, $minorVersion, $projectId, $data);
    }
}