<?php

namespace App\Entity;

use App\Repository\ComentarioCancionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComentarioCancionRepository::class)]
class ComentarioCancion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Comentario $comentario = null;

    #[ORM\ManyToOne]
    private ?Cancion $cancion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComentario(): ?Comentario
    {
        return $this->comentario;
    }

    public function setComentario(?Comentario $comentario): static
    {
        $this->comentario = $comentario;

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
