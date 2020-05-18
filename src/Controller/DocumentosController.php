<?php
namespace App\Controller;

use App\Entity\Documento;
use App\Form\DocumentoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class DocumentosController extends AbstractController
{

    public function nuevoDocumento(Request $request)
    {
        $documento = new Documento();

        $documento->setFecha(new \DateTime('now'));

        $form = $this->createForm(DocumentoType::class, $documento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $fichero */
            $fichero = $form->get('fichero')->getData();
            if ($fichero) {
                $originalFilename = pathinfo($fichero->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $originalFilename;
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $fichero->guessExtension();

                try {
                    $fichero->move(
                        $this->getParameter('documento_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $documento->setFichero($newFilename);
            }

            $documento = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($documento);
            $entityManager->flush();
            $this->addFlash('success', 'El fichero se ha subido correctamente!');
            return $this->redirectToRoute('documentosAdmin');
        }

        return $this->render('documentos/nuevoDocumento.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function listaDocumentos()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $documento = $entityManager->getRepository(Documento::class)->findBy(
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
        $documento = $entityManager->getRepository(Documento::class)->findBy(
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
        $documento = $entityManager->getRepository(Documento::class)->findBy(
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
        $documento = $entityManager->getRepository(Documento::class)->find($id);
        $entityManager->remove($documento);
        $entityManager->flush();
        $this->addFlash('success', 'Documento borrado correctamente!');
        return $this->redirectToRoute('documentosAdmin');
    }

}
