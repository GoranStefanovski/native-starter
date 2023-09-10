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

    public function editLocation($id, $request);

    public function deleteLocation($id);

    public function getPublicLocations();

    public function getLocationsData($data);

    public function getLocationsCollaborator();
}