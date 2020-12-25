<?php

namespace App\Domain\Contract\Api\Upsource;

interface Client
{
	public function request(string $url, array $parameters): array;
}