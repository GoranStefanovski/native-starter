<?php

namespace App\Applications\Common\BLL;


interface SimpleContentBLLInterface
{
    public function getAllColors();

    public function orderColors($request);

    public function editColor($request, $id);

    public function newColor($request);

//    private function getColorDataArray($request);

    }
