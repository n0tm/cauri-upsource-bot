<?php

namespace Tests\Unit\Domain\Action;

use App\Domain\Implementation;
use Tests\TestCase;

class FactoryTest extends TestCase
{
    /**
     * @var \App\Domain\Implementation\Action\Factory
     */
    private $factory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new Implementation\Action\Factory();
    }

    public function testCreateUpsource(): void
    {
        $expectedUpsourceFactory = new Implementation\Action\Upsource\Factory();
        $actualUpsourceFactory = $this->factory->createUpsource();
        $this->assertEquals($expectedUpsourceFactory, $actualUpsourceFactory);
    }
}