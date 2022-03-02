<?php

namespace App\Http\Library;

use Illuminate\Http\JsonResponse;

trait RoleHelpers
{
    protected function isSuperAdmin($user): bool
    {
        if (!empty($user)) {
            return $user->tokenCan('Super Admin');
        }

        return false;
    }

    protected function isAdmin($user): bool
    {
        if (!empty($user)) {
            return $user->tokenCan('Admin');
        }

        return false;
    }

    protected function isInstructor($user): bool
    {

        if (!empty($user)) {
            return $user->tokenCan('Instructor');
        }

        return false;
    }

    protected function isStudent($user): bool
    {
        if (!empty($user)) {
            return $user->tokenCan('student');
        }

        return false;
    }
}