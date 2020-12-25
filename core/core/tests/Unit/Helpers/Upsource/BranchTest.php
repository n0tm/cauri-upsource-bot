<?php

namespace Tests\Unit\Helpers\Upsource;

use App\Helpers\Upsource\Branch;
use Tests\TestCase;

class BranchTest extends TestCase
{
	/**
	 * @param string $branch
	 * @param string $resultTaskId
	 * @dataProvider branchDataProvider
	 */
	public function testGetTaskId(string $branch, ?string $resultTaskId)
	{
		$branchHelper = new Branch();
		$this->assertSame($resultTaskId, $branchHelper->getTaskId($branch));
	}

	public function branchDataProvider(): array
	{
		return [
			['feature/CQ-463', 'CQ-463'],
			['feature/CQ-4634', 'CQ-463'],
			['feature/CQ-46', 'CQ-46'],
			['feature/CQ-4', 'CQ-4'],
			['feature/CQ-', null],
			['feature/aekgkaegkykr/CC/CR--', null],
			['feature/aekgkaegkykr/CC-100/CR--', 'CC-100'],
		];
	}
}
