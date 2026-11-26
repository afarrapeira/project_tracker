<?php

namespace App\Entity\Enum;

enum OrganizationPermission: string
{
    case PROJECT_DELETE = 'project.delete';
    case PROJECT_CREATE = 'project.create';

    case USER_INVITE = 'user.invite';
    case USER_DELETE = 'user.delete';

    case ORGANIZATION_MANAGE = 'organization.manage';

}
