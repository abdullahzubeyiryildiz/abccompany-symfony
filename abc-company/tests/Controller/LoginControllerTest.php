<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    

    public function testSuccessfulLogin()
    {
        $client = static::createClient();

        $client->request('POST', '/api/login', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'email' => 'musteri1@abccompany.com',
            'password' => '123456',
        ]));

        $response = $client->getResponse();

        $this->assertSame(200, $response->getStatusCode(), $response->getContent());
        $this->assertJson($response->getContent());

        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('token', $responseData);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertSame('Login Success', $responseData['message']);
 
        $token = $responseData['token'];
 
        $client->request('GET', '/api/some-protected-route', [], [], ['HTTP_AUTHORIZATION' => 'Bearer ' . $token]);
 
        $protectedResponse = $client->getResponse();
        $this->assertSame(200, $protectedResponse->getStatusCode()); 
    }
}