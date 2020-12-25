<?php

namespace App\Console\Commands;

use App\Domain\Implementation\Action\Telegram\UpdateReviewNotificationMessage;
use App\Model\Telegram\ReviewNotificationMessage;
use Illuminate\Console\Command;
use App\Api;
use App\Domain\Contract;

class UpdateTelegramReviewMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:update_review_messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update\'s telegram messages which was created by upsource \'new review\' webhook action' ;

	/**
	 * @var Contract\Action\Telegram\ContextFactory
	 */
    private $contextFactory;

    public function __construct(Contract\Action\Telegram\ContextFactory $contextFactory)
    {
    	$this->contextFactory = $contextFactory;

        parent::__construct();
    }

    public function handle(ReviewNotificationMessage $reviewNotificationMessage)
    {
    	/** @var ReviewNotificationMessage[] $messages */
    	$messages = $reviewNotificationMessage->query()->get()->all();
    	foreach ($messages as $message) {
		    $this->updateReviewNotificationMessage($message->getChatId(), $message->getMessageId(), $message->getReviewId());
	    }

        return 0;
    }

    private function updateReviewNotificationMessage(int $chatId, int $messageId, string $reviewId): void
    {
		$context = $this->contextFactory->createUpdateReviewNotificationMessage($chatId, $messageId, $reviewId);

	    /** @var UpdateReviewNotificationMessage $command */
	    $command = resolve(UpdateReviewNotificationMessage::class);
	    $command->process($context);
    }
}
