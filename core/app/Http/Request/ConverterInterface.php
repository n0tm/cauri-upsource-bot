<?php

namespace App\Http\Request;

use Illuminate\Http\Request;

interface ConverterInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function convert(Request $request);
}