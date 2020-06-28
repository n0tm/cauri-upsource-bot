<?php

namespace App\Http\Request\Upsource\Model;

class ReviewCreated extends AbstractReviewRequest
{
    public function getBranch(): string
    {
        return $this->getData()['branch'];
    }
}