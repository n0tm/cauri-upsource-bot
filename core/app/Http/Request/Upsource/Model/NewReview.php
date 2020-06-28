<?php

namespace App\Http\Request\Upsource\Model;

class NewReview extends AbstractReviewRequest
{
    public function getBranch(): string
    {
        return $this->getData()['branch'];
    }
}