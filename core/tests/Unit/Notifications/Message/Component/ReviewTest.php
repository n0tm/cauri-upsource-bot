<?php

namespace Tests\Unit\Notifications\Message\Component;

use App\Notifications\Message\Component\Object\ReviewRecipient;
use App\Notifications\Message\Component\NewReview;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReviewTest extends TestCase
{
	use WithFaker;

	public function testToStringWhenOnlyTitle(): void
	{
		$title = $this->faker->title;

		$reviewMessage = new NewReview();
		$reviewMessage->setTitle($title);

		self::assertSame(
			sprintf("%s\n👨‍💻 Нет автора\n〽️ Нет ветки\n\n🗒 Нет описания\n\n💬 0/0\n\nНужно добить", $title),
			$reviewMessage->__toString()
		);
	}

	public function testToStringWhenOnlyAuthor(): void
	{
		$author = $this->faker->text;

		$reviewMessage = new NewReview();
		$reviewMessage->setAuthor($author);

		self::assertSame(
			sprintf("\n👨‍💻 %s\n〽️ Нет ветки\n\n🗒 Нет описания\n\n💬 0/0\n\nНужно добить", $author),
			$reviewMessage->__toString()
		);
	}

	public function testToStringWhenOnlyBranch(): void
	{
		$branch = $this->faker->title;

		$reviewMessage = new NewReview();
		$reviewMessage->setBranch($branch);

		self::assertSame(
			sprintf("\n👨‍💻 Нет автора\n〽️ %s\n\n🗒 Нет описания\n\n💬 0/0\n\nНужно добить", $branch),
			$reviewMessage->__toString()
		);
	}

	public function testToStringWhenOnlyDescription(): void
	{
		$description = $this->faker->title;

		$reviewMessage = new NewReview();
		$reviewMessage->setDescription($description);

		self::assertSame(
			sprintf("\n👨‍💻 Нет автора\n〽️ Нет ветки\n\n🗒 %s\n\n💬 0/0\n\nНужно добить", $description),
			$reviewMessage->__toString()
		);
	}

	public function testToStringWhenOnlyTotalDiscussionsCount(): void
	{
		$discussionsCount = $this->faker->randomNumber();

		$reviewMessage = new NewReview();
		$reviewMessage->setTotalDiscussionsCount($discussionsCount);

		self::assertSame(
			sprintf("\n👨‍💻 Нет автора\n〽️ Нет ветки\n\n🗒 Нет описания\n\n💬 %s/0\n\nНужно добить", $discussionsCount),
			$reviewMessage->__toString()
		);
	}

	public function testToStringWhenOnlyResolvedDiscussionsCount(): void
	{
		$resolvedDiscussionsCount = $this->faker->randomNumber();

		$reviewMessage = new NewReview();
		$reviewMessage->setResolvedDiscussionsCount($resolvedDiscussionsCount);

		self::assertSame(
			sprintf("\n👨‍💻 Нет автора\n〽️ Нет ветки\n\n🗒 Нет описания\n\n💬 0/%s\n\nНужно добить", $resolvedDiscussionsCount),
			$reviewMessage->__toString()
		);
	}

	public function testToStringWhenOnlyIsReadyToClose(): void
	{
		$isReadyToClose = true;

		$reviewMessage = new NewReview();
		$reviewMessage->setIsReadyToClose($isReadyToClose);

		self::assertSame(
			"\n👨‍💻 Нет автора\n〽️ Нет ветки\n\n🗒 Нет описания\n\n💬 0/0\n\nМожно закрывать",
			$reviewMessage->__toString()
		);
	}

	/**
	 * @param string $name
	 * @param int $state
	 * @param string $expectedMessage
	 * @dataProvider whenOnlyOneParticipantDataProvider
	 */
	public function testToStringWhenOnlyOneRecipient(string $name, int $state, string $expectedMessage): void
	{
		$reviewMessage = new NewReview();
		$reviewMessage->addRecipient($name, $state);

		self::assertSame(
			$expectedMessage,
			$reviewMessage->__toString()
		);
	}

	public function whenOnlyOneParticipantDataProvider(): array
	{
		return [
			[
				'Angelo Mortines',
				ReviewRecipient::REVIEWER_STATE_UNREAD,
				"\n👨‍💻 Нет автора\n〽️ Нет ветки\n\n🗒 Нет описания\n\n💬 0/0\n\n👁‍🗨 Angelo Mortines 💤\nНужно добить"
			],
			[
				'Sergio Scaletti',
				ReviewRecipient::REVIEWER_STATE_READ,
				"\n👨‍💻 Нет автора\n〽️ Нет ветки\n\n🗒 Нет описания\n\n💬 0/0\n\n👁‍🗨 Sergio Scaletti 👀\nНужно добить"
			],
			[
				'Lucio Fachenti',
				ReviewRecipient::REVIEWER_STATE_ACCEPTED,
				"\n👨‍💻 Нет автора\n〽️ Нет ветки\n\n🗒 Нет описания\n\n💬 0/0\n\n👁‍🗨 Lucio Fachenti ✅\nНужно добить"
			],
			[
				'Fabricio Sobrano',
				ReviewRecipient::REVIEWER_STATE_REJECTED,
				"\n👨‍💻 Нет автора\n〽️ Нет ветки\n\n🗒 Нет описания\n\n💬 0/0\n\n👁‍🗨 Fabricio Sobrano ❌\nНужно добить"
			],
			[
				'Soluchi Kapresko',
				0,
				"\n👨‍💻 Нет автора\n〽️ Нет ветки\n\n🗒 Нет описания\n\n💬 0/0\n\n👁‍🗨 Soluchi Kapresko ❔\nНужно добить"
			]
		];
	}

	public function testToStringWhenOnlyMoreThanOneRecipient(): void
	{
		$firstName   = $this->faker->name;
		$firstState  = ReviewRecipient::REVIEWER_STATE_UNREAD;

		$secondName  = $this->faker->name;
		$secondState = ReviewRecipient::REVIEWER_STATE_READ;

		$reviewMessage = new NewReview();
		$reviewMessage->addRecipient($firstName, $firstState);
		$reviewMessage->addRecipient($secondName, $secondState);

		self::assertSame(
			sprintf("\n👨‍💻 Нет автора\n〽️ Нет ветки\n\n🗒 Нет описания\n\n💬 0/0\n\n👁‍🗨 %s 💤\n👁‍🗨 %s 👀\nНужно добить", $firstName, $secondName),
			$reviewMessage->__toString()
		);
	}

	public function testToStringWhenOnlyOneSuggestedReviewer(): void
	{
		$name = $this->faker->name;

		$reviewMessage = new NewReview();
		$reviewMessage->addSuggestedReviewer($name);

		self::assertSame(
			sprintf("\n👨‍💻 Нет автора\n〽️ Нет ветки\n\n🗒 Нет описания\n\n💬 0/0\n\nПредлагаемые ревьюверы:\n%s\nНужно добить", $name),
			$reviewMessage->__toString()
		);
	}

	public function testToStringWhenMoreThanOneSuggestedReviewer(): void
	{
		$firstName  = $this->faker->name;
		$secondName = $this->faker->name;

		$reviewMessage = new NewReview();
		$reviewMessage->addSuggestedReviewer($firstName);
		$reviewMessage->addSuggestedReviewer($secondName);

		self::assertSame(
			sprintf("\n👨‍💻 Нет автора\n〽️ Нет ветки\n\n🗒 Нет описания\n\n💬 0/0\n\nПредлагаемые ревьюверы:\n%s\n%s\nНужно добить", $firstName, $secondName),
			$reviewMessage->__toString()
		);
	}

	public function testToStringWithAllParameters(): void
	{
		$title = $this->faker->title;
		$author = $this->faker->name;
		$branch = $this->faker->word;
		$description = $this->faker->text;
		$totalDiscussionsCount = $this->faker->randomNumber();
		$resolvedDiscussionsCount = $this->faker->randomNumber();
		$isReadyToClose = true;

		$recipientName = $this->faker->name;
		$recipientState = ReviewRecipient::REVIEWER_STATE_UNREAD;

		$suggestedReviewerName = $this->faker->name;

		$reviewMessage = new NewReview();
		$reviewMessage->setTitle($title)
			->setAuthor($author)
			->setBranch($branch)
			->setDescription($description)
			->setTotalDiscussionsCount($totalDiscussionsCount)
			->setResolvedDiscussionsCount($resolvedDiscussionsCount)
			->setIsReadyToClose($isReadyToClose)
			->addRecipient($recipientName, $recipientState)
			->addSuggestedReviewer($suggestedReviewerName);

		self::assertSame(
			sprintf("%s\n👨‍💻 %s\n〽️ %s\n\n🗒 %s\n\n💬 %s/%s\n\n👁‍🗨 %s 💤\nПредлагаемые ревьюверы:\n%s\nМожно закрывать", $title, $author, $branch, $description, $totalDiscussionsCount, $resolvedDiscussionsCount, $recipientName, $suggestedReviewerName),
			$reviewMessage->__toString()
		);
	}
}
