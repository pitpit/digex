<?php

use Silex\WebTestCase;

/**
 * @author Damien Pitard <dpitard at digitas.fr>
 * @version $Id$
 */
class AppTest extends WebTestCase
{
    public function createApplication()
    {
        putenv('ENV=test');
        
        return require __DIR__.'/../src/app.php';
    }
    
    public function testHomepage()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');
        
        $this->assertTrue($client->getResponse()->isOk());
    }
}
