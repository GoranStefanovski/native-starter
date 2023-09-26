<?php

namespace App\Applications\Common\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Applications\Common\BLL\OrganizationEventBLLInterface;
use App\Applications\Common\Requests\OrganizationEventRequest;
use App\Applications\Common\Requests\EventTimelineRequest;
use App\Applications\Common\Requests\EventContactRequest;

/**
 * @property OrganizationEventBLLInterface $eventBLL
 */
class OrganizationEventController extends Controller
{
    public function __construct(
        OrganizationEventBLLInterface $eventBLL
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

    public function allOrganiztaionEvents(Request $request){
        // dd($this->postBLL->getAllPosts());
        return $this->eventBLL->getOrganizationEventsData($request);
    }

    public function allOrganiztaionEventsPublic(Request $request){
        // dd($this->postBLL->getAllPosts());
        return $this->eventBLL->getPublicOrganizationEvents($request);
    }

    public function getBoostedOrganizationEvents(Request $request){
        // dd($this->postBLL->getAllPosts());
        return $this->eventBLL->getBoostedOrganizationEvents($request);
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
    public function saveOrganizationEvent(OrganizationEventRequest $request){
        return $this->eventBLL->saveOrganizationEvent($request);
    }

    public function editOrganizationEventTimeline(EventTimelineRequest $request, $id){
        return $this->eventBLL->editOrganizationEventTimeline($request, $id);
    }
    
    public function editOrganizationEvent(OrganizationEventRequest $request, $id){
        return $this->eventBLL->editOrganizationEvent($request,$id);
    }
    public function deleteOrganiztaionEvent($id){
        return $this->eventBLL->deleteOrganiztaionEvent($id);
    }
}
