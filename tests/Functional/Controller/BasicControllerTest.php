<?php

namespace App\Tests\Functional\Controller;

use App\DataFixtures\UserFixtures;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class BasicControllerTest extends WebTestCase
{
    /**
     * @param KernelBrowser $client
     *
     * @return KernelBrowser $client
     */
    public function setTokenToClient(KernelBrowser $client): KernelBrowser
    {
        $client->request(
            'POST',
            '/api/auth',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['username' => UserFixtures::DEFAULT_USERNAME, 'password' => UserFixtures::DEFAULT_PASSWORD])
        );

        $token = json_decode($client->getResponse()->getContent(), 1)['token'];

        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $token));

        return $client;
    }
}
