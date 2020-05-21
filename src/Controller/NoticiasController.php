<?php
// COntroller PBetica
namespace App\Controller;

use App\Entity\Noticia;
use App\Form\NoticiaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class NoticiasController extends AbstractController
{

    public function noticias()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $noticias = $entityManager->getRepository(Noticia::class)->findBy(
            array(),
            array('fecha' => 'DESC')
        );

        return $this->render('noticias/noticias.html.twig', array(
            'noticias' => $noticias,
        ));
    }

    public function noticiasSocios()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $noticias = $entityManager->getRepository(Noticia::class)->findBy(
            array(),
            array('fecha' => 'DESC')
        );

        return $this->render('noticias/noticiasSocios.html.twig', array(
            'noticias' => $noticias,
        ));
    }

    public function noticiasAdmin()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $noticias = $entityManager->getRepository(Noticia::class)->findBy(
            array(),
            array('fecha' => 'DESC')
        );

        return $this->render('administradores/noticiasAdmin.html.twig', array(
            'noticias' => $noticias,
        ));
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
        return $this->render('noticias/verNoticia.html.twig', array(
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
            $this->addFlash('success', 'Noticia agregada correctamente.');
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
}
