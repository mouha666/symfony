<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\UsersRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints\Length;

#[ORM\Entity(repositoryClass:UsersRepository::class)]
class User 
{
    public const GENDER_FEMALE = 'femme';
    public const GENDER_MALE = 'homme';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("users")]
    private ?int $id;

    #[Assert\NotBlank(message: 'The Name cannot be blank')]
    #[Assert\Length(max: 30, maxMessage: 'The first name cannot be longer than {{ limit }} characters')]
    #[Assert\Regex(pattern: '/^[a-zA-Z]*$/', message: 'The first name must contain only alphabetic characters')]
    #[ORM\Column(length: 30, type: 'string')]
    #[Groups("users")]
    private ?string $name = null;

    #[Assert\NotBlank(message: 'The Email cannot be blank')]
    #[Assert\Email(message: 'Please enter a valid email address')]
    #[ORM\Column(length: 50, type: 'string')]
    #[Groups("users")]
    private ?string $email;

    #[Assert\NotBlank(message: 'The Phone Number cannot be blank')]
    #[Assert\Length(
        min: 8,
        max: 8,
        exactMessage: 'Your Phone number must be exactly 8 numbers'
    )]
    #[ORM\Column(type: 'integer')]
    #[Groups("users")]
    private ?int $phonenum = null;

    
    #[ORM\Column(type:'string', length: 10)]
    #[Assert\Choice(choices: [self::GENDER_FEMALE, self::GENDER_MALE])]
    #[Groups("users")]
    private ?string $gender;

    #[Assert\NotBlank(message: 'The Adresse cannot be blank')]
    #[ORM\Column(type:'string', length: 100)]
    #[Groups("users")]
    private ?string $adresse = null;

    #[Assert\NotBlank(message: 'The Age cannot be blank')]
    #[ORM\Column(type:'integer')]
    #[Groups("users")]
    private ?int $age;

    #[Assert\NotBlank(message: 'The Password cannot be blank')]
    #[Assert\Regex(pattern: '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', message: 'Please enter a password that contains At least one lowercase letter ,  At least one uppercase letter ,At least one digit,  At least one special character among @$!%*?& with a minimum length of 8 characters ')]
    #[ORM\Column(length: 30, type: 'string')]
    #[Groups("users")]
    private ?string $password;

    
    #[ORM\Column(type: 'date')]
    #[Groups("users")]
    private ?\DateTimeInterface $joindate;

    
    #[ORM\Column(length: 30, type: 'string')]
    #[Groups("users")]
    private ?string $role;

    #[Assert\NotBlank(message: 'The Height cannot be blank')]
    #[Assert\Regex(pattern: '/^\d+$/', message: 'Only numbers are allowed')]
    #[ORM\Column]
    #[Groups("users")]
    private ?float $height = null;

    #[Assert\NotBlank(message: 'The Weight cannot be blank')]
    #[ORM\Column]
    #[Groups("users")]
    private ?float $weight = null;

    
    #[ORM\Column(type: 'integer')]
    #[Groups("users")]
    private ?int $recetteId;

    
    #[ORM\Column(type: 'integer')]
    #[Groups("users")]
    private ?int $conseilId;

    #[ORM\Column(type: 'integer')]
    #[Groups("users")]
    private ?int $feedbackId;

    #[ORM\Column(length: 100, type: 'string')]
    #[Groups("users")]
    private ?string $recoveryCode=null;

    private $passwordEncoder;
    
    public function __construct()
    {
        
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhonenum(): ?int
    {
        return $this->phonenum;
    }

    public function setPhonenum(int $phonenum): static
    {
        $this->phonenum = $phonenum;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getJoindate(): ?\DateTimeInterface
    {
        return $this->joindate;
    }

    public function setJoindate(\DateTimeInterface $joindate): static
    {
        $this->joindate = $joindate;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    public function setHeight(float $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): static
    {
        $this->weight = $weight;

        return $this;
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

    public function getConseilId(): ?int
    {
        return $this->conseilId;
    }

    public function setConseilId(int $conseilId): static
    {
        $this->conseilId = $conseilId;

        return $this;
    }

    public function getFeedbackId(): ?int
    {
        return $this->feedbackId;
    }

    public function setFeedbackId(int $feedbackId): static
    {
        $this->feedbackId = $feedbackId;

        return $this;
    }

    public function getRecoveryCode(): ?string
    {
        return $this->recoveryCode;
    }

    public function setRecoveryCode(?string $recoveryCode): static
    {
        $this->recoveryCode = $recoveryCode;

        return $this;
    }
    public function getUserIdentifier()
    {
        return $this->id; // Assuming 'email' is the unique identifier
    }
    public function getRoles()
    {
        return [$this->role]; // Assuming 'role' is a property containing the user's role
    }
    public function getSalt()
    {
        return null; // You can return a salt if you're using a custom password encoder
    }
    public function eraseCredentials()
    {
        // Implement this method if you need to erase sensitive data stored on the user
    }
    public function getUsername()
    {
        return $this->email; // Assuming 'email' is used as the username
    }

}
