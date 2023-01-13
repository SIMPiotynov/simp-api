<?php

namespace App\Controller;

use App\Entity\History;
use App\Entity\User;
use App\Repository\AlarmRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use App\Service\Serializer;

class UserController extends AbstractController
{
    #[Route('/users', name: 'getUsers', methods: ['GET'])]
    public function getUsers(UserRepository $UserRepository, Serializer $serializer): Response
    {
        $serializer = $serializer->getSerializer();
    
        $users = $UserRepository->findAll();
        $users = $serializer->serialize($users, 'json', ['groups'=> ["user", "alarm"]]);

        return $this->json([
            'code' => 200,
            'message' => json_decode($users)
        ]);
    }

    #[Route('/users/{id}', name: 'getUserById', methods: ['GET'])]
    public function getUserById(Serializer $serializer, User $user): Response
    {
        $serializer = $serializer->getSerializer();
        
        $user = $serializer->serialize($user, 'json', ['groups'=> ["user", "alarm"]]);
        return $this->json([
            'code' => 200,
            'message' => json_decode($user)
        ]);
    }

    #[Route('/users/{id}', name: 'deleteUser', methods: ['DELETE'])]
    public function deleteUser(User $user, EntityManagerInterface $em)
    {
        // supprimer l'alarme
        $em->remove($user);
        $em->flush();

        return $this->json([
            'code' => 200,
            'message' => 'delete'
        ]);
    }

    #[Route('/users/{id}', name: 'updateUser', methods: ['PUT'])]
    public function updateUser(Request $request, User $user, EntityManagerInterface $em, Serializer $serializer, AlarmRepository $alarmRepository)
    {

        $serializer = $serializer->getSerializer();

        // creer un objet à partir des elements
        $content = json_decode($request->getContent());
        if(!empty($content->email))
            $user->setEmail($content->email);
        if(!empty($content->lastname))
            $user->setLastname($content->lastname);
        if(!empty($content->firstname))
            $user->setFirstname($content->firstname);
        if(!empty($content->fingerprint))
            $user->setFingerprint($content->fingerprint);
        if(!empty($content->isAuthorized))
            $user->setIsAuthorized($content->isAuthorized);
        if(!empty($content->alarmId))
            $user->setAlarm($alarmRepository->find($content->alarmId));
        
        $user->setUpdatedAt(new DateTimeImmutable());

        $em->persist($user);
        $em->flush();

        $user = $serializer->serialize($user, 'json', ['groups'=> ["user", "alarm"]]);

        return $this->json([
            'code' => 200,
            'message' => json_decode($user)
        ]);
    }

    #[Route('/users', name: 'createUser', methods: ['POST'])]
    public function createUser(Request $request, EntityManagerInterface $em, Serializer $serializer)
    {
        $serializer = $serializer->getSerializer();

        $content = json_decode($request->getContent());
        $user = new User();
        $user->setLastname($content->lastname); 
        $user->setFirstname($content->firstname); 
        $user->setFingerprint($content->fingerprint); 
        $user->setIsAuthorized($content->isAuthorized); 
        $user->setCreatedAt(new DateTimeImmutable());

        $em->persist($user);
        $em->flush();

        $user = $serializer->serialize($user, 'json', ['groups'=> "user"]);

        return $this->json([
            'code' => 200,
            'message' => json_decode($user)
        ]);
    }

    #[Route('/users/{id}/history', name: 'createUserHistory', methods: ['POST'])]
    public function createUserHistory(Request $request, User $user, EntityManagerInterface $em, Serializer $serializer)
    {
        $serializer = $serializer->getSerializer();

        $content = json_decode($request->getContent());
        $history = new History();
        $history->setUnlocked($content->unlocked);
        $history->setCreatedAt(new DateTimeImmutable());
        $history->setUser($user);

        $user->addHistory($history);

        $em->persist($user);
        $em->persist($history);
        $em->flush();

        $user = $serializer->serialize($user, 'json', ['groups'=> ["user", "alarm"]]);
        $history = $serializer->serialize($history, 'json', ['groups'=> ["history", "user"]]);

        return $this->json([
            'code' => 200,
            'message' => [
                "user" => json_decode($user),
                'history' => json_decode($history)
            ]
        ]);
    }

    #[Route('/users/{id}/history', name: 'getUserHistory', methods: ['GET'])]
    public function getUserHistory(User $user, Serializer $serializer)
    {
        $serializer = $serializer->getSerializer();

        $histories = $user->getHistories();

        $user = $serializer->serialize($user, 'json', ['groups'=> "user"]);
        $histories = $serializer->serialize($histories, 'json', ['groups'=> "history"]);

        return $this->json([
            'code' => 200,
            'message' => [
                "user" => json_decode($user),
                'histories' => json_decode($histories)
                ]
        ]);
    }

}
