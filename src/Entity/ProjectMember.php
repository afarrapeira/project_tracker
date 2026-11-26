<?php

namespace App\Entity;


use App\Repository\ProjectMemberRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectMemberRepository::class)]
#[ORM\Table(name: 'project_member',
    uniqueConstraints: [
        new ORM\UniqueConstraint(
            name: 'unique_project_member',
            columns: ['project_id', 'user_id'],
        )
    ]
)]
class ProjectMember
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

    #[ORM\ManyToOne(targetEntity: Project::class, inversedBy: "projectMembers")]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    public ?Project $project = null {
        get {
            return $this->project;
        }
        set {
            $this->project = $value;
        }
    }

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "projectMembers")]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    public ?User $user = null {
        get {
            return $this->user;
        }
        set {
            $this->user = $value;
        }
    }

    #[ORM\ManyToOne(targetEntity: ProjectRole::class)]
    public ?ProjectRole $role = null {
        get {
            return $this->role;
        }
        set {
            $this->role = $value;
        }
    }

    #[ORM\Column]
    private bool $active = true {
        get {
            return $this->active;
        }
        set {
            $this->active = $value;
        }
    }

    #[ORM\Column]
    private \DateTimeImmutable $joinedAt;

    public function __construct()
    {
        $this->joinedAt = new \DateTimeImmutable();
    }

    public function getJoinedAt(): \DateTimeImmutable
    {
        return $this->joinedAt;
    }

}
