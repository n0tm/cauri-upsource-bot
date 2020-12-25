<?php

namespace App\System\Config\Object;

class Youtrack extends AbstractObject
{
	private const CONFIG_NAME = 'youtrack';

	private const SETTING_NAME_URL_SITE = 'url.site';

	public function getUrlSite(): string
	{
		return $this->getSetting(self::SETTING_NAME_URL_SITE);
	}

	protected function getConfigName(): string
	{
		return self::CONFIG_NAME;
	}
}