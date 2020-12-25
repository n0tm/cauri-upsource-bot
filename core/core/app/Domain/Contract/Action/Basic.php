<?php

namespace App\Domain\Contract\Action;

interface Basic
{
	/**
	 * @param mixed $context
	 */
    public function process($context): void;
}