<?php

namespace App\Controller;

use App\Entity\Module;
use App\Form\ModuleType;
use App\Repository\ModuleRepository;
use App\Service\ModuleService;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/module')]
class ModuleController extends AbstractController
{

    private ModuleService $moduleService;
    private ModuleRepository $moduleRepository;

    /**
     * @param ModuleService $moduleService
     * @param ModuleRepository $moduleRepository
     */
    public function __construct(ModuleService $moduleService, ModuleRepository $moduleRepository)
    {
        $this->moduleService = $moduleService;
        $this->moduleRepository = $moduleRepository;
    }


    #[Route('/', name: 'app_module_index', methods: ['GET'])]
    public function index(ModuleRepository $moduleRepository): Response
    {
        $modules = $this->moduleRepository->findAll();
        foreach ($modules as $module){
            $operatingHistory = $module->getOperatingHistory();
            $lastOperatingHistory = $operatingHistory[sizeof($operatingHistory) -1];

            if($lastOperatingHistory->getStatus() === "Hors service"){
                $this->addFlash('danger', "Le module " . $module->getId() . " est hors service");
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

            return $this->redirectToRoute('app_module_index', [], Response::HTTP_SEE_OTHER);
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
    public function generate()
    {
        $this->moduleService->generate();
    }
}
