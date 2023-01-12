<?php

namespace App\Controller;

use App\Entity\History;
use App\Repository\HistoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class HistoryController extends AbstractController
{
    #[Route('/history', name: 'getHistories')]
    public function getHistories(HistoryRepository $historyRepository, SerializerInterface $serializer): Response
    {
        $histories = $historyRepository->findAll();
        $histories = $serializer->serialize($histories, 'json', ['groups'=> ["history", "user"]]);

        return $this->json([
            'code' => 200,
            'message' => json_decode($histories)
        ]);
    }

    #[Route('/history/{id}', name: 'getHistoryById')]
    public function getHistoryById(History $history, SerializerInterface $serializer): Response
    {
        $history = $serializer->serialize($history, 'json', ['groups'=> ["history", "user"]]);

        return $this->json([
            'code' => 200,
            'message' => json_decode($history)
        ]);
    }
}
