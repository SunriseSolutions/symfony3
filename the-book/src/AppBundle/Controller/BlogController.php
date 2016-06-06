<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{

    /**
     * @Route("/blog/{page}", defaults = {"page" : 1}, requirements={"page":"\d+"})
     */
    public function routeRequirementsAction($page)
    {
        return $this->render('blog/index.html.twig', array('name' => 'page: '.$page));
    }

    /**
     * @param $page
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/blog/{slug}", defaults = {"slug" = "default-slug"})
     */
    public function optionalRouteAction($slug)
    {
        return $this->render('blog/index.html.twig', array('name' => 'slug: '.$slug));
    }


    public function indexAction($name)
    {
        return $this->render('blog/index.html.twig', array('name' => $name));
    }
}
