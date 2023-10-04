<?php

namespace App\Applications\Common\BLL;
use App\Applications\Common\DAL\MediaDALInterface;
use App\Applications\Common\Model\Location;
use App\Applications\User\Model\User;
use App\Applications\Common\Model\LocationTypes;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


/**
 * @property MediaDALInterface $mediaDAL
 * @property Location $location
 * @property LocationTypes $locationTypes
 */
class LocationBLL implements LocationBLLInterface
{

    public function __construct(
        MediaDALInterface $mediaDAL,
        Location $location,
        LocationTypes $locationTypes
    ){
        $this->mediaDAL = $mediaDAL;
        $this->location = $location;
        $this->locationTypes = $locationTypes;
    }

    private const COLUMNS_MAP = [
        'id' => 'locations.id',
        'title' => 'locations.title',
        'description' => 'locations.description',
        'rating' => 'locations.rating',
        'user_id' => 'locations.user_id',
        'owner' => 'locations.owner',
        'city' => 'locations.city',
        'is_active' => 'locations.is_active'
    ];

    public function getScrolldownPosts(Request $request)
    {
        // TODO: Implement getScrolldownPosts() method.
    }

    public function getAllLocations()
    {
        $data['records'] =$this->location->all();
        $data['draw'] = 2;
        return $data;
    }


    public function getPostById($id){
        return $this->location::find($id);
    }

    public function getPostByIdNonAuth($id)
    {
        // TODO: Implement getPostByIdNonAuth() method.
    }

