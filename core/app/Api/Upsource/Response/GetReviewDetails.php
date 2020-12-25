<?php

namespace App\Api\Upsource\Response;

use App\Api\Upsource\Response\Object as Objects;
use App\Domain\Contract;

class GetReviewDetails extends AbstractResponse implements Contract\Api\Upsource\Response\GetReviewDetails
{
	private const KEY_NAME_STATE               = 'state';
	private const KEY_NAME_DISCUSSION_COUNTER  = 'discussionCounter';
	private const KEY_NAME_COUNT               = 'count';
	private const KEY_NAME_RESOLVED_COUNT      = 'resolvedCount';
	private const KEY_NAME_DESCRIPTION         = 'description';
	private const KEY_NAME_IS_READY_TO_CLOSE   = 'isReadyToClose';
	private const KEY_NAME_PARTICIPANTS        = 'participants';
	private const KEY_NAME_PARTICIPANT_USER_ID = 'userId';
	private const KEY_NAME_PARTICIPANT_STATE   = 'state';
	private const KEY_NAME_PARTICIPANT_ROLE    = 'role';

	public function getDiscussionsCount(): int
	{
		return $this->getDiscussionCounter()[self::KEY_NAME_COUNT];
	}

	public function getResolvedDiscussionsCount(): int
	{
		return $this->getDiscussionCounter()[self::KEY_NAME_RESOLVED_COUNT];
	}

	public function getDescription(): ?string
	{
		return $this->getResult()[self::KEY_NAME_DESCRIPTION] ?? null;
	}

	public function isReadyToClose(): bool
	{
		return $this->getResult()[self::KEY_NAME_IS_READY_TO_CLOSE];
	}

	public function isOpen(): bool
	{
		return $this->getResult()[self::KEY_NAME_STATE] === 1;
	}

	/**
	 * @return Objects\ParticipantInReview[]
	 */
	public function getParticipants(): array
	{
		$participants = [];
		foreach ($this->getResult()[self::KEY_NAME_PARTICIPANTS] as $participant) {
			$participantId = $participant[self::KEY_NAME_PARTICIPANT_USER_ID];
			$participantState = $participant[self::KEY_NAME_PARTICIPANT_STATE];
			$participantRole = $participant[self::KEY_NAME_PARTICIPANT_ROLE];
			$participants[] = Objects\Factory::participantInReview($participantId, $participantRole, $participantState);
		}

		return $participants;
	}

	private function getDiscussionCounter(): array
	{
		return $this->getResult()[self::KEY_NAME_DISCUSSION_COUNTER];
	}
}