<?php

namespace App\Applications\PageBuilder\BLL;

use Illuminate\Http\Request;

interface SimpleContentBLLInterface
{

    /**
     * @param Request $request
     *
     * @return integer
     */
    public function saveContent($request);
}
