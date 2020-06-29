<?php

namespace App\Domain\Helpers\Upsource;

class Branch
{
    private const REGEXP_TASK = '/[A-Z]{2}-\d{0,3}/';

    public static function getTaskId(string $branch): ?string
    {
        preg_match(self::REGEXP_TASK, $branch, $matches);
        return $matches[0] ?? null;
    }
}