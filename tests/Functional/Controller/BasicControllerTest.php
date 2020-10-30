<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class BasicControllerTest extends WebTestCase
{
    /**
     * @param mixed $client
     *
     * @return mixed $client
     */
    public function setTokenToClient($client)
    {
        $client->request(
            'POST',
            '/api/login_check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['username' => 'test', 'password' => 'test'])
        );

        $token = json_decode($client->getResponse()->getContent(), 1)['token'];

        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $token));

        return $client;
    }
}
