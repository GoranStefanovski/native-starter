<?php

namespace App\Applications\Common\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Applications\Common\BLL\EventBLLInterface;
use App\Applications\Common\Requests\EventRequest;

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

    public function getPostById($id){
        return $this->eventBLL->getPostById($id);
    }
    public function saveEvent(EventRequest $request){
//         dd($request->all());
//        dd($request);
        return $this->eventBLL->saveEvent($request);
    }
    public function editEvent(EventRequest $request, $id){
        return $this->eventBLL->editEvent($request,$id);
    }
    public function deleteEvent($id){
        return $this->eventBLL->deleteEvent($id);
    }
}
