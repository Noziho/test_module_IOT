<?php

namespace App\Service;

use App\Entity\Detail;
use App\Entity\Module;
use App\Repository\ModuleRepository;
use Doctrine\ORM\EntityManagerInterface;

class ModuleService
{
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function generate(): void
    {
        for ($i = 1; $i < 11 ; $i++) {
            $module = new Module();
            $module->setName('Samsung Galaxy A' . $i);
            $module->setDescription('Ma description'. " " . $i);

            $detail = new Detail();
            $detail->setModule($module);
            $detail->setManufacturer('Samsung');
            $detail->setSerialNumber(uniqid());

            $this->entityManager->persist($module);
            $this->entityManager->persist($detail);
        }
        $this->entityManager->flush();
    }
}