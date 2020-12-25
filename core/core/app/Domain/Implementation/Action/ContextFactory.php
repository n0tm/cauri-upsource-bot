<?php

namespace App\Domain\Implementation\Action;

use App\Domain\Contract;

class ContextFactory implements Contract\Action\ContextFactory
{
	public function createUpsource(): Contract\Action\Upsource\ContextFactory
	{
		return new Upsource\ContextFactory();
	}

	public function createTelegram(): Contract\Action\Telegram\ContextFactory
	{
		return new Telegram\ContextFactory();
	}
}