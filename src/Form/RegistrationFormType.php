<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\Common\Annotations\Annotation\Required;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', null, [
                'label' => "Nom *",
                'required' => true,
                'attr' => [
                    'placeholder' => 'Jean'
                ]
            ])
            ->add('prenom', null, [
                'label' => "Prénom *",
                'attr' => [
                    'placeholder' => 'Dupont'
                ]
            ])
            ->add('civilite', ChoiceType::class, [
                'label' => "Civilité *",
                'required' => true,
                'choices'=>[
                    'Homme' => 'Homme',
                    'Femme' => 'Femme'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => "Email *",
                'required' => true,
                'attr' => [
                    'placeholder' => 'exemple@exemple.com'
                ]
            ])
            ->add('date_de_naissance', BirthdayType::class, [
                'label' => "Date de naissance *",
                'required' => true,
                'attr' => [
                    'placeholder' => 'Select a value'
                ]
            ])
            ->add('telephone', null, [
                'label' => "Numéro de téléphone",
                'attr' => [
                    'placeholder' => '0607080910'
                ]
            ])

            ->add('ville', null, [
                'label' => "Ville",
                'attr' => [
                    'placeholder' => 'Paris'
                ]
            ])

            ->add('code_postal', null, [
                'label' => "Code Postal",
                'attr' => [
                    'placeholder' => '75000'
                ]
            ])
            ->add('numero_de_secu', null, [
                'label' => "Numéro de sécurité social ",
                'attr' => [
                    'placeholder' => 'A BB CC DD EEE FFF GG'
                ]
            ])
            
            ->add('pays', CountryType::class, [
                'required' => false,
                'preferred_choices' => ['FR'],
                'label' => 'Pays',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'address.form.country.placeholder'
                ],
                'label_attr' => [
                    'class' => 'col-sm-2 col-form-label'
                ],
            ])

            
            
            ->add('plainPassword', PasswordType::class, [
                'label' => "Password *",
                'attr' => [
                    'placeholder' => '***********'
                ],
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => "Nos conditions générales d'utilisation *",
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez agréer aux conditions générales.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
