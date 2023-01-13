<?php

namespace App\Controller;

use App\Entity\History;
use App\Repository\HistoryRepository;
use App\Service\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HistoryController extends AbstractController
{
    #[Route('/history', name: 'getHistories')]
    public function getHistories(HistoryRepository $historyRepository, Serializer $serializer): Response
    {
        $serializer = $serializer->getSerializer();

        $histories = $historyRepository->findAll();
        $histories = $serializer->serialize($histories, 'json', ['groups'=> ["history", "user"]]);

        return $this->json([
            'code' => 200,
            'message' => json_decode($histories)
        ]);
    }

    #[Route('/history/{id}', name: 'getHistoryById')]
    public function getHistoryById(History $history, Serializer $serializer): Response
    {
        $serializer = $serializer->getSerializer();

        $history = $serializer->serialize($history, 'json', ['groups'=> ["history", "user"]]);

        return $this->json([
            'code' => 200,
            'message' => json_decode($history)
        ]);
    }
}
