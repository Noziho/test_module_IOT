<?php

namespace App\Service;

use App\Entity\OperatingHistory;
use App\Repository\ModuleRepository;
use App\Repository\OperatingHistoryRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class OperatingHistoryService
{
    private OperatingHistoryRepository $historyRepository;
    private ModuleRepository $moduleRepository;
    private EntityManagerInterface $entityManager;

    /**
     * @param OperatingHistoryRepository $historyRepository
     * @param ModuleRepository $moduleRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(OperatingHistoryRepository $historyRepository, ModuleRepository $moduleRepository, EntityManagerInterface $entityManager)
    {
        $this->historyRepository = $historyRepository;
        $this->moduleRepository = $moduleRepository;
        $this->entityManager = $entityManager;
    }


    public function generateRandomOperatingHistory()
    {
        $modules = $this->moduleRepository->findAll();

        foreach ($modules as $module) {
            $data = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
            $status = ['En fonctionnement', 'Hors service', 'Eteint'];
            $randomStatus = $status[array_rand($status)];
            //get a random module to set a random operating history to it.
            $operatingHistory = new OperatingHistory();
            $operatingHistory->setModule($module);
            $operatingHistory->setStatus($randomStatus);
            $operatingHistory->setDate(new DateTime());
            if ($operatingHistory->getStatus() === 'En fonctionnement') {
                $operatingHistory->setDuration($data[array_rand($data)]);
                $operatingHistory->setConsumedData($data[array_rand($data)]);
                $operatingHistory->setDataSent($data[array_rand($data)]);
            }

            $this->entityManager->persist($operatingHistory);
        }
        $this->entityManager->flush();
    }


}