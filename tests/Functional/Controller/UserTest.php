<?php

namespace App\Tests\Functional\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class UserTest extends BasicControllerTest
{
    public function testRegister()
    {
        $client = static::createClient();
        $data = [
            'username' => 'new_user',
            'password' => 'new_password',
        ];

        $this->setTokenToClient($client)->request('POST', '/api/user/register', [], [], [], json_encode($data));
        $this->assertEquals(JsonResponse::HTTP_CREATED, $client->getResponse()->getStatusCode());
    }

    public function testList()
    {
        $client = static::createClient();

        $this->setTokenToClient($client)->request('GET', '/api/user/list');
        $this->assertEquals(JsonResponse::HTTP_OK, $client->getResponse()->getStatusCode());
    }
}
