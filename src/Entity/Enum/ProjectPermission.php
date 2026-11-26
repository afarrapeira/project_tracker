<?php

namespace App\Entity\Enum;

enum ProjectPermission: string
{
    case PROJECT_MANAGE = 'project.manage';
    case PROJECT_VIEW = 'project.view';
    case PROJECT_DELETE = 'project.delete';
    case PROJECT_EDIT = 'project.edit';

    case TASK_CREATE = 'task.create';
    case TASK_ASSIGN = 'task.assign';
    case TASK_EDIT = 'task.edit';
    case TASK_DELETE = 'task.delete';
    case TASK_SOLVE = 'task.solve';
    case TASK_COMMENT = 'task.comment';

    case SPRINT_START = 'sprint.start';
    case SPRINT_END = 'sprint.end';

}
