<?php
namespace App\Controller;

use App\Entity\Socio;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class SociosController extends AbstractController
{

    public function socios()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $socios = $entityManager->getRepository(Socio::class)->findBy(
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
            $this->addFlash('success', 'Socio agregado correctamente.');
            return $this->redirectToRoute('sociosAdmin');
        }

        return $this->render('socios/nuevoSocio.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function editarSocioAdmin(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $socio = $entityManager->getRepository(Socio::class)->find($id);
        if (!$socio) {
            throw $this->createNotFoundException(
                'No existe ningún socio con id ' . $id
            );
        }

        $form = $this->createFormBuilder($socio)
            ->add('numSocio', NumberType::class)
            ->add('nombre', TextType::class)
            ->add('dni', TextType::class)
            ->add('fechaNacimiento', BirthdayType::class)
            ->add('direccion', TextType::class)
            ->add('localidad', TextType::class)
            ->add('telefono', TextType::class)
            ->add('save', SubmitType::class,
                array('label' => 'Editar Socio'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $socio = $form->getData();

            $entityManager->flush();
            $this->addFlash('success', 'Socio editado correctamente.');
            return $this->redirectToRoute('sociosAdmin');
        }
        return $this->render('socios/editarSocio.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function editarSocio(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $socio = $entityManager->getRepository(Socio::class)->find($id);
        if (!$socio) {
            throw $this->createNotFoundException(
                'No existe ningún socio con id ' . $id
            );
        }

        $form = $this->createFormBuilder($socio)
            ->add('direccion', TextType::class)
            ->add('localidad', TextType::class)
            ->add('telefono', TextType::class)
            ->add('save', SubmitType::class,
                array('label' => 'Guardar Datos'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $socio = $form->getData();

            $entityManager->flush();

            return $this->redirectToRoute('inicioAreaPrivada');
        }
        return $this->render('socios/editarSocio.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function borrarSocio($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $socio = $entityManager->getRepository(Socio::class)->find($id);

        $entityManager->remove($socio);
        $entityManager->flush();
        $this->addFlash('success', 'Socio borrado correctamente.');
        return $this->redirectToRoute('sociosAdmin');
    }

}
