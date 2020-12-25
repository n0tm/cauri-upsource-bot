<?php

namespace App\System\Config\Object;

class Upsource extends AbstractObject
{
	private const CONFIG_NAME = 'upsource';

	private const SETTING_PATH_URL_SITE                = 'url.site';
	private const SETTING_PATH_URL_API                 = 'url.api';
	private const SETTING_PATH_AUTHORIZATION_LOGIN     = 'authorization.login';
	private const SETTING_PATH_AUTHORIZATION_PASSWORD  = 'authorization.password';

	public function getUrlSite(): string
	{
		return $this->getSetting(self::SETTING_PATH_URL_SITE);
	}

	public function getUrlApi(): string
	{
		return $this->getSetting(self::SETTING_PATH_URL_API);
	}

	public function getAuthorizationLogin(): string
	{
		return $this->getSetting(self::SETTING_PATH_AUTHORIZATION_LOGIN);
	}

	public function getAuthorizationPassword(): string
	{
		return $this->getSetting(self::SETTING_PATH_AUTHORIZATION_PASSWORD);
	}

	protected function getConfigName(): string
	{
		return self::CONFIG_NAME;
	}
}