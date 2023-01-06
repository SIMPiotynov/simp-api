<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlarmController extends AbstractController
{
    #[Route('/alarms', name: 'app_alarm', methods: ['GET'])]
    public function index(): Response
    {
        return $this->json([
            'code' => 200,
            'message' => 'all alarms'
        ]);
    }

    #[Route('/alarms/{alarm_id}', name: 'app_alarm', methods: ['GET'])]
    public function getAlarmById(int $alarm_id)
    {
        // requete vers la BDD
        $message = 'play alarm for '.$alarm_id;
        return $this->json([
            'code' => 200,
            'message' => $message
        ]);
    }

    #[Route('/alarms/', name: 'app_alarm', methods: ['POST'])]
    public function createAlarm($request)
    {
        // creer un objet à partir des elements
        $request->request->get('music');
    }

    #[Route('alarms/{alarm_id}', name: 'app_alarm', methods: ['DELETE'])]
    public function deleteAlarm($alarm_id)
    {
        // supprimer l'alarme
        return $this->json([
            'code' => 200,
            'message' => 'Not deleted yet, no function'
        ]);
    }
}
