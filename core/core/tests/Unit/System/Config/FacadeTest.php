<?php

namespace Tests\Unit\System\Config;

use App\System\Config;
use Tests\TestCase;

class FacadeTest extends TestCase
{
	/**
	 * @var Config\Object\Factory|\PHPUnit\Framework\MockObject\MockObject
	 */
	private $objectFactory;

	/**
	 * @var Config\Facade
	 */
	private $facade;

	protected function setUp(): void
	{
		parent::setUp();

		$this->objectFactory = $this->createMock(Config\Object\Factory::class);
		$this->facade        = new Config\Facade($this->objectFactory);
	}

	public function testGetUpsourceUrlSite(): void
	{
		$upsourceFactory = $this->createMock(Config\Object\Upsource::class);
		$upsourceFactory->expects($this->once())->method('getUrlSite');

		$this->objectFactory->expects($this->once())->method('upsource')->willReturn($upsourceFactory);

		$this->facade->getUpsourceUrlSite();
	}

	public function testGetUpsourceUrlApi(): void
	{
		$upsourceFactory = $this->createMock(Config\Object\Upsource::class);
		$upsourceFactory->expects($this->once())->method('getUrlApi');

		$this->objectFactory->expects($this->once())->method('upsource')->willReturn($upsourceFactory);

		$this->facade->getUpsourceUrlApi();
	}

	public function testGetYoutrackUrlSite(): void
	{
		$youtrackFactory = $this->createMock(Config\Object\Youtrack::class);
		$youtrackFactory->expects($this->once())->method('getUrlSite');

		$this->objectFactory->expects($this->once())->method('youtrack')->willReturn($youtrackFactory);

		$this->facade->getYoutrackUrlSite();
	}

	public function testGetUpsourceAuthorizationLogin(): void
	{
		$upsourceFactory = $this->createMock(Config\Object\Upsource::class);
		$upsourceFactory->expects($this->once())->method('getAuthorizationLogin');

		$this->objectFactory->expects($this->once())->method('upsource')->willReturn($upsourceFactory);

		$this->facade->getUpsourceAuthorizationLogin();
	}

	public function testUpsourceAuthorizationPassword(): void
	{
		$upsourceFactory = $this->createMock(Config\Object\Upsource::class);
		$upsourceFactory->expects($this->once())->method('getAuthorizationPassword');

		$this->objectFactory->expects($this->once())->method('upsource')->willReturn($upsourceFactory);

		$this->facade->getUpsourceAuthorizationPassword();
	}
}
