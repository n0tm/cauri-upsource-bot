<?php

namespace Tests\Integration\Console\Commands;

use App\Domain\Implementation\Action;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Model;
use App\Domain\Contract;

class NotifyReviewersAboutAllDoneDiscussionsTest extends TestCase
{
	use WithFaker, RefreshDatabase;

	public function testHandle(): void
	{
		$reviewsCount = $this->faker->numberBetween(1, 20);
		factory(Model\Upsource\Review::class, $reviewsCount)->create();

		$context = $this->createMock(Contract\Action\Telegram\Context\NotifyReviewersAboutAllDoneDiscussions::class);
		$contextFactory = $this->createMock(Contract\Action\Telegram\ContextFactory::class);
		$contextFactory->expects(self::exactly($reviewsCount))
			->method('createNotifyReviewersAboutAllDoneDiscussions')
			->withAnyParameters()
			->willReturn($context);
		$this->instance(Contract\Action\Telegram\ContextFactory::class, $contextFactory);

		$action = $this->createMock(Action\Telegram\NotifyReviewersAboutAllDoneDiscussions::class);
		$action->expects(self::exactly($reviewsCount))->method('process')->with($context);
		$this->instance(Action\Telegram\NotifyReviewersAboutAllDoneDiscussions::class, $action);

		$this->artisan('telegram:notify_reviewers_about_done_discussions')->assertExitCode(0);
	}
}
