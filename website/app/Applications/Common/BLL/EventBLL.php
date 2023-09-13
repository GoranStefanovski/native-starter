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

    public function getPublicEvents(Request $request)
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
            );


        $query->whereNull('events.deleted_at');
        $query->where('events.is_active',1);
        $query->groupBy('events.id');

        return $query->get();
    }

    public function getPostsByUser()
    {
        // TODO: Implement getPostsByUser() method.
    }

    public function saveEvent($request){
        $location = DB::table('locations')->where('id', $request['location_id'])->first();
        
        $input['title'] = $request['title'];
        $input['description'] = $request['description'];
        $input['start_date'] = $request['start_date'];
        $input['end_date'] = $request['end_date'];
        $input['location_id'] = $request['location_id'];
        $input['is_active'] = $request['is_active'];
        $input['user_id'] = Auth::user()->id;
        $input['owner'] = Auth::user()->first_name;
        $input['start_time'] = json_encode($request->input('start_time'));
        $input['end_time'] = json_encode($request->input('end_time'));
        $input['music_types'] = json_encode($request->input('music_types'));

        if ($location) {
            $input['location_name'] = $location->title;
        } else {
            // Handle the case where the location is not found
            $input['location_name'] = 'Unknown Location';
        }

        $event = $this->event->create($input);
        $this->mediaDAL->save($request,$event,'event_image');

    }
    public function editEvent($request,$id){
        $event_data = $request->all();
        $event = $this->event->find($id);
        $this->mediaDAL->save($request,$event,'event_image');
        return $event->update($event_data);
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
                DB::raw('events.music_types as music_types')
                
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
