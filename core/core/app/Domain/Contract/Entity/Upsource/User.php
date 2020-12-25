<?php

namespace App\Domain\Contract\Entity\Upsource;

use App\Domain\Contract;

/**
 * Interface User
 * @package App\Domain\Contract\Entity\Upsource
 * @method Contract\Record\Upsource\User getRecord()
 */
interface User extends Contract\Entity\Basic
{
	public function getId(): string;
	public function getName(): string;
	public function getProjectId(): string;
	public function getGlobalUserId(): int;
}