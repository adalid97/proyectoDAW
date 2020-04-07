<?php
// COntroller PBetica
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Controller extends AbstractController{
    public function index(){
        return $this->render('index.html.twig', [
            ]);
    }

    public function noticias(){
        return $this->render('noticias.html.twig', [
            ]);
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

}


?>