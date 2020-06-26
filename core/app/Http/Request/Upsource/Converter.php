<?php

namespace App\Http\Request\Upsource;

use App\Http\Request\ConverterInterface;
use Illuminate\Http\Request;

class Converter implements ConverterInterface
{
    /**
     * @param Request $request
     * @return RequestInterface
     */
    public function convert(Request $request)
    {
        // TODO: Implement convert() method.
    }
}