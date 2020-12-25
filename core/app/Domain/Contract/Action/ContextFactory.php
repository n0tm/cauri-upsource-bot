<?php

namespace App\Domain\Contract\Action;

interface ContextFactory
{
	public function createUpsource(): Upsource\ContextFactory;
	public function createTelegram(): Telegram\ContextFactory;
}