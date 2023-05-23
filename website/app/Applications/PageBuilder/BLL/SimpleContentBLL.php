<?php

namespace App\Applications\PageBuilder\BLL;

use App\Applications\PageBuilder\DAL\SimpleContentDALInterface;

/**
 * @property SimpleContentDALInterface $simpleContentDAL
 */
class SimpleContentBLL implements SimpleContentBLLInterface
{

    public function __construct(
        SimpleContentDALInterface $simpleContentDAL
    ){
        $this->simpleContentDAL = $simpleContentDAL;
    }

    public function saveContent($request){
        $info = $this->simpleContentDAL->saveSimpleData($request);

        return $info;
    }
}
