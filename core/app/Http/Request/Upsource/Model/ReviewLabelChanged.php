<?php

namespace App\Http\Request\Upsource\Model;

class ReviewLabelChanged extends AbstractReviewRequest
{
    public function getLabelId(): string
    {
        return $this->getData()['labelId'];
    }

    public function isWasAdded(): bool
    {
        return $this->getData()['wasAdded'];
    }
}