<?php

namespace App\Applications\Common\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Applications\Common\BLL\OrganizationEventBLLInterface;
use App\Applications\Common\Requests\OrganizationEventRequest;
use App\Applications\Common\Requests\EventTimelineRequest;
use App\Applications\Common\Requests\EventContactRequest;

/**
 * @property OrganizationEventBLLInterface $organizationEventBLL
 */
class OrganizationEventController extends Controller
{
    public function __construct(
        OrganizationEventBLLInterface $organizationEventBLL
    ){
        $this->organizationEventBLL = $organizationEventBLL;
    }

    public function index(){

        return $this->organizationEventBLL->index();

    }
    public function getScrolldownPosts(Request $request){
        $data = $this->organizationEventBLL->getScrolldownPosts($request);
        // dd($data);
        return $data;
    }

    public function allOrganiztaionEvents(Request $request){
        // dd($this->postBLL->getAllPosts());
        return $this->organizationEventBLL->getOrganizationEventsData($request);
    }

    public function allOrganiztaionEventsPublic(Request $request){
        // dd($this->postBLL->getAllPosts());
        return $this->organizationEventBLL->getPublicOrganizationEvents($request);
    }

    public function getBoostedOrganizationEvents(Request $request){
        // dd($this->postBLL->getAllPosts());
        return $this->organizationEventBLL->getBoostedOrganizationEvents($request);
    }

    public function getThisWeekEvents(Request $request){
        // dd($this->postBLL->getAllPosts());
        return $this->organizationEventBLL->getThisWeekEvents($request);
    }

    public function getThisMonthEvents(Request $request){
        // dd($this->postBLL->getAllPosts());
        return $this->organizationEventBLL->getThisMonthEvents($request);
    }

    public function getThisDayEvents(Request $request){
        // dd($this->postBLL->getAllPosts());
        return $this->organizationEventBLL->getThisDayEvents($request);
    }

    public function getPostById($id){
        return $this->organizationEventBLL->getPostById($id);
    }
    public function saveOrganizationEvent(OrganizationEventRequest $request){
        return $this->organizationEventBLL->saveOrganizationEvent($request);
    }

    public function editOrganizationEventTimeline(EventTimelineRequest $request, $id){
        return $this->organizationEventBLL->editOrganizationEventTimeline($request, $id);
    }
    
    public function editOrganizationEvent(OrganizationEventRequest $request, $id){
        return $this->organizationEventBLL->editOrganizationEvent($request,$id);
    }
    public function deleteOrganiztaionEvent($id){
        return $this->organizationEventBLL->deleteOrganiztaionEvent($id);
    }
}
