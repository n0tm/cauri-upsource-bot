<?php

namespace Tests\Integration\Repository;

use App\Domain\Implementation;
use Tests\TestCase;

class Factory extends TestCase
{
    /**
     * @var Implementation\Repository\Factory
     */
    private $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->factory = new Implementation\Repository\Factory();
    }

    public function testCreateUpsource(): void
    {
        $this->assertEquals(new Implementation\Repository\Upsource\Factory(), $this->factory->createUpsource());
    }
}