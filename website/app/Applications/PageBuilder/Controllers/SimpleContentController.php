<?php

namespace App\Applications\PageBuilder\Controllers;

use App\Applications\PageBuilder\Requests\SimpleContentRequest;
use Exception;
use App\Http\Controllers\Controller;
use App\Applications\PageBuilder\BLL\SimpleContentBLLInterface;
use Illuminate\Http\Request;

/**
 * @property SimpleContentBLLInterface $simpleContentBLL
 */
class SimpleContentController extends Controller
{
    public function __construct(
        SimpleContentBLLInterface $simpleContentBLL
    ){
        $this->simpleContentBLL = $simpleContentBLL;
    }

    /**
     * Create a new color
     *
     * @param SimpleContentRequest $request
     * @return integer|Exception
     */
    public function saveContent(SimpleContentRequest $request){
        try{
            return $this->simpleContentBLL->saveContent($request);
        }
        catch(Exception $e){
            return $e;
        }
    }
}
