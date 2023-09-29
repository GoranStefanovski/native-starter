<?php

namespace App\Applications\Common\BLL;
use App\Applications\Common\DAL\MediaDALInterface;
use App\Applications\Common\Model\PostShort;
use App\Applications\User\Model\User;
use App\Applications\Common\Model\LocationTypes;
use App\Applications\Common\Model\MusicTypes;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


/**
 * @property PostShort $postShort
 * @property LocationTypes $locationTypes
 * @property MusicTypes $musicTypes
 */
class PostShortBLL implements PostShortBLLInterface
{

    public function __construct(
        PostShort $postShort,
        LocationTypes $locationTypes,
        MusicTypes $musicTypes
    ){
        $this->postShort = $postShort;
        $this->locationTypes = $locationTypes;
        $this->musicTypes = $musicTypes;
    }

    private const COLUMNS_MAP = [
        'id' => 'post_shorts.id',
        'title' => 'post_shorts.title',
        'link' => 'post_shorts.link',
        'is_active' => 'post_shorts.is_active'
    ];

    public function getScrolldownPosts(Request $request)
    {
        // TODO: Implement getScrolldownPosts() method.
    }

    public function getAllLocations()
    {
        $data['records'] =$this->postShort->all();
        $data['draw'] = 2;
        return $data;
    }


    public function getPostById($id){
        return $this->postShort::find($id);
    }

    public function getPostByIdNonAuth($id)
    {
        // TODO: Implement getPostByIdNonAuth() method.
    }

    public function getPublicShortPosts($request)
    {
        $currentDate = now()->toDateString();

        $query = DB::table('post_shorts')
        ->select(
            DB::raw('post_shorts.id as id'),
            DB::raw('post_shorts.title as title'),
            DB::raw('post_shorts.link as link'),
            DB::raw('post_shorts.location_types as location_types'),
            DB::raw('post_shorts.music_types as music_types'),
            DB::raw('post_shorts.image as image'),
            DB::raw('post_shorts.contact_person_email_second as contact_person_email_second')
        );
        
        $interest = $request['interest'];
        if($interest){
            $query->where(function($subquery) use ($interest) {
                $subquery->where('post_shorts.location_types', 'like', '%'.$interest.'%');
                $subquery->orWhere('post_shorts.music_types', 'like', '%'.$interest.'%');
            });
        }

        $query->whereNull('post_shorts.deleted_at');
        $query->where('post_shorts.is_active',1);
        $query->whereDate('post_shorts.start_active_date', '<=', $currentDate);
        $query->whereDate('post_shorts.end_active_date', '>=', $currentDate);
        
        return $query->get();
    }


    public function getPostsByUser()
    {
        // TODO: Implement getPostsByUser() method.
    }

    public function savePost($request){
        $input['title'] = $request['title'];
        $input['link'] = $request['link'];
        $input['user_id'] = Auth::user()->id;
        $input['event_id'] = $request['event_id'];
        $input['location_id'] = $request['location_id'];
        $input['artist_id'] = $request['artist_id'];
        $input['location_types'] = json_encode($request->input('location_types'));
        $input['music_types'] = json_encode($request->input('music_types'));
        $post = $this->postShort->create($input);
    }

    public function savePostStatus($request, $id){
        $input['is_active'] = $request['is_active'];
        $input['is_boosted'] = $request['is_boosted'];
        $input['start_active_date'] = $request['start_active_date'];
        $input['end_active_date'] = $request['end_active_date'];

        $postShort = $this->postShort->find($id);
        return $postShort->update($input);
    }

    public function editPost($request,$id){
        $input = $request->all();
//        dd($post_data);
        $postShort = $this->postShort->find($id);
        return $postShort->update($input);
    }

    public function deletePost($id){
        return $this->postShort
            ->where('id', $id)
            ->delete();
    }

    public function getShortPostData($data){
        // TODO: Refactor this segment
        $query = DB::table('post_shorts')
            ->select(
                DB::raw('post_shorts.id as id'),
                DB::raw('post_shorts.title as title'),
                DB::raw('post_shorts.link as link'),
                DB::raw('post_shorts.user_id as user_id'),
                DB::raw('post_shorts.is_active as is_active'),
                DB::raw('post_shorts.location_types as location_types'),
                DB::raw('post_shorts.music_types as music_types'),
            );
        $search = $data['search'];
        if($search){
            $query->where(function($subquery) use ($search) {
                $subquery->where('post_shorts.title', 'like', '%'.$search.'%');
                $subquery->orWhere('post_shorts.location_types', 'like', '%'.$search.'%');
                $subquery->orWhere('post_shorts.music_types', 'like', '%'.$search.'%');
            });
        }

        $query->whereNull('post_shorts.deleted_at');
        $query->groupBy('post_shorts.id');
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
