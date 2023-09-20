<?php

namespace App\Applications\Common\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Applications\Common\BLL\LocationBLLInterface;
use App\Applications\Common\Requests\LocationRequest;
use App\Applications\Common\Requests\LocationContactRequest;

/**
 * @property LocationBLLInterface $locationBLL
 */
class LocationController extends Controller
{
    public function __construct(
        LocationBLLInterface $locationBLL
    ){
        $this->locationBLL = $locationBLL;
    }

    public function index(){

        return $this->locationBLL->index();

    }
    public function getScrolldownPosts(Request $request){
        $data = $this->locationBLL->getScrolldownPosts($request);
        // dd($data);
        return $data;
    }

    public function allLocations(Request $request){
        // dd($this->postBLL->getAllPosts());
        return $this->locationBLL->getLocationsData($request);
    }

    public function allLocationsPublic(Request $request){
        // dd($this->postBLL->getAllPosts());
        return $this->locationBLL->getPublicLocations($request);
    }

    public function getBoostedLocations(Request $request) {
        return $this->locationBLL->getBoostedLocations($request);
    }

    public function getPostById($id){
        return $this->locationBLL->getPostById($id);
    }
    public function saveLocation(LocationRequest $request){
        return $this->locationBLL->saveLocation($request);
    }
    public function saveLocationStatus(LocationRequest $request, $id){
        return $this->locationBLL->saveLocationStatus($request, $id);
    }
    public function editLocation(LocationRequest $request, $id){
        return $this->locationBLL->editLocation($request,$id);
    }

    public function editLocationContact(LocationContactRequest $request, $id) {
        return $this->locationBLL->editLocationContact($request,$id); 
    }

    public function deleteLocation($id){
        return $this->locationBLL->deleteLocation($id);
    }

    public function getLocationsCollaborator(Request $request) {
        return $this->locationBLL->getLocationsCollaborator($request);
    }
}
