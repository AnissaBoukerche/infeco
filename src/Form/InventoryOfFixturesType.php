<?php

namespace App\Form;

use App\Entity\InventoryOfFixtures;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class InventoryOfFixturesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('status', ChoiceType::class,[
            'label' => 'Entrée ou Sortie',
            'required' => TRUE,
            'choices' => [
                'Entrée' => 1,
                'Sortie' => 0,
            ],
            'constraints' => new NotBlank(['message' =>'Champ obligatoire']),
        ])
        ->add('comments', TextType::class,[
            'label' => 'Commentaires',
            'required' => FALSE,
            'constraints' => new NotBlank(['message' =>'Champ obligatoire']),
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InventoryOfFixtures::class,
        ]);
    }
}
