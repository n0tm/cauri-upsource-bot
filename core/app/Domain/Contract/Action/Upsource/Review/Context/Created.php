<?php

namespace App\Domain\Contract\Action\Upsource\Review\Context;

interface Created extends Basic
{
	public function getCreatorId(): string;
	public function getBranch(): string;
}