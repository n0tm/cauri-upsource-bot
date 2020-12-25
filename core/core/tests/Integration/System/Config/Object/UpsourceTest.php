<?php

namespace Tests\Integration\System\Config\Object;

use App\System\Config\Object\Upsource;
use Tests\TestCase;

class UpsourceTest extends TestCase
{
	/**
	 * @var Upsource
	 */
	private $config;

	protected function setUp(): void
	{
		parent::setUp();

		$this->config = new Upsource();
	}

	public function testGetUrlSite(): void
	{
		self::assertSame(config('upsource.url.site'), $this->config->getUrlSite());
	}

	public function testGetUrlApi(): void
	{
		self::assertSame(config('upsource.url.api'), $this->config->getUrlApi());
	}

	public function testGetAuthorizationLogin(): void
	{
		self::assertSame(config('upsource.authorization.login'), $this->config->getAuthorizationLogin());
	}

	public function testGetAuthorizationPassword(): void
	{
		self::assertSame(config('upsource.authorization.password'), $this->config->getAuthorizationPassword());
	}
}
