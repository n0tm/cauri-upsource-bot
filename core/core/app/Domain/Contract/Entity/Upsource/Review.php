<?php

namespace App\Domain\Contract\Entity\Upsource;

use App\Domain\Contract;

/**
 * Interface Review
 * @package App\Domain\Contract\Entity\Upsource
 *
 * @method Contract\Record\Upsource\Review getRecord()
 */
interface Review extends Contract\Entity\Basic
{
	public function getId(): string;
	public function getCreatorUpsourceUserId(): string;
	public function getBranch(): string;
}