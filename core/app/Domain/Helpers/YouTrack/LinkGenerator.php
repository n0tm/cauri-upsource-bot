<?php

namespace App\Domain\Helpers\YouTrack;

class LinkGenerator
{
    public static function getTask(string $taskId): string
    {
        return self::createUrl("/issue/$taskId");
    }

    private static function createUrl(string $url): string
    {
        $domain = config('youtrack.domain');
        return "$domain$url";
    }
}