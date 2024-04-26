<?php

namespace App\Controller;

use App\Entity\Module;
use App\Entity\OperatingHistory;
use App\Form\ModuleType;
use App\Repository\ModuleRepository;
use App\Service\ModuleService;
use App\Service\OperatingHistoryService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/module')]
class ModuleController extends AbstractController
{

    private ModuleService $moduleService;
    private ModuleRepository $moduleRepository;
    private SerializerInterface $serializer;
    private OperatingHistoryService $historyService;
    private EntityManagerInterface $entityManager;

    /**
     * @param ModuleService $moduleService
     * @param ModuleRepository $moduleRepository
     * @param SerializerInterface $serializer
     * @param OperatingHistoryService $historyService
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ModuleService $moduleService, ModuleRepository $moduleRepository, SerializerInterface $serializer, OperatingHistoryService $historyService, EntityManagerInterface $entityManager)
    {
        $this->moduleService = $moduleService;
        $this->moduleRepository = $moduleRepository;
        $this->serializer = $serializer;
        $this->historyService = $historyService;
        $this->entityManager = $entityManager;
    }


    #[Route('/', name: 'app_module_index', methods: ['GET'])]
    public function index(): Response
    {
        $modules = $this->moduleRepository->findAll();
        foreach ($modules as $module){
            $operatingHistory = $module->getOperatingHistory();
            $lastOperatingHistory = $operatingHistory[sizeof($operatingHistory) -1];

            if ($lastOperatingHistory !== null){
                if($lastOperatingHistory->getStatus() === "Hors service"){
                    $this->addFlash('danger', "Le module " . $module->getId() . " est hors service");
                }
            }

        }
        return $this->render('module/index.html.twig', [
            'modules' => $this->moduleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_module_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $module = new Module();
        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($module);
            $entityManager->flush();

            $this->historyService->generateRandomOperatingHistory();

            return $this->redirectToRoute('app_detail_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('module/new.html.twig', [
            'module' => $module,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_module_show', methods: ['GET'])]
    public function show(Module $module): Response
    {
        return $this->render('module/show.html.twig', [
            'module' => $module,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_module_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Module $module, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_module_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('module/edit.html.twig', [
            'module' => $module,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_module_delete', methods: ['POST'])]
    public function delete(Request $request, Module $module, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$module->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($module);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_module_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/generate', name: 'app_module_generate', methods: ['GET'], priority: 999)]
    public function generate(): Response
    {
        $this->moduleService->generate();
        $this->historyService->generateRandomOperatingHistory();
        return $this->redirect('http://localhost:8000/module');
    }

    #[Route('/getAll', name: 'app_module_getAll', priority: 20)]
    public function getAll(): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize($this->moduleRepository->findAll(), 'json', ['groups' => 'getModule']),
            Response::HTTP_OK, [], true
        );
    }
}
