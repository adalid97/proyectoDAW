<?php

namespace App\Form;

use App\Entity\Noticia;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditarNoticiaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titular')
            ->add('entrada')
            ->add('cuerpo', TextareaType::class)
            ->add('fecha')
            ->add('localidad')
            ->add('save', SubmitType::class,
                array('label' => 'Editar Noticia'))
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Noticia::class,
        ]);
    }
}
