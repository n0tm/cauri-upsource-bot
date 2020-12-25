<?php

namespace App\Domain\Contract\Repository\Upsource;

use App\Domain\Contract\Entity;

interface User
{
	public function getById(string $id): ?Entity\Upsource\User;
}