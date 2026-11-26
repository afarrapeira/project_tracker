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
    public ?int $id = null;

    #[ORM\Column(length: 255)]
    public ?string $name = null;

    #[ORM\Column(length: 255)]
    public ?string $description = null;

    #[ORM\Column(length: 10)]
    public ?string $shortName = null;

    #[ORM\Column(length: 255)]
    public ?string $slug = null;

    #[ORM\OneToMany(targetEntity: ProjectMember::class, mappedBy: 'project',cascade: ['persist'], orphanRemoval: true)]
    public Collection $projectMembers;

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
