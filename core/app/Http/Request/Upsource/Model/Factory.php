<?php

namespace App\Http\Request\Upsource\Model;

class Factory
{
    public function createReviewCreated(
        int $majorVersion,
        int $minorVersion,
        string $projectId,
        array $data
    ): ReviewCreated {
        return new ReviewCreated($majorVersion, $minorVersion, $projectId, $data);
    }

    public function createReviewLabelChanged(
        int $majorVersion,
        int $minorVersion,
        string $projectId,
        array $data
    ): ReviewLabelChanged {
        return new ReviewLabelChanged($majorVersion, $minorVersion, $projectId, $data);
    }

    public function createReviewClosedOrReopened(
	    int $majorVersion,
	    int $minorVersion,
	    string $projectId,
	    array $data
    ): ReviewClosedOrReopened {
    	return new ReviewClosedOrReopened($majorVersion, $minorVersion, $projectId, $data);
    }

	public function createDiscussionNew(
		int $majorVersion,
		int $minorVersion,
		string $projectId,
		array $data
	): DiscussionNew {
		return new DiscussionNew($majorVersion, $minorVersion, $projectId, $data);
	}
}