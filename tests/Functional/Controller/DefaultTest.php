<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultTest extends BasicControllerTest
{
    public function testDefault()
    {
        $client = static::createClient();

        $client->request('GET', '/api/default');
        $this->assertEquals(401, $client->getResponse()->getStatusCode());

        $this->setTokenToClient($client)->request('GET', '/api/default');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }
}
