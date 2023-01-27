<?php

namespace App\Controller;

use App\Entity\Alarm;
use App\Repository\AlarmRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Serializer;
use function PHPUnit\Framework\isEmpty;

class AlarmController extends AbstractController
{
    #[Route('/alarms', name: 'getAlarms', methods: ['GET'])]
    public function getAlarms(AlarmRepository $alarmRepository, Serializer $serializer): Response
    {
        $serializer = $serializer->getSerializer();

        $alarms = $alarmRepository->findAll();
        $alarms = $serializer->serialize($alarms, 'json', ['groups'=> "alarm"]);
        return $this->json([
            'code' => 200,
            'message' => json_decode($alarms)
        ]);
    }

    #[Route('/alarms/{id}', name: 'getAlarmById', methods: ['GET'])]
    public function getAlarmById(Alarm $alarm, Serializer $serializer)
    {
        $serializer = $serializer->getSerializer();
        
        $alarm = $serializer->serialize($alarm, 'json', ['groups'=> ["alarm", "user_details"]]);
        
        return $this->json([
            'code' => 200,
            'message' => json_decode($alarm)
        ]);
    }

    #[Route('/alarms', name: 'createAlarm', methods: ['POST'])]
    public function createAlarm(Request $request, EntityManagerInterface $em, Serializer $serializer, AlarmRepository $alarmRepository)
    {
        $serializer = $serializer->getSerializer();

        // creer un objet à partir des elements
        $content = json_decode($request->getContent());
        // $checkAlarm = $alarmRepository->findOneBy(['name' => $content->name]);
        dd($request->files->get('files'));

        return $this->json([
            'code' => 200,
            'message' => null,
        ]);
        if (!$checkAlarm) {
            $alarm = new Alarm();

            $music64 = $content->content;// explode(",", $content->content)[1];

            $alarm->setAlarm($music64); 
            $alarm->setName(isEmpty($content->name) ? $content->name :  "noName" );
            
            // file_put_contents($this->getParameter('uploads_directory').'/'.$content->name, base64_decode(str_replace("data:audio/midi;base64,", '', $content->content)));
            $ifp = fopen($this->getParameter('uploads_directory').'/'.$content->name, "w"); 
            fwrite( $ifp, base64_decode(str_replace("data:audio/midi;base64,", '', $content->content))); 
            fclose( $ifp ); 

            $em->persist($alarm);
            $em->flush();

            $alarm = $serializer->serialize($alarm, 'json', ['groups'=> ["alarm", "user_details"]]);
    
            return $this->json([
                'code' => 200,
                'message' => json_decode($alarm),
                "explode" => $music64
            ]);
        } else {
            return $this->json([
                'code' => 200,
                'message' => null,
            ]);
        }

    }

    #[Route('/alarms/{id}', name: 'deleteAlarm', methods: ['DELETE'])]
    public function deleteAlarm(Alarm $alarm, EntityManagerInterface $em, Serializer $serializer)
    {
        foreach($alarm->getUsers() as $user) {
            $user->setAlarm(null);
            $em->persist($user);
            $em->flush();
        };

        // supprimer l'alarme
        $em->remove($alarm);
        $em->flush();

        return $this->json([
            'code' => 200,
            'message' => 'deleted'
        ]);
    }

    #[Route('/alarms/{id}', name: 'updateAlarm', methods: ['PUT'])]
    public function updateAlarm(Request $request, Alarm $alarm, EntityManagerInterface $em, Serializer $serializer)
    {
        $serializer = $serializer->getSerializer();

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

        $alarm = $serializer->serialize($alarm, 'json', ['groups'=> ["alarm", "user_details"]]);

        return $this->json([
            'code' => 200,
            'message' => json_decode($alarm)
        ]);
    }
}
