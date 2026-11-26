<?php

namespace App\Service\PermissionChecker;

use App\Entity\Enum\ProjectPermission;
use App\Entity\Project;
use App\Entity\User;
use App\Repository\ProjectMemberRepository;

readonly class ProjectPermissionChecker
{
    public function __construct(
        private ProjectMemberRepository $projectMemberRepository,
    )
    {
    }
    public function isGranted(User $user, Project $project, ProjectPermission $permission): bool
    {
        $member = $this->projectMemberRepository->findMembership($project, $user);

        if (null === $member) return false;

        if ($member->isOwner) return true;

        if (null === $member->role) return false;

        if ($member->role->hasPermission($permission)) return true;

        return false;
    }

}
