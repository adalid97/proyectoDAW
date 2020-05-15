<?php
namespace App\Controller;

use App\Entity\Notificacion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class NotificacionesController extends AbstractController
{

    public function nuevaNotificacion(Request $request)
    {
        $notificacion = new Notificacion();

        $form = $this->createFormBuilder($notificacion)
            ->add('nombre', TextType::class)
            ->add('email', EmailType::class)
            ->add('telefono', TextType::class)
            ->add('mensaje', TextareaType::class)
            ->add('save', SubmitType::class,
                array('label' => 'Enviar Mensaje'))
            ->getForm();

        $notificacion->setLeido(false);
        $notificacion->setDate(new \DateTime('now'));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notificacion = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($notificacion);
            $entityManager->flush();
            return $this->redirectToRoute('nuevaNotificacion');
        }

        return $this->render('contacto.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function listaNotificaciones()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $notificacion = $entityManager->getRepository(Notificacion::class)->findBy(
            array(),
            array('leido' => 'ASC'),
        );
        return $this->render('administradores/notificacionesAdmin.html.twig', array(
            'notificaciones' => $notificacion,
        ));

    }

    public function verNotificacion($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $notificacion = $entityManager->getRepository(Notificacion::class)->find($id);
        if (!$notificacion) {
            throw $this->createNotFoundException(
                'No existe ninguna notificacion con id ' . $id
            );
        }
        $notificacion->setLeido(true);

        $entityManager->flush();

        return $this->render('administradores/verNotificacion.html.twig', array(
            'notificacion' => $notificacion,
        ));
    }

    public function notificacionNoLeida(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $notificacion = $entityManager->getRepository(Notificacion::class)->find($id);

        if (!$notificacion) {
            throw $this->createNotFoundException(
                'No existe ninguna notificacion con id ' . $id
            );
        }
        $notificacion->setLeido(false);

        $entityManager->flush();

        return $this->redirectToRoute('notificacionesAdmin');
    }

}
