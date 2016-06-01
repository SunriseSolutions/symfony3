<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LuckyController
{
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