<?php

namespace Tests\Unit\Domain\Action\Upsource;

use App\Domain\Contract;
use App\Domain\Implementation\Action;
use Tests\TestCase;

class FactoryTest extends TestCase
{
    /**
     * @var Action\Upsource\Factory
     */
    private $actionFactory;

    private $repositoryFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repositoryFactory = $this->createMock(Contract\Repository\Upsource\Factory::class);
        $this->actionFactory = new Action\Upsource\Factory();
    }

    public function testCreateReviewCreated(): void
    {
        $reviewId  = '::id::';
        $creatorId = '::creator id::';
        $branch    = '::branch::';

        $expectedReviewCreatedAction = new Action\Upsource\ReviewCreated($this->repositoryFactory, $reviewId, $creatorId, $branch);
        $actualReviewCreatedAction   = $this->actionFactory->createReviewCreated($this->repositoryFactory, $reviewId, $creatorId, $branch);

        $this->assertEquals($expectedReviewCreatedAction, $actualReviewCreatedAction);
    }

    /**
     * @param bool $isWasAdded
     * @dataProvider createReviewLabelChangedProvider
     */
    public function testCreateReviewLabelChanged(bool $isWasAdded): void
    {
        $reviewId                = '::id::';
        $labelId                 = '::label id::';
        $projectId               = '::project id::';
        $userNameWhoChangedLabel = '::user name::';

        $expectedReviewLabelChangedAction = new Action\Upsource\ReviewLabelChanged(
            $this->repositoryFactory,
            $reviewId,
            $projectId,
            $userNameWhoChangedLabel,
            $labelId,
            $isWasAdded
        );
        $actualReviewLabelChangedAction   = $this->actionFactory->createReviewLabelChanged(
            $this->repositoryFactory,
            $reviewId,
            $projectId,
            $userNameWhoChangedLabel,
            $labelId,
            $isWasAdded
        );

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