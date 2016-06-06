<?php
namespace Tests\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogControllerTest extends WebTestCase
{
    public function testRouteRequirements(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/blog/1');
        $this->assertEquals(0,$crawler->filter('html:contains("slug: 1")')->count());
        $this->assertEquals(1,$crawler->filter('html:contains("page: 1")')->count());
        $crawler = $client->request('GET', '/blog/my-slug');
        $this->assertEquals(1,$crawler->filter('html:contains("slug: my-slug")')->count());
        $this->assertEquals(0,$crawler->filter('html:contains("page: 1")')->count());

    }

    public function testOptionalRoute()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/blog');
        $this->assertEquals(0,$crawler->filter('html:contains("slug: default-slug")')->count());
        $this->assertEquals(1,$crawler->filter('html:contains("page: 1")')->count());
        $crawler = $client->request('GET', '/blog/my-slug');
        $this->assertEquals(1,$crawler->filter('html:contains("slug: my-slug")')->count());
    }

}
