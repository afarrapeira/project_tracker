<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id;

    #[ORM\Column(length: 255)]
    public ?string $username = null {
        get {
            return mb_trim($this->username);
        }
    }

    #[ORM\Column(length: 255)]
    public ?string $password = null;

    #[ORM\Column(length: 255)]
    public ?string $email = null {
        get {
            return mb_trim(mb_strtolower($this->email));
        }
    }

    #[ORM\Column(length: 255)]
    public ?string $phone = null;

    #[ORM\Column(length: 255)]
    public ?string $name = null {
        get {
            return mb_trim($this->name);
        }
    }

    #[ORM\Column(length: 255)]
    public ?string $lastName = null {
        get {
            return mb_trim($this->lastName);
        }
    }

    #[ORM\OneToMany(targetEntity: ProjectMember::class, mappedBy: 'user', cascade: ['persist'], orphanRemoval: true)]
    public Collection $projectMembers;

    #[ORM\OneToMany(targetEntity: OrganizationMember::class, mappedBy: 'user', cascade: ['persist'], orphanRemoval: true)]
    public Collection $organizationMembers;

    public function __construct()
    {
        $this->projectMembers = new ArrayCollection();
        $this->organizationMembers = new ArrayCollection();
    }

    public function addProjectMember(ProjectMember $projectMember): void
    {
        if (!$this->projectMembers->contains($projectMember)) {
            $this->projectMembers->add($projectMember);
            $projectMember->user = $this;
        }
    }

    public function removeProjectMember(ProjectMember $projectMember): void
    {
        if ($this->projectMembers->removeElement($projectMember)) {
            if ($projectMember->user === $this) {
                $projectMember->user = null;
            }
        }
    }

    public function addOrganizationMember(OrganizationMember $organizationMember): void
    {
        if (!$this->organizationMembers->contains($organizationMember)) {
            $this->organizationMembers->add($organizationMember);
            $organizationMember->user = $this;
        }
    }

    public function removeOrganizationMember(OrganizationMember $organizationMember): void
    {
        if ($this->organizationMembers->removeElement($organizationMember)) {
            if ($organizationMember->user === $this) {
                $organizationMember->user = null;
            }
        }
    }
}
