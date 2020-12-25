<?php

namespace App\Domain\Implementation\Entity;

use App\Domain\Contract;

abstract class AbstractEntity implements Contract\Entity\Basic
{
	/**
	 * @var Contract\Record\Basic
	 */
	protected $record;

	public function __construct(Contract\Record\Basic $record)
	{
		$this->record = $record;
	}

	public function getRecord(): Contract\Record\Basic
	{
		return $this->record;
	}
}