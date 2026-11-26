<?php

namespace App\Entity;

use App\Repository\OrganizationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrganizationRepository::class)]
class Organization
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column(length: 255)]
    public ?string $name = null;

    #[ORM\Column(length: 255)]
    public ?string $description = null;

    #[ORM\Column(length: 255)]
    public ?string $slug = null;

    #[ORM\OneToMany(targetEntity: OrganizationMember::class, mappedBy: 'organization',cascade: ['persist'], orphanRemoval: true)]
    public private(set) Collection $organizationMembers;
    public function __construct()
    {
        $this->organizationMembers = new ArrayCollection();
    }

    public function addOrganizationMember(OrganizationMember $organizationMember): void
    {
        if (!$this->organizationMembers->contains($organizationMember)) {
            $this->organizationMembers->add($organizationMember);
            $organizationMember->organization = $this;
        }
    }

    public function removeOrganizationMember(OrganizationMember $organizationMember): void
    {
        if ($this->organizationMembers->removeElement($organizationMember)) {
            if ($organizationMember->organization === $this) {
                $organizationMember->organization = null;
            }
        }
    }

}
