<?php

namespace App\Domain\Implementation\Entity\Upsource;

use App\Domain\Contract;
use App\Domain\Implementation;

/**
 * Class Review
 * @package App\Domain\Implementation\Entity\Upsource
 * @property-read Contract\Record\Upsource\Review $record
 *
 * @method Contract\Record\Upsource\Review getRecord()
 */
class Review extends Implementation\Entity\AbstractEntity implements Contract\Entity\Upsource\Review
{
	public function getId(): string
	{
		return $this->record->getId();
	}

	public function getCreatorUpsourceUserId(): string
	{
		return $this->record->getCreatorUpsourceUserId();
	}

	public function getBranch(): string
	{
		return $this->record->getBranch();
	}
}