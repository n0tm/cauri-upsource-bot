<?php

namespace Tests\Integration\Repository\Upsource;

use App\Domain\Implementation;
use Tests\TestCase;

class Factory extends TestCase
{
    /**
     * @var Implementation\Repository\Upsource\Factory
     */
    private $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->factory = new Implementation\Repository\Upsource\Factory();
    }

    public function testCreateReview(): void
    {
        $this->assertEquals(new Implementation\Repository\Upsource\Review(), $this->factory->createReview());
    }
}