<?php
namespace App\Controller;

use App\Entity\Cuota;
use App\Entity\Socio;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class CuotasController extends AbstractController
{

    public function verCuota($idSocio)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $cuota = $entityManager->getRepository(Cuota::class)->findBy(
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

    public function nuevoAño(Request $request)
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

    public function editarCuota(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $cuota = $entityManager->getRepository(Cuota::class)->find($id);
        $socio = $cuota->getIdSocio()->getId();
        $form = $this->createFormBuilder($cuota)
            ->add('enero', CheckboxType::class, [
                'required' => false,
            ])
            ->add('febrero', CheckboxType::class, [
                'required' => false,
            ])
            ->add('marzo', CheckboxType::class, [
                'required' => false,
            ])
            ->add('abril', CheckboxType::class, [
                'required' => false,
            ])
            ->add('mayo', CheckboxType::class, [
                'required' => false,
            ])
            ->add('junio', CheckboxType::class, [
                'required' => false,
            ])
            ->add('julio', CheckboxType::class, [
                'required' => false,
            ])
            ->add('agosto', CheckboxType::class, [
                'required' => false,
            ])
            ->add('septiembre', CheckboxType::class, [
                'required' => false,
            ])
            ->add('octubre', CheckboxType::class, [
                'required' => false,
            ])
            ->add('noviembre', CheckboxType::class, [
                'required' => false,
            ])
            ->add('diciembre', CheckboxType::class, [
                'required' => false,
            ])
            ->add('save', SubmitType::class, array('label' => 'Editar Cuota'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $noticia = $form->getData();
            $entityManager->flush();
            return $this->redirectToRoute('verCuota', array('idSocio' => $socio));
        }
        return $this->render('cuotas/editarCuota.html.twig', array(
            'form' => $form->createView(),
            'cuota' => $cuota,
        ));
    }

    public function anoCompletoCuota(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $cuota = $entityManager->getRepository(Cuota::class)->find($id);

        $cuota->setEnero(true);
        $cuota->setFebrero(true);
        $cuota->setMarzo(true);
        $cuota->setAbril(true);
        $cuota->setMayo(true);
        $cuota->setJunio(true);
        $cuota->setJulio(true);
        $cuota->setAgosto(true);
        $cuota->setSeptiembre(true);
        $cuota->setOctubre(true);
        $cuota->setNoviembre(true);
        $cuota->setDiciembre(true);
        $entityManager->persist($cuota);
        $entityManager->flush();

        $socio = $cuota->getIdSocio()->getId();

        return $this->redirectToRoute('verCuota', array('idSocio' => $socio));

    }

    public function seisMesesCuota(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $cuota = $entityManager->getRepository(Cuota::class)->find($id);

        if ($cuota->getEnero() == false) {
            $cuota->setEnero(true);
            $cuota->setFebrero(true);
            $cuota->setMarzo(true);
            $cuota->setAbril(true);
            $cuota->setMayo(true);
            $cuota->setJunio(true);
        } else if ($cuota->getJulio() == false) {
            $cuota->setJulio(true);
            $cuota->setAgosto(true);
            $cuota->setSeptiembre(true);
            $cuota->setOctubre(true);
            $cuota->setNoviembre(true);
            $cuota->setDiciembre(true);
        }

        $entityManager->persist($cuota);
        $entityManager->flush();

        $socio = $cuota->getIdSocio()->getId();

        return $this->redirectToRoute('verCuota', array('idSocio' => $socio));

    }
}
