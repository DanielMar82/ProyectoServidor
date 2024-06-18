<?php

namespace App\Entity;

use App\Repository\ComentarioProductoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComentarioProductoRepository::class)]
class ComentarioProducto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Comentario $comentario = null;

    #[ORM\ManyToOne]
    private ?Producto $producto = null;

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

    public function getProducto(): ?Producto
    {
        return $this->producto;
    }

    public function setProducto(?Producto $producto): static
    {
        $this->producto = $producto;

        return $this;
    }
}
