<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\recetteRepository;

#[ORM\Entity(repositoryClass: recetteRepository::class)]


class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("recette")]
    private ?int $id ;
    

    #[ORM\Column(length: 30, type: 'string')]
    #[Groups("recette")]
    private ?string $titre;


    #[ORM\Column(type: 'integer')]
    #[Groups("recette")]
    private ?Integer $rate = null;


    #[ORM\Column(length: 30, type: 'string')]
    #[Groups("recette")]
    private ?string $content;


    #[ORM\Column(type: 'integer')]
    #[Groups("recette")]
    private ?Integer $userId = null;


    #[ORM\Column(type: 'integer')]
    #[Groups("recette")]
    private ?Integer $ingredientId = null;


    #[ORM\Column(type: 'string')]
    #[Groups("recette")]
    private ?string $category;


    #[ORM\Column(length: 255, type: 'string')]
    #[Groups("recette")]
    private ?string $imagepath = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(?int $rate): static
    {
        $this->rate = $rate;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getIngredientId(): ?int
    {
        return $this->ingredientId;
    }

    public function setIngredientId(?int $ingredientId): static
    {
        $this->ingredientId = $ingredientId;

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

    public function getImagepath(): ?string
    {
        return $this->imagepath;
    }

    public function setImagepath(?string $imagepath): static
    {
        $this->imagepath = $imagepath;

        return $this;
    }


}