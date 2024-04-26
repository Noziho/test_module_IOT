<?php

namespace App\Form;

use App\Entity\Module;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ModuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => new Length([
                    'min' => 3,
                    'minMessage'=> "Le nom doit avoir une longueur minimale de 3",
                    'max' => 50,
                    'maxMessage' => "La longueur maximale du nom peut être de 50"
                ]),
                'label' => 'Nom'
            ])
            ->add('description', TextareaType::class, [
                'constraints' => new Length([
                    'min' => 3,
                    'minMessage'=> "La description doit avoir une longueur minimale de 3",
                    'max' => 255,
                    'maxMessage' => "La longueur maximale de la description peut être de 255"
                ]),
                'label' => 'Description'
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Module::class,
        ]);
    }
}
