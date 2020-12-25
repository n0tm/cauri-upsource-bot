<?php

namespace App\Helpers\Upsource;

class Branch
{
    private const REGEXP_TASK = '/[A-Z]{2}-\d{1,3}/';

    public function getTaskId(string $branch): ?string
    {
        preg_match(self::REGEXP_TASK, $branch, $matches);
        return $matches[0] ?? null;
    }
}