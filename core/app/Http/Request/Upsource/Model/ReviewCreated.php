<?php

namespace App\Http\Request\Upsource\Model;

class ReviewCreated extends AbstractRequest
{
    public function getBranch(): string
    {
        return $this->getData()['branch'];
    }

    public function getReviewId(): string
    {
        return $this->getData()['base']['reviewId'];
    }

    public function getActorId(): string
    {
        return $this->getData()['base']['actor']['userId'];
    }

    public function getActorName(): string
    {
        return $this->getData()['base']['actor']['userName'];
    }
}