<?php

namespace App\Tests\Functional\Controller;

use App\DataFixtures\UserFixtures;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserTest extends BasicControllerTest
{
    public function testGetUser()
    {
        $client = static::createClient();

        $client->request('GET', '/api/user');
        $this->assertEquals(JsonResponse::HTTP_UNAUTHORIZED, $client->getResponse()->getStatusCode());

        $this->setTokenToClient($client)->request('GET', '/api/user');
        $this->assertEquals(JsonResponse::HTTP_OK, $client->getResponse()->getStatusCode());

        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(UserFixtures::DEFAULT_USERNAME, $data['username']);
    }

    public function testRegister()
    {
        $client = static::createClient();
        $data = [
            'username' => 'new_user',
            'password' => 'new_password',
        ];

        $client->request('POST', '/api/user', [], [], [], json_encode($data));
        $this->assertEquals(JsonResponse::HTTP_CREATED, $client->getResponse()->getStatusCode());
    }
}
