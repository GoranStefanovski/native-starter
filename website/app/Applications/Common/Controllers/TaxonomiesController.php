<?php

namespace App\Applications\Common\Controllers;

use Exception;
use App\Http\Controllers\Controller;
use App\Applications\Common\BLL\TaxonomiesBLLInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @property TaxonomiesBLLInterface $taxonomiesBLL
 */
class TaxonomiesController extends Controller
{
    public function __construct(
        TaxonomiesBLLInterface $taxonomiesBLL
    ){
        $this->taxonomiesBLL = $taxonomiesBLL;
    }



    /**
     * Get a JSON with combinations
     *
     * @return array|Exception
     */
    public function getCountries(){
        try{
            return $this->taxonomiesBLL->getCountries();
        }
        catch(Exception $e){
            return $e;
        }
    }


}
