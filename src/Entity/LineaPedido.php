<?php

namespace App\Entity;

use App\Repository\LineaPedidoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LineaPedidoRepository::class)]
class LineaPedido
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'lineasPedidos', targetEntity: Producto::class)]
    private Collection $productos;

    #[ORM\ManyToOne(inversedBy: 'lineaPedidos')]
    private ?Pedido $pedidos = null;

    #[ORM\ManyToOne]
    private ?Producto $producto = null;

    public function __construct()
    {
        $this->productos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Producto>
     */
    public function getProductos(): Collection
    {
        return $this->productos;
    }

    public function addProducto(Producto $producto): static
    {
        if (!$this->productos->contains($producto)) {
            $this->productos->add($producto);
            $producto->setLineasPedidos($this);
        }

        return $this;
    }

    public function removeProducto(Producto $producto): static
    {
        if ($this->productos->removeElement($producto)) {
            // set the owning side to null (unless already changed)
            if ($producto->getLineasPedidos() === $this) {
                $producto->setLineasPedidos(null);
            }
        }

        return $this;
    }

    public function getPedidos(): ?Pedido
    {
        return $this->pedidos;
    }

    public function setPedidos(?Pedido $pedidos): static
    {
        $this->pedidos = $pedidos;

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
