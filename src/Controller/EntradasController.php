<?php
namespace App\Controller;

use App\Entity\Entrada;
use App\Entity\Socio;
use App\Entity\SolicitudEntrada;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class EntradasController extends AbstractController
{
    public function entradasAdmin()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entradas = $entityManager->getRepository(Entrada::class)->findAll();
        return $this->render('entradas/listaEntradas.html.twig', array(
            'entradas' => $entradas,
        ));
    }

    public function entradasSocios()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entradas = $entityManager->getRepository(Entrada::class)->findAll();
        return $this->render('entradas/listaEntradas.html.twig', array(
            'entradas' => $entradas,
        ));
    }

    public function solicitudesEntradas($id, $idEntrada)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $solicitudes = $entityManager->getRepository(SolicitudEntrada::class)->findByEntrada($id);
        $entrada = $entityManager->getRepository(Entrada::class)->find($idEntrada);
        $idEntrada = $id;
        return $this->render('entradas/verSolicitudes.html.twig', array(
            'solicitudes' => $solicitudes,
            'idEntrada' => $idEntrada,
            'entrada' => $entrada,
        ));
    }

    public function nuevaEntrada(Request $request)
    {
        $entrada = new Entrada();

        $form = $this->createFormBuilder($entrada)
            ->add('partido')
            ->add('precio')
            ->add('publico')
            ->add('save', SubmitType::class,
                array('label' => 'Añadir Entrada'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entrada = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entrada);
            $entityManager->flush();
            return $this->redirectToRoute('entradasAdmin');
        }

        return $this->render('entradas/nuevaEntrada.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function nuevaSolicitudEntrada(Request $request, $idEntrada, $idSocio)
    {
        $solicitudEntrada = new SolicitudEntrada();
        $entityManager = $this->getDoctrine()->getManager();

        $socio = $entityManager->getRepository(Socio::class)->find($idSocio);
        $entrada = $entityManager->getRepository(Entrada::class)->find($idEntrada);
        $solicitudes = $entityManager->getRepository(SolicitudEntrada::class)->findAll();
        $repetido = false;
        for ($i = 0; $i < count($solicitudes); ++$i) {
            if ($solicitudes[$i]->getSocio() == $socio && $solicitudes[$i]->getEntrada() == $entrada) {
                $this->addFlash('error', 'Ya estabas inscrito para este partido. Si tienes alguna duda, ponte en contacto con la Directiva de la Peña.');
                $repetido = true;
                $i = count($solicitudes);
            }
        }
        if ($repetido == false) {
            $solicitudEntrada->setSocio($socio);
            $solicitudEntrada->setEntrada($entrada);
            $entityManager->persist($solicitudEntrada);
            $entityManager->flush();
            $this->addFlash('success', 'Te has inscrito correctamente a este partido. Comprueba que tu teléfono es el correcto, en los próximos días nos pondremos en contacto contigo.');
        }

        return $this->redirectToRoute('entradasSocios');
    }

    public function verEntrada($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entrada = $entityManager->getRepository(Entrada::class)->find($id);
        return $this->render('entradas/verPartido.html.twig', array(
            'entrada' => $entrada,
        ));
    }

    public function editarEntrada(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entrada = $entityManager->getRepository(Entrada::class)->find($id);

        $form = $this->createFormBuilder($entrada)
            ->add('partido')
            ->add('precio')
            ->add('publico')
            ->add('save', SubmitType::class,
                array('label' => 'Editar Entrada'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $noticia = $form->getData();
            $entityManager->flush();
            $this->addFlash('success', 'Editado correctamente!');
            return $this->redirectToRoute('entradasAdmin');
        }
        return $this->render('entradas/nuevaEntrada.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}
