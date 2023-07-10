<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrderControllerTest extends WebTestCase
{
    private function getToken()
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

        return $client;  
    }

    public function testOrderList(): void
    {
        $client = $this->getToken(); 
        $token = $client->getContainer()->get('security.token_storage')->getToken();
 
        $client->request('GET', '/api/orders', [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testOrderCreate(): void
    {
        $client = $this->getToken(); 
        $token = $client->getContainer()->get('security.token_storage')->getToken();
 
        $client->request('POST', '/api/orders', [], [], ['CONTENT_TYPE' => 'application/json', 'HTTP_Authorization' => 'Bearer ' . $token], json_encode([
            'productId' => 1,
            'quantity' => 10,
            'address' => '123 Test Adres',
            'shippingDate' => '2023-07-10',
        ]));
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }

    public function testOrderShow(): void
    {
        $client = $this->getToken();
        $token = $client->getContainer()->get('security.token_storage')->getToken();
        $client->request('GET', '/api/orders/ORD-1688896578', [], [], ['HTTP_Authorization' => 'Bearer ' . $token]); 
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('orderCode', $responseData);
        $this->assertArrayHasKey('address', $responseData);
        
    }

    public function testOrderUpdate(): void
    { 
        $client = $this->getToken();
        $token = $client->getContainer()->get('security.token_storage')->getToken();
        $client->request('POST', '/api/orders', [], [], ['CONTENT_TYPE' => 'application/json', 'HTTP_Authorization' => 'Bearer ' . $token], json_encode([
            'address' => '123 Test Street',  // Provide the other necessary fields
            'quantity' => 3,
            'productId' => 1 
        ]));
    
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        
        $postResponseData = json_decode($client->getResponse()->getContent(), true);
        $orderCode = $postResponseData['orderCode']; // Assuming the orderCode is returned in the response
    
        $client->request('PUT', '/api/orders/'.$orderCode.'', [], [], ['CONTENT_TYPE' => 'application/json', 'HTTP_Authorization' => 'Bearer ' . $token], json_encode([
            'shippingDate' => '2023-07-12',
        ]));
    
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('orderCode', $responseData);
        $this->assertArrayHasKey('shippingDate', $responseData);
    }
}