<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ConseilRepository;
use Symfony\Component\Serializer\Annotation\Groups;
#[ORM\Entity(repositoryClass: ConseilRepository::class)]
class Conseil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("Conseil")]
    private ?int $id;
    
    #[ORM\Column(type: 'string', length: 255)]
    private string $content;

    #[ORM\Column(type: 'integer')]
    private ?int $userId = null;

    #[ORM\Column(type: 'string', length: 50)]
    private string $title;

    #[ORM\Column(type: 'string', length: 50)]
    private string $categorie;

    #[ORM\Column(type: "integer")]
    private ?int $liking = null;
    public function getId(): ?int
    {
        return $this->id;
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getLiking(): ?int
    {
        return $this->liking;
    }

    public function setLiking(?int $liking): static
    {
        $this->liking = $liking;

        return $this;
    }


}