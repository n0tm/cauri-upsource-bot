<?php

namespace App\Domain\Contract\Api\Upsource\Response;

interface GetUsersForReview
{
	public function getIds(): array;
}