<?php

namespace Tests\Unit\Api\Upsource;

use App\Api\Upsource\Client;
use App\Domain\Contract;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use GuzzleHttp;

class ClientTest extends TestCase
{

	public function testRequest()
	{
		/** @var Contract\System\Facade|MockObject $config */
		$config = $this->createMock(Contract\System\Facade::class);
		/** @var GuzzleHttp\Client|MockObject $guzzleClient */
		$guzzleClient = $this->getMockBuilder(GuzzleHttp\Client::class)->addMethods(['post'])->getMock();
		$client = new Client($guzzleClient, $config);

		$baseUrl       = '::baseUrl::';
		$parameters    = ['::key::' => '::value::'];
		$urlToEndpoint = '::endpointUrl::';

		$upsourceAuthorizationLogin    = '::login::';
		$upsourceAuthorizationPassword = '::password::';

		$config->expects($this->once())->method('getUpsourceUrlApi')->willReturn($baseUrl);
		$config->expects($this->once())->method('getUpsourceAuthorizationLogin')->willReturn($upsourceAuthorizationLogin);
		$config->expects($this->once())->method('getUpsourceAuthorizationPassword')->willReturn($upsourceAuthorizationPassword);

		$requestBody = $this->createMock(StreamInterface::class);
		$decodedBody = ['::response::' => '::value::'];
		$requestBody->expects($this->once())->method('getContents')->willReturn(json_encode($decodedBody));

		$response = $this->createMock(ResponseInterface::class);
		$response->expects($this->once())->method('getBody')->willReturn($requestBody);

		$fullUrl = sprintf('%s/%s', $baseUrl, $urlToEndpoint);
		$guzzleClient->expects($this->once())
			->method('post')
			->with(
				$fullUrl,
				[
					GuzzleHttp\RequestOptions::JSON => $parameters,
					GuzzleHttp\RequestOptions::AUTH => [
						$upsourceAuthorizationLogin,
						$upsourceAuthorizationPassword,
					]
				]
			)
			->willReturn($response);

		$this->assertSame($decodedBody, $client->request($urlToEndpoint, $parameters));
	}
}
