<?php

namespace App\Http\Request\Upsource;

interface ConverterInterface extends \App\Http\Request\ConverterInterface
{
    public const DATA_TYPE_NEW_REVIEW = 'ReviewCreatedFeedEventBean';
}