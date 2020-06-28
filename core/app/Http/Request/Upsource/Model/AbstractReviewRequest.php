<?php

namespace App\Http\Request\Upsource\Model;

class AbstractReviewRequest extends AbstractRequest
{
    public function getReviewId(): string
    {
        return $this->getData()['base']['reviewId'];
    }
}