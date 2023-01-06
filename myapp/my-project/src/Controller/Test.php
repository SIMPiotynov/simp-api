<?php

namespace App\Controller;

use App\Entity\Alarm;
use App\Repository\AlarmRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class Test extends AbstractController {

    /**
     * @Route("/api/test", name="test", methods={"GET"})
     */
    public function test(AlarmRepository $alarmRepository, SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $a = new Alarm();
        $a->setAlarm("oula");
        $em->persist($a);
        $em->flush();

        $response = new Response();
        $alarms = $serializer->serialize($alarmRepository->findAll(), 'json', ["groups" => "alarm"]);
        // $val = $alarmRepository->find(1)->getAlarm();
        $response->setContent($alarms);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}