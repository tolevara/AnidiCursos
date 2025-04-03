<?php

namespace App\Entity;

use App\Repository\CursosRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CursosRepository::class)]
class Cursos
{
    // Esta es la clave principal Tabla Relacionada
    #[ORM\Id]
    #[ORM\Column(length: 50)]
    private ?string $expediente = null;

    #[ORM\Column(length: 50)]
    private ?string $denominacion = null;
    
    #[ORM\ManyToOne(inversedBy: 'Aulas')]
    #[ORM\JoinColumn(nullable: false, name: 'codAula', 
    referencedColumnName: 'codigo')]
    private ?Aulas $codAula = null;



    public function getExpediente(): ?string
    {
        return $this->expediente;
    }

    public function setExpediente(string $expediente): static
    {
        $this->expediente = $expediente;

        return $this;
    }

    public function getDenominacion(): ?string
    {
        return $this->denominacion;
    }

    public function setDenominacion(string $denominacion): static
    {
        $this->denominacion = $denominacion;

        return $this;
    }

    public function getCodAula(): ?Aulas
    {
        return $this->codAula;
    }

    public function setCodAula(?Aulas $codAula): static
    {
        $this->codAula = $codAula;

        return $this;
    }
}
