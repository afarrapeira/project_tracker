<?php

namespace App\Security\Voters;

use App\Entity\Enum\OrganizationPermission;
use App\Entity\Organization;
use App\Entity\User;
use App\Service\PermissionChecker\OrganizationPermissionChecker;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class OrganizationVoter extends Voter
{
    public function __construct(
        private readonly OrganizationPermissionChecker $permissionChecker
    )
    {
    }

    protected function supports(string|object $attribute, mixed $subject): bool
    {
        return $attribute instanceof OrganizationPermission &&
            $subject instanceof Organization;
    }

    protected function voteOnAttribute(string|object $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        $user = $token->getUser();
        if (!$user instanceof User || !$attribute instanceof OrganizationPermission) {
            return false;
        }

        return $this->permissionChecker->isGranted($user, $subject, $attribute);
    }
}
