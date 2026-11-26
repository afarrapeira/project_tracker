<?php

namespace App\Security\Voters;

use App\Entity\Enum\ProjectPermission;
use App\Entity\Project;
use App\Entity\User;
use App\Service\PermissionChecker\ProjectPermissionChecker;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ProjectVoter extends Voter
{
    public function __construct(
        private readonly ProjectPermissionChecker $permissionChecker,
    )
    {
    }

    protected function supports(string|object $attribute, mixed $subject): bool
    {
        return $attribute instanceof ProjectPermission &&
            $subject instanceof Project;
    }

    protected function voteOnAttribute(string|object $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        $user = $token->getUser();
        if (!$user instanceof User || !$attribute instanceof ProjectPermission) {
            return false;
        }

        return $this->permissionChecker->isGranted($user, $subject, $attribute);
    }
}
