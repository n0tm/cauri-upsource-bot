<?php

namespace App\Notifications\Message;

abstract class AbstractFactory
{
	/**
	 * @return mixed
	 */
	abstract protected function getBasic();
}