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

    #[ORM\Column(length: 255)]
    private ?string $slug = null {
        get {
            return $this->slug;
        }
        set {
            $this->slug = $value;
        }
    }

    #[ORM\OneToMany(targetEntity: OrganizationMember::class, mappedBy: 'organization',cascade: ['persist'], orphanRemoval: true)]
    private Collection $organizationMembers {
        get {
            return $this->organizationMembers;
        }
        set {
            $this->organizationMembers = $value;
        }
    }
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
