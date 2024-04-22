<?php

namespace App\Controller;

use App\Entity\OperatingHistory;
use App\Form\OperatingHistoryType;
use App\Repository\OperatingHistoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/operating/history')]
class OperatingHistoryController extends AbstractController
{
    #[Route('/', name: 'app_operating_history_index', methods: ['GET'])]
    public function index(OperatingHistoryRepository $operatingHistoryRepository): Response
    {
        return $this->render('operating_history/index.html.twig', [
            'operating_histories' => $operatingHistoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_operating_history_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $operatingHistory = new OperatingHistory();
        $form = $this->createForm(OperatingHistoryType::class, $operatingHistory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($operatingHistory);
            $entityManager->flush();

            return $this->redirectToRoute('app_operating_history_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('operating_history/new.html.twig', [
            'operating_history' => $operatingHistory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_operating_history_show', methods: ['GET'])]
    public function show(OperatingHistory $operatingHistory): Response
    {
        return $this->render('operating_history/show.html.twig', [
            'operating_history' => $operatingHistory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_operating_history_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, OperatingHistory $operatingHistory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OperatingHistoryType::class, $operatingHistory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_operating_history_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('operating_history/edit.html.twig', [
            'operating_history' => $operatingHistory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_operating_history_delete', methods: ['POST'])]
    public function delete(Request $request, OperatingHistory $operatingHistory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$operatingHistory->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($operatingHistory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_operating_history_index', [], Response::HTTP_SEE_OTHER);
    }
}
