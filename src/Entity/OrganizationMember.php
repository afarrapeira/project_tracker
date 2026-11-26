<?php

namespace App\Entity;

use App\Repository\OrganizationMemberRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrganizationMemberRepository::class)]
#[ORM\Table(name: 'organization_member',
    uniqueConstraints: [
        new ORM\UniqueConstraint(
            name: 'unique_organization_member',
            columns: ['organization_id', 'user_id'],
        )
    ]
)]
class OrganizationMember
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

    #[ORM\ManyToOne(targetEntity: Organization::class, inversedBy: "organizationMembers")]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    public ?Organization $organization = null {
        get {
            return $this->organization;
        }
        set {
            $this->organization = $value;
        }
    }

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "organizationMembers")]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    public ?User $user = null {
        get {
            return $this->user;
        }
        set {
            $this->user = $value;
        }
    }

    #[ORM\ManyToOne(targetEntity: OrganizationRole::class)]
    public ?OrganizationRole $role = null {
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
