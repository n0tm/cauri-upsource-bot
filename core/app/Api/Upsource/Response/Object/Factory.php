<?php

namespace App\Api\Upsource\Response\Object;

class Factory
{
	public static function participantInReview(string $id, int $role, int $state): ParticipantInReview
	{
		return new ParticipantInReview($id, $role, $state);
	}
}