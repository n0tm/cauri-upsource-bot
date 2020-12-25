<?php

namespace App\Http\Request\Upsource\Model;

class ReviewLabelChanged extends AbstractRequest
{
    public function getLabelId(): string
    {
        return $this->getData()['labelId'];
    }

    public function isWasAdded(): bool
    {
        return $this->getData()['wasAdded'];
    }

    public function getReviewId(): string
    {
        return $this->getData()['reviewId'];
    }

    public function getActorId(): string
    {
        return $this->getData()['actor']['userId'];
    }

    public function getActorName(): string
    {
        return $this->getData()['actor']['userName'];
    }
}