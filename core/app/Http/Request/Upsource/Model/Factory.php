<?php

namespace App\Http\Request\Upsource\Model;

class Factory
{
    public static function createNewReview(
        int $majorVersion,
        int $minorVersion,
        string $projectId,
        string $dataType,
        array $data
    ): NewReview {
        return new NewReview($majorVersion, $minorVersion, $projectId, $dataType, $data);
    }
}