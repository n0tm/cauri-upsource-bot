<?php

namespace App\Domain\Contract\Entity;

use App\Domain\Contract;

interface Basic
{
	public function getRecord(): Contract\Record\Basic;
}