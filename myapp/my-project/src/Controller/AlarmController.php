<?php

namespace App\Controller;

use App\Entity\Alarm;
use App\Repository\AlarmRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AlarmController extends AbstractController
{
    #[Route('/alarms', name: 'getAlarms', methods: ['GET'])]
    public function getAlarms(AlarmRepository $alarmRepository, SerializerInterface $serializer): Response
    {
        $alarms = $alarmRepository->findAll();
        $alarms = $serializer->serialize($alarms, 'json', ['groups'=> "alarm"]);
        return $this->json([
            'code' => 200,
            'message' => json_decode($alarms)
        ]);
    }

    #[Route('/alarms/{id}', name: 'getAlarmById', methods: ['GET'])]
    public function getAlarmById(Alarm $alarm, SerializerInterface $serializer)
    {
        $alarm = $serializer->serialize($alarm, 'json', ['groups'=> "alarm"]);
        
        return $this->json([
            'code' => 200,
            'message' => json_decode($alarm)
        ]);
    }

    #[Route('/alarms', name: 'createAlarm', methods: ['POST'])]
    public function createAlarm(Request $request, EntityManagerInterface $em)
    {
        // creer un objet à partir des elements
        $content = json_decode($request->getContent());
        $alarm = new Alarm();
        $alarm->setAlarm($content->music); 

        $em->persist($alarm);
        $em->flush();

        return $this->json([
            'code' => 200,
            'message' => json_encode($alarm)
        ]);
    }

    #[Route('/alarms/{id}', name: 'deleteAlarm', methods: ['DELETE'])]
    public function deleteAlarm(Alarm $alarm, EntityManagerInterface $em)
    {
        // supprimer l'alarme
        $em->remove($alarm);
        $em->flush();

        return $this->json([
            'code' => 200,
            'message' => 'deleted'
        ]);
    }

    #[Route('/alarms/{id}', name: 'updateAlarm', methods: ['PUT'])]
    public function updateAlarm(Request $request, Alarm $alarm, EntityManagerInterface $em)
    {
        // creer un objet à partir des elements
        $content = json_decode($request->getContent());
        if(!empty($content->music))
            $alarm->setAlarm($content->music);
        if(!empty($content->name))
            $alarm->setName($content->name);
        if(!empty($content->isDefault))
            $alarm->setIsDefault($content->isDefault);
            
        $em->persist($alarm);
        $em->flush();

        return $this->json([
            'code' => 200,
            'message' => json_encode($alarm)
        ]);
    }
}
