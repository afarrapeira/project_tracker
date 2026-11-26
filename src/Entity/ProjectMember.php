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
    public ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Project::class, inversedBy: "projectMembers")]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    public ?Project $project = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "projectMembers")]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    public ?User $user = null;

    #[ORM\ManyToOne(targetEntity: ProjectRole::class)]
    public ?ProjectRole $role = null;

    #[ORM\Column]
    public bool $active = true;

    #[ORM\Column]
    public bool $isOwner = false;

    #[ORM\Column]
    public private(set) \DateTimeImmutable $joinedAt;

    public function __construct()
    {
        $this->joinedAt = new \DateTimeImmutable();
    }
}
