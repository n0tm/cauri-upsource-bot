<?php

namespace App\Http\Request\Upsource;

interface ConverterInterface extends \App\Http\Request\ConverterInterface
{
    public const DATA_TYPE_REVIEW_CREATED       = 'ReviewCreatedFeedEventBean';
    public const DATA_TYPE_REVIEW_LABEL_CHANGED = 'ReviewLabelChangedEventBean';
    public const DATA_TYPE_REVIEW_STATE_CHANGED = 'ReviewStateChangedFeedEventBean';
    public const DATA_TYPE_DISCUSSION_NEW       = 'DiscussionFeedEventBean';
}