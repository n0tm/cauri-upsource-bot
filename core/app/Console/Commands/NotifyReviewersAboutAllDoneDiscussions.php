<?php

namespace App\Console\Commands;

use App\Domain\Implementation\Action;
use App\Model;
use App\Domain\Contract;
use Illuminate\Console\Command;

class NotifyReviewersAboutAllDoneDiscussions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:notify_reviewers_about_done_discussions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command will search for all done discussions in all saved reviews. If all discussion are done, command will notify all reviewers about it.';

	/**
	 * @var Contract\Action\Telegram\ContextFactory
	 */
    private $contextFactory;

    public function __construct(Contract\Action\Telegram\ContextFactory $contextFactory)
    {
        parent::__construct();

        $this->contextFactory = $contextFactory;
    }

    public function handle(Model\Upsource\Review $reviewSearchModel)
    {
    	/** @var Model\Upsource\Review[] $reviews */
    	$reviews = $reviewSearchModel->query()->get()->all();
    	foreach ($reviews as $review) {
    		$this->notifyReviewersInReview($review);
	    }

        return 0;
    }

    private function notifyReviewersInReview(Model\Upsource\Review $review): void
    {
    	$context = $this->contextFactory->createNotifyReviewersAboutAllDoneDiscussions($review);
    	/** @var Action\Telegram\NotifyReviewersAboutAllDoneDiscussions $command */
    	$command = resolve(Action\Telegram\NotifyReviewersAboutAllDoneDiscussions::class);
    	$command->process($context);
    }
}
