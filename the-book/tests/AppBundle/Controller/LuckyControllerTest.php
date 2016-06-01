<?php
namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LuckyControllerTest extends WebTestCase
{
    public function luckyNumberCountProvider()
    {
        return array(array('1'), array('2'), array('3'), array('4'), array('5'), array('6'), array('7'));
    }

    /**
     * @dataProvider luckyNumberCountProvider
     */
    public function testLuckyNumberCount($count)
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/lucky/number/' . $count);
        $this->assertEquals($count, $crawler->filter('li')->count());
        $crawlerTwig = $client->request('GET', '/lucky/number/twig/' . $count);
        $this->assertEquals($count, $crawlerTwig->filter('li')->count());

    }

    public function testShowLuckyNumber()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/lucky/number');
        $this->assertGreaterThan(0, $crawler->filter('html:contains("My lucky number is")')->count());
    }

    public function testLuckyNumberLinkClicking()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/lucky/number');
        $link = $crawler->filter('a:contains("Greet")')->eq(0)->link();
        $crawler = $client->click($link);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}