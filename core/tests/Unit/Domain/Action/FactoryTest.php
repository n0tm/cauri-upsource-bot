<?php

namespace Tests\Unit\Domain\Action;

use App\Domain\Implementation\Action\Factory;
use App\Domain\Implementation\Action\NewReview;

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

    public function testCreateNewReview(): void
    {
        $id     = '::id::';
        $branch = '::branch::';

        $expectedNewReviewAction = new NewReview($id, $branch);
        $actualNewReviewAction   = $this->factory->createNewReview($id, $branch);

        $this->assertEquals($expectedNewReviewAction, $actualNewReviewAction);
    }
}