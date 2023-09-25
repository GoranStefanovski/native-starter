<?php

namespace App\Applications\Common\BLL;
use App\Applications\Common\DAL\MediaDALInterface;
use App\Applications\Common\Model\OrganizationEvent;
use App\Applications\Common\BLL\OrganizationEventBLLInterface;
use Illuminate\Http\Request;
use App\Applications\Common\Model\MusicTypes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


/**
 * @property MediaDALInterface $mediaDAL
 * @property OrganizationEvent $organizationEvent
 * @property MusicTypes $musicTypes
 */
class OrganizationEventBLL implements OrganizationEventBLLInterface
{

    public function __construct(
        MediaDALInterface $mediaDAL,
        OrganizationEvent $organizationEvent,
        MusicTypes $musicTypes,
    ){
        $this->mediaDAL = $mediaDAL;
        $this->organizationEvent = $organizationEvent;
        $this->musicTypes = $musicTypes;
    }

    private const COLUMNS_MAP = [
        'id' => 'organization_events.id',
        'title' => 'organization_events.title',
        'is_active' => 'organization_events.is_active',
        'description' => 'organization_events.description',
        'user_id' => 'organization_events.user_id',
        'owner' => 'organization_events.owner'
    ];

    public function getScrolldownPosts(Request $request)
    {
        // TODO: Implement getScrolldownPosts() method.
    }

    public function getAllLocations()
    {
//        dd($this->post->all());
        $data['records'] =$this->organizationEvent->all();
        $data['draw'] = 2;
        return $data;
//        return Post::all();
        // TODO: Implement getAllPosts() method.
    }


    public function getPostById($id){
//        dd($this->post->find($id));
        return $this->organizationEvent::find($id);
    }

    public function getPostByIdNonAuth($id)
    {
        // TODO: Implement getPostByIdNonAuth() method.
    }

