<?php

namespace App\Http\Request\Upsource\Model;

abstract class AbstractRequest implements RequestInterface
{
    /**
     * @var int
     */
    private $majorVersion;

    /**
     * @var int
     */
    private $minorVersion;

    /**
     * @var string
     */
    private $projectId;

    /**
     * @var array
     */
    private $data;

    public function __construct(int $majorVersion, int $minorVersion, string $projectId, array $data)
    {
        $this->majorVersion = $majorVersion;
        $this->minorVersion = $minorVersion;
        $this->projectId    = $projectId;
        $this->data         = $data;
    }

    public function getMajorVersion(): int
    {
        return $this->majorVersion;
    }

    public function getMinorVersion(): int
    {
        return $this->minorVersion;
    }

    public function getProjectId(): string
    {
        return $this->projectId;
    }

    public function getData(): array
    {
        return $this->data;
    }
}