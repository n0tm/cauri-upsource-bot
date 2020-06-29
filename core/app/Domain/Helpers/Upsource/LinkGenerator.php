<?php

namespace App\Domain\Helpers\Upsource;

class LinkGenerator
{
    public static function getReview(string $projectId, string $reviewId): string
    {
        return self::createUrl("/$projectId/review/$reviewId");
    }

    private static function createUrl(string $url): string
    {
        $domain = config('upsource.domain');
        return "$domain$url";
    }
}