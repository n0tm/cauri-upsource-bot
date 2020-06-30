<?php

namespace App\Notifications;

use App\Domain\Helpers;
use App\Model;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram;

class ReviewReadyForReview extends Notification
{
    use Queueable;

    /**
     * @var string
     */
    private $userNameWhoSetReadyForReview;

    /**
     * @var string
     */
    private $projectId;

    /**
     * @var string
     */
    private $reviewId;

    /**
     * @var string
     */
    private $branch;

    public function __construct(string $projectId, string $reviewId, string $branch, string $userNameWhoSetReadyForReview)
    {
        $this->projectId                    = $projectId;
        $this->reviewId                     = $reviewId;
        $this->userNameWhoSetReadyForReview = $userNameWhoSetReadyForReview;
        $this->branch                       = $branch;
    }

    public function via()
    {
        return [Telegram\TelegramChannel::class];
    }

    public function toTelegram(Model\Telegram\User $notifiable)
    {
        $taskId = Helpers\Upsource\Branch::getTaskId($this->branch);
        $content = "Пользователь {$this->userNameWhoSetReadyForReview} открыл ревью для просмотра";
        $message = Telegram\TelegramMessage::create()
            ->to($notifiable->review_chat_id)
            ->button('Ревью', Helpers\Upsource\LinkGenerator::getReview($this->projectId, $this->reviewId));
        $taskId !== null
            ? $message->button('Задача', Helpers\YouTrack\LinkGenerator::getTask($taskId))
            : $content .= "\n\nНе удалось найти задачу привязанную к ветке";
        return $message->content($content);
    }
}
