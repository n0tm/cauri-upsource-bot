<?php

namespace App\Domain\Implementation\Action;

use Illuminate\Support\Facades\Log;

class NewReview extends \App\Domain\Contract\Action\AbstractAction
{
    private const TYPE = 'new review';

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $branch;

    public function __construct(string $id, string $branch)
    {
        parent::__construct();
        $this->id     = $id;
        $this->branch = $branch;
    }

    public function process(): void
    {
        Log::info("New Review created!\nID: {$this->id}\nBranch: {$this->branch}");
    }

    public function getType(): string
    {
        return self::TYPE;
    }
}