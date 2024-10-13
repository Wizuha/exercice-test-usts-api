<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\UserCompanyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserCompanyRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:usercompany']],
    operations: [
        new Post(
            uriTemplate: '/companies/add-user',
            denormalizationContext: ['groups' => ['write:user']]
        )
    ],

)] 
class UserCompany
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['write:user'])]
    private ?Company $company = null;

    #[ORM\ManyToOne(inversedBy: 'userCompanies')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:usercompany','write:user'])]
    private ?User $user = null;

    #[ORM\Column(length: 50)]
    #[Groups(['read:usercompany','write:user'])]
    private ?string $role = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    #[Assert\Choice(choices: ['admin', 'manager', 'consultant'], message: 'Invalid role')]
    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;
        return $this;
    }
}
