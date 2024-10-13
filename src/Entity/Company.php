<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[ApiResource(
    // operations: [
    //     new Get(),
    // ],

)] 
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length:14)]
    private ?string $siret = null;
    
    #[ORM\Column(length: 255)]
    private ?string $adress = null;

    /**
     * @var Collection<int, Project>
     */
    #[ORM\OneToMany(targetEntity: Project::class, mappedBy: 'company', cascade: ['persist'])]
    private Collection $projects;

    #[ORM\OneToMany(targetEntity: UserCompany::class, mappedBy: 'company', orphanRemoval: true)]
    private Collection $userCompanies;

    /**
     * @var Collection<int, User>
     */
    #[Assert\NotBlank]
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'company')]
    private Collection $user;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->user = new ArrayCollection();
        $this->userCompanies = new ArrayCollection();
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

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): static
    {
        $this->siret = $siret;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): static
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

     /**
     * @return Collection<int, UserCompany>
     */
    public function getUserCompanies(): Collection
    {
        return $this->userCompanies;
    }

    public function addProject(Project $project): static
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->setCompany($this);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getCompany() === $this) {
                $project->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user, string $role): static
    {
        if (!$this->user->contains($user)) {
            $userCompany = new UserCompany();
            $userCompany->setUser($user);
            $userCompany->setCompany($this);
            $userCompany->setRole($role);

            $this->user->add($user);
            $this->userCompanies->add($userCompany);
            $this->setCompany($this);
        }

        return $this;
    }
    
    public function removeUser(User $user): static
    {
        if ($this->user->removeElement($user)) {
            if ($user->getCompany() === $this) {
                $user->setCompany(null);
            }
        }
    
        return $this;
    }
}
