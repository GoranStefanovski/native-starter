<?php

namespace App\Applications\Common\BLL;
use App\Applications\Common\DAL\MediaDALInterface;
use App\Applications\Common\Model\Event;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Http\Request;
use App\Applications\Common\Model\MusicTypes;
use App\Applications\Common\Model\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


/**
 * @property MediaDALInterface $mediaDAL
 * @property Event $event
 * @property MusicTypes $musicTypes
 * @property Location $location
 */
class EventBll implements EventBLLInterface
{

    public function __construct(
        MediaDALInterface $mediaDAL,
        Event $event,
        MusicTypes $musicTypes,
        Location $location
    ){
        $this->mediaDAL = $mediaDAL;
        $this->event = $event;
        $this->musicTypes = $musicTypes;
        $this->location = $location;
    }

    private const COLUMNS_MAP = [
        'id' => 'events.id',
        'title' => 'events.title',
        'is_active' => 'events.is_active',
        'description' => 'events.description',
        'user_id' => 'events.user_id',
        'owner' => 'events.owner'
    ];

    public function getScrolldownPosts(Request $request)
    {
        // TODO: Implement getScrolldownPosts() method.
    }

    public function getAllLocations()
    {
//        dd($this->post->all());
        $data['records'] =$this->event->all();
        $data['draw'] = 2;
        return $data;
//        return Post::all();
        // TODO: Implement getAllPosts() method.
    }


    public function getPostById($id){
//        dd($this->post->find($id));
        return $this->event::find($id);
    }

    public function getPostByIdNonAuth($id)
    {
        // TODO: Implement getPostByIdNonAuth() method.
    }

