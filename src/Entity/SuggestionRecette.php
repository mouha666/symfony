<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\SuggestionRecetteRepository;


#[ORM\Entity(repositoryClass: SuggestionRecetteRepository::class)]
class SuggestionRecette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("SuggestionRecette")]
    private ?int $idRecetteFamille = null;
    

    #[ORM\Column(type: 'string', length: 255)]
    private string $ingredientsUser;

    #[ORM\Column(type: 'integer')]
    private ?int $rating=null;

    public function getIdRecetteFamille(): ?int
    {
        return $this->idRecetteFamille;
    }

    public function getIngredientsUser(): ?string
    {
        return $this->ingredientsUser;
    }

    public function setIngredientsUser(string $ingredientsUser): static
    {
        $this->ingredientsUser = $ingredientsUser;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): static
    {
        $this->rating = $rating;

        return $this;
    }


}