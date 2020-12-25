<?php

namespace App\Domain\Contract\Record\Upsource;

use App\Domain\Contract;

/**
 * Interface User
 * @package App\Domain\Contract\Record\Upsource
 * @method Contract\Entity\Upsource\User getEntity()
 */
interface User extends Contract\Record\Basic
{
	public function getId(): string;
	public function getName(): string;
	public function getProjectId(): string;
	public function getUserId(): int;
	public function getUser(): Contract\Record\User;
}