<?php

namespace App\Form;

<<<<<<< Updated upstream
use App\Entity\Rental;
=======
use App\Entity\Apartment;
use App\Entity\Rental;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
>>>>>>> Stashed changes
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class RentalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('entryAt', DateTimeType::class, [
                'label' => 'Date de début de location',
                'required' => TRUE,
                'constraints' => new NotBlank(['message' =>'Champ obligatoire']),
                'widget'=>'single_text',
                'format' => 'yyy-MM-dd',
                'html5'=>false,
            ])
            ->add('exitAt', DateTimeType::class, [
                'label' => 'Date de fin de location',
                'required' => TRUE,
                'constraints' => new NotBlank(['message' =>'Champ obligatoire']),
                'widget'=>'single_text',
                'format' => 'yyy-MM-dd',
                'html5'=>false,
            ])
            ->add('charges', TextType::class, [
                'label' => 'Charges',
                'required' => TRUE,
                'constraints' => new NotBlank(['message' =>'Champ obligatoire']),
                ])
            ->add('rent', TextType::class, [
                'label' => 'Loyer',
                'required' => TRUE,
                'constraints' => new NotBlank(['message' =>'Champ obligatoire']),
                ])
            ->add('balance', TextType::class, [
                'label' => 'Solde',
                'required' => TRUE,
                'constraints' => new NotBlank(['message' =>'Champ obligatoire']),
                ])
<<<<<<< Updated upstream
=======
            ->add('apartment', EntityType::class,[
                // looks for choices from this entity
                'class' => Apartment::class,
                'label' => 'Appartement',
                // uses the User.username property as the visible option string
                'choice_label' => 'address',
                'constraints' => new NotBlank(['message' =>'Champ obligatoire']),
                ])
>>>>>>> Stashed changes
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rental::class,
        ]);
    }
}
