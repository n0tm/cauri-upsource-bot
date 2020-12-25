<?php

namespace App\Api\Upsource;

use App\Domain\Contract;
use GuzzleHttp;

class Client implements Contract\Api\Upsource\Client
{
	/**
	 * @var GuzzleHttp\Client
	 */
	private $client;

	/**
	 * @var Contract\System\Facade
	 */
	private $config;

	public function __construct(GuzzleHttp\Client $client, Contract\System\Facade $config)
	{
		$this->config = $config;
		$this->client = $client;
	}

	public function request(string $url, array $parameters): array
	{
		$baseUrl = $this->config->getUpsourceUrlApi();
		$fullUrl = sprintf('%s/%s', $baseUrl, $url);
		$response = $this->client->post(
			$fullUrl,
			[
				GuzzleHttp\RequestOptions::JSON => $parameters,
				GuzzleHttp\RequestOptions::AUTH => [
					$this->config->getUpsourceAuthorizationLogin(),
					$this->config->getUpsourceAuthorizationPassword(),
				]
			]
		);

		return json_decode($response->getBody()->getContents(), true);
	}
}