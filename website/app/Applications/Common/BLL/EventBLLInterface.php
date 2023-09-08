<?php
namespace App\Applications\Common\BLL;
use Illuminate\Http\Request;

interface EventBLLInterface{

    public function getScrolldownPosts(Request $request);

    public function getAllLocations();

    public function getPostById($id);

    public function getPostByIdNonAuth($id);

    public function getPostsByUser();

    public function saveEvent($request);

    public function editEvent($id, $request);

    public function deleteEvent($id);

    public function getPublicEvents();

    /**
     * @param array $data
     * @return array
     */
    public function getEventsData($data);

}
