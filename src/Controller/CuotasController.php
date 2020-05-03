<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Cuota;
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
        
        if (!$cuota){
            throw $this->createNotFoundException(
                'No existe ninguna cuota con id '.$idSocio
            );
        }

        return $this->render('cuotas/verCuota.html.twig', array(
            'cuotas' => $cuota,
        ));
    }

}

?>