    public function getPublicLocations($request)
    {
        $currentDate = now()->toDateString();

        $query = DB::table('locations')
        ->select(
            DB::raw('locations.id as id'),
            DB::raw('locations.title as title'),
            DB::raw('locations.description as description'),
            DB::raw('locations.user_id as user_id'),
            DB::raw('locations.location_types as location_types'),
            DB::raw('locations.city as city'),
            DB::raw('locations.address as address'),
            DB::raw('locations.location_types as location_types'),
            DB::raw('locations.image as image'),
            DB::raw('locations.website as website'),
            DB::raw('locations.website_second as website_second'),
            DB::raw('locations.contact_person as contact_person'),
            DB::raw('locations.contact_person_second as contact_person_second'),
            DB::raw('locations.contact_person_phone as contact_person_phone'),
            DB::raw('locations.contact_person_phone_second as contact_person_phone_second'),
            DB::raw('locations.contact_person_email as contact_person_email'),
            DB::raw('locations.contact_person_email_second as contact_person_email_second'),
            DB::raw('media.file_name as file_name'),
            DB::raw('media.id as model_id')
        )->leftJoin('users', 'locations.user_id', '=', 'users.id') 
        ->leftJoin('media', function ($join) {
            $join->on('locations.id', '=', 'media.model_id')
            ->where('media.model_type', '=','App\\Applications\\Common\\Model\\Location')
            ->where('media.collection_name', '=', 'location_image');
        })->orderByRaw('
            CASE 
                WHEN users.sub_type = 3 THEN 1
                WHEN users.sub_type = 2 THEN 2
                WHEN users.sub_type = 1 THEN 3
                ELSE 4
            END
        ')
        ->orderByRaw('RAND()');
        
        $search = $request['search'];
        if($search){
            $query->where(function($subquery) use ($search) {
                $subquery->where('locations.title', 'like', '%'.$search.'%');
                $subquery->orWhere('locations.description', 'like', '%'.$search.'%');
                $subquery->orWhere('locations.rating', 'like', '%'.$search.'%');
                $subquery->orWhere('locations.user_id', 'like', '%'.$search.'%');
                $subquery->orWhere('countries.full_name', 'like', '%'.$search.'%');
            });
        }

    $query->whereNull('locations.deleted_at');
    $query->where('locations.is_active',1);
    $query->whereDate('locations.start_active_date', '<=', $currentDate)
      ->whereDate('locations.end_active_date', '>=', $currentDate);
    
      $paginator = $query->paginate($request['length']);
        return $this->prepareDatatablesData($paginator, $request);
    }

    public function getBoostedLocations($request)
    {
        $currentDate = now()->toDateString();

        $query = DB::table('locations')
        ->select(
            DB::raw('locations.id as id'),
            DB::raw('locations.title as title'),
            DB::raw('locations.description as description'),
            DB::raw('locations.user_id as user_id'),
            DB::raw('locations.location_types as location_types'),
            DB::raw('locations.city as city'),
            DB::raw('locations.address as address'),
            DB::raw('locations.location_types as location_types'),
            DB::raw('locations.image as image'),
            DB::raw('locations.website as website'),
            DB::raw('locations.website_second as website_second'),
            DB::raw('locations.contact_person as contact_person'),
            DB::raw('locations.contact_person_second as contact_person_second'),
            DB::raw('locations.contact_person_phone as contact_person_phone'),
            DB::raw('locations.contact_person_phone_second as contact_person_phone_second'),
            DB::raw('locations.contact_person_email as contact_person_email'),
            DB::raw('locations.contact_person_email_second as contact_person_email_second')
        )->join('users', 'locations.user_id', '=', 'users.id') // Join with users table.
        ->where('users.sub_type', '>', 1) // Filter locations where user's sub_type is greater than 1.
        ->orderByRaw('RAND()');
        
        $search = $request['search'];
        if($search){
            $query->where(function($subquery) use ($search) {
                $subquery->where('locations.title', 'like', '%'.$search.'%');
                $subquery->orWhere('locations.description', 'like', '%'.$search.'%');
                $subquery->orWhere('locations.rating', 'like', '%'.$search.'%');
                $subquery->orWhere('locations.user_id', 'like', '%'.$search.'%');
                $subquery->orWhere('countries.full_name', 'like', '%'.$search.'%');
            });
        }

    $query->whereNull('locations.deleted_at');
    $query->where('locations.is_active',1);
    $query->whereDate('locations.start_active_date', '<=', $currentDate)
      ->whereDate('locations.end_active_date', '>=', $currentDate);
    return $query->get();
    }

    public function getPostsByUser()
    {
        // TODO: Implement getPostsByUser() method.
    }

    public function saveLocation($request){
     
        $userSubType = Auth::user()->sub_type;

        $userLocationCount = $this->location->where('user_id', Auth::user()->id)->count();

        if (($userSubType == 1 && $userLocationCount < 3) || ($userSubType == 2 && $userLocationCount < 8) || ($userSubType == 3)) {
            $input['title'] = $request['title'];
            $input['description'] = $request['description'];
            $input['country_id'] = $request['country_id'];
            $input['address'] = $request['address'];
            $input['user_id'] = Auth::user()->id;
            $input['location_types'] = json_encode($request->input('location_types'));
            $input['owner'] = Auth::user()->first_name;
            $input['city'] = $request['city'];
            $location = $this->location->create($input);
            $this->mediaDAL->save($request,$location,'location_image');
        } else {
            abort(403, 'You do not meet the criteria for creating a new location.');
        }
    }

    public function saveLocationStatus($request, $id){
        $input['is_active'] = $request['is_active'];
        $input['start_active_date'] = $request['start_active_date'];
        $input['end_active_date'] = $request['end_active_date'];

        $location = $this->location->find($id);
        return $location->update($input);
    }

    public function editLocation($request,$id){
        $location_data = $request->all();
//        dd($post_data);
        $location = $this->location->find($id);
        $this->mediaDAL->save($request,$location,'location_image');
        return $location->update($location_data);
    }

    public function editLocationContact($request, $id){
        $input['website'] = $request['website'];
        $input['website_second'] = $request['website_second'];
        $input['contact_person'] = $request['contact_person'];
        $input['contact_person_second'] = $request['contact_person_second'];
        $input['contact_person_phone'] = $request['contact_person_phone'];
        $input['contact_person_phone_second'] = $request['contact_person_phone_second'];
        $input['contact_person_email'] = $request['contact_person_email'];
        $input['contact_person_email_second'] = $request['contact_person_email_second'];

        $location = $this->location->find($id);
        return $location->update($input);
    }
    public function deleteLocation($id){
        return $this->location
            ->where('id', $id)
            ->delete();
    }

    public function getLocationsData($data){
        // TODO: Refactor this segment
        $query = DB::table('locations')
            ->select(
                DB::raw('locations.id as id'),
                DB::raw('locations.title as title'),
                DB::raw('locations.description as description'),
                DB::raw('locations.city as city'),
                DB::raw('locations.rating as rating'),
                DB::raw('locations.user_id as user_id'),
                DB::raw('locations.owner as owner'),
                DB::raw('locations.address as address'),
                DB::raw('locations.is_active as is_active'),
                DB::raw('locations.location_types as location_types'),
                DB::raw('locations.image as image'),
                DB::raw('locations.website as website'),
                DB::raw('locations.website_second as website_second'),
                DB::raw('locations.contact_person as contact_person'),
                DB::raw('locations.contact_person_second as contact_person_second'),
                DB::raw('locations.contact_person_phone as contact_person_phone'),
                DB::raw('locations.contact_person_phone_second as contact_person_phone_second'),
                DB::raw('locations.contact_person_email as contact_person_email'),
                DB::raw('locations.contact_person_email_second as contact_person_email_second'),
            );
        $search = $data['search'];
        if($search){
            $query->where(function($subquery) use ($search) {
                $subquery->where('locations.title', 'like', '%'.$search.'%');
                $subquery->orWhere('locations.description', 'like', '%'.$search.'%');
                $subquery->orWhere('locations.rating', 'like', '%'.$search.'%');
                $subquery->orWhere('locations.user_id', 'like', '%'.$search.'%');
                $subquery->orWhere('countries.full_name', 'like', '%'.$search.'%');
            });
        }

        // If user is collaborator it will show only its locations
        if(Auth::user()->isCollaborator()) {
            $query->where('locations.user_id','=',Auth::user()->id);
        }

        $query->whereNull('locations.deleted_at');
        $query->groupBy('locations.id');
        if (array_key_exists($data['column'], self::COLUMNS_MAP)) {
            $query->orderBy(self::COLUMNS_MAP[$data['column']], $data['dir']);
        }

        $paginator = $query->paginate($data['length']);
        return $this->prepareDatatablesData($paginator, $data);
    }


    function prepareDatatablesData($paginator, $data){
        $last_page = $paginator->lastPage();
        $limit = $paginator->perPage();
        $current_page = $paginator->currentPage();
        $total = $paginator->total();
        $pagination = [
            'lastPage' => $last_page,
            'currentPage' => $current_page,
            'total' => $total,
            'dataLength' => $limit,
            'options' => $paginator->getOptions(),
        ];

        return [
            'data' => $paginator,
            'records' => $paginator->items(),
            'pagination' => $pagination,
            'draw' => $data['draw']
        ];
    }

    function getLocationsCollaborator() {
        return $this->location->where('user_id', Auth::user()->id)->where('is_active', 1)->get();
    }
}
