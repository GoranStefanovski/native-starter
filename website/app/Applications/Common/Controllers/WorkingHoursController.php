<?php

namespace App\Applications\Common\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Applications\Common\BLL\WorkingHoursBLLInterface;
use App\Applications\Common\Requests\EventRequest;
use App\Applications\Common\Requests\EventTimelineRequest;
use App\Applications\Common\Requests\EventContactRequest;

/**
 * @property WorkingHoursBLLInterface $workingHours
 */
class WorkingHoursController extends Controller
{
    public function __construct(
        WorkingHoursBLLInterface $workingHours
    ){
        $this->workingHours = $workingHours;
    }

    public function index(){

        return $this->workingHours->index();

    }
    public function getScrolldownPosts(Request $request){
        $data = $this->workingHours->getScrolldownPosts($request);
        // dd($data);
        return $data;
    }
    
    public function saveWorkingHours(Request $request, $id){
        return $this->workingHours->saveWorkingHours($request, $id);
    }

    public function getWorkingHours($id){
        return $this->workingHours->getWorkingHours($id);
    }

}
