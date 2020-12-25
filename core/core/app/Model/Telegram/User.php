<?php

namespace App\Model\Telegram;

use App\Notifications;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;
use App\Domain\Contract;

/**
 * Class User
 * @package App\Model
 *
 * @property int $id
 * @property int $user_id
 * @property int $review_chat_id
 */
class User extends Model implements Contract\Record\Telegram\User
{
    use Notifiable;

    public $incrementing = false;

    protected $table = 'telegram_users';

    protected $fillable = [
        'id',
        'user_id',
        'review_chat_id',
    ];

	/**
	 * @return \App\Domain\Implementation\Entity\Telegram\User
	 */
	public function getEntity(): Contract\Entity\Basic
	{
		return new \App\Domain\Implementation\Entity\Telegram\User($this);
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getUserId(): int
	{
		return $this->user_id;
	}

	public function getReviewChatId(): int
	{
		return $this->review_chat_id;
	}

	public function notifyAboutNewReview(Contract\Notifications\Context\Review $context): void
	{
		/** @var Notifications\NewReview $notification */
		$notification = resolve(Notifications\NewReview::class);
		$notification->setContext($context);
		$this->notify($notification);
	}

	public function notifyAboutAllDoneDiscussions(Contract\Notifications\Context\Review $context): void
	{
		/** @var Notifications\AllDiscussionsInReviewAreDone $notification */
		$notification = resolve(Notifications\AllDiscussionsInReviewAreDone::class);
		$notification->setContext($context);
		$this->notify($notification);
	}

	// TODO: Нужно подумать как подменить использование модели ReviewNotificationsMessage на обёртку с моделью и репозиторием DatabaseNotifications
	public function notifications()
	{
		return $this->morphMany(DatabaseNotification::class, 'notifiable')->orderBy('created_at', 'desc');
	}
}
