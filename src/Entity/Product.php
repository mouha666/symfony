<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Assert\NotBlank(message: 'The Name cannot be blank')]
    #[ORM\Column(length: 255)]
    private ?string $name;

    #[Assert\NotBlank(message: 'The Price cannot be blank')]
    #[Assert\Type(type: 'integer', message: 'The Price must be an integer')]
    #[ORM\Column(type: 'integer')]
    private $price;

    #[Assert\NotBlank(message: 'The Fabrication date cannot be blank')]
    #[ORM\Column(length: 255)]
    private ?string $datefabrication;

    #[Assert\NotBlank(message: 'The quantity cannot be blank')]
    #[Assert\Type(type: 'integer', message: 'The Price must be an integer')]
    #[ORM\Column(type: 'integer')]
    private $quantite;

    #[Assert\NotBlank(message: 'The likes cannot be blank')]
    #[Assert\Type(type: 'integer', message: 'The Price must be an integer')]
    #[ORM\Column(type: 'integer')]
    private $likes;

    #[Assert\NotBlank(message: 'The Image  cannot be blank')]
    #[ORM\Column(length:255)]
    private ?string $image = 'NULL';

    #[Assert\NotBlank(message: 'The Category cannot be blank')]
    #[ORM\Column(length: 255)]
    private ?string $category;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: CommandProduct::class)]
    private Collection $command ;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->command = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDatefabrication(): ?string
    {
        return $this->datefabrication;
    }

    public function setDatefabrication(string $datefabrication): static
    {
        $this->datefabrication = $datefabrication;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): static
    {
        $this->likes = $likes;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Command>
     */
    public function getCommand(): Collection
    {
        return $this->command;
    }

    public function addCommand(Command $command): static
    {
        if (!$this->command->contains($command)) {
            $this->command->add($command);
            $command->addProduct($this);
        }

        return $this;
    }

    public function removeCommand(Command $command): static
    {
        if ($this->command->removeElement($command)) {
            $command->removeProduct($this);
        }

        return $this;
    }
    public function __toString(): string
    {
        return (string) $this->getId(); // or $this->name if you have a name field
    }

}
