<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Socio;
use App\Form\DocumentoType;

class SociosController extends AbstractController{

    public function socios(){
        $entityManager = $this->getDoctrine()->getManager();
        $socios= $entityManager->getRepository(Socio::class)->findBy(
            array(),
            array('numSocio' => 'ASC')
        );

        return $this->render('administradores/sociosAdmin.html.twig', array(
            'socios' => $socios,
        ));        
    }

    public function nuevoSocio(Request $request)
    {
        $socio = new Socio();

        $form = $this->createFormBuilder($socio)
        ->add('numSocio', NumberType::class)
        ->add('nombre', TextType::class)
        ->add('dni', TextType::class)
        ->add('fechaNacimiento', BirthdayType::class)
        ->add('direccion', TextType::class)
        ->add('localidad', TextType::class)
        ->add('telefono', TextType::class)
        ->add('save', SubmitType::class,
        array('label' => 'Añadir Socio'))
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $socio = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($socio);
            $entityManager->flush();
            return $this->redirectToRoute('sociosAdmin');
        }

        return $this->render('socios/nuevoSocio.html.twig', array(
        'form' => $form->createView(),
        ));
    }

}

?>
