<?php
namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LuckyControllerTest extends WebTestCase
{
    public function testForward(){
        $client = static::createClient();
        $crawler = $client->request('GET','/lucky/forward');
        $this->assertEquals(1,$crawler->filter('div#welcome:contains("Welcome to Symfony ")')->count());
    }
    public function testResponseHeader()
    {
        $client = static::createClient();
        $client->request('GET', '/lucky/response/header');
        $this->assertTrue(
            $client->getResponse()->headers->contains( 
                'Content-Type',
                'application/json'
            )
        );
    }

    public function testFlashBag()
    {
        $client = static::createClient();
        $client->request('GET', '/lucky/flash-bag?message=anh-yeu-em');
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertEquals(1, $crawler->filter('html:contains("anh-yeu-em")')->count());
    }

    public function testFooSession()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/lucky/session/foo');
        $this->assertEquals(1, $crawler->filter('html:contains("foo: bar")')->count());
        $crawler = $client->request('GET', '/lucky/page');
        $this->assertEquals(1, $crawler->filter('html:contains("session: bar")')->count());
    }

    public function testReadQueryParam()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/lucky/query?page=hahahalala');
        $this->assertEquals(1, $crawler->filter('html:contains("page: hahahalala")')->count());
    }

    public function testRedirectToRoute()
    {
        $client = static::createClient();
        $client->request('GET', '/index');
        $this->assertTrue($client->getResponse()->isRedirect('/'));
    }

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

    public function testGenerateUrl()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/lucky/number/twig');
        $this->assertEquals(1, $crawler->filter('h2:contains("/lucky/number/twig")')->count());
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