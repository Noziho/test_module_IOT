<?php

namespace App\Form;

use App\Entity\Detail;
use App\Entity\Module;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class DetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('manufacturer', TextType::class, [
                'constraints' => new Length([
                    'min' => 2,
                    'minMessage'=> "Le fabricant doit avoir une longueur minimale de 2",
                    'max' => 50,
                    'maxMessage' => "La longueur maximale du fabricant peut être de 50"
                ]),
                'label' => 'Fabricant'
            ])
            ->add('serialNumber', TextType::class, [
                'constraints' => new Length([
                    'min' => 4,
                    'minMessage'=> "Le nom doit avoir une longueur minimale de 4",
                    'max' => 255,
                    'maxMessage' => "La longueur maximale du numéro de série peut être de 255"
                ]),
                'label' => 'Numéro de série'
            ])
            ->add('module', EntityType::class, [
                'class' => Module::class
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Detail::class,
        ]);
    }
}
