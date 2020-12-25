<?php

namespace App\Repository\Telegram;

use App\Domain\Contract;
use App\Repository\AbstractRepository;
use Illuminate\Database\Eloquent\Model;
use App\Model\Telegram\ReviewNotificationMessage as ReviewNotificationMessageModel;

class ReviewNotificationMessage extends AbstractRepository implements Contract\Repository\Telegram\ReviewNotificationMessage
{

	public function create(int $messageId, int $chatId, string $reviewId): bool
	{
		$reviewNotification = $this->getModel();

		$reviewNotification->setAttribute(ReviewNotificationMessageModel::COLUMN_NAME_MESSAGE_ID, $messageId);
		$reviewNotification->setAttribute(ReviewNotificationMessageModel::COLUMN_NAME_CHAT_ID, $chatId);
		$reviewNotification->setAttribute(ReviewNotificationMessageModel::COLUMN_NAME_REVIEW_ID, $reviewId);

		return $reviewNotification->save();
	}

	public function isExistsByReviewId(string $id): bool
	{
		return $this->getModel()
			->newQuery()
			->where([
		        ReviewNotificationMessageModel::COLUMN_NAME_REVIEW_ID => $id
	        ])->exists();
	}

	public function getByReviewId(string $id): ?Contract\Entity\Telegram\ReviewNotificationMessage
	{
		/** @var Contract\Record\Telegram\ReviewNotificationMessage $record */
		$record = $this->getModel()
			->newQuery()
			->where([
				        ReviewNotificationMessageModel::COLUMN_NAME_REVIEW_ID => $id
			        ])->first();

		return $record !== null ? $record->getEntity() : null;
	}

	/**
	 * @return ReviewNotificationMessageModel
	 */
	protected function getModel(): Model
	{
		return new ReviewNotificationMessageModel();
	}
}