<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Noticia;
use App\Entity\Usuario;
use App\Entity\Notificacion;
use App\Entity\Socio;
use App\Form\NoticiaType;

class NotificacionesController extends AbstractController{

    public function nuevaNotificacion(Request $request)
    {
        $notificacion = new Notificacion();

        $form = $this->createFormBuilder($notificacion)
        ->add('nombre', TextType::class)
        ->add('email', TextType::class)
        ->add('telefono', TextareaType::class)
        ->add('mensaje', TextareaType::class)
        ->add('save', SubmitType::class,
        array('label' => 'Enviar Mensaje'))
        ->getForm();

        $notificacion->setLeido(false);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $noticia = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($noticia);
            $entityManager->flush();
            return $this->redirectToRoute('nuevaNotificacion');
        }

        return $this->render('contacto.html.twig', array(
        'form' => $form->createView(),
        ));
    }

}



?>