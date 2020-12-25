<?php

namespace App\System\Config\Object;

abstract class AbstractObject
{
	/**
	 * @param string $name
	 * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
	 */
	protected function getSetting(string $name)
	{
		$settingPath = sprintf('%s.%s', $this->getConfigName(), $name);
		return config($settingPath);
	}

	abstract protected function getConfigName(): string;
}