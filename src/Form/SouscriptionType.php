<?php

namespace App\Form;

use App\Entity\Souscription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class SouscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('etat', ChoiceType::class, [
                'label' => "Etat de la souscription :",
                'required' => true,
                'choices'=>[
                    'En attente' => 'En attente',
                    'Validée' => 'Validée'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Souscription::class,
        ]);
    }
}
