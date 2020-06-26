<?php

namespace App\Http\Request\Upsource;

interface RequestInterface
{
    public function getMajorVersion(): int;
    public function getMinorVersion(): int;
    public function getProjectId(): string;
    public function getDataType(): string;
    public function getData(): array;
}