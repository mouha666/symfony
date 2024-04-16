<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\IngredientRepository;


#[ORM\Entity(repositoryClass:IngredientRepository::class)]
class Ingredient
{
    
    #[ORM\Id] 
    #[ORM\GeneratedValue]
    #[ORM\Column] 
    private ?int $id;

    #[ORM\Column]
    private ?int $recetteId;

    #[ORM\Column]
    private ?int $quantity;

    #[ORM\Column(length:250)]
    private ?string $name;

    #[ORM\Column]
    private ?int $calories;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecetteId(): ?int
    {
        return $this->recetteId;
    }

    public function setRecetteId(int $recetteId): static
    {
        $this->recetteId = $recetteId;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
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

    public function getCalories(): ?int
    {
        return $this->calories;
    }

    public function setCalories(int $calories): static
    {
        $this->calories = $calories;

        return $this;
    }


}