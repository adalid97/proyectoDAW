<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password', PasswordType::class, [
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, escribe una contraseña',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Su contraseña debe tener un mínimo de {{ limit }} caracteres',
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('dni', TextType::class, ['mapped' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