    public function getPublicEvents($request)
    {
        $currentDate = now()->toDateString();
     
        $query = DB::table('organization_events')
            ->select(
                DB::raw('organization_events.id as id'),
                DB::raw('organization_events.title as title'),
                DB::raw('organization_events.description as description'),
                DB::raw('organization_events.user_id as user_id'),
                DB::raw('organization_events.music_types as music_types'),
                DB::raw('organization_events.location_id as location_id'),
                DB::raw('organization_events.location_name as location_name'),
                DB::raw('organization_events.start_date as start_date'),
                DB::raw('organization_events.end_date as end_date'),
                DB::raw('organization_events.start_time as start_time'),
                DB::raw('organization_events.end_time as end_time')
            )->leftJoin('users', 'organization_events.user_id', '=', 'users.id') // Use leftJoin to include organization_events without users.
            ->orderByRaw('
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
                $subquery->where('organization_events.title', 'like', '%'.$search.'%');
                $subquery->orWhere('organization_events.description', 'like', '%'.$search.'%');
                $subquery->orWhere('organization_events.music_types', 'like', '%'.$search.'%');
            });
        }


        $query->whereNull('organization_events.deleted_at');
        $query->where('organization_events.is_active',1);
        $query->where('organization_events.end_date', '>=', $currentDate);

        return $query->get();
    }


    public function getBoostedEvents($request)
    {
        $query = DB::table('organization_events')
            ->select(
                DB::raw('organization_events.id as id'),
                DB::raw('organization_events.title as title'),
                DB::raw('organization_events.description as description'),
                DB::raw('organization_events.user_id as user_id'),
                DB::raw('organization_events.music_types as music_types'),
                DB::raw('organization_events.location_id as location_id'),
                DB::raw('organization_events.location_name as location_name'),
                DB::raw('organization_events.start_date as start_date'),
                DB::raw('organization_events.end_date as end_date'),
                DB::raw('organization_events.start_time as start_time'),
                DB::raw('organization_events.end_time as end_time')
            )->join('users', 'organization_events.user_id', '=', 'users.id') // Join with users table.
            ->where('users.sub_type', '>', 1) // Filter organization_events where user's sub_type is greater than 1.
            ->orderByRaw('RAND()');



        $query->whereNull('organization_events.deleted_at');
        $query->where('organization_events.is_active',1);
        
        return $query->get();
    }

    public function getThisWeekEvents($request)
    {
        $currentDate = now()->toDateString();
        $nextWeekEndDate = now()->addWeek()->toDateString();

        $query = DB::table('organization_events')
            ->select(
                DB::raw('organization_events.id as id'),
                DB::raw('organization_events.title as title'),
                DB::raw('organization_events.description as description'),
                DB::raw('organization_events.user_id as user_id'),
                DB::raw('organization_events.music_types as music_types'),
                DB::raw('organization_events.location_id as location_id'),
                DB::raw('organization_events.location_name as location_name'),
                DB::raw('organization_events.start_date as start_date'),
                DB::raw('organization_events.end_date as end_date'),
                DB::raw('organization_events.start_time as start_time'),
                DB::raw('organization_events.end_time as end_time')
            )->orderBy('organization_events.start_date');

        $query->whereNull('organization_events.deleted_at');
        $query->where('organization_events.is_active',1);
        $query->whereBetween('organization_events.start_date', [$currentDate, $nextWeekEndDate]);

        $search = $request['search'];
        if($search){
            $query->where(function($subquery) use ($search) {
                $subquery->where('organization_events.title', 'like', '%'.$search.'%');
                $subquery->orWhere('organization_events.music_types', 'like', '%'.$search.'%');
            });
        }

        return $query->get();
    }

    public function getThisMonthEvents($request)
    {
        $currentDateTime = now();

        $query = DB::table('organization_events')
            ->select(
                DB::raw('organization_events.id as id'),
                DB::raw('organization_events.title as title'),
                DB::raw('organization_events.description as description'),
                DB::raw('organization_events.user_id as user_id'),
                DB::raw('organization_events.music_types as music_types'),
                DB::raw('organization_events.location_id as location_id'),
                DB::raw('organization_events.location_name as location_name'),
                DB::raw('organization_events.start_date as start_date'),
                DB::raw('organization_events.end_date as end_date'),
                DB::raw('organization_events.start_time as start_time'),
                DB::raw('organization_events.end_time as end_time')
            )->leftJoin('users', 'organization_events.user_id', '=', 'users.id') // Use leftJoin to include organization_events without users.
            ->orderBy('organization_events.start_date')

            ->where(function ($query) use ($currentDateTime) {
            // Filter organization_events happening in the next month.
            $query->whereBetween('organization_events.start_date', [$currentDateTime->toDateString(), $currentDateTime->addMonth()->endOfMonth()->toDateString()]);

            // Filter organization_events happening today or in the future based on both date and time.
            $query->orWhere(function ($query) use ($currentDateTime) {
                $query->whereDate('organization_events.start_date', '>', $currentDateTime->toDateString())
                    ->orWhere(function ($query) use ($currentDateTime) {
                        $query->whereDate('organization_events.start_date', '=', $currentDateTime->toDateString())
                            ->whereTime('organization_events.start_time', '>=', $currentDateTime->toTimeString());
                    });
            });
        });

        $search = $request['search'];
        if($search){
            $query->where(function($subquery) use ($search) {
                $subquery->where('organization_events.title', 'like', '%'.$search.'%');
                $subquery->orWhere('organization_events.music_types', 'like', '%'.$search.'%');
            });
        }

        $query->whereNull('organization_events.deleted_at');
        $query->where('organization_events.is_active',1);

        return $query->get();
    }

    public function getThisDayEvents($request)
    {
        $currentDateTime = now();

        $query = DB::table('organization_events')
            ->select(
                DB::raw('organization_events.id as id'),
                DB::raw('organization_events.title as title'),
                DB::raw('organization_events.description as description'),
                DB::raw('organization_events.user_id as user_id'),
                DB::raw('organization_events.music_types as music_types'),
                DB::raw('organization_events.location_id as location_id'),
                DB::raw('organization_events.location_name as location_name'),
                DB::raw('organization_events.start_date as start_date'),
                DB::raw('organization_events.end_date as end_date'),
                DB::raw('organization_events.start_time as start_time'),
                DB::raw('organization_events.end_time as end_time')
            )->leftJoin('users', 'organization_events.user_id', '=', 'users.id') // Use leftJoin to include organization_events without users.
            ->orderByRaw('
                CASE 
                    WHEN users.sub_type = 3 THEN 1
                    WHEN users.sub_type = 2 THEN 2
                    WHEN users.sub_type = 1 THEN 3
                    ELSE 4
                END
            ')
            ->orderByRaw('RAND()')->where(function ($query) use ($currentDateTime) {
                // Filter organization_events happening today or at the current moment.
                $query->whereDate('organization_events.start_date', $currentDateTime->toDateString())
                    ->orWhere(function ($query) use ($currentDateTime) {
                        $query->whereDate('organization_events.start_date', '<', $currentDateTime->toDateString())
                            ->whereDate('organization_events.end_date', '>=', $currentDateTime->toDateString())
                            ->whereTime('organization_events.end_time', '>=', $currentDateTime->toTimeString());
                    });
            });

        $search = $request['search'];
        if($search){
            $query->where(function($subquery) use ($search) {
                $subquery->where('organization_events.title', 'like', '%'.$search.'%');
                $subquery->orWhere('organization_events.music_types', 'like', '%'.$search.'%');
            });
        }

        $query->whereNull('organization_events.deleted_at');
        $query->where('organization_events.is_active',1);

        return $query->get();
    }


    public function getPostsByUser()
    {
        // TODO: Implement getPostsByUser() method.
    }

    // Save Event Info (1)
    public function saveOrganizationEvent($request){
        $input['title'] = $request['title'];
        $input['description'] = $request['description'];
        $input['name'] = $request['name'];
        $input['user_id'] = Auth::user()->id;
        $input['user_username'] = Auth::user()->username;
        $input['owner'] = Auth::user()->first_name;
        
        $input['address'] = $request['address'];
        $input['city'] = $request['city'];

        $input['music_types'] = json_encode($request->input('music_types'));

        $organizationEvent = $this->organizationEvent->create($input);
        $this->mediaDAL->save($request,$organizationEvent,'organization_events_image');

    }

    // Edit Event Timeline & Halls (2)
    public function editEventTimeline($request, $id){
        $input['start_date'] = $request['start_date'];
        $input['end_date'] = $request['end_date'];
        $input['start_time'] = $request['start_time'];
        $input['end_time'] = $request['end_time'];

        $organizationEvent = $this->organizationEvent->find($id);
        return $organizationEvent->update($input);
    }

    // Edit Event Info
    public function editOrganizationEvent($request,$id){
        $input['title'] = $request['title'];
        $input['description'] = $request['description'];
        $input['location_id'] = $request['location_id'];
        $input['name'] = $request['name'];
        $input['is_active'] = $request['is_active'];
        $input['user_id'] = Auth::user()->id;
        $input['user_username'] = Auth::user()->username;
        $input['owner'] = Auth::user()->first_name;
        
        $input['music_types'] = json_encode($request->input('music_types'));


        $organizationEvent = $this->organizationEvent->find($id);

        $this->mediaDAL->save($request,$organizationEvent,'organization_events_image');
        return $organizationEvent->update($input);
    }

    public function deleteOrganiztaionEvent($id){
        return $this->organizationEvent
            ->where('id', $id)
            ->delete();
    }

    public function getOrganizationEventsData($data){

        $query = DB::table('organization_events')
            ->select(
                DB::raw('organization_events.id as id'),
                DB::raw('organization_events.title as title'),
                DB::raw('organization_events.description as description'),
                DB::raw('organization_events.is_active as is_active'),
                DB::raw('organization_events.user_id as user_id'),
                DB::raw('organization_events.owner as owner'),
                DB::raw('organization_events.music_types as music_types'),
                DB::raw('organization_events.city as city'),
                DB::raw('organization_events.address as address'),
            );

        $search = $data['search'];
        if($search){
            $query->where(function($subquery) use ($search) {
                $subquery->where('organization_events.title', 'like', '%'.$search.'%');
                $subquery->orWhere('organization_events.description', 'like', '%'.$search.'%');
                $subquery->orWhere('organization_events.user_id', 'like', '%'.$search.'%');
                $subquery->orWhere('organization_events.music_types', 'like', '%'.$search.'%');
            });
        }

        // If user is collaborator it will show only its locations
        if(Auth::user() && Auth::user()->isOrganizator()) {
            $query->where('organization_events.user_id','=',Auth::user()->id);
        }

        $query->whereNull('organization_events.deleted_at');

        $query->groupBy('organization_events.id');
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
}
