<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Usuario;

class UsuarioFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $usuario = new Usuario();
        $usuario->setRoles(array('ROLE_ADMIN'));
        $usuario->setUsername('admin');
        $usuario->setPassword($this->passwordEncoder->encodePassword($usuario,'admin'));
        $manager->persist($usuario);

        $usuario1 = new Usuario();
        $usuario1->setRoles(array('ROLE_USER'));
        $usuario1->setUsername('usuario');
        $usuario1->setPassword($this->passwordEncoder->encodePassword($usuario,'usuario'));
        $manager->persist($usuario1);

        $manager->flush();
    }
}
