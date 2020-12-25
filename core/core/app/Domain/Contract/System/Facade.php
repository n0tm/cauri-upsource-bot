<?php

namespace App\Domain\Contract\System;

interface Facade
{
	public function getUpsourceUrlSite(): string;
	public function getUpsourceUrlApi(): string;
	public function getYoutrackUrlSite(): string;
	public function getUpsourceAuthorizationLogin(): string;
	public function getUpsourceAuthorizationPassword(): string;
}