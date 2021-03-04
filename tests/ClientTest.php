<?php

use Maclof\Kubernetes\Client;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Message\RequestInterface;
use GuzzleHttp\Message\ResponseInterface;

class ClientTest extends TestCase
{
	protected function getClient(GuzzleClient $guzzleClient = null)
	{
		return new Client(
			[
				'master' => '',
			],
			$guzzleClient
		);
	}

	protected function getMockGuzzleCLient(RequestInterface $guzzleRequest = null, ResponseInterface $guzzleResponse = null)
	{
		$mockGuzzleClient = Mockery::mock('GuzzleHttp\Client');

		if ($guzzleRequest && $guzzleResponse) {
			$mockGuzzleClient->shouldReceive('send')->with($guzzleRequest)->andReturn($guzzleResponse);
		}

		return $mockGuzzleClient;
	}

	protected function getMockGuzzleRequest()
	{
		$mockGuzzleRequest = Mockery::mock('GuzzleHttp\Message\RequestInterface');

		return $mockGuzzleRequest;
	}

	protected function getMockGuzzleResponse(array $response = array())
	{
		$mockGuzzleResponse = Mockery::mock('GuzzleHttp\Message\ResponseInterface');
		$mockGuzzleResponse->shouldReceive('json')->with()->andReturn($response);

		return $mockGuzzleResponse;
	}

	public function test_get_guzzle_client()
	{
		$client = $this->getClient();

		$this->assertInstanceOf('GuzzleHttp\Client', $client->getGuzzleClient());
	}

	public function testStreamReturnsResponseObject()
    {
        $mockGuzzleClient = Mockery::mock('GuzzleHttp\Client');
        $mockGuzzleClient->shouldReceive('request')->andReturn(new \GuzzleHttp\Psr7\Response());

        $client = new Client([], $mockGuzzleClient);
        $response = $client->sendRequest(
            'GET', '/v1/deployments', [], [], true, null, ['stream' => true]
        );

        $this->assertInstanceOf(\GuzzleHttp\Psr7\Response::class, $response);
    }

    public function testStreamGetsResourceVersion()
    {
        $deploymentsTable = $this->getFixture('deployments/table.json');

        $mockGuzzleClient = Mockery::mock('GuzzleHttp\Client');
        $mockGuzzleClient->shouldReceive('request')->andReturn(
            new \GuzzleHttp\Psr7\Response(200, [], $deploymentsTable)
        );

        $client = new Client([], $mockGuzzleClient);

        $response = $client->sendRequest(
            'GET', '/v1/deployments', [], [], true, null, ['stream' => true]
        );

        $requestOptions = $client->getRequestOptions();

        $this->assertArrayHasKey('resourceVersion', $requestOptions['query']);
        $this->assertSame('4372200', $requestOptions['query']['resourceVersion']);
    }

	// public function test_get_pods()
	// {
	// 	$request = $this->getMockGuzzleRequest();
	// 	$response = $this->getMockGuzzleResponse([
	// 		'items' => [
	// 			[],
	// 			[],
	// 			[],
	// 		],
	// 	]);
	// 	$mockGuzzleClient = $this->getMockGuzzleCLient($request, $response);
	// 	$mockGuzzleClient->shouldReceive('createRequest')
	// 		->with('GET', '/api/' . $this->apiVersion . '/namespaces/' . $this->namespace . '/pods', ['query' => [], 'body' => null])
	// 		->andReturn($request);

	// 	$client = $this->getClient($mockGuzzleClient);
	// 	$pods = $client->pods()->find();

	// 	$this->assertInstanceOf('Maclof\Kubernetes\Collections\PodCollection', $pods);
	// }
}
