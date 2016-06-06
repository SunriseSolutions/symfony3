<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LuckyController extends Controller
{       
    // todo $this->isCsrfTokenValid : Chapter 5: Validating a CSRF Token: page 49
    public function csrfTokenAction(){
        $this->isCsrfTokenValid('token_id','tokenstring');
        return new Response('todo');
    }
    
    /**
     * @return Response
     * @Route("/lucky/forward")
     */
    public function forwardAction(){
        $response = $this->forward('AppBundle:Default:index');
        return $response;
    }
    /**
     * @Route("/lucky/response/header")
     */
    public function responseHeaderAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        return $response->setContent('response->setContent()');
    }

    /**
     * @param Request $request
     * @Route("/lucky/flash-bag",name="flash_bag")
     */
    public function sessionFlashBag(Request $request)
    {
        $msg = $request->query->get('message');
        $this->addFlash('notice', $msg);
        return $this->redirectToRoute('view_page');
    }

    /**
     * @return Response
     * @Route("/lucky/page",name="view_page")
     */
    public function viewPageAction(Request $request)
    {
        return $this->render('lucky/page.html.twig', array('foo' => $request->getSession()->get('foo')));
    }

    /**
     * @Route("/lucky/session/foo",name="manage_session")
     * @param Request $request
     */
    public function manageFooSessionAction(Request $request)
    {
        $session = $request->getSession();
        $session->set('foo', 'bar');
        $foo = $session->get('foo');
        $foobar = $session->get('foobar');
        $filters = $session->get('filters', array());
        return $this->render('lucky/number.html.twig', array('luckyNumberList' => 'foo: ' . $foo, 'url' => 'no url'));
    }

    /**
     * @Route("/lucky/query", name="read_query_param")
     * @param Request $request
     * @return Response
     */
    public function readQueryParameterAction(Request $request)
    {
        $page = $request->query->get('page', 1);
        return $this->render('lucky/number.html.twig', array('luckyNumberList' => 'page: ' . $page, 'url' => 'no url'));
    }

    /**
     * @Route("/lucky/not-found/{found}")
     */
    public function notFoundAction($found = false)
    {
        if (!$found) {
            throw $this->createNotFoundException('anh ko the tim thay em ' . $found);
        }
        return $this->render('lucky/number.html.twig', array('luckyNumberList' => 'no list', 'url' => 'no url'));
    }

    /**
     * @Route("/index",name="indedex")
     */
    public function indexAction()
    {
        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/lucky/number/twig/{count}", name="luck_number_twig")
     */
    public function numberCountTwigAction($count = 10)
    {
        $numbers = array('<ol>');
        for ($i = 0; $i < $count; $i++) {
            $numbers[] = '<li>' . rand(0, 100) . '</li>';
        }
        $numbers[] = '</ol>';
        $numbersList = implode(' ', $numbers);
        $url = $this->generateUrl('luck_number_twig');
        return $this->render('lucky/number.html.twig', array('luckyNumberList' => $numbersList, 'url' => $url));
    }

    /**
     * @Route("/lucky/number/{count}")
     */
    public function numberCountAction($count)
    {
        $numbers = array();
        for ($i = 0; $i < $count; $i++) {
            $numbers[] = '<li>' . rand(0, 100) . '</li>';
        }
        $numbersList = implode(' ', $numbers);

        return new Response(
            '<html><body>Lucky numbers: <ol>' . $numbersList . '</ol></body></html>'
        );
    }

    /**
     * @Route("/lucky/number")
     */
    public function numberAction(Request $request)
    {
        $number = rand(0, 100);
        return new Response('<html><body><strong>PHPSESSID cookie: ' . $request->cookies->get('PHPSESSID') . '</strong><br/><a href="http://www.google.com">Greet first link</a><h1>My lucky number is:</h1><h2>' . $number . '</h2></body></html>');
    }

    /**
     * @Route("/api/lucky/number")
     * @return Response
     */
    public function apiNumberAction()
    {
        $number = rand(0, 100);
        $data = array('lucky_number' => $number);
        return new Response(json_decode($data), 200, array('Content-Type' => 'application/json'));
        // or
//        return new JsonResponse($data);
    }
}