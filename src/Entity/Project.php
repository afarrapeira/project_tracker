<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
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
    private ?string $name = null {
        get {
            return $this->name;
        }
        set {
            $this->name = $value;
        }
    }

    #[ORM\Column(length: 255)]
    private ?string $description = null {
        get {
            return $this->description;
        }
        set {
            $this->description = $value;
        }
    }

    #[ORM\Column(length: 10)]
    private ?string $shortName = null {
        get {
            return $this->shortName;
        }
        set {
            $this->shortName = $value;
        }
    }

    #[ORM\Column(length: 255)]
    private ?string $slug = null {
        get {
            return $this->slug;
        }
        set {
            $this->slug = $value;
        }
    }

    #[ORM\OneToMany(targetEntity: ProjectMember::class, mappedBy: 'project',cascade: ['persist'], orphanRemoval: true)]
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
            $projectMember->project = $this;
        }
    }

    public function removeProjectMember(ProjectMember $projectMember): void
    {
        if ($this->projectMembers->removeElement($projectMember)) {
            if ($projectMember->project === $this) {
                $projectMember->project = null;
            }
        }
    }
}
