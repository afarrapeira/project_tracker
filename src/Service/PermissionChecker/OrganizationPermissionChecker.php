<?php

namespace App\Service\PermissionChecker;

use App\Entity\Enum\OrganizationPermission;
use App\Entity\Organization;
use App\Entity\User;
use App\Repository\OrganizationMemberRepository;

readonly class OrganizationPermissionChecker
{

    public function __construct(
        private OrganizationMemberRepository $organizationMemberRepository,
    )
    {
    }

    public function isGranted(User $user, Organization $organization, OrganizationPermission $permission): bool
    {
        $member = $this->organizationMemberRepository->findMembership($organization, $user);

        if (null === $member) return false;

        if ($member->isOwner) return true;

        if (null === $member->role) return false;

        if ($member->role->hasPermission($permission)) return true;

        return false;
    }

}
