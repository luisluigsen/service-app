<?php

declare(strict_types=1);

namespace App\Tests\Functional\Customer\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerControllerTestBase extends WebTestCase
{
    protected const CREATE_CUSTOMER_ENDPOINT = '/customer/create';

    protected AbstractBrowser $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->client->setServerParameter('CONTENT_TYPE', 'application/json');
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    protected function getResponseData(Response $response): array
    {
        try {
             return (array)\json_decode($response->getContent(), true);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    protected function createCustomer(): string
    {
        $payload = [
            'name' => 'Peter',
            'address' => 'Fake street 123',
            'age' => 30,
            'employeeId' => 'd368263a-ab71-4587-960d-cfe9725c373f',
        ];

        $this->client->request(Request::METHOD_POST, self::CREATE_CUSTOMER_ENDPOINT,[],[],[], json_encode($payload));

        $response = $this->client->getResponse();
        $responseData = $this->getResponseData($response);

        return $responseData['customerId'];
    }


}



