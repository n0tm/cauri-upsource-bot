<?php

namespace App\System\Config;

class Facade implements \App\Domain\Contract\System\Facade
{
	/**
	 * @var Object\Factory
	 */
	private $factory;

	public function __construct(Object\Factory $factory)
	{
		$this->factory = $factory;
	}

	public function getUpsourceUrlSite(): string
	{
		return $this->factory->upsource()->getUrlSite();
	}

	public function getUpsourceUrlApi(): string
	{
		return $this->factory->upsource()->getUrlApi();
	}

	public function getYoutrackUrlSite(): string
	{
		return $this->factory->youtrack()->getUrlSite();
	}

	public function getUpsourceAuthorizationLogin(): string
	{
		return $this->factory->upsource()->getAuthorizationLogin();
	}

	public function getUpsourceAuthorizationPassword(): string
	{
		return $this->factory->upsource()->getAuthorizationPassword();
	}
}