<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\PlannificationRepository;
#[ORM\Entity(repositoryClass: PlannificationRepository::class)]
class Planification
{    
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("plannification")]
    private ?int $id = null;
    
    #[ORM\Column(type: 'integer')]
    private int $userId;

    #[ORM\Column(type: 'string', length: 20)]
    private string $day;

    #[ORM\Column(type: 'string', length: 20)]
    private string $meal;

    #[ORM\Column(type: 'boolean')]
    private bool $inDiet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): static
    {
        $this->day = $day;

        return $this;
    }

    public function getMeal(): ?string
    {
        return $this->meal;
    }

    public function setMeal(string $meal): static
    {
        $this->meal = $meal;

        return $this;
    }

    public function isInDiet(): ?bool
    {
        return $this->inDiet;
    }

    public function setInDiet(bool $inDiet): static
    {
        $this->inDiet = $inDiet;

        return $this;
    }


}