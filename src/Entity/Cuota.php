<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CuotaRepository")
 */
class Cuota
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $ano;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Socio", inversedBy="cuotas")
     */
    private $idSocio;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default" : false})
     */
    private $enero;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default" : false})
     */
    private $febrero;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default" : false})
     */
    private $marzo;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default" : false})
     */
    private $abril;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default" : false})
     */
    private $mayo;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default" : false})
     */
    private $junio;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default" : false})
     */
    private $julio;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default" : false})
     */
    private $agosto;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default" : false})
     */
    private $septiembre;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default" : false})
     */
    private $octubre;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default" : false})
     */
    private $noviembre;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default" : false})
     */
    private $diciembre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAno(): ?int
    {
        return $this->ano;
    }

    public function setAno(int $ano): self
    {
        $this->ano = $ano;

        return $this;
    }

    public function getIdSocio(): ?Socio
    {
        return $this->idSocio;
    }

    public function setIdSocio(?Socio $idSocio): self
    {
        $this->idSocio = $idSocio;

        return $this;
    }

    public function getEnero(): ?bool
    {
        return $this->enero;
    }

    public function setEnero(bool $enero): self
    {
        $this->enero = $enero;

        return $this;
    }

    public function getFebrero(): ?bool
    {
        return $this->febrero;
    }

    public function setFebrero(bool $febrero): self
    {
        $this->febrero = $febrero;

        return $this;
    }

    public function getMarzo(): ?bool
    {
        return $this->marzo;
    }

    public function setMarzo(bool $marzo): self
    {
        $this->marzo = $marzo;

        return $this;
    }

    public function getAbril(): ?bool
    {
        return $this->abril;
    }

    public function setAbril(bool $abril): self
    {
        $this->abril = $abril;

        return $this;
    }

    public function getMayo(): ?bool
    {
        return $this->mayo;
    }

    public function setMayo(bool $mayo): self
    {
        $this->mayo = $mayo;

        return $this;
    }

    public function getJunio(): ?bool
    {
        return $this->junio;
    }

    public function setJunio(bool $junio): self
    {
        $this->junio = $junio;

        return $this;
    }

    public function getJulio(): ?bool
    {
        return $this->julio;
    }

    public function setJulio(bool $julio): self
    {
        $this->julio = $julio;

        return $this;
    }

    public function getAgosto(): ?bool
    {
        return $this->agosto;
    }

    public function setAgosto(bool $agosto): self
    {
        $this->agosto = $agosto;

        return $this;
    }

    public function getSeptiembre(): ?bool
    {
        return $this->septiembre;
    }

    public function setSeptiembre(bool $septiembre): self
    {
        $this->septiembre = $septiembre;

        return $this;
    }

    public function getOctubre(): ?bool
    {
        return $this->octubre;
    }

    public function setOctubre(bool $octubre): self
    {
        $this->octubre = $octubre;

        return $this;
    }

    public function getNoviembre(): ?bool
    {
        return $this->noviembre;
    }

    public function setNoviembre(bool $noviembre): self
    {
        $this->noviembre = $noviembre;

        return $this;
    }

    public function getDiciembre(): ?bool
    {
        return $this->diciembre;
    }

    public function setDiciembre(bool $diciembre): self
    {
        $this->diciembre = $diciembre;

        return $this;
    }
}
