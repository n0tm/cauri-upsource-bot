<?php

namespace App\Domain\Contract\Record\Upsource;

use App\Domain\Contract;

/**
 * Interface Review
 * @package App\Domain\Contract\Record\Upsource
 * @method Contract\Entity\Upsource\Review getEntity()
 */
interface Review extends Contract\Record\Basic
{
	public function getId(): string;
	public function getCreatorUpsourceUserId(): string;
	public function getBranch(): string;
	public function getUpsourceUser(): Contract\Record\Upsource\User;
}