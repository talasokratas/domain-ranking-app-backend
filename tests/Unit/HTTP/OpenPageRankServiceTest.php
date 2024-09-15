<?php

namespace Tests\Unit;

use App\Services\OpenPageRankService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;
use Tests\TestCase;

class OpenPageRankServiceTest extends TestCase
{
    /** @test */
    public function testBatchSplitting()
    {
        $mockClient = Mockery::mock(Client::class);

        $responseBody = json_encode([
            'response' => [
                ['domain' => 'google.com', 'rank' => 10],
                ['domain' => 'apple.com', 'rank' => 8],
            ]
        ]);

        $domains = array_fill(0, 150, 'example.com'); // Simulate 150 domains

        $mockClient->shouldReceive('request')
            ->twice() // Expect two batches
            ->andReturn(new Response(200, [], $responseBody));

        $service = new OpenPageRankService($mockClient);

        $result = $service->getPagesData($domains);

        $this->assertCount(4, $result); // Two domains per response, two batches
        $this->assertEquals('google.com', $result[0]->domain);
        $this->assertEquals(10, $result[0]->rank);
    }
}
