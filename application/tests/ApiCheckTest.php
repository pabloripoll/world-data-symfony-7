<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;

class ApiCheckTest extends TestCase
{
    public function testSomething(): void
    {
        $client = HttpClient::create();
        $response = $client->request('GET', '/api/v1/check');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['@id' => '/']);
    }
}
