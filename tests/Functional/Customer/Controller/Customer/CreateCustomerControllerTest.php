<?php

namespace App\Tests\Functional\Customer\Controller\Customer;

use App\Tests\Functional\Customer\Controller\CustomerControllerTestBase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateCustomerControllerTest extends CustomerControllerTestBase
{
    private const ENDPOINT = '/customer/create';

    public function testCreateCustomerAndCheckIt(): void
    {
        $payload = [
            'name' => 'Peter',
            'address' => 'Fake street 123',
            'age' => 30,
            'employeeId' => '78c5b803-e335-43da-b3e2-f8400bbd2907',
        ];

        $this->client->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));

        $response = $this->client->getResponse();
        $responseData = $this->getResponseData($response);

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        self::assertArrayHasKey('customerId', $responseData);
        self::assertEquals(36, \strlen($responseData['customerId']));

        $generatedCustomerId = $responseData['customerId'];

        $this->client->request(Request::METHOD_GET, \sprintf('/customer/%s', $generatedCustomerId));

        $response = $this->client->getResponse();
        $responseData = $this->getResponseData($response);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());

        self::assertArrayHasKey('id', $responseData);
        self::assertArrayHasKey('name', $responseData);
        self::assertArrayHasKey('address', $responseData);
        self::assertArrayHasKey('age', $responseData);
        self::assertArrayHasKey('employeeId', $responseData);

        self::assertEquals($generatedCustomerId, $responseData['id']);
        self::assertEquals($payload['name'], $responseData['name']);
        self::assertEquals($payload['address'], $responseData['address']);
        self::assertEquals($payload['age'], $responseData['age']);
        self::assertEquals($payload['employeeId'], $responseData['employeeId']);
    }
}
