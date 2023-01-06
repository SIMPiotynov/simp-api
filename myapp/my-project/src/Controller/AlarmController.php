<?php

namespace App\Controller;

use App\Entity\Alarm;
use App\Repository\AlarmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route('/alarms/', name: 'createAlarm', methods: ['POST'])]
    public function createAlarm($request)
    {
        // creer un objet à partir des elements
        $request->request->get('music');
    }

    #[Route('alarms/{alarm_id}', name: 'deleteAlarm', methods: ['DELETE'])]
    public function deleteAlarm($alarm_id)
    {
        // supprimer l'alarme
        return $this->json([
            'code' => 200,
            'message' => 'Not deleted yet, no function'
        ]);
    }
}
