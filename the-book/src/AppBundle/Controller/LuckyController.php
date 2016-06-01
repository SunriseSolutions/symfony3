<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LuckyController extends Controller
{
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

        return $this->render('lucky/number.html.twig', array('luckyNumberList' => $numbersList));
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
    public function numberAction()
    {
        $number = rand(0, 100);
        return new Response('<html><body><a href="http://www.google.com">Greet first link</a><h1>My lucky number is:</h1><h2>' . $number . '</h2></body></html>');
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