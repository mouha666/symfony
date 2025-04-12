<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandProductRepository;
#[ORM\Entity(repositoryClass: CommandProductRepository::class)]
#[ORM\Table(name: 'command_products')]
class CommandProduct
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Command::class, inversedBy: 'products')]
    #[ORM\JoinColumn(name: 'command_id', referencedColumnName: 'id')]
    private ?Command $command = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'commands')]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id')]
    private ?Product $product = null;

    #[ORM\Column(type: 'integer')]
    private int $quantity;

    public function getCommand(): ?Command
    {
        return $this->command;
    }

    public function setCommand(?Command $command): self
    {
        $this->command = $command;
        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }
}
