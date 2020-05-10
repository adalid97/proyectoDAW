<?php
// COntroller PBetica
namespace App\Controller;

use App\Entity\Noticia;
use App\Entity\Notificacion;
use App\Entity\Partido;
use App\Form\NoticiaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

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

    public function noticias()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $noticias = $entityManager->getRepository(Noticia::class)->findBy(
            array(),
            array('fecha' => 'DESC')
        );

        return $this->render('noticias.html.twig', array(
            'noticias' => $noticias,
        ));
    }

    public function socios()
    {
        return $this->render('socios.html.twig', [
        ]);
    }

    public function faq()
    {
        return $this->render('faq.html.twig', [
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
        return $this->render('administradores/inicioAdmin.html.twig', [
        ]);
    }

    public function sociosAdmin()
    {
        return $this->render('administradores/sociosAdmin.html.twig', [
        ]);
    }

    public function noticiasAdmin()
    {
        // Obtenemos el gestor de entidades de Doctrine
        $entityManager = $this->getDoctrine()->getManager();
        // obtenemos todas las noticias
        $noticias = $entityManager->getRepository(Noticia::class)->findBy(
            array(),
            array('fecha' => 'DESC')
        );

        return $this->render('administradores/noticiasAdmin.html.twig', array(
            'noticias' => $noticias,
        ));
    }

    public function notificacionesAdmin()
    {
        return $this->render('administradores/notificacionesAdmin.html.twig', [
        ]);
    }

    public function verNoticia($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $noticia = $entityManager->getRepository(Noticia::class)->find($id);
        if (!$noticia) {
            throw $this->createNotFoundException(
                'No existe ninguna noticia con id ' . $id
            );
        }
        return $this->render('verNoticia.html.twig', array(
            'noticia' => $noticia,
        ));
    }

    public function nuevaNoticia(Request $request)
    {
        $noticia = new Noticia();

        $form = $this->createForm(NoticiaType::class, $noticia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imagen */
            $imagen = $form->get('imagen')->getData();
            if ($imagen) {
                $originalFilename = pathinfo($imagen->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $originalFilename;
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imagen->guessExtension();

                try {
                    $imagen->move(
                        $this->getParameter('imagen_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $noticia->setImagen($newFilename);
            }

            $noticia = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($noticia);
            $entityManager->flush();
            return $this->redirectToRoute('noticiasAdmin');
        }

        return $this->render('/administradores/nuevaNoticia.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function borrarNoticia($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $noticia = $entityManager->getRepository(Noticia::class)->find($id);
        if (!$noticia) {
            throw $this->createNotFoundException(
                'No existe ninguna noticia con id ' . $id
            );
        }
        $entityManager->remove($noticia);
        $entityManager->flush();
        return $this->redirectToRoute('noticiasAdmin');
    }

    public function editarNoticia(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $noticia = $entityManager->getRepository(Noticia::class)->find($id);

        if (!$noticia) {
            throw $this->createNotFoundException(
                'No existe ninguna noticia con id ' . $id
            );
        }

        $form = $this->createForm(NoticiaType::class, $noticia);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $noticia = $form->getData();

            $entityManager->flush();
            return $this->redirectToRoute('noticiasAdmin');
        }
        return $this->render('administradores/nuevaNoticia.html.twig', array(
            'form' => $form->createView(),
        ));
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

}
