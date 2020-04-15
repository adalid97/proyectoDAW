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
        $usuario->setNombre('Admin');
        $usuario->setApellidos('Admin');
        $usuario->setLocalidad('Fuentes de Andalucia');
        $usuario->setRoles(array('ROLE_ADMIN'));
        $usuario->setUsername('admin');
        $usuario->setPassword($this->passwordEncoder->encodePassword($usuario,'admin'));
        $manager->persist($usuario);

        $manager->flush();
    }
}
