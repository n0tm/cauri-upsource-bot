<?php

namespace Tests\Unit\System\Config\Object;

use App\System\Config\Object as Objects;
use Tests\TestCase;

class FactoryTest extends TestCase
{
	/**
	 * @var Objects\Factory
	 */
	private $factory;

	protected function setUp(): void
	{
		parent::setUp();

		$this->factory = new Objects\Factory();
	}

	public function testUpsource(): void
	{
		$this->assertEquals(
			new Objects\Youtrack(),
			$this->factory->youtrack()
		);
	}

	public function testYoutrack(): void
	{
		$this->assertEquals(
			new Objects\Upsource(),
			$this->factory->upsource()
		);
	}
}
