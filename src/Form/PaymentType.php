<?php

namespace App\Form;

use App\Entity\Payment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('paymentAt', DateTimeType::class, [
                'label' => 'Date du paiement',
                'required' => TRUE,
                'constraints' => new NotBlank(['message' =>'Champ obligatoire']),
                'widget'=>'single_text',
                'format' => 'yyyy-MM-dd',
                'html5'=>false,
            ])
            ->add('amount', NumberType::class, [
                'label' => 'Montant',
                'required' => TRUE,
                'constraints' => new NotBlank(['message' =>'Champ obligatoire']),
                ])
            ->add('type', ChoiceType::class,[
                'label' => 'Type',
                'required' => TRUE,
                'expanded' => true,
                'choices' => [
                    'APL' => "APL",
                    'Locataire' => "Locataire",
                ],
                'constraints' => new NotBlank(['message' =>'Champ obligatoire']),
            ])
            ->add('paymentMethod', ChoiceType::class,[
                'label' => 'Méthode de payment',
                'required' => TRUE,
                'choices' => [
                    'Virement' => "Virement",
                    'Chèque' => "Chèque",
                    'Espèces' => "Espèces",
                ],
                'constraints' => new NotBlank(['message' =>'Champ obligatoire']),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Payment::class,
        ]);
    }
}
