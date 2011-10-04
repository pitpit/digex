<?php

namespace Digitas\Test;

use Silex\WebTestCase;

/**
 * @author Damien Pitard <dpitard at digitas.fr>
 * @version $Id$
 */
class MainApplicationTest extends WebTestCase
{
    public function createApplication()
    {
        return new Digitas\MainApplication(__DIR__.'/../../../app', __DIR__.'/../../../vendor');
    }
    
    public function testHomepage()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');
        
        $this->assertTrue($client->getResponse()->isOk());
    }
}
