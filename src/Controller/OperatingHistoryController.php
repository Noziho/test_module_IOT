<?php

namespace App\Controller;

use App\Entity\OperatingHistory;
use App\Form\OperatingHistoryType;
use App\Repository\ModuleRepository;
use App\Repository\OperatingHistoryRepository;
use App\Service\OperatingHistoryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/operatingHistory')]
class OperatingHistoryController extends AbstractController
{

    private OperatingHistoryService $historyService;
    private ModuleRepository $moduleRepository;
    private SerializerInterface $serializer;

    /**
     * @param OperatingHistoryService $historyService
     * @param ModuleRepository $moduleRepository
     * @param SerializerInterface $serializer
     */
    public function __construct(OperatingHistoryService $historyService, ModuleRepository $moduleRepository, SerializerInterface $serializer)
    {
        $this->historyService = $historyService;
        $this->moduleRepository = $moduleRepository;
        $this->serializer = $serializer;
    }


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

    #[Route('/random', name: 'app_operating_history_random', priority: 10)]
    public function generateRandomOperatingHistory(): Response
    {
        $this->historyService->generateRandomOperatingHistory();

        return new JsonResponse(
            $this->serializer->serialize($this->moduleRepository->findAll(), 'json', ['groups' => 'getModule']),
            Response::HTTP_OK, [], true
        );
    }
}
