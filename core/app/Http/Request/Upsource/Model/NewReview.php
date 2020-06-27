<?php

namespace App\Http\Request\Upsource\Model;

class NewReview extends AbstractRequest
{
    public function getBranch(): string
    {
        return $this->getData()['branch'];
    }

    public function getReviewId(): string
    {
        return $this->getData()['base']['reviewId'];
    }
}