<?php

namespace App\Listeners;

interface Listener
{
	/**
	 * @param mixed $context
	 */
	public function handle($context): void;
}