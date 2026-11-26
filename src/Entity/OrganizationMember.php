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
    public ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Organization::class, inversedBy: "organizationMembers")]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    public ?Organization $organization = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "organizationMembers")]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    public ?User $user = null;

    #[ORM\ManyToOne(targetEntity: OrganizationRole::class)]
    public ?OrganizationRole $role = null;

    #[ORM\Column]
    public bool $active = true;

    #[ORM\Column]
    public bool $isOwner = false;

    #[ORM\Column]
    public \DateTimeImmutable $joinedAt;

    public function __construct()
    {
        $this->joinedAt = new \DateTimeImmutable();
    }

}
