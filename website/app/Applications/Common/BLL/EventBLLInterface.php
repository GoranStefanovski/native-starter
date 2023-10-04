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

    public function saveEvent($request);

    public function editEventTimeline($request, $id);

    public function saveEventStatus($request, $id);

    public function editEvent($id, $request);

    public function deleteEvent($id);

    /**
     * Summary of getPublicEvents
     * @param array $data
     * @return array
     */
    public function getPublicEvents($data);

    /**
     * Summary of getPublicEventsLocation
     * @param array $data
     * @param number $id
     * @return array
     */
    public function getPublicEventsLocation($data, $id);

    /**
     * @param array $data
     * @return array
     */
    public function getEventsData($data);

     /**
     * @param array $data
     * @return array
     */
    public function getBoostedEvents($data);

    public function getThisWeekEvents($data);

    public function getThisMonthEvents($data);

    public function getThisDayEvents($data);

}
