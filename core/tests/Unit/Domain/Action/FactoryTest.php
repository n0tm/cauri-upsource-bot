<?php

namespace Tests\Unit\Domain\Action;

use App\Domain\Implementation\Action\Factory;
use App\Domain\Implementation\Action\ReviewCreated;
use App\Domain\Implementation\Action\ReviewLabelChanged;
use Telegram\Bot\Api;

class FactoryTest extends \Tests\TestCase
{
    /**
     * @var Factory
     */
    private $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->factory = new Factory();
    }

    public function testCreateReviewCreated(): void
    {
        $reviewId = '::id::';
        $branch   = '::branch::';

        $expectedReviewCreatedAction = new ReviewCreated($reviewId, $branch);
        $actualReviewCreatedAction   = $this->factory->createReviewCreated($reviewId, $branch);

        $this->assertEquals($expectedReviewCreatedAction, $actualReviewCreatedAction);
    }

    /**
     * @param bool $isWasAdded
     * @dataProvider createReviewLabelChangedProvider
     */
    public function testCreateReviewLabelChanged(bool $isWasAdded): void
    {
        $reviewId   = '::id::';
        $labelId    = '::label id::';

        $expectedReviewLabelChangedAction = new ReviewLabelChanged($reviewId, $labelId, $isWasAdded);
        $actualReviewLabelChangedAction   = $this->factory->createReviewLabelChanged($reviewId, $labelId, $isWasAdded);

        $this->assertEquals($expectedReviewLabelChangedAction, $actualReviewLabelChangedAction);
    }

    public function createReviewLabelChangedProvider(): array
    {
        return [
            [true],
            [false],
        ];
    }
}