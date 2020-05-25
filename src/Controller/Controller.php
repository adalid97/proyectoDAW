<?php
// COntroller PBetica
namespace App\Controller;

use App\Entity\Noticia;
use App\Entity\Notificacion;
use App\Entity\Partido;
use App\Entity\Socio;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Controller extends AbstractController
{

    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $partidos = $entityManager->getRepository(Partido::class)->findBy(
            array(),
            array('fecha' => 'ASC'),
            2
        );

        $noticias = $entityManager->getRepository(Noticia::class)->findBy(
            array(),
            array('fecha' => 'DESC'),
            3
        );

        return $this->render('index.html.twig', array(
            'partidos' => $partidos,
            'noticias' => $noticias,
        ));

    }

    public function socios()
    {
        return $this->render('socios.html.twig', [
        ]);
    }

    public function documentos()
    {
        return $this->render('documentos.html.twig', [
        ]);
    }

    public function contacto()
    {
        return $this->render('contacto.html.twig', [
        ]);
    }

    public function inicioAdmin()
    {
        return $this->render('areaPrivada/inicioAreaPrivada.html.twig', [
        ]);
    }

    public function sociosAdmin()
    {
        return $this->render('administradores/sociosAdmin.html.twig', [
        ]);
    }

    public function notificacionesAdmin()
    {
        return $this->render('administradores/notificacionesAdmin.html.twig', [
        ]);
    }

    public function inicioAreaPrivada()
    {
        return $this->render('areaPrivada/inicioAreaPrivada.html.twig', [
        ]);
    }

    public function menuAreaPrivada($seccionActual)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $notificaciones = $entityManager->getRepository(Notificacion::class)->findBy(
            array('leido' => 0)
        );

        return $this->render('areaPrivada/navAreaPrivada.html.twig', array(
            'seccionActual' => $seccionActual,
            'notificaciones' => $notificaciones,
        ));
    }

    public function carnetSocio($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $socio = $entityManager->getRepository(Socio::class)->findOneById($id);
        return $this->render('socios/carnet.html.twig', array(
            'socio' => $socio,
        ));
    }

}
