<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Cuota;
use App\Entity\Socio;
use App\Form\DocumentoType;

class CuotasController extends AbstractController{

    public function verCuota($idSocio)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $cuota= $entityManager->getRepository(Cuota::class)->findBy(
            array(
                'idSocio' => $idSocio,
            )
        );

        return $this->render('cuotas/verCuota.html.twig', array(
            'cuotas' => $cuota,
        ));
    }

    public function nuevaCuota(Request $request, $idSocio)
    {
        $cuota = new Cuota();
        $entityManager = $this->getDoctrine()->getManager();
        $socio = $entityManager->getRepository(Socio::class)->find($idSocio);

        $cuota->setIdSocio($socio);

        $form = $this->createFormBuilder($cuota)
        ->add('ano', NumberType::class)
        ->add('save', SubmitType::class,
        array('label' => 'Añadir Cuota'))
        ->getForm();



        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cuota = $form->getData();
            
            $entityManager->persist($cuota);
            $entityManager->flush();
            return $this->redirectToRoute('sociosAdmin');
        }

        return $this->render('cuotas/nuevaCuota.html.twig', array(
        'form' => $form->createView(),
        ));
    }

}

?>
