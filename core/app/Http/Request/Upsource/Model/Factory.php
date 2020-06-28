<?php

namespace App\Http\Request\Upsource\Model;

class Factory
{
    public static function createReviewCreated(
        int $majorVersion,
        int $minorVersion,
        string $projectId,
        array $data
    ): ReviewCreated {
        return new ReviewCreated($majorVersion, $minorVersion, $projectId, $data);
    }

    public static function createReviewLabelChanged(
        int $majorVersion,
        int $minorVersion,
        string $projectId,
        array $data
    ): ReviewLabelChanged {
        return new ReviewLabelChanged($majorVersion, $minorVersion, $projectId, $data);
    }
}