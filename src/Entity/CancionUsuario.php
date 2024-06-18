<?php

namespace App\Entity;

use App\Repository\CancionUsuarioRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CancionUsuarioRepository::class)]
class CancionUsuario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?Usuario $usuario = null;

    #[ORM\ManyToOne]
    private ?Cancion $cancion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getCancion(): ?Cancion
    {
        return $this->cancion;
    }

    public function setCancion(?Cancion $cancion): static
    {
        $this->cancion = $cancion;

        return $this;
    }
}
