<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReminderWaterRepository;


#[ORM\Entity(repositoryClass:ReminderWaterRepository::class)]
class ReminderWater
{
    #[ORM\Id] 
    #[ORM\GeneratedValue]
    #[ORM\Column] 
    private ?int $id;

    #[ORM\Column] 
    private ?int $reminder;

    #[ORM\Column(length:250)]
    private ?string $activity;

    #[ORM\Column(length:250)]
    private ?string $climate;

    #[ORM\Column(length:250)]
    private ?string $personalGoal;

    #[ORM\Column] 
    private $dailyWaterGoal;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReminder(): ?int
    {
        return $this->reminder;
    }

    public function setReminder(int $reminder): static
    {
        $this->reminder = $reminder;

        return $this;
    }

    public function getActivity(): ?string
    {
        return $this->activity;
    }

    public function setActivity(?string $activity): static
    {
        $this->activity = $activity;

        return $this;
    }

    public function getClimate(): ?string
    {
        return $this->climate;
    }

    public function setClimate(string $climate): static
    {
        $this->climate = $climate;

        return $this;
    }

    public function getPersonalGoal(): ?string
    {
        return $this->personalGoal;
    }

    public function setPersonalGoal(string $personalGoal): static
    {
        $this->personalGoal = $personalGoal;

        return $this;
    }

    public function getDailyWaterGoal(): ?int
    {
        return $this->dailyWaterGoal;
    }

    public function setDailyWaterGoal(?int $dailyWaterGoal): static
    {
        $this->dailyWaterGoal = $dailyWaterGoal;

        return $this;
    }


}