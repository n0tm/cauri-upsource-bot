<?php

namespace Tests\Unit\Notifications\Message\Component\Object;

use App\Notifications\Message\Component\Object\ReviewRecipient;
use Tests\TestCase;

class ReviewRecipientTest extends TestCase
{
	/**
	 * @param ReviewRecipient $recipient
	 * @param string $name
	 * @param string $emojiState
	 * @dataProvider recipientsDataProvider
	 */
	public function testToString(ReviewRecipient $recipient, string $name, string $emojiState): void
	{
		self::assertSame(sprintf('%s %s', $name, $emojiState), $recipient->__toString());
	}

	public function recipientsDataProvider(): array
	{
		$firstName  = '::firstName::';
		$secondName = '::secondName::';
		$thirdName  = '::thirdName::';
		$fourthName = '::fourthName::';
		$fifth      = '::fifthName::';

		return [
			[(new ReviewRecipient($firstName, ReviewRecipient::REVIEWER_STATE_UNREAD)), $firstName, '💤'],
			[(new ReviewRecipient($secondName, ReviewRecipient::REVIEWER_STATE_READ)), $secondName, '👀'],
			[(new ReviewRecipient($thirdName, ReviewRecipient::REVIEWER_STATE_ACCEPTED)), $thirdName, '✅'],
			[(new ReviewRecipient($fourthName, ReviewRecipient::REVIEWER_STATE_REJECTED)), $fourthName, '❌'],
			[(new ReviewRecipient($fifth, 0)), $fifth, '❔'],
		];
	}
}