    public function getPublicEvents($request)
    {
        $currentDate = now()->toDateString();
     
        $query = DB::table('events')
            ->select(
                DB::raw('events.id as id'),
                DB::raw('events.title as title'),
                DB::raw('events.description as description'),
                DB::raw('events.user_id as user_id'),
                DB::raw('events.music_types as music_types'),
                DB::raw('events.location_id as location_id'),
                DB::raw('events.location_name as location_name'),
                DB::raw('events.start_date as start_date'),
                DB::raw('events.end_date as end_date'),
                DB::raw('events.start_time as start_time'),
                DB::raw('events.end_time as end_time')
            )->leftJoin('users', 'events.user_id', '=', 'users.id') // Use leftJoin to include events without users.
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
                $subquery->where('events.title', 'like', '%'.$search.'%');
                $subquery->orWhere('events.description', 'like', '%'.$search.'%');
                $subquery->orWhere('events.music_types', 'like', '%'.$search.'%');
            });
        }


        $query->whereNull('events.deleted_at');
        $query->where('events.is_active',1);
        $query->where('events.end_date', '>=', $currentDate);

        return $query->get();
    }


    public function getBoostedEvents($request)
    {
        $query = DB::table('events')
            ->select(
                DB::raw('events.id as id'),
                DB::raw('events.title as title'),
                DB::raw('events.description as description'),
                DB::raw('events.user_id as user_id'),
                DB::raw('events.music_types as music_types'),
                DB::raw('events.location_id as location_id'),
                DB::raw('events.location_name as location_name'),
                DB::raw('events.start_date as start_date'),
                DB::raw('events.end_date as end_date'),
                DB::raw('events.start_time as start_time'),
                DB::raw('events.end_time as end_time')
            )->join('users', 'events.user_id', '=', 'users.id') // Join with users table.
            ->where('users.sub_type', '>', 1) // Filter events where user's sub_type is greater than 1.
            ->orderByRaw('RAND()');



        $query->whereNull('events.deleted_at');
        $query->where('events.is_active',1);
        
        return $query->get();
    }

    public function getThisWeekEvents($request)
    {
        $currentDate = now()->toDateString();
        $nextWeekEndDate = now()->addWeek()->toDateString();

        $query = DB::table('events')
            ->select(
                DB::raw('events.id as id'),
                DB::raw('events.title as title'),
                DB::raw('events.description as description'),
                DB::raw('events.user_id as user_id'),
                DB::raw('events.music_types as music_types'),
                DB::raw('events.location_id as location_id'),
                DB::raw('events.location_name as location_name'),
                DB::raw('events.start_date as start_date'),
                DB::raw('events.end_date as end_date'),
                DB::raw('events.start_time as start_time'),
                DB::raw('events.end_time as end_time')
            )->orderBy('events.start_date');

        $query->whereNull('events.deleted_at');
        $query->where('events.is_active',1);
        $query->whereBetween('events.start_date', [$currentDate, $nextWeekEndDate]);

        return $query->get();
    }

    public function getThisMonthEvents($request)
    {
        $currentDateTime = now();

        $query = DB::table('events')
            ->select(
                DB::raw('events.id as id'),
                DB::raw('events.title as title'),
                DB::raw('events.description as description'),
                DB::raw('events.user_id as user_id'),
                DB::raw('events.music_types as music_types'),
                DB::raw('events.location_id as location_id'),
                DB::raw('events.location_name as location_name'),
                DB::raw('events.start_date as start_date'),
                DB::raw('events.end_date as end_date'),
                DB::raw('events.start_time as start_time'),
                DB::raw('events.end_time as end_time')
            )->leftJoin('users', 'events.user_id', '=', 'users.id') // Use leftJoin to include events without users.
            ->orderBy('events.start_date')

            ->where(function ($query) use ($currentDateTime) {
            // Filter events happening in the next month.
            $query->whereBetween('events.start_date', [$currentDateTime->toDateString(), $currentDateTime->addMonth()->endOfMonth()->toDateString()]);

            // Filter events happening today or in the future based on both date and time.
            $query->orWhere(function ($query) use ($currentDateTime) {
                $query->whereDate('events.start_date', '>', $currentDateTime->toDateString())
                    ->orWhere(function ($query) use ($currentDateTime) {
                        $query->whereDate('events.start_date', '=', $currentDateTime->toDateString())
                            ->whereTime('events.start_time', '>=', $currentDateTime->toTimeString());
                    });
            });
        });

        $query->whereNull('events.deleted_at');
        $query->where('events.is_active',1);

        return $query->get();
    }

    public function getThisDayEvents($request)
    {
        $currentDateTime = now();

        $query = DB::table('events')
            ->select(
                DB::raw('events.id as id'),
                DB::raw('events.title as title'),
                DB::raw('events.description as description'),
                DB::raw('events.user_id as user_id'),
                DB::raw('events.music_types as music_types'),
                DB::raw('events.location_id as location_id'),
                DB::raw('events.location_name as location_name'),
                DB::raw('events.start_date as start_date'),
                DB::raw('events.end_date as end_date'),
                DB::raw('events.start_time as start_time'),
                DB::raw('events.end_time as end_time')
            )->leftJoin('users', 'events.user_id', '=', 'users.id') // Use leftJoin to include events without users.
            ->orderByRaw('
                CASE 
                    WHEN users.sub_type = 3 THEN 1
                    WHEN users.sub_type = 2 THEN 2
                    WHEN users.sub_type = 1 THEN 3
                    ELSE 4
                END
            ')
            ->orderByRaw('RAND()')->where(function ($query) use ($currentDateTime) {
                // Filter events happening today or at the current moment.
                $query->whereDate('events.start_date', $currentDateTime->toDateString())
                    ->orWhere(function ($query) use ($currentDateTime) {
                        $query->whereDate('events.start_date', '<', $currentDateTime->toDateString())
                            ->whereDate('events.end_date', '>=', $currentDateTime->toDateString())
                            ->whereTime('events.end_time', '>=', $currentDateTime->toTimeString());
                    });
            });

        $query->whereNull('events.deleted_at');
        $query->where('events.is_active',1);

        return $query->get();
    }


    public function getPostsByUser()
    {
        // TODO: Implement getPostsByUser() method.
    }

    // Save Event Info (1)
    public function saveEvent($request){
        $location = DB::table('locations')->where('id', $request['location_id'])->first();
        
        $input['title'] = $request['title'];
        $input['description'] = $request['description'];
        $input['location_id'] = $request['location_id'];
        $input['name'] = $request['name'];
        $input['is_active'] = $request['is_active'];
        $input['user_id'] = Auth::user()->id;
        $input['user_username'] = Auth::user()->username;
        $input['owner'] = Auth::user()->first_name;
        
        $input['music_types'] = json_encode($request->input('music_types'));

        if ($location) {
            $input['location_name'] = $location->title;
            $input['location_address'] = $location->address;
        } else {
            $input['location_name'] = 'Unknown Location';
            $input['location_address'] = 'Unknown Address';
        }

        $event = $this->event->create($input);
        $this->mediaDAL->save($request,$event,'event_image');

    }

    // Edit Event Timeline & Halls (2)
    public function editEventTimeline($request, $id){
        $input['start_date'] = $request['start_date'];
        $input['end_date'] = $request['end_date'];
        $input['start_time'] = $request['start_time'];
        $input['end_time'] = $request['end_time'];

        $event = $this->event->find($id);
        return $event->update($input);
    }

    // Edit Event Info
    public function editEvent($request,$id){
        $location = DB::table('locations')->where('id', $request['location_id'])->first();
        
        $input['title'] = $request['title'];
        $input['description'] = $request['description'];
        $input['location_id'] = $request['location_id'];
        $input['name'] = $request['name'];
        $input['is_active'] = $request['is_active'];
        $input['user_id'] = Auth::user()->id;
        $input['user_username'] = Auth::user()->username;
        $input['owner'] = Auth::user()->first_name;
        
        $input['music_types'] = json_encode($request->input('music_types'));

        if ($location) {
            $input['location_name'] = $location->title;
            $input['location_address'] = $location->address;
        } else {
            $input['location_name'] = 'Unknown Location';
            $input['location_address'] = 'Unknown Address';
        }

        $event = $this->event->find($id);

        $this->mediaDAL->save($request,$event,'event_image');
        return $event->update($input);
    }

    public function deleteEvent($id){
        return $this->event
            ->where('id', $id)
            ->delete();
    }

    public function getEventsData($data){

        $query = DB::table('events')
            ->select(
                DB::raw('events.id as id'),
                DB::raw('events.title as title'),
                DB::raw('events.description as description'),
                DB::raw('events.is_active as is_active'),
                DB::raw('events.user_id as user_id'),
                DB::raw('events.owner as owner'),
                DB::raw('events.music_types as music_types'),
                DB::raw('events.location_name as location_name'),             
                DB::raw('events.location_id as location_id')   
            );

        $search = $data['search'];
        if($search){
            $query->where(function($subquery) use ($search) {
                $subquery->where('events.title', 'like', '%'.$search.'%');
                $subquery->orWhere('events.description', 'like', '%'.$search.'%');
                $subquery->orWhere('events.user_id', 'like', '%'.$search.'%');
            });
        }

        // If user is collaborator it will show only its locations
        if(Auth::user() && Auth::user()->isCollaborator()) {
            $query->where('events.user_id','=',Auth::user()->id);
        }

        $query->whereNull('events.deleted_at');

        $query->groupBy('events.id');
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
