<?php

namespace App\Applications\PageBuilder\DAL;

use Illuminate\Support\Facades\Storage;


/**
 *
 */
class SimpleContentDAL implements SimpleContentDALInterface
{
    public function __construct(){}

    public function saveSimpleData($request){
        $data = $request->all();

        Storage::disk('nuxt')->put(
            'content/json/'.$data['page_path'].'.json',
            json_encode($data)
        );

        return $data;
    }
}
