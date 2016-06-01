<?php
namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LuckyControllerTest extends WebTestCase
{
    public function testShowNumber()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/lucky/number');
        $this->assertGreaterThan(0, $crawler->filter('html:contains("My lucky number is")')->count());
    }
    public function testLinkClicking(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/lucky/number');
        $link = $crawler->filter('a:contains("Greet")')->eq(0)->link();
        $crawler = $client->click($link);
        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }
}