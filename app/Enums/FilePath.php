<?php

namespace App\Enums;

enum FilePath: string
{
    case ORGANIZATION = 'static' . DIRECTORY_SEPARATOR . 'organization';
    case PROJECT = 'static' . DIRECTORY_SEPARATOR . 'project';
    case DEPARTMENT = 'static' . DIRECTORY_SEPARATOR . 'department';
    case USER = 'static' . DIRECTORY_SEPARATOR . 'user';
}
