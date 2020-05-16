<?php
namespace App\Controller;

use App\Entity\Equipo;
use App\Entity\Partido;
use App\Form\EquipoType;
use App\Form\PartidoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PartidosController extends AbstractController
{

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
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $escudo->guessExtension();

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

    public function partidos()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $partidos = $entityManager->getRepository(Partido::class)->findBy(
            array(),
            array('fecha' => 'ASC')
        );
        return $this->render('partidos/partidos.html.twig', array(
            'partidos' => $partidos,
        ));
    }

    public function partido()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $partidos = $entityManager->getRepository(Partido::class)->findOneBy(
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
            $this->addFlash('success', 'Partido agregado correctamente!');
            return $this->redirectToRoute('partidosAdmin');

        }

        return $this->render('partidos/nuevoPartido.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function borrarPartido($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $partido = $entityManager->getRepository(Partido::class)->find($id);
        if (!$partido) {
            throw $this->createNotFoundException(
                'No existe ningún partido con id ' . $id
            );
        }
        $entityManager->remove($partido);
        $entityManager->flush();
        $this->addFlash('success', 'Partido borrado correctamente!');
        return $this->redirectToRoute('partidosAdmin');
    }

    public function listaEquipos()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $equipos = $entityManager->getRepository(Equipo::class)->findBy(
            array(),
            array('nombre' => 'ASC')
        );
        return $this->render('partidos/listaEquipos.html.twig', array(
            'equipos' => $equipos,
        ));
    }

    public function borrarEquipo($id)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $equipo = $entityManager->getRepository(Equipo::class)->find($id);

        $entityManager->remove($equipo);
        $entityManager->flush();
        return $this->redirectToRoute('listaEquipos');

    }

}
