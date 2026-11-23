<?php

namespace App\Entity;

use App\Entity\Enum\Permission;
use App\Repository\RoleRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
class Role
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
            static fn (string $permission) => Permission::from($permission),
            $this->permissions
        );
    }

    public function setPermissions(array $permissions): void
    {
        $this->permissions = array_map(
            static fn (Permission $permission) => $permission->value,
            $permissions
        );
    }

    public function hasPermission(Permission $permission): bool
    {
        return in_array($permission->value, $this->permissions, true);
    }

    public function addPermission(Permission $permission): void {
        if (!$this->hasPermission($permission)) {
            $this->permissions[] = $permission->value;
        }
    }

    public function removePermission(Permission $permission): void {
        if ($this->hasPermission($permission)) {
            $this->permissions = array_values(array_filter(
                $this->permissions,
                fn(string $value) => $value !== $permission->value
            ));
        }
    }
}
