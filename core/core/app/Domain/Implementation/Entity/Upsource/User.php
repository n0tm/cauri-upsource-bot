<?php

namespace App\Domain\Implementation\Entity\Upsource;

use App\Domain\Contract;
use App\Domain\Implementation;

/**
 * Class User
 * @package App\Domain\Implementation\Entity\Upsource
 * @property-read Contract\Record\Upsource\User $record
 *
 * @method Contract\Record\Upsource\User getRecord()
 */
class User extends Implementation\Entity\AbstractEntity implements Contract\Entity\Upsource\User
{
	public function getId(): string
	{
		return $this->record->getId();
	}

	public function getName(): string
	{
		return $this->record->getName();
	}

	public function getProjectId(): string
	{
		return $this->record->getProjectId();
	}

	public function getGlobalUserId(): int
	{
		return $this->record->getUserId();
	}
}