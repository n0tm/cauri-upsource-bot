<?php

namespace Tests\Unit\Domain\Action;

use App\Domain\Implementation\Action\Factory;
use App\Domain\Implementation\Action\ReviewCreated;

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

    public function testCreatReviewCreated(): void
    {
        $id     = '::id::';
        $branch = '::branch::';

        $expectedReviewCreatedAction = new ReviewCreated($id, $branch);
        $actualReviewCreatedAction   = $this->factory->createReviewCreated($id, $branch);

        $this->assertEquals($expectedReviewCreatedAction, $actualReviewCreatedAction);
    }
}