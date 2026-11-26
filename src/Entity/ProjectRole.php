<?php

namespace App\Entity;

use App\Entity\Enum\ProjectPermission;
use App\Repository\ProjectRoleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRoleRepository::class)]
class ProjectRole
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

    #[ORM\ManyToOne(targetEntity: Project::class)]
    private Project $project {
        get {
            return $this->project;
        }
        set {
            $this->project = $value;
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

    #[ORM\Column(type: Types::JSON)]
    private array $permissions = [];

    public function getPermissions(): array
    {
        return array_map(
            static fn (string $permission) => ProjectPermission::from($permission),
            $this->permissions
        );
    }

    public function setPermissions(array $permissions): void
    {
        $this->permissions = array_map(
            static fn (ProjectPermission $permission) => $permission->value,
            $permissions
        );
    }

    public function hasPermission(ProjectPermission $permission): bool
    {
        return in_array($permission->value, $this->permissions, true);
    }

    public function addPermission(ProjectPermission $permission): void {
        if (!$this->hasPermission($permission)) {
            $this->permissions[] = $permission->value;
        }
    }

    public function removePermission(ProjectPermission $permission): void {
        if ($this->hasPermission($permission)) {
            $this->permissions = array_values(array_filter(
                $this->permissions,
                fn(string $value) => $value !== $permission->value
            ));
        }
    }
}
