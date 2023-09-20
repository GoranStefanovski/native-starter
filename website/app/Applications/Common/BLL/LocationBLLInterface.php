<?php
namespace App\Applications\Common\BLL;
use Illuminate\Http\Request;

interface LocationBLLInterface{

    public function getScrolldownPosts(Request $request);

    public function getAllLocations();

    public function getPostById($id);

    public function getPostByIdNonAuth($id);

    public function getPostsByUser();

    public function saveLocation($request);

    public function saveLocationStatus($request, $id);

    public function editLocation($id, $request);

    public function editLocationContact($request, $id);

    public function deleteLocation($id);

    public function getPublicLocations($request);

    public function getBoostedLocations($request);

    public function getLocationsData($data);

    public function getLocationsCollaborator();
}
