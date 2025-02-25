<?php

declare(strict_types=1);

namespace Modules\User\Enums;

enum UserTypeEnum: string
{
    case STUDENT = 'student';
    case TEACHER = 'teacher';
    case STUDENT_PARENT = 'student_parent';
}
