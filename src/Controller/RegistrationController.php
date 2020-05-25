<?php

namespace App\Controller;

use App\Entity\Socio;
use App\Entity\Usuario;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
    {
        $user = new Usuario();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $form->get('dni')->getData();
            $codigoRegistro = $form->get('codigoRegistro')->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $socio = $entityManager->getRepository(Socio::class)->findOneByDni($form->get('dni')->getData());
            $username = $entityManager->getRepository(Usuario::class)->findOneByUsername($form->get('username')->getData());

            if ($socio == null) {
                $this->addFlash('error', 'El DNI no pertenece a ningún socio de la Peña. Por favor, póngase en contacto con la Directiva de la Peña');
            } elseif ($username != null) {
                $this->addFlash('error', 'El usuario ya existe, por favor escribe otro distinto.');
            } elseif ($codigoRegistro != $_ENV['CLAVEREGISTRO']) {
                $this->addFlash('error', 'El código de registro no es correcto.');
            } else {
                try {
                    $user->setSocio($socio);

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($user);
                    $entityManager->flush();
                    return $guardHandler->authenticateUserAndHandleSuccess(
                        $user,
                        $request,
                        $authenticator,
                        'main' // firewall name in security.yaml
                    );
                } catch (UniqueConstraintViolationException $e) {
                    $this->addFlash('error', 'El DNI ya está registrado');
                }

            }
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
