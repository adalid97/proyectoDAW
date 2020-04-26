<?php
// COntroller PBetica
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Noticia;
use App\Entity\usuario;
use App\Entity\socio;
use App\Form\NoticiaType;

class Controller extends AbstractController{
    public function index(){
        return $this->render('index.html.twig', [
            ]);
    }

    public function noticias(){
        $entityManager = $this->getDoctrine()->getManager();
        $noticias= $entityManager->getRepository(Noticia::class)->findBy(
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

    public function documentos(){
        return $this->render('documentos.html.twig', [
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
        // Obtenemos el gestor de entidades de Doctrine
        $entityManager = $this->getDoctrine()->getManager();
        // obtenemos todas las noticias
        $noticias= $entityManager->getRepository(Noticia::class)->findBy(
            array(),
            array('fecha' => 'DESC')
        );

        return $this->render('administradores/noticiasAdmin.html.twig', array(
            'noticias' => $noticias,
        )); 
    }

    public function notificacionesAdmin(){
        return $this->render('administradores/notificacionesAdmin.html.twig', [
            ]);
    }

    public function verNoticia($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $noticia= $entityManager->getRepository(Noticia::class)->find($id);
        if (!$noticia){
        throw $this->createNotFoundException(
            'No existe ninguna noticia con id '.$id
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
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imagen->guessExtension();

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
        $noticia= $entityManager->getRepository(Noticia::class)->find($id);
        if (!$noticia){
            throw $this->createNotFoundException(
                'No existe ninguna noticia con id '.$id
        );
        }
        $entityManager->remove($noticia);
        $entityManager->flush();
        return $this->redirectToRoute('noticiasAdmin');
    }

    public function editarNoticia(Request $request, $id)
    {
        // Obtenemos el gestor de entidades de Doctrine
        $entityManager = $this->getDoctrine()->getManager();
        
        // Obtenenemos el repositorio de noticias y buscamos en el usando la i
        $noticia = $entityManager->getRepository(Noticia::class)->find($id);
        
        // Si la noticia no existe lanzamos una excepción.
        if (!$noticia){
            throw $this->createNotFoundException(
                'No existe ninguna noticia con id '.$id
        );
        }
       
        $form = $this->createForm(NoticiaType::class, $noticia);

        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {
            // De esta manera podemos sobreescribir la variable $noticia con l
            $noticia = $form->getData();
        
            // Ejecuta las consultas necesarias (UPDATE en este caso)
            $entityManager->flush();
        
            //Redirigimos a la página de ver la noticia editada.
            return $this->redirectToRoute('noticiasAdmin');
            //return $this->redirectToRoute('verNoticia', array('id'=>$id));
        }
        return $this->render('administradores/nuevaNoticia.html.twig', array(
            'form' => $form->createView(),
        ));    
    }

    public function inicioAreaPrivada(){
        return $this->render('areaPrivada/inicioAreaPrivada.html.twig', [
            ]);
    }

}



?>