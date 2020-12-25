<?php

namespace App\Helpers\Upsource;

use App\Domain\Contract;

class LinkGenerator
{
	public function getReview(string $baseUrl, string $projectId, string $reviewId): string
    {
        return $this->createUrl($baseUrl, "$projectId/review/$reviewId");
    }

    private function createUrl(string $baseUrl, string $url): string
    {
        return "$baseUrl/$url";
    }
}