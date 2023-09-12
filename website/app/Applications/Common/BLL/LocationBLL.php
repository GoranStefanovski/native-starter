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
//        dd($this->post->all());
        $data['records'] =$this->location->all();
        $data['draw'] = 2;
        return $data;
//        return Post::all();
        // TODO: Implement getAllPosts() method.
    }


    public function getPostById($id){
//        dd($this->post->find($id));
        return $this->location::find($id);
    }

    public function getPostByIdNonAuth($id)
    {
        // TODO: Implement getPostByIdNonAuth() method.
    }

    public function getPublicLocations($request)
    {
        $query = DB::table('locations')
        ->select(
            DB::raw('locations.id as id'),
            DB::raw('locations.title as title'),
            DB::raw('locations.description as description'),
            DB::raw('locations.user_id as user_id'),
            DB::raw('locations.location_types as location_types'),
            DB::raw('locations.city as city')
        );
        
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
    $query->groupBy('locations.id');

    return $query->get();
    }

    public function getPostsByUser()
    {
        // TODO: Implement getPostsByUser() method.
    }

    public function saveLocation($request){
        $input['title'] = $request['title'];
        $input['description'] = $request['description'];
        $input['country_id'] = $request['country_id'];
        $input['is_active'] = $request['is_active'];
        $input['user_id'] = Auth::user()->id;
        $input['location_types'] = json_encode($request->input('location_types'));
        $input['owner'] = Auth::user()->first_name;
        $input['city'] = $request['city'];
        $location = $this->location->create($input);
        $this->mediaDAL->save($request,$location,'location_image');

    }
    public function editLocation($request,$id){
        $location_data = $request->all();
//        dd($post_data);
        $location = $this->location->find($id);
        $this->mediaDAL->save($request,$location,'location_image');
        return $location->update($location_data);
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
                DB::raw('locations.is_active as is_active'),
                DB::raw('locations.location_types as location_types'),
                DB::raw('locations.image as image'),
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
