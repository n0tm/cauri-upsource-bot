<?php

namespace App\Api\Upsource\Response;

use App\Domain\Contract;

class GetReviewSummaryDiscussions extends AbstractResponse implements Contract\Api\Upsource\Response\GetReviewSummaryDiscussions
{
	private const KEY_NAME_DISCUSSIONS                     = 'discussions';
	private const KEY_NAME_DISCUSSIONS_IN_FILE             = 'discussionInFile';
	private const KEY_NAME_DISCUSSIONS_IN_FILE_LABELS      = 'labels';
	private const KEY_NAME_DISCUSSIONS_IN_FILE_LABELS_NAME = 'name';

	private const LABEL_NAME_DONE = 'done';

	public function isAllWithLabelDone(): bool
	{
		$discussions = $this->getResult()[self::KEY_NAME_DISCUSSIONS];
		$isAllWithLabelDone = true;
		foreach ($discussions as $discussion) {
			$labels = $discussion[self::KEY_NAME_DISCUSSIONS_IN_FILE][self::KEY_NAME_DISCUSSIONS_IN_FILE_LABELS] ?? [];
			$hasLabelDone = false;
			foreach ($labels as $label) {
				if ($label[self::KEY_NAME_DISCUSSIONS_IN_FILE_LABELS_NAME] === self::LABEL_NAME_DONE) {
					$hasLabelDone = true;
				}
			}

			if (!$hasLabelDone) {
				$isAllWithLabelDone = false;
			}
		}

		return $isAllWithLabelDone;
	}
}