<?php

namespace App\Http\Request;

use App\Http\Request\Exception\UnknownRequest;
use Illuminate\Http\Request;

interface ConverterInterface
{
    /**
     * @param Request $request
     * @return mixed
     * @throws UnknownRequest
     */
    public function convert(Request $request);
}