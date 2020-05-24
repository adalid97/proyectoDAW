<?php

namespace App\Entity;

use App\Repository\SolicitudEntradaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SolicitudEntradaRepository::class)
 */
class SolicitudEntrada
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Socio::class, inversedBy="solicitudEntradas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $socio;

    /**
     * @ORM\ManyToOne(targetEntity=Entrada::class, inversedBy="solicitudEntradas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $entrada;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSocio(): ?Socio
    {
        return $this->socio;
    }

    public function setSocio(?Socio $socio): self
    {
        $this->socio = $socio;

        return $this;
    }

    public function getEntrada(): ?Entrada
    {
        return $this->entrada;
    }

    public function setEntrada(?Entrada $entrada): self
    {
        $this->entrada = $entrada;

        return $this;
    }
}
