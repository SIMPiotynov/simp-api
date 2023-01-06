<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Test extends AbstractController {

    /**
     * @Route("/test", name="test", methods={"GET"})
     */
    public function test()
    {
        $response = new Response();
        $response->setContent(json_encode(['result' => "oui !"]));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}