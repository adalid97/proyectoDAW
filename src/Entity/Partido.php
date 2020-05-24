<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartidoRepository")
 */
class Partido
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $estadio;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\Column(type="time")
     */
    private $hora;

    /**
     * @ORM\Column(type="time")
     */
    private $horaAperturaSede;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipo")
     */
    private $idEquipoLocal;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipo")
     */
    private $idEquipoVisitante;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEstadio(): ?string
    {
        return $this->estadio;
    }

    public function setEstadio(string $estadio): self
    {
        $this->estadio = $estadio;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getHora(): ?\DateTimeInterface
    {
        return $this->hora;
    }

    public function setHora(\DateTimeInterface $hora): self
    {
        $this->hora = $hora;

        return $this;
    }

    public function getHoraAperturaSede(): ?\DateTimeInterface
    {
        return $this->horaAperturaSede;
    }

    public function setHoraAperturaSede(\DateTimeInterface $horaAperturaSede): self
    {
        $this->horaAperturaSede = $horaAperturaSede;

        return $this;
    }

    public function getIdEquipoLocal(): ?Equipo
    {
        return $this->idEquipoLocal;
    }

    public function setIdEquipoLocal(?Equipo $idEquipoLocal): self
    {
        $this->idEquipoLocal = $idEquipoLocal;

        return $this;
    }

    public function getIdEquipoVisitante(): ?Equipo
    {
        return $this->idEquipoVisitante;
    }

    public function setIdEquipoVisitante(?Equipo $idEquipoVisitante): self
    {
        $this->idEquipoVisitante = $idEquipoVisitante;

        return $this;
    }

    public function __toString()
    {
        return $this->idEquipoLocal . " - " . $this->idEquipoVisitante;
    }
}
