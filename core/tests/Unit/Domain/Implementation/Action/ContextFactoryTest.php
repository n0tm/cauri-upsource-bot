<?php

namespace Tests\Unit\Domain\Implementation\Action;

use App\Domain\Implementation\Action;
use Tests\TestCase;

class ContextFactoryTest extends TestCase
{
	/**
	 * @var Action\ContextFactory
	 */
	private $factory;

	protected function setUp(): void
	{
		parent::setUp();
		$this->factory = new Action\ContextFactory();
	}

	public function testCreateUpsource()
	{
		$this->assertEquals(
			new Action\Upsource\ContextFactory(),
			$this->factory->createUpsource()
		);
	}

	public function testCreateTelegram()
	{
		$this->assertEquals(
			new Action\Telegram\ContextFactory(),
			$this->factory->createTelegram()
		);
	}
}
