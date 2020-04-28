<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Partido;
use App\Entity\Equipo;


class PartidoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipo')
            ->add('estadio')
            ->add('fecha', DateType::class)
            ->add('hora', TimeType::class)
            ->add('horaAperturaSede', TimeType::class)
            ->add('idEquipoLocal')
            ->add('idEquipoVisitante')
            ->add('save', SubmitType::class, array('label'=> 'Guardar Partido'))
            ->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            
        ]);
    }
}
