<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Partido;
use App\Entity\Equipo;
use App\Form\EquipoType;
use App\Form\PartidoType;

class PartidosController extends AbstractController{

    public function nuevoEquipo(Request $request)
    {
        $equipo = new Equipo();

        $form = $this->createForm(EquipoType::class, $equipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $escudo */
            $escudo = $form->get('escudo')->getData();
            if ($escudo) {
                $originalFilename = pathinfo($escudo->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $originalFilename;
                $newFilename = $safeFilename.'-'.uniqid().'.'.$escudo->guessExtension();

                try {
                    $escudo->move(
                        $this->getParameter('equipos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $equipo->setEscudo($newFilename);
            }

            $equipo = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($equipo);
            $entityManager->flush();
            return $this->redirectToRoute('partidosAdmin');
        }

        return $this->render('partidos/nuevoEquipo.html.twig', array(
            'form' => $form->createView(),
            ));
    }

    public function partidos(){
        $entityManager = $this->getDoctrine()->getManager();
        $partidos= $entityManager->getRepository(Partido::class)->findBy(
            array(),
            array('fecha' => 'ASC')
        );
        return $this->render('partidos/partidos.html.twig', array(
            'partidos' => $partidos,
        )); 
    }   

    public function partido(){
        $entityManager = $this->getDoctrine()->getManager();
        $partidos= $entityManager->getRepository(Partido::class)->findOneBy(
            array(),
            array('fecha' => 'ASC')
        );
        return $this->render('partidos/partido.html.twig', array(
            'partidos' => $partidos,
        )); 
    }   

    public function nuevoPartido(Request $request)
    {
        $partido = new Partido();

        $form = $this->createForm(PartidoType::class, $partido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $partido = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($partido);
            $entityManager->flush();
            return $this->redirectToRoute('partidosAdmin');
            
        }

        return $this->render('partidos/nuevoPartido.html.twig', array(
            'form' => $form->createView(),
            ));
    }


    
    /* public function listaDocumentos()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $documento= $entityManager->getRepository(Documento::class)->findBy(
            array(),
            array('fecha' => 'DESC')
        );
        return $this->render('documentos/documentos.html.twig', array(
            'documentos' => $documento,
        ));
    }

    public function documentosAdmin()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $documento= $entityManager->getRepository(Documento::class)->findBy(
            array(),
            array('fecha' => 'DESC')
        );
        return $this->render('documentos/documentosAdmin.html.twig', array(
            'documentos' => $documento,
        ));
    }

    public function documentosSocios()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $documento= $entityManager->getRepository(Documento::class)->findBy(
            array(),
            array('fecha' => 'DESC')
        );
        return $this->render('documentos/documentosSocios.html.twig', array(
            'documentos' => $documento,
        ));
    }

    public function borrarDocumento($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $documento= $entityManager->getRepository(Documento::class)->find($id);
        $entityManager->remove($documento);
        $entityManager->flush();
        return $this->redirectToRoute('documentosAdmin');
    } */

}

?>
