<?php

namespace App\Helpers\YouTrack;

use App\Domain\Contract;

class LinkGenerator
{
	public function getTask(string $baseUrl, string $taskId): string
    {
        return $this->createUrl($baseUrl, "issue/$taskId");
    }

    private function createUrl(string $baseUrl, string $url): string
    {
        return "$baseUrl/$url";
    }
}