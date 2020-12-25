<?php

namespace App\Repository\Upsource;

use App\Domain\Contract;
use App\Repository\AbstractRepository;
use Illuminate\Database\Eloquent\Model;

class User extends AbstractRepository implements Contract\Repository\Upsource\User
{
	public function getById(string $id): ?Contract\Entity\Upsource\User
	{
		/** @var Contract\Record\Upsource\User $record */
		$record = $this->getModel()
			->newQuery()
			->find($id);

		return $record === null ? null : $record->getEntity();
	}

	protected function getModel(): Model
	{
		return new \App\Model\Upsource\User();
	}
}