<?php

namespace App\Applications\Common\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Applications\Common\BLL\EventBLLInterface;
use App\Applications\Common\Requests\EventRequest;
use App\Applications\Common\Requests\EventTimelineRequest;
use App\Applications\Common\Requests\EventContactRequest;

/**
 * @property EventBLLInterface $eventBLL
 */
class EventController extends Controller
{
    public function __construct(
        EventBLLInterface $eventBLL
    ){
        $this->eventBLL = $eventBLL;
    }

    public function index(){

        return $this->eventBLL->index();

    }
    public function getScrolldownPosts(Request $request){
        $data = $this->eventBLL->getScrolldownPosts($request);
        // dd($data);
        return $data;
    }

    public function allEvents(Request $request){
        // dd($this->postBLL->getAllPosts());
        return $this->eventBLL->getEventsData($request);
    }

    public function allEventsPublic(Request $request){
        // dd($this->postBLL->getAllPosts());
        return $this->eventBLL->getPublicEvents($request);
    }

    public function getBoostedEvents(Request $request){
        // dd($this->postBLL->getAllPosts());
        return $this->eventBLL->getBoostedEvents($request);
    }

    public function getThisWeekEvents(Request $request){
        // dd($this->postBLL->getAllPosts());
        return $this->eventBLL->getThisWeekEvents($request);
    }

    public function getThisMonthEvents(Request $request){
        // dd($this->postBLL->getAllPosts());
        return $this->eventBLL->getThisMonthEvents($request);
    }

    public function getThisDayEvents(Request $request){
        // dd($this->postBLL->getAllPosts());
        return $this->eventBLL->getThisDayEvents($request);
    }

    public function getPostById($id){
        return $this->eventBLL->getPostById($id);
    }
    public function saveEvent(EventRequest $request){
        return $this->eventBLL->saveEvent($request);
    }

    public function editEventTimeline(EventTimelineRequest $request, $id){
        return $this->eventBLL->editEventTimeline($request, $id);
    }
    
    public function editEvent(EventRequest $request, $id){
        return $this->eventBLL->editEvent($request,$id);
    }
    public function deleteEvent($id){
        return $this->eventBLL->deleteEvent($id);
    }
}
