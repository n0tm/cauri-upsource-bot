<?php

namespace Tests\Unit\Notifications\Message\Component;

use App\Notifications\Message\Component\AllDiscussionsInReviewAreDone;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AllDiscussionsInReviewAreDoneTest extends TestCase
{
	use WithFaker;

	/**
	 * @var AllDiscussionsInReviewAreDone
	 */
	private $message;

	protected function setUp(): void
	{
		parent::setUp();

		$this->message = new AllDiscussionsInReviewAreDone();
	}

	public function testToStringWhenOnlyBranch(): void
	{
		$branch = $this->faker->text;
		$this->message->setBranch($branch);

		self::assertSame(
			sprintf("Пользователь закрыл все комментарии в ревью\n\n👨‍💻 \n〽️ %s", $branch),
			$this->message->toString()
		);
	}

	public function testToStringWhenOnlyAuthor(): void
	{
		$author = $this->faker->firstName;
		$this->message->setAuthor($author);

		self::assertSame(
			sprintf("Пользователь закрыл все комментарии в ревью\n\n👨‍💻 %s\n〽️ ", $author),
			$this->message->toString()
		);
	}

	public function testToString(): void
	{
		$branch = $this->faker->text;
		$author = $this->faker->firstName;

		$this->message->setBranch($branch);
		$this->message->setAuthor($author);

		self::assertSame(
			sprintf("Пользователь закрыл все комментарии в ревью\n\n👨‍💻 %s\n〽️ %s", $author, $branch),
			$this->message->toString()
		);
	}
}
