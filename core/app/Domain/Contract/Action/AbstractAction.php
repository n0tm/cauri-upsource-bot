<?php

namespace App\Domain\Contract\Action;

abstract class AbstractAction implements Base
{
    /**
     * @var string
     */
    private $id;

    public function __construct()
    {
        $this->id = $this->generateId();
    }

    public function getId(): string
    {
        return $this->id;
    }

    private function generateId(): string
    {
        return uniqid('action-');
    }
}