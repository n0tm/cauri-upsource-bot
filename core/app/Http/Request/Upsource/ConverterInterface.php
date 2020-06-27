<?php

namespace App\Http\Request\Upsource;

interface ConverterInterface extends \App\Http\Request\ConverterInterface
{
    public const KEY_DATA_TYPE     = 'dataType';
    public const KEY_MAJOR_VERSION = 'majorVersion';
    public const KEY_MINOR_VERSION = 'minorVersion';
    public const KEY_PROJECT_ID    = 'projectId';
    public const KEY_DATA          = 'data';

    public const DATA_TYPE_NEW_REVIEW = 'ReviewCreatedFeedEventBean';
}