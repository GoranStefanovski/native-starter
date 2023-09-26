<?php
namespace App\Applications\Common\BLL;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface OrganizationEventBLLInterface{

    public function getScrolldownPosts(Request $request);

    public function getAllLocations();

    public function getPostById($id);

    public function getPostByIdNonAuth($id);

    public function getPostsByUser();

    public function saveOrganizationEvent($request);

    public function editOrganizationEventTimeline($request, $id);

    public function editOrganizationEvent($id, $request);

    public function deleteOrganiztaionEvent($id);

    /**
     * Summary of getPublicOrganizationEvents
     * @param array $data
     * @return array
     */
    public function getPublicOrganizationEvents($data);

    /**
     * @param array $data
     * @return array
     */
    public function getOrganizationEventsData($data);

     /**
     * @param array $data
     * @return array
     */
    public function getBoostedOrganizationEvents($data);

    public function getThisWeekEvents($data);

    public function getThisMonthEvents($data);

    public function getThisDayEvents($data);

}
