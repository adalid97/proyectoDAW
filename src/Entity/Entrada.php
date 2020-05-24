<?php

namespace App\Entity;

use App\Repository\EntradaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EntradaRepository::class)
 */
class Entrada
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Partido::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $partido;

    /**
     * @ORM\Column(type="integer")
     */
    private $precio;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default" : false})
     */
    private $publico;

    /**
     * @ORM\OneToMany(targetEntity=SolicitudEntrada::class, mappedBy="entrada", orphanRemoval=true)
     */
    private $solicitudEntradas;

    public function __construct()
    {
        $this->solicitudEntradas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPartido(): ?Partido
    {
        return $this->partido;
    }

    public function setPartido(Partido $partido): self
    {
        $this->Partido = $partido;

        return $this;
    }

    public function getPrecio(): ?int
    {
        return $this->precio;
    }

    public function setPrecio(int $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getPublico(): ?bool
    {
        return $this->publico;
    }

    public function setPublico(bool $publico): self
    {
        $this->publico = $publico;

        return $this;
    }

    /**
     * @return Collection|SolicitudEntrada[]
     */
    public function getSolicitudEntradas(): Collection
    {
        return $this->solicitudEntradas;
    }

    public function addSolicitudEntrada(SolicitudEntrada $solicitudEntrada): self
    {
        if (!$this->solicitudEntradas->contains($solicitudEntrada)) {
            $this->solicitudEntradas[] = $solicitudEntrada;
            $solicitudEntrada->setEntrada($this);
        }

        return $this;
    }

    public function removeSolicitudEntrada(SolicitudEntrada $solicitudEntrada): self
    {
        if ($this->solicitudEntradas->contains($solicitudEntrada)) {
            $this->solicitudEntradas->removeElement($solicitudEntrada);
            // set the owning side to null (unless already changed)
            if ($solicitudEntrada->getEntrada() === $this) {
                $solicitudEntrada->setEntrada(null);
            }
        }

        return $this;
    }

}
