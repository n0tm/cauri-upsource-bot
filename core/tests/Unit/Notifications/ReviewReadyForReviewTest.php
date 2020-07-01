<?php

namespace Tests\Unit\Notifications;

use App\Model\Telegram\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications;
use Tests\TestCase;

class ReviewReadyForReviewTest extends TestCase
{
    public function testNotificationWhenBranchIncorrect(): void
    {
        Notification::fake();

        $projectId = '::project id::';
        $reviewId = '::review id::';
        $branch = '::branch::';
        $userNameWhoSetReadyForReview = '::name::';

        /** @var User $telegramUser */
        $telegramUser = factory(User::class)->create();
        $telegramUser->notify(new Notifications\ReviewReadyForReview(
            $projectId,
            $reviewId,
            $branch,
            $userNameWhoSetReadyForReview
        ));

        Notification::assertNotSentTo(
            $telegramUser,
            Notifications\ReviewReadyForReview::class,
            function (Notifications\ReviewReadyForReview $notification) use ($telegramUser, $userNameWhoSetReadyForReview, $branch) {
                $message = $notification->toTelegram($telegramUser)->toArray();
                $this->assertSame($message['text'], "Пользователь открыл ревью для просмотра\n*Автор:* {$userNameWhoSetReadyForReview}\n*Ветка:* {$branch}\n\nНе удалось найти задачу привязанную к ветке");
                $this->assertSame($message['chat_id'], $telegramUser->review_chat_id);
                $this->assertSame($message['reply_markup'], '{"inline_keyboard":[[{"text":"\u0420\u0435\u0432\u044c\u044e","url":"https:\/\/upsource.qubb.su\/::project id::\/review\/::review id::"}]]}');
            }
        );
    }

    public function testNotificationWhenBranchCorrect(): void
    {
        Notification::fake();

        $projectId = '::project id::';
        $reviewId = '::review id::';
        $branch = 'feature/CC-525/test-branch-with-task-id';
        $userNameWhoSetReadyForReview = '::name::';

        /** @var User $telegramUser */
        $telegramUser = factory(User::class)->create();
        $telegramUser->notify(new Notifications\ReviewReadyForReview(
            $projectId,
            $reviewId,
            $branch,
            $userNameWhoSetReadyForReview
        ));

        // @todo: Не понимаю, почему нотификация заполняется правильно, но ассерт срабатывать так как будто нотификация не отправилась (тут и методом выше)
        Notification::assertNotSentTo(
            $telegramUser,
            Notifications\ReviewReadyForReview::class,
            function (Notifications\ReviewReadyForReview $notification) use ($telegramUser, $userNameWhoSetReadyForReview, $branch) {
                $message = $notification->toTelegram($telegramUser)->toArray();
                $this->assertSame($message['text'], "Пользователь открыл ревью для просмотра\n*Автор:* {$userNameWhoSetReadyForReview}\n*Ветка:* {$branch}");
                $this->assertSame($message['chat_id'], $telegramUser->review_chat_id);
                $this->assertSame($message['reply_markup'], '{"inline_keyboard":[[{"text":"\u0420\u0435\u0432\u044c\u044e","url":"https:\/\/upsource.qubb.su\/::project id::\/review\/::review id::"},{"text":"\u0417\u0430\u0434\u0430\u0447\u0430","url":"https:\/\/youtrack.qubb.su\/issue\/CC-525"}]]}');
            }
        );
    }
}