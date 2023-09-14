<?php
namespace App\Applications\Common\BLL;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface EventBLLInterface{

    public function getScrolldownPosts(Request $request);

    public function getAllLocations();

    public function getPostById($id);

    public function getPostByIdNonAuth($id);

    public function getPostsByUser();

    public function saveEventInfo($request);

    public function saveEventTimeline($request);

    public function saveEventContact($request);

    public function editEvent($id, $request);

    public function deleteEvent($id);

    /**
     * Summary of getPublicEvents
     * @param \Illuminate\Http\Request $request
     * @return Collection
     */
    public function getPublicEvents(Request $request);

    /**
     * @param array $data
     * @return array
     */
    public function getEventsData($data);

}
