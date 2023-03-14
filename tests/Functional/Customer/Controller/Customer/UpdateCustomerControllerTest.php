<?php

namespace App\Tests\Functional\Customer\Controller\Customer;

use App\Tests\Functional\Customer\Controller\CustomerControllerTestBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateCustomerControllerTest extends CustomerControllerTestBase
{
    private const ENDPOINT = '/customer/%s';

    /**
     * @dataProvider UpdateCustomerDataProvider
     *
     */
    public function testUpdateCustomer(array $payload): void
    {
        //create a customer
        $customerId = $this->createCustomer();
        //update a customer
        $this->client->request(Request::METHOD_PATCH, sprintf(self::ENDPOINT, $customerId), [], [], [], json_encode($payload));
        //check
        $response = $this->client->getResponse();
        $responseData = $this->getResponseData($response);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $keys = array_keys($payload);

        foreach ($keys as $key){
            self::assertEquals($payload[$key], $responseData[$key]);
        }
    }

    public function testUpdateWithInvalidName(): void
    {
        $customerId = $this->createCustomer();

        $invalidPayload = ['name'=> 'X'];
        $this->client->request(Request::METHOD_PATCH, sprintf(self::ENDPOINT, $customerId),[],[],[], json_encode($invalidPayload));

        $response = $this->client->getResponse();
        self::assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());

        $responseData = $this->getResponseData($response);
    }

    public function updateCustomerDataProvider(): iterable
    {
        yield 'Update name payload' => [
            [
                'name' => 'Romeo',
            ],
        ];

        yield 'Update address payload' => [
            [
                'address' => 'New address 344',
            ],
        ];

        yield 'Update name and address payload' => [
            [
                'name' => 'Jose',
                'address' => 'New address 333',
            ],
        ];

        yield 'Update age payload' => [
            [
                'age' => 35,
            ],
        ];
    }
}