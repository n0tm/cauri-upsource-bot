<?php

namespace App\Domain\Implementation\Entity;

use App\Domain\Contract;

/**
 * Class User
 * @package App\Domain\Implementation\Entity
 *
 * @property-read Contract\Record\User $record
 *
 * @method Contract\Record\User getRecord()
 */
class User extends AbstractEntity implements Contract\Entity\User
{
	public function getId(): int
	{
		return $this->record->getId();
	}

	public function getName(): string
	{
		return $this->record->getName();
	}

	public function getSurname(): string
	{
		return $this->record->getSurname();
	}

	public function getEmail(): string
	{
		return $this->record->getEmail();
	}
}