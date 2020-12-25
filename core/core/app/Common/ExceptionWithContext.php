<?php

namespace App\Common;

use Exception;

class ExceptionWithContext extends Exception
{
	/**
	 * @var mixed
	 */
	private $context;

	public function getContext()
	{
		return $this->context;
	}

	/**
	 * @param mixed $context
	 */
	public function setContext($context): void
	{
		$this->context = $context;
	}
}