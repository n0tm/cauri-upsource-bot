<?php

namespace App\Domain\Contract\Record;

use App\Domain\Contract;
use Exception;

interface Basic
{
	public function getEntity(): Contract\Entity\Basic;

	/**
	 * Save the model to the database.
	 *
	 * @param  array  $options
	 * @return bool
	 */
	public function save(array $options = []);

	/**
	 * Delete the model from the database.
	 *
	 * @return bool|null
	 *
	 * @throws Exception
	 */
	public function delete();
}