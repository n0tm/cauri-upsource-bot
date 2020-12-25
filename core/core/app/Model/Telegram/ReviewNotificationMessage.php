<?php

namespace App\Model\Telegram;

use App\Model\Upsource\Review;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Contract;

/**
 * Class ReviewNotificationMessage
 * @package App\Model\Telegram
 * @property string $review_id
 * @property int $message_id
 * @property int $chat_id
 *
 * relations
 * @property Contract\Record\Upsource\Review $review
 */
class ReviewNotificationMessage extends Model implements Contract\Record\Telegram\ReviewNotificationMessage
{
	public const COLUMN_NAME_REVIEW_ID  = 'review_id';
	public const COLUMN_NAME_MESSAGE_ID = 'message_id';
	public const COLUMN_NAME_CHAT_ID    = 'chat_id';

    protected $table = 'telegram_review_notifications_messages';

	public function review()
	{
		return $this->hasOne(Review::class, 'id', 'review_id');
	}

	/**
	 * @return \App\Domain\Implementation\Entity\Telegram\ReviewNotificationMessage
	 */
	public function getEntity(): Contract\Entity\Basic
	{
		return new \App\Domain\Implementation\Entity\Telegram\ReviewNotificationMessage($this);
	}

	public function getReviewId(): string
	{
		return $this->review_id;
	}

	public function getMessageId(): int
	{
		return $this->message_id;
	}

	public function getReview(): Contract\Record\Upsource\Review
	{
		return $this->review;
	}

	public function getChatId(): int
	{
		return $this->chat_id;
	}
}
