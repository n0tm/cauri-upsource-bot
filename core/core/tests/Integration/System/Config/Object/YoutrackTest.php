<?php

namespace Tests\Integration\System\Config\Object;

use App\System\Config\Object\Youtrack;
use Tests\TestCase;

class YoutrackTest extends TestCase
{
	/**
	 * @var Youtrack
	 */
	private $config;

	protected function setUp(): void
	{
		parent::setUp();

		$this->config = new Youtrack();
	}

	public function testGetUrlSite(): void
	{
		self::assertSame(config('youtrack.url.site'), $this->config->getUrlSite());
	}
}
