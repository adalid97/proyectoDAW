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

        $usuario1 = new Usuario();
        $usuario1->setNombre('Socio');
        $usuario1->setApellidos('Socio 1');
        $usuario1->setLocalidad('Fuentes de Andalucia');
        $usuario1->setRoles(array('ROLE_USER'));
        $usuario1->setUsername('socio1');
        $usuario1->setPassword($this->passwordEncoder->encodePassword($usuario,'1234'));
        $manager->persist($usuario1);

        $manager->flush();
    }
}
