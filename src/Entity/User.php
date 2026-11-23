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
    private ?int $id = null {
        get {
            return $this->id;
        }
        set {
            $this->id = $value;
        }
    }

    #[ORM\Column(length: 255)]
    private ?string $username = null {
        get {
            return $this->username;
        }
        set {
            $this->username = $value;
        }
    }

    #[ORM\Column(length: 255)]
    private ?string $password = null {
        get {
            return $this->password;
        }
        set {
            $this->password = $value;
        }
    }

    #[ORM\Column(length: 255)]
    private ?string $email = null {
        get {
            return $this->email;
        }
        set {
            $this->email = $value;
        }
    }

    #[ORM\Column(length: 255)]
    private ?string $phone = null {
        get {
            return $this->phone;
        }
        set {
            $this->phone = $value;
        }
    }

    #[ORM\Column(length: 255)]
    private ?string $name = null {
        get {
            return $this->name;
        }
        set {
            $this->name = $value;
        }
    }

    #[ORM\Column(length: 255)]
    private ?string $lastName = null {
        get {
            return $this->lastName;
        }
        set {
            $this->lastName = $value;
        }
    }

    #[ORM\OneToMany(targetEntity: ProjectMember::class, mappedBy: 'user', cascade: ['persist'], orphanRemoval: true)]
    private Collection $projectMembers {
        get {
            return $this->projectMembers;
        }
        set(Collection $value) {
            $this->projectMembers = $value;
        }
    }

    public function __construct()
    {
        $this->projectMembers = new ArrayCollection();
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
}
