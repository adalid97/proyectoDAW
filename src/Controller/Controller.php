<?php
// COntroller PBetica
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\Noticias;

class Controller extends AbstractController{
    public function index(){
        return $this->render('index.html.twig', [
            ]);
    }

    public function noticias(){

        // Obtenemos el gestor de entidades de Doctrine
        $entityManager = $this->getDoctrine()->getManager();
        // obtenemos todas las noticias
        $noticias= $entityManager->getRepository(Noticias::class)->findBy(
            array(),
            array('fecha' => 'DESC')
        );

        return $this->render('noticias.html.twig', array(
            'noticias' => $noticias,
        ));        
    }

    public function socios(){
        return $this->render('socios.html.twig', [
            ]);
    }

    public function faq(){
        return $this->render('faq.html.twig', [
            ]);
    }

    public function contacto(){
        return $this->render('contacto.html.twig', [
            ]);
    }

    public function inicioAdmin(){
        return $this->render('administradores/inicioAdmin.html.twig', [
            ]);
    }
    
    public function sociosAdmin(){
        return $this->render('administradores/sociosAdmin.html.twig', [
            ]);
    }

    public function noticiasAdmin(){
        return $this->render('administradores/noticiasAdmin.html.twig', [
            ]);
    }

    public function notificacionesAdmin(){
        return $this->render('administradores/notificacionesAdmin.html.twig', [
            ]);
    }

}


?>