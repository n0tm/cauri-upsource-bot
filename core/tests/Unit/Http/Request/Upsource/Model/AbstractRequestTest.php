<?php

namespace Tests\Unit\Http\Request\Upsource\Model;

use App\Http\Request\Upsource\Model\AbstractRequest;

abstract class AbstractRequestTest extends \Tests\TestCase
{
    protected const TEST_MAJOR_VERSION = 100;
    protected const TEST_MINOR_VERSION = 1;
    protected const TEST_DATA          = [];
    protected const TEST_PROJECT_ID    = '::project id::';

    public function testGetMajorVersion(): void
    {
        $request = $this->getRequest(
            self::TEST_MAJOR_VERSION,
            self::TEST_MINOR_VERSION,
            self::TEST_PROJECT_ID,
            self::TEST_DATA
        );

        $this->assertSame($request->getMajorVersion(), self::TEST_MAJOR_VERSION);
    }

    public function testGetMinorVersion(): void
    {
        $request = $this->getRequest(
            self::TEST_MAJOR_VERSION,
            self::TEST_MINOR_VERSION,
            self::TEST_PROJECT_ID,
            self::TEST_DATA
        );

        $this->assertSame($request->getMinorVersion(), self::TEST_MINOR_VERSION);
    }

    public function testGetProjectId(): void
    {
        $request = $this->getRequest(
            self::TEST_MAJOR_VERSION,
            self::TEST_MINOR_VERSION,
            self::TEST_PROJECT_ID,
            self::TEST_DATA
        );

        $this->assertSame($request->getProjectId(), self::TEST_PROJECT_ID);
    }

    public function testGetData(): void
    {
        $request = $this->getRequest(
            self::TEST_MAJOR_VERSION,
            self::TEST_MINOR_VERSION,
            self::TEST_PROJECT_ID,
            self::TEST_DATA
        );

        $this->assertSame($request->getData(), self::TEST_DATA);
    }

    abstract protected function getRequest(int $majorVersion, int $minorVersion, string $projectId, array $data): AbstractRequest;
}